<?php
class Cashiering {
  // code goes here...
  
  protected $con;
  public function setDb($db)
  {
      $this->con = $db;
  }

  public function GetAll()
  {
    $sql = "SELECT * FROM `payments`;";
    $result = mysqli_query($this->con, $sql);

    return $result;
  }
}
?>