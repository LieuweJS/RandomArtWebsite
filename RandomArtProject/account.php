<?php session_start(); ?>

<html>
<head>
  <link href="main.css" type="text/css" rel="stylesheet">
  <title>account</title>
</head>
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
  <br />
  <br />
<?php
include 'serverinfo.php';
$mysqli = mysqli_connect($server, $user, $password, $database);
if ($mysqli->connect_error) {
   die("Connection failed: " . $mysqli->connect_error);
}
print("database connected". "<br />");

if(EMPTY($_SESSION['gebruikersnaam'])) {
  print("you are not logged in");
  echo '<a href="login.php">
        <button id="loginButton">login page</button>
        </a>';
}
else {
  $gebruikersnaam = $_SESSION['gebruikersnaam'];
  $emailadres = $_SESSION['emailadres'];
  print("your username is: " . $gebruikersnaam . "<br />");
  print("your e-mail adress is:     " . $emailadres . "<br />");
  $sql = "SELECT user_verified FROM user_info WHERE user_name = '$gebruikersnaam' AND user_email = '$emailadres'"; 
  $result = $mysqli->query($sql);  
  $row = mysqli_fetch_row($result);
  //echo $row[0];
  //echo '<br />';
  if ($row[0] == 1 ) { 
    echo 'your account has been verified. <br />';
  }
  if($row[0] == 0) {
    echo 'your account has not been verified, if you wish to verify your account, click the link in the verification e-mail that was send to your e-mail adress. <br />';
  }
  echo '<a href="logout.php">
        <button id="logoutButton">logout</button>
        </a';
}
?>
</body>
</html>