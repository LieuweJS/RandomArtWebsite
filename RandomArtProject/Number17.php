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
<title>Kunstwerk 4</title>
<body>
<canvas id="myCanvas" width="500" height="500" style="z-index:1000;border:1px solid #000000" ></canvas>
<script type="text/javascript">
var c = document.getElementById("myCanvas");
var screenwidth = $( window  ).width();
var screenheight = $( window  ).height();
canvaslocationheight = ((screenheight - c.height) / 2) + "px";
canvaslocationwidth = ((screenwidth -c.width) / 2) + "px";
c.style.marginTop = canvaslocationheight;
c.style.marginLeft = canvaslocationwidth;
var ctx = c.getContext("2d")
var x = 0
var y = 0
var totWidth = 500
function getRANDCOLOR() {
  var h = Math.floor(Math.random() * 360);
  var s = Math.floor(Math.random() * 25) + 60
  var l = Math.floor(Math.random() * 25) + 40
  return 'hsl(' + h + ',' + s + '%,' + l + '%)';
}
for (height = 0; height < 250; height++) {
  while (totWidth >= 0) {
    ctx.beginPath()
    ctx.rect(x, y, 2, 2)
    ctx.fillStyle = getRANDCOLOR();
    ctx.fill()
    x = x + 2
    totWidth = totWidth - 2
  }
  y = y + 2
  x = 0
  totWidth = 500
}

function getHSLcolor(input) {
  var h = input;
  var s = 100;
  var l = 50;
}
</script>
  <?php
  include 'serverinfo.php';
  $mysqli = mysqli_connect($server, $user, $password, $database);
  if ($mysqli->connect_error) {
     die("Connection failed: " . $mysqli->connect_error);
  }
  if(EMPTY($_SESSION['gebruikersnaam'])) {
    print("u bent niet ingelogd en kunt geen kunst op slaan.");
  }
  else {
    $gebruikersnaam = $_SESSION['gebruikersnaam'];
    echo '<button id="onclickbutton" onclick="getImg()">opslaan</button>';
    }
?>
<script>
function getImg() {
  var img = myCanvas.toDataURL();
  $.ajax({
    type: 'POST',
    data: { imgBase64: img,
            category: 'number4'
        },
    url: 'processingimages.php',
  });
  document.getElementById("message").innerHTML = "opgeslagen!";
};
</script>
<p style="text-align: center;" id="message"></p>
</body>
</html>
