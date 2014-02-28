<?

printHeader();
printAdminLinks();
echo registrationModes();

$search = isset($_GET['search']) ? $_GET['search'] : '';
$mode = choose(isset(config()->uri[2]) ? config()->uri[2] : false, "all");
$registrations = getRegistrations($mode, $search);
$stats = collectStats($registrations);

?>

<div class="notice_bar">
  It's advised to use these emails in the BCC field to prevent massive unwanted mailing lists.
</div>
<?=registrationStats($stats)?>
<div class="content-box">
  <textarea style="line-height: 16pt; width: 740px; height: 400px;"><?
      foreach ($registrations as $item) {
        echo $item['email'] . ', ';
      }
      ?></textarea>
</div>


<?

printFooter();