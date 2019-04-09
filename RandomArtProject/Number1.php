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
<title>Artwork 1</title>
<body>
<canvas id="myCanvas" width="500" height="500" style="z-index:1000; border:1px solid #000000"></canvas>
<script type="text/javascript">
var c = document.getElementById("myCanvas");
var screenwidth = $( window  ).width();
var screenheight = $( window  ).height();
canvaslocationheight = ((screenheight - c.height) / 2) + "px";
canvaslocationwidth = ((screenwidth - c.width) / 2) + "px";
c.style.marginTop = canvaslocationheight;
c.style.marginLeft = canvaslocationwidth;
var ctx = c.getContext("2d");
var x = 0;
var y = 0;
var totWidth = 500;
for (height = 0; height < 500; height++) {
  while (totWidth >= 0) {
    var result = ['white', 'black'][Math.floor(Math.random() * 2)];
    ctx.beginPath();
    ctx.rect(x, y, 1, 1);
    ctx.fillStyle = result;
    ctx.fill();
    x = x + 1;
    totWidth = totWidth - 1;
  }
  y = y + 1;
  x = 0;
  totWidth = 500;
}
</script>
<?php
  include 'serverinfo.php';
  $mysqli = mysqli_connect($server, $user, $password, $database);
  if ($mysqli->connect_error) {
     die("Connection failed: " . $mysqli->connect_error);
  }
  if(EMPTY($_SESSION['gebruikersnaam'])) {
    print("<p style='text-align: center;'>" . "you are not logged in so you can't save any art, please log in." . "</p>");
  }
  else {
    $gebruikersnaam = $_SESSION['gebruikersnaam'];
    echo '<br />'  . '<br />' . '<button style="position: fixed; width: 50px; left: 50%; margin-left: -25; " id="button" onclick="getImg()">Save</button>' . '<br />';
    }
?>
<script>
function getImg() {
  var img = myCanvas.toDataURL();
  $.ajax({
    type: 'POST',
    data: { imgBase64: img,
            category: 'number1'
        },
    url: 'processingimages.php',
  });
  document.getElementById("message").innerHTML = "Saved!";
};
</script>
<p style="text-align: center;" id="message"></p>
</body>
</html>
