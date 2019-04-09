<?php session_start(); ?>
<html>
<head>
 <link href="main.css" type="text/css" rel="stylesheet">
  <title>Artwork 8</title>
</head>
<body>
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
<canvas id="myCanvas" width="500" height="500" style="z-index:1000;border:1px solid #000000" ></canvas>
<script type="text/javascript">
var x = 0
var height = 0
var totWidth = 500
var y = 0
var c = document.getElementById("myCanvas");
var screenwidth = $( window  ).width();
var screenheight = $( window  ).height();
canvaslocationheight = ((screenheight - c.height) / 2) + "px";
canvaslocationwidth = ((screenwidth -c.width) / 2) + "px";
c.style.marginTop = canvaslocationheight;
c.style.marginLeft = canvaslocationwidth;
var ctx = c.getContext("2d")
function get_random_color() {
    var h = 0
    var s = 0
    var l = Math.floor(Math.random() * 100) + 1
    return 'hsl(' + h + ',' + s + '%,' + l + '%)';
}
for (height = 0; height < 500; height++) {
  while (totWidth >= 0) {
    ctx.beginPath()
    ctx.rect(x, y, 1, 1)
    ctx.fillStyle = get_random_color()
    ctx.fill()
    x = x + 1
    totWidth = totWidth - 1
  }
  y = y + 1
  x = 0
  totWidth = 500
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
            category: 'number8'
        },
    url: 'processingimages.php',
  });
  document.getElementById("message").innerHTML = "Saved!";
};
</script>
<p style="text-align: center;" id="message"></p>
</body>
</html>
