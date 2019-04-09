<?php session_start(); ?>
<?php
  include 'serverinfo.php';
  $mysqli = mysqli_connect($server, $user, $password, $database);
  $artnr = $_POST['artnr'];
  $sql = "DELETE FROM art WHERE artnr = $artnr;";
  $result = $mysqli->query($sql);

?>
