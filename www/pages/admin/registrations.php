<?

config()->push('css', '/css/admin/registrations.css');
config()->push('js', 'https://www.google.com/jsapi');
config()->push('js', '/js/admin/registrations.js');

$search = isset($_GET['search']) ? $_GET['search'] : '';
$mode = choose(isset(config()->uri[2]) ? config()->uri[2] : false, "all");
$registrations = getRegistrations($mode, $search);
$stats = collectStats($registrations);

if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  if ($id) {
    DB::update("registrations", array(
      'enabled' => 0
    ), "id=%d", $id);

    if (DB::affectedRows()) {
      flash("success", "Order deleted successfully.");
    } else {
      flash('error', 'Unable to delete order.');
    }
    redirect(config()->path, true);
  }
}

if (isset($_POST['modify'])) {
  DB::update("registrations", array(
    $_POST['key'] => $_POST['value']
  ), "id=%d", $_POST['registration_id']);
  echo DB::affectedRows();
  die();
}

function showPercentages($percents) {
  $str = '<ul>';
  $total = 0;
  foreach ($percents as $percent) {
    $total += $percent[1];
  }
  foreach ($percents as $percent) {
    $str .= '<li><strong>' . $percent[0] . '</strong>: <span class="blue">' . floor($percent[1] / $total * 100) . '%</span></li>';
  }
  $str .= '</ul>';
  return $str;
}

function shirtsToString($json) {
  $shirts = json_decode($json, true);
  if (!$shirts) return 'None';
  $string = '';
  foreach ($shirts as $shirt) {
    $string .= $shirt['name'] . ', ';
  }
  return substr($string, 0, -2);
}


function em($amount) {
  if (preg_match("/[0-9.]+/", $amount)) {
    if ($amount) {
      return '<strong class="green">' . $amount . '</strong>';
    } else {
      return '<span style="color:#666">&nbsp</span>';
    }
  } else {
    if ($amount == "CHARGED") {
      return '<span class="green">' . strtolower($amount) . '</span>';
    } else if ($amount == "CHARGEABLE") {
      return '<span class="orange">' . strtolower($amount) . '</span>';
    } else if ($amount == "CANCELLED") {
      return '<span style="color:#666">' . strtolower($amount) . '</span>';
    }
    return strtolower($amount);
  }
}


printHeader();
printAdminLinks();

  ?>
  <script type="text/javascript">
    var sourceData = <?=json_encode($stats['source'])?>;
    var reasonData = <?=json_encode($stats['reason'])?>;
    var packageData = <?=json_encode($stats['package'])?>;
  </script>
  <?=registrationModes()?>
  <?=registrationStats($stats)?>
  <div class="charts content-box split thirds">
    <div class="left">
      <h4>Where did you find out?</h4>
      <?=showPercentages($stats['source']);?>
      <div id="source-graph"></div>
    </div>
    <div class="middle">
      <h4>Reasons for attending?</h4>
      <?=showPercentages($stats['reason']);?>
      <div id="reason-graph"></div>
    </div>
    <div class="right">
      <h4>Packages</h4>
      <?=showPercentages($stats['package']);?>
      <div id="package-graph"></div>
    </div>
    <div class="clear"></div>
  </div>
  <div class="registrations content-box">
      <div class="item header">
        <div class="column">Name</div>
        <div class="column small">Date</div>
        <div class="column small">Soak</div>
        <div class="column small">Splash</div>
        <div class="column small">Sprinkle</div>
        <div class="column small">Shirts</div>
        <div class="column small">Donation</div>
        <div class="column small">Total</div>
        <div class="column" style="border-right: none">State</div>
        <div class="clear"></div>
      </div>
    <?
    foreach($registrations as $item) {
      ?>
      <div class="item<?=$item['picked_up'] ? " claimed" : ""?>" data-id="<?=$item['id']?>">
        <div class="expand">
          <div class="name column"><?=$item['first_name'] . ' ' . $item['last_name'] ?></div>
          <div class="date column small center"><?=date("n/j", strtotime($item['date'])) ?></div>
          <div class="column small center"><?=em($item['soak']) ?></div>
          <div class="column small center"><?=em($item['splash']) ?></div>
          <div class="column small center"><?=em($item['sprinkle']) ?></div>
          <div class="column small center"><?=em(substr_count($item['other'], "{")) ?></div>
          <div class="column small center"><?=toDollar($item['donation'], true) ?></div>
          <div class="column small center"><?=toDollar($item['total'], true) ?></div>
          <div class="column center" style="border-right: none"><?=em($item['state']) ?>&nbsp;</div>
          <div class="clear"></div>
        </div>
        <div class="expander" style="display: none">
          <div class="left">
            <div class="pair">
              <label>Internal ID</label>
              <span class="value"><?=$item['id']?></span>
            </div>
            <div class="pair">
              <label>Google Order #</label>
              <span class="value">
                <a href="https://checkout.google.com/sell/multiOrder?order=<?=$item['order']?>&ordersTable=1">
                  <?=$item['order']?>
                </a>
              </span>
            </div>
            <div class="pair">
              <label>Google Checkout</label>
              <span class="value">
                <a href="<?=$item['cart_url']?>">
                  <?=$item['cart_url']?>
                </a>
              </span>
            </div>
            <div class="pair">
              <label>Time</label>
              <span class="value"><?=date("g:ia", strtotime($item['date']))?></span>
            </div>
            <div class="pair">
              <label>Email</label>
              <span class="value"><a href="mailto:<?=$item['email']?>"><?=$item['email']?></a></span>
            </div>
            <div class="pair">
              <label>Date of Birth</label>
              <span class="value"><?=$item['dob']?></span>
            </div>
            <div class="pair">
              <label>Phone</label>
              <span class="value"><?=$item['phone']?></span>
            </div>
            <div class="centered">
              <a class="button green pickedup<?=$item['picked_up'] ? " disabled" : ""?>" data-error="User has already picked up order">
                Claimed Order
              </a>
            </div>
          </div>
          <div class="right">
            <div class="pair">
              <label>Gender</label>
              <span class="value"><?=$item['gender']?></span>
            </div>
            <div class="pair">
              <label>Source</label>
              <span class="value"><?=$item['source']?></span>
            </div>
            <div class="pair">
              <label>Reason</label>
              <span class="value"><?=$item['reason']?></span>
            </div>
            <div class="pair">
              <label>Extra Packets</label>
              <span class="value"><?=$item['extra_packets']?></span>
            </div>
            <div class="pair">
              <label>Shirts</label>
              <span class="value"><?=shirtsToString($item['other'])?></span>
            </div>
            <div class="pair">
              <label>Promo Code</label>
              <span class="value"><?=$item['promo']?></span>
            </div>
            <div class="pair">
              <label>Promo Discount</label>
              <span class="value"><?=$item['discount']?></span>
            </div>
            <div class="centered">
              <a class="button orange" onclick="if(confirm('Are you sure you want to delete this order?')) window.location='?delete=<?=$item['id']?>'">
                Delete Order
              </a>
            </div>
          </div>
          <div class="clear"></div>
        </div>
      </div>
      <?
    } ?>
  </div>

<?
printFooter();
?>