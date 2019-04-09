<?php session_start(); ?>
<?php
$gebruikersnaam = $_SESSION['gebruikersnaam'];
include 'serverinfo.php';
$mysqli = mysqli_connect($server, $user, $password, $database);
$artnr = $_POST['artnr'];
$update = $_POST['update'];
if ($update === 'likes') {
  $likesgained = mysqli_query($mysqli, "SELECT * From likes WHERE art_liked = '$artnr'  AND liked_state = 'like'");
  $result = mysqli_num_rows($likesgained);
} else if ($update === 'dislikes') {
  $dislikesgained = mysqli_query($mysqli,"SELECT * From likes WHERE art_liked = '$artnr' AND liked_state = 'dislike'");
  $result = mysqli_num_rows($dislikesgained);

} else {
  $likesgained = mysqli_query($mysqli, "SELECT * From likes WHERE art_liked = '$artnr'  AND liked_state = 'like'");
  $likes = mysqli_num_rows($likesgained);
  $dislikesgained = mysqli_query($mysqli,"SELECT * From likes WHERE art_liked = '$artnr' AND liked_state = 'dislike'");
  $dislikes = mysqli_num_rows($dislikesgained);
  if ($dislikes > 0 AND $likes > 0) {
        $result = $likes/$dislikes;
        $result = round($liketodislikeratio,2);
        if (strlen($result) === 1) {
          $result = $result . '.00';
        }
        if (strlen($result) === 3) {
          $result = $result . '0';
        }
      }
      if ($dislikes === 0) {
        $result = $likes . '.00';
      }
      if ($likes === 0) {
        $result = '-' . $dislikes . '.00';
      }
      if ($dislikes === 0 AND $likes === 0) {
        $result = '0.00';
      }
}

echo $result;
?>
