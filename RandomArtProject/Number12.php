<?php session_start(); ?>
<html>
<head>
  <link href="main.css" type="text/css" rel="stylesheet">
  <title>Artwork 12</title>
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
<canvas id="myCanvas" width="410" height="500" style="z-index:1000;border:1px solid #000000" ></canvas>
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
function get_random_color_black() {
    var h = 0
    var s = 0
    var l = Math.floor(Math.random() * 33) + 1
    return 'hsl(' + h + ',' + s + '%,' + l + '%)';
}
function get_random_color_gray() {
    var h = 0
    var s = 0
    var l = Math.floor(Math.random() * 33) + 33
    return 'hsl(' + h + ',' + s + '%,' + l + '%)';
}
function get_random_color_white() {
    var h = 0
    var s = 0
    var l = Math.floor(Math.random() * 33) + 66
    return 'hsl(' + h + ',' + s + '%,' + l + '%)';
}
for (height = 0; height < 500; height++) {
  while (totWidth >= 0) {
    var randWidth = Math.floor(Math.random() * 8) + 1
    if (totWidth >400 || totWidth <100) {
    ctx.beginPath()
    ctx.rect(x, y, randWidth, 1)
    ctx.fillStyle = get_random_color_black()
    ctx.fill()
    x = x + randWidth
    totWidth = totWidth - randWidth
  } else {
      if (totWidth >300 || totWidth <200) {
        ctx.beginPath()
        ctx.rect(x, y, randWidth, 1)
        ctx.fillStyle = get_random_color_gray()
        ctx.fill()
        x = x + randWidth
        totWidth = totWidth - randWidth
       } else {
          ctx.beginPath()
          ctx.rect(x, y, randWidth, 1)
          ctx.fillStyle = get_random_color_white()
          ctx.fill()
          x = x + 1
          totWidth = totWidth - randWidth
       }
    }
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
            category: 'number12',
            width: '410',
            height: '500'
        },
    url: 'processingimages.php',
  });
  document.getElementById("message").innerHTML = "Saved!";
};
</script>
<p style="text-align: center;" id="message"></p>
</body>
</html>
