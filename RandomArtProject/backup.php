<?php session_start(); ?>

<html>
<head>
<div id="container">

  <div id="menuknoppen">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
      $(function() {
        $("#navbar").load("navbar.html");
      });
    </script>
    <div id="navbar"></div>
  </div>
</div>
<link href="main.css" type="text/css" rel="stylesheet">
<title>display test</title>
<body>
<?php
include 'serverinfo.php';
$mysqli = mysqli_connect($server, $user, $password, $database);
if ($mysqli->connect_error) {
   die("Connection failed: " . $mysqli->connect_error);
}
if(EMPTY($_SESSION['gebruikersnaam'])) {
  print("u bent niet ingelogd en kunt geen kunst opslaan.");
}
else {
  $gebruikersnaam = $_SESSION['gebruikersnaam'];
  $sql = "SELECT artnr, category FROM art WHERE user = '$gebruikersnaam'";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
    $artnumber = ($row['artnr']);
    $cat = ($row['category']);
    echo "<button id=button onClick=artPost($artnumber)>artnumber $artnumber category $cat</button>";
    echo '<br />';
    }
}
?>
<script>
function artPost($artnumber) {
  var artnr = $artnumber
  console.log(artnr)
  $.post("getArtphp.php", {
      artnr: artnr
    },
    function(response) {
      data = response
      //dataUrl = data.split('')
      drawImg()
    })
}
function drawImg() {
  //imgUrl = dataUrl.join('')
 console.log(data)
 var imgUrl = data
}

</script>
<canvas id="myCanvas" width="500" height="500" style="z-index:1000; position: absolute; top: 200px; left: 700px;border:1px solid #000000"></canvas>
</body>
</html>




<?php session_start(); ?>
<?php
  $server = 'localhost';
  $user = '17h_jellek';
  $password = 'xofjjs';
  $database = '17h_jellek_RandomArtProject';
  $mysqli = mysqli_connect($server, $user, $password, $database);
  if ($mysqli->connect_error) {
     die("Connection failed: " . $mysqli->connect_error);
  }
  if(EMPTY($_SESSION['gebruikersnaam'])) {
    print("u bent niet ingelogd en kunt geen kunst opslaan.");
  }
  else {
    $gebruikersnaam = $_SESSION['gebruikersnaam'];
    $sql = "SELECT artnr, user, art, category FROM art WHERE user = '$gebruikersnaam'";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
     $artnr = ($row['artnr']);
     $user = ($row['user']);
     $art = ($row['art']);
     $category = ($row['category']);
    }
    echo json_encode($art);
  }
?>
