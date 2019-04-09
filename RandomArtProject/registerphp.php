<?php session_start(); ?>
<?php
require_once 'Bcrypt.php';

$email = $_POST['email'];
$gebruikersnaam = $_POST['user'];
$wachtwoord = $_POST['pass'];
$wachtwoord_bevestigen = $_POST['passconfirm'];
$length_username = strlen($gebruikersnaam);
$password_length = strlen($wachtwoord);

include 'serverinfo.php';
$mysqli = mysqli_connect($server, $user, $password, $database);
if ($mysqli->connect_error) {
   die("Connection failed: " . $mysqli->connect_error);
}

if(empty($_POST['email'])) {
$succes = "you must fill in an e-mailadress, try again.";
} else {
  if($length_username < 5 ) {
  $succes = "your username must be 5 characters or longer.";
  } else {
    if($password_length < 5) {
    $succes = "your password must be 5 characters or longer.";
    } else {
      if($wachtwoord != $wachtwoord_bevestigen) {
      $succes = "your password and confirm password don't match, try again.";
      }
      else {
        $checkuseremail = "SELECT * FROM user_info WHERE user_name = '$email'";
        $checkemail = $mysqli->query($checkuseremail);
        if (mysqli_num_rows($checkemail) == 0) {
          //hash wachtwoord
          $hashed = Bcrypt::hashPassword($wachtwoord);

          $unhasher = Bcrypt::checkPassword($wachtwoord, $hashed);

          //email bot and account register query
          $code = md5(rand(1,10000000));
          $sql = mysqli_query($mysqli,"INSERT INTO user_info (user_name, user_email, user_password, user_verification_code) VALUES ('$gebruikersnaam', '$email', '$hashed', '$code')");
          if($sql) {

            //send email
            $naar = $email;
            $onderwerp = 'account verification';
            $bericht =
            'dear ' . $gebruikersnaam . "\r\n" . ' to activate your account, please click the following link: ' . "\r\n"
            . 'https://infgc.tk/~17h_lieuweb/RandomArtProject/verify.php?email='. $email . '&code=' . $code . '
            if you have not registered an account on thsi website, please ignore this email.';
            $koppen = 'From: noreply@RandomArtProject' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
            mail($naar, $onderwerp, $bericht, $koppen);
          }

          if(!$sql) {
            $succes = "an account with this e-mail or username has already been made.";
          } else {
            $succes = "your account has been created, please verify your e-mail by clicking the link send to your e-mailadress. (check your spam folder)";
          }
        }
        else {
          $succes  ="an account with this e-mail or username has already been made.";
        }
      }
    }
  }
}
echo $succes;
?>
