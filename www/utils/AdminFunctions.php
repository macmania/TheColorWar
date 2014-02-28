<?
function takeCount(&$array, $category, $value, $count = 1) {
  if (!isset($array[$category]))
    $array[$category] = array();
  if (!isset($array[$category][$value]))
    $array[$category][$value] = 0;
  $array[$category][$value] += $count;
}


function countsToRow($data) {
  $list = array();
  foreach ($data as $key => $value) {
    array_push($list, array($key, $value));
  }
  return $list;
}

function toDollar($i, $empty = false) {
  if ($i < 0) {
    return "-$" . abs($i);
  } else if ($i == 0 && $empty) {
    return '&nbsp;';
  }
  return "$" . $i;
}
function getProfit($item) {
  $profit = 0;
  if ($item['state'] == 'CHARGED') {
    $profit += intval($item['soak']) * (config()->soakPrice - (config()->soakPackets * config()->pricePerPacket));
    $profit += intval($item['splash']) * (config()->splashPrice - (config()->splashPackets * config()->pricePerPacket));
    $profit += $item['donation'];
  }
  $profit -= intval($item['sprinkle']) * config()->pricePerPacket;
  return $profit;
}

function getPackets($item) {
  $packets = 0;
  if ($item['state'] == 'CHARGED') {
    $packets += intval($item['soak']) * config()->soakPackets;
    $packets += intval($item['splash']) * config()->splashPackets;
  }
  $packets += intval($item['sprinkle']) * config()->sprinklePackets;
  return $packets;
}

function getShirts($item) {
  $shirts = 0;
  if ($item['state'] == 'CHARGED') {
    $other = json_decode($item['other'], true);
    $shirts += intval(count($other));
  }
  return $shirts;
}
function getRegistrations($mode = 'all', $search = false) {
  if ($mode == "all") {
    $query = "SELECT * FROM registrations WHERE enabled = 1";
  } else if ($mode == "payments") {
    $query = "SELECT * FROM registrations WHERE enabled = 1 AND total > 0";
  } else if ($mode == "free") {
    $query = "SELECT * FROM registrations WHERE enabled = 1 AND total = 0";
  } else if ($mode == "unfinished") {
    $query = "SELECT * FROM registrations WHERE (other != \"[]\" OR soak > 0 OR splash > 0) AND state != \"CHARGED\"";
  }

  $post = " ORDER BY id DESC";

  if ($search) {
    $s = $search . '%';
    $query .= " AND (
      first_name LIKE %s OR
      last_name LIKE %s OR
      email LIKE %s OR 
      phone LIKE %s OR
      `order` LIKE %s OR 
      state LIKE %s)
      $post";
    return DB::query($query,
      $s, $s, $s, $s, $s, $s
    );
  } else {
    return DB::query($query . $post);
  }
}


function collectStats($items) {
  $total = 0;
  $counts = array(
    'participants' => 0,
    'paying' => 0,
    'revenue' => 0,
    'profit' => 0,
    'packets' => 0,
    'shirts' => 0,
  );
  $charts = array(
    'source' => array(),
    'reason' => array(),
    'package' => array()
  );
  foreach ($items as $item) {
    $counts['participants']++;
    $counts['revenue'] += $item['total'];
    $counts['profit'] += getProfit($item);
    $counts['packets'] += getPackets($item);
    $counts['shirts'] += getShirts($item);
    if ($item['total'] > 0)
      $counts['paying']++;


    takeCount($charts, 'source', $item['source']);
    takeCount($charts, 'reason', $item['reason']);
    takeCount($charts, 'package', 'soak', $item['soak']);
    takeCount($charts, 'package', 'splash', $item['splash']);
    takeCount($charts, 'package', 'sprinkle', $item['sprinkle']);
  }
  return array_merge($counts, array(
    'source' => countsToRow($charts['source']),
    'reason' => countsToRow($charts['reason']),
    'package' => countsToRow($charts['package']),
  ));
}

function printAdminLinks() {
  ?>
  <div class="admin-links content-box">
    <a href="/admin/registrations">Registrations</a>
    <a href="/admin/emails">Emails</a>
    <a href="/admin/shirts">Shirts</a>
  </div>
  <?
}

function registrationStats($stats) {
  ?>
  <div class="stats content-box">
    <div class="stat">
      <b><?=$stats['participants']?></b>
      <i>Participants</i>
    </div>
    <div class="stat">
      <b><?=$stats['paying']?></b>
      <i>Paying Participants</i>
    </div>
    <div class="stat">
      <b><?=$stats['packets']?></b>
      <i>Color Packets</i>
    </div>
    <div class="stat">
      <b><?=$stats['shirts']?></b>
      <i>Shirts Ordered</i>
    </div>
    <div class="stat">
      <b><?=toDollar($stats['revenue'])?></b>
      <i>Gross Revenue</i>
    </div>
    <div class="stat">
      <b><?=toDollar($stats['profit'])?></b>
      <i>Net Revenue</i>
    </div>
    <div class="clear"></div>
  </div>
  <?
}

function registrationModes() {
  return '
  <div class="modes content-box flush">
    <a class="link" href="/admin/' . config()->uri[1] . '/all">All</a>
    <a class="link" href="/admin/' . config()->uri[1] . '/payments">Payments</a>
    <a class="link" href="/admin/' . config()->uri[1] . '/free">Free</a>
    <a class="link" href="/admin/' . config()->uri[1] . '/unfinished">Unfinished</a>
    <form style="float:right" method="GET" action="">
      <input type="text" value="' . (isset($_REQUEST['search']) ? $_REQUEST['search'] : '') . '" name="search" />
      <input type="submit" value="SEARCH" class="button" />
    </form>
  </div>';
}