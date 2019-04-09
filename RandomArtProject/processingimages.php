<?php session_start(); ?>
<?php
include 'serverinfo.php';
$mysqli = new mysqli($server, $user, $password, $database);
$gebruikersnaam = $_SESSION['gebruikersnaam'];
$img = $_POST['imgBase64'];
$width = $_POST['width'];
$height = $_POST['height'];
if (!isset($_POST['height'])) {
  $width = '500';
  $height = '500';
}
//$img = str_replace('data:image/png;base64,', '', $img);
//$img = str_replace(' ', '+', $img);
$category = $_POST['category'];
$sql = mysqli_query($mysqli, "INSERT INTO art (user, art, category, width, height) VALUES ('$gebruikersnaam', '$img', '$category', '$width', '$height')");
?>
