<?


// Sorry to whoever has to maintain this code after me,
// we were on an extremely tight timeline and had to get
// this thing live within a handful of days. It's not the
// cleanest code in the world but gets the job done.


session_start();

function includeFolder($folder, $depth = 1) {
  if (!$depth) return;
  foreach (glob($folder . "/*") as $file) {
    if (!is_dir($file)) {
      include $file;
    } else if ($depth) {
      includeFolder($file, $depth - 1);
    }
  }
}
includeFolder("utils");
include "templates/snippets.php";
include "config.php";

$parts = explode('?', $_SERVER['REQUEST_URI'], 2);

config()->path = $parts[0];
config()->uri = array_slice(explode('/', $parts[0]), 1);
config()->page = config()->uri[0];
config()->promo = isset($_GET['promo']) ? $_GET['promo'] : false;


if (!config()->page) {
  config()->page = "home";
}

if (file_exists("pages/" . config()->page . ".php")) {
  include "pages/" . config()->page . ".php";
} else {
  include "pages/404.php";
}


?>