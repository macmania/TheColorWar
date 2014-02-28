<?


class Container {
  private $data;
  public function __construct() {
    $this->data = array();
  }
  public function __set($key, $val) {
    $this->data[$key] = $val;
  }
  public function __get($key) {
    if (!isset($this->data[$key])) return NULL;
    return $this->data[$key];
  }
  public function push($key, $val) {
    if (!isset($this->data[$key])) $this->data[$key] = array();
    array_push($this->data[$key], $val);
  }
  public function each($key, $func) {
    if ($this->{$key} === NULL) return;
    foreach ($this->{$key} as $k => $elem) {
      $func($k, $elem);
    }
  }
}
class Config extends Container {
  private static $instance;
  public function __construct() {
    self::$instance = $this;
  }
  public static function get() {
    if (!self::$instance) self::$instance = new Config();
    return self::$instance;
  }
}

function config() { return Config::get(); }

?>