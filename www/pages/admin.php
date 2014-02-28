<?

config()->push('css', '/css/admin/main.css');


if (isset(config()->uri[1]) && file_exists("pages/admin/" . config()->uri[1] . ".php")) {
  if (isset($_SESSION['adminPassword']) && $_SESSION['adminPassword'] == config()->adminPassword) {
    include "pages/admin/" . config()->uri[1] . ".php";
  } else {
    include "pages/admin/login.php";
  }
} else {
  include "pages/404.php";
}


?>