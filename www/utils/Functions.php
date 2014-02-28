<?


function choose() {
  foreach (func_get_args() as $key => $value) {
    if ($value) return $value;
  }
  return NULL;
}

function flash($type = null, $msg = null) {
  if (!$type && !$msg) {
    $ret = array(
      isset($_SESSION['flash_type']) ? $_SESSION['flash_type'] : false,
      isset($_SESSION['flash_message']) ? $_SESSION['flash_message'] : false
    );
    $_SESSION['flash_type'] = null;
    $_SESSION['flash_message'] = null;
    if ($ret[0] || $ret[1]) return $ret;
    return null;
  } else {
    $_SESSION['flash_type'] = $type;
    $_SESSION['flash_message'] = $msg;
  }
}

function redirect($url, $prepend = false) {
  if ($prepend) $url = 'http://' . $_SERVER['SERVER_NAME'] . $url;
  header("Location: $url");
  die();
}

function writeToFile($file, $string, $mode = "a+") {
    $fh = fopen($file, "a+");
    if ($fh) {
        flock($fh, LOCK_EX);
        fwrite($fh, $string);
        fflush($fh);
        flock($fh, LOCK_UN);
        return true;
    } else {
        fclose($fh);
        return false;
    }
}

function writeToCSV($file, $items) {
    $fh = fopen($file, "a+");
    if ($fh) {
        flock($fh, LOCK_EX);
        fputcsv($fh, $items);
        fflush($fh);
        flock($fh, LOCK_UN);
        return true;
    } else {
        fclose($fh);
        return false;
    }
}

?>