<?


require "utils/google/googlerequest.php";
require 'utils/google/googlenotificationhistory.php';
require 'utils/google/googleresponse.php';
require 'utils/google/xml-processing/gc_xmlparser.php';


$history = new GoogleNotificationHistoryRequest(
  config()->googleMerchantId,
  config()->googleMerchantKey,
  'checkout-shopping-cart'
);

$status = 0;
$response = '';

$serial = isset($_POST['serial-number']) ? $_POST['serial-number'] : false;
$order = isset($_POST['order-number']) ? $_POST['order-number'] : false;
// $order = '518219121234975';
// $serial = '136560622724199-00001-7';

if (!$serial && !$order) die("Invalid input");

if ($serial) 
    list($status, $response) = $history->SendNotificationHistoryRequest($serial);
else
    list($status, $response) = $history->SendNotificationHistoryRequest(null, null, array($order));

if ($status != 200) die("Invalid response: $status");


$parser = new gc_xmlparser($response);

$root = $parser->GetRoot();
$data = $parser->GetData();

function handleResponse($root, $data, $serial) {

    $orderId = $data['order-summary']['google-order-number']['VALUE'];
    $total = $data['order-summary']['order-total']['VALUE'];
    $transactionId = intval($data['order-summary']['shopping-cart']['merchant-private-data']['VALUE']);
    $state = $data['order-summary']['financial-order-state']['VALUE'];

    $transaction = DB::queryFirstRow("SELECT * FROM registrations WHERE id=%d", $transactionId);

    if ($transaction) {
        DB::update('registrations', array(
            'state' => $state,
            'total' => $total,
            'order' => $orderId
        ), 'id=%d', $transactionId);

        $response = new GoogleResponse(
          config()->googleMerchantId,
          config()->googleMerchantKey
        );
        $response->SendAck($serial, true);
    } else {
        die("Invalid transaction: $transactionId");
    }
}

handleResponse($root, $data[$root], $serial);

?>