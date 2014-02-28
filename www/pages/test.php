<?


require "utils/google/googlerequest.php";
include 'utils/google/googlenotificationhistory.php';

$history = new GoogleNotificationHistoryRequest(
  config()->googleMerchantId,
  config()->googleMerchantKey,
  'checkout-shopping-cart'
);

print_r($history->SendNotificationHistoryRequest(
  null,
  null,
  array('136560622724199')
));

die("Dead.");
?>