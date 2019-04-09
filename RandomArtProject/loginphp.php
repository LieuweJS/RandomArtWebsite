<?php
require_once 'Bcrypt.php';
session_start(); 
unset($_SESSION['gebruikersnaam']); 
unset($_SESSION['emailadres']); 
error_reporting(0);
$email = $_POST["email"];
$gebruikersnaam = $_POST["user"];
$wachtwoord = $_POST["pass"];
  
include 'serverinfo.php';
$mysqli = mysqli_connect($server, $user, $password, $database);
$sql = "SELECT user_password FROM user_info WHERE user_email = '$email' AND user_name = '$gebruikersnaam'"; 
$result = $mysqli->query($sql);
while ($row = $result->fetch_assoc()) {  
 $storedhash = ($row['user_password']);
}
$unhashed = Bcrypt::checkPassword($wachtwoord, $storedhash);
if($unhashed) {
   $succes ='password correct, you have been signed in!';
   $_SESSION['gebruikersnaam'] = $gebruikersnaam;
   $_SESSION['emailadres'] = $email;
 }
if(!$unhashed) {
  $succes = 'password incorrect!';  
}
echo $succes;
?>