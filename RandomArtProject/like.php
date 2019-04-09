<?php session_start(); ?>
<?php
include 'serverinfo.php';
$mysqli = mysqli_connect($server, $user, $password, $database);
if ($mysqli->connect_error) {
   die("Connection failed: " . $mysqli->connect_error);
}

$gebruikersnaam = $_SESSION['gebruikersnaam'];
$artnr = $_POST['artnr'];
$whatlike = $_POST['whatlike'];
//check if user has already liked or disliked this art
$checkIfLiked = mysqli_query($mysqli,"SELECT ID FROM likes WHERE user_name = '$gebruikersnaam' AND art_liked = '$artnr' AND liked_state = '$whatlike'");
if (mysqli_num_rows($checkIfLiked) > 0) {
  $style = 'unliked';
  $sql = mysqli_query($mysqli,"DELETE FROM likes WHERE user_name = '$gebruikersnaam' AND art_liked = '$artnr'");
} else {
  $style = 'liked';
  $sql = mysqli_query($mysqli,"DELETE FROM likes WHERE user_name = '$gebruikersnaam' AND art_liked = '$artnr'");
  $sql = mysqli_query($mysqli,"INSERT INTO likes (user_name, liked_state, art_liked) VALUES ('$gebruikersnaam', '$whatlike', '$artnr')");
}
echo $style;
?>
