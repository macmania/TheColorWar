<?

if (isset($_POST['password'])) {
  $_SESSION['adminPassword'] = $_POST['password'];
  header("Location: /" . implode("/", config()->uri));
}


printHeader();
?>

<div class="content-box" style="padding: 50px;">
  <form action="" method="POST">
    <h3>You're not authorized to be here, password please!</h3>
    <br />
    <div class="pair">
      <label class="required">Password</label>
      <input type="text" name="password" />
    </div>
    <div class="pair">
      <label></label>
      <input type="submit" class="button" />
    </div>

  </form>
</div>

<?
printFooter();
?>