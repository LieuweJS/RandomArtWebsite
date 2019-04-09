<?php session_start(); ?>
<?php
$artnr = $_POST['artnr'];
$gebruikersnaam = $_SESSION['gebruikersnaam'];
include 'serverinfo.php';
$mysqli = mysqli_connect($server, $user, $password, $database);
  $artnr = $_POST['artnr'];
  $sql = "SELECT artnr, user, art, category FROM art WHERE user = '$gebruikersnaam' AND artnr = '$artnr'";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
    $artnr = ($row['artnr']);
    $user = ($row['user']);
    $art = ($row['art']);
    $category = ($row['category']);
  }
echo json_encode($art);
?>
