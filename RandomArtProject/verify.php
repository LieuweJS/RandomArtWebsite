<html>
<head>
  <link href="main.css" type="text/css" rel="stylesheet">
  <title>verify account</title>
</head>
  <script src="libs/sessions.js"></script>
<body>
  <div id="container">
    <div id="menuknoppen">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    $(function() {
      $("#navbar").load("navbarHUB.html");
    });
    </script>
    <div id="navbar"></div>
    </div>
  </div>
<?php
error_reporting(0);
include 'serverinfo.php';
$mysqli = mysqli_connect($server, $user, $password, $database);
if ($mysqli->connect_error) {
   die("Connection failed: " . $mysqli->connect_error);
}
$email = $_GET['email'];
$code = $_GET['code'];
echo $email;
echo '<br />';
echo $code;
echo '<br />';
echo '<br />';
$sql = "SELECT * FROM user_info WHERE user_email = '$email' AND user_verification_code = '$code'";
$result = $mysqli->query($sql);
if (mysqli_num_rows($result) > 0) {
  $verifiedsql = "UPDATE  user_info SET user_verified = 1 WHERE user_email = '$email' AND user_verification_code = '$code'";
  $result = $mysqli->query($verifiedsql);
  if(!$result) {
    echo 'sql error';
  }
  if($result) {
    echo 'succes, your account has been verified';
  }
} else {
  echo 'data does not match, account has not been verified.';
}

?>
</body>
</html>
