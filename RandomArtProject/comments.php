<?php session_start(); ?>
<?php
include 'serverinfo.php';
$mysqli = mysqli_connect($server, $user, $password, $database);
if ($mysqli->connect_error) {
   die("Connection failed: " . $mysqli->connect_error);
}
$artnr = $_POST['artnr'];
$user = $_POST['user'];
$comment = $_POST['comment'];
$addcomment = mysqli_query($mysqli,"INSERT INTO comments (user_name, art_commented, comment) VALUES ('$user',  '$artnr', '$comment')");

?>
