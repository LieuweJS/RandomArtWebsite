<?php session_start(); ?>
<?php
include 'serverinfo.php';
$mysqli = mysqli_connect($server, $user, $password, $database);
if ($mysqli->connect_error) {
   die("Connection failed: " . $mysqli->connect_error);
}
$gebruikersnaam = $_SESSION['gebruikersnaam'];
$artnr = $_POST['artnr'];
$sql = mysqli_query($mysqli,"INSERT INTO likes (user_name, liked_state, art_liked) VALUES ('$gebruikersnaam', 'liked', '$artnr')");
echo "$artnr";
?>
