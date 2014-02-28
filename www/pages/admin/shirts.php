<?
printHeader();

$registrations = getRegistrations('all');
$shirts = array();

foreach ($registrations as $item) {
  $other = json_decode($item['other'], true);
  foreach ($other as $shirt) {
    if (!isset($shirts[$shirt['name']])) {
      $shirts[$shirt['name']] = 0;
    }
    $shirts[$shirt['name']]++;
  }
}

printAdminLinks();
?>

<div class="content-box">
  <ul>
  <?
  foreach ($shirts as $shirt => $count) {
    echo '<li><strong>' . $count . '</strong> - ' . $shirt . '</li>';
  }
  ?>
  </ul>
</div>

<?
printFooter();
?>