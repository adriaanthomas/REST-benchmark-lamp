<?php
class RestController {
  private $mysqli;
  public $server;

  public function __construct() {
    $this->mysqli = new mysqli('localhost', 'rest', 'rest', 'rest');
    /* check connection */
    if (mysqli_connect_errno()) {
      printf("Connect failed: %s\n", mysqli_connect_error());
      exit();
    }
  }

  public function __destruct() {
    $this->mysqli->close();
  }

  /**
   * @url GET /
   * @url GET /rest
   */
  public function welcome() {
    return "Hello Xebia!";
  }

  /**
   * Returns the data item for the given id.
   *
   * @url GET /rest/get/$id
   */
  public function getData($id) {
    if ($stmt = $this->mysqli->prepare("SELECT short_string, long_string, int_number, true_or_false FROM rest_data2 WHERE id=?")) {
      $stmt->bind_param('s', $id);
      $stmt->execute();
      $stmt->bind_result($short_string, $long_string, $int_number, $true_or_false);
      $data = null;
      $found = $stmt->fetch();
      $stmt->close();

      if ($found) {
        return array(
                      'id'                      => 0 + $id,
                      'shortStringAttribute'    => $short_string,
                      'longStringAttribute'     => $long_string,
                      'intNumber'               => $int_number,
                      'trueOrFalse'             => $true_or_false != 0
                      );
      } else {
        $this->server->handleError(404);
        exit();
      }
    }
  }

  /**
   * Inserts data.
   *
   * @url POST /rest/put/$id
   */
  public function postData($id, $data) {
    if ($id != $data->id) {
      $this->server->handleError(409);
      exit();
    }
    if ($stmt = $this->mysqli->prepare('INSERT INTO rest_data2(id, short_string, long_string, int_number, true_or_false) VALUES(?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE short_string=?, long_string=?, int_number=?, true_or_false=?')) {
      $stmt->bind_param('dssddssdd', $id, $data->shortStringAttribute, $data->longStringAttribute, $data->intNumber, $data->trueOrFalse, $data->shortStringAttribute, $data->longStringAttribute, $data->intNumber, $data->trueOrFalse);
      $stmt->execute();
      $stmt->close();
    }
  }
}
?>
