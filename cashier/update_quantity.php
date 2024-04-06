<?php
session_start();
if (isset($_POST['item_id'])) {
    $key = array_search($_POST['item_id'], array_column($_SESSION['foodarr'], 'item_id'));
    if ($key !== false) {
      // Reset array keys
      $_SESSION['foodarr'][$key]["qty"] = $_POST['quantity'];
      
      echo $_SESSION['foodarr'][$key]["qty"];
    }
} else {
    echo 'Error: New value not provided.';
}
?>