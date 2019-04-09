<?php session_start(); ?>
<html>

<head>
   <link href="main.css" type="text/css" rel="stylesheet">
  <title>Artwork 16</title>
</head>

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
  <canvas id="myCanvas" width="500" height="500" style="z-index:1000;border:1px solid #000000"></canvas>
  <script type="text/javascript">
    // dit is geen sin grafiek maar een acos grafiek, geen zin om alles te veranderen.
    var iterations = 1
    var itTotal = iterations - 1
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

    function random_sin() {
      var randomColor = "#" + (Math.random().toString(16) + "000000").slice(2, 8)
      var random = Math.floor(Math.random() * 400) + 1
      var random2 = Math.floor(Math.random() * 200) + 1
      var i
      var RandHeight = Math.floor(Math.random() * 500) + 1
      var counter = 0,
        x = 0,
        y = 180
      var increase = random2 / random * Math.PI / 9
      for (i = 0; i <= 500; i += 10) {
        ctx.moveTo(x, y)
        x = i
        y = RandHeight - Math.acos(counter) * 120
        counter += increase
        ctx.lineTo(x, y)
      }
      ctx.strokeStyle = "#" + (Math.random().toString(16) + "000000").slice(2, 8)
      ctx.stroke()
    }
    random_sin()
    for (i = 0; i <= itTotal; i += 1) {
      random_sin()
    }
  </script>
<body>
  <br />
  <button style="width: 300px; position: fixed; margin: auto; left: 50%; margin-left: -150px;" id="button" href=# onclick="random_sin()">Click on me to add another graph!</button>
  <br />
  <br />
  <button style="width: 300px; position: fixed; margin: auto; left: 50%; margin-left: -150px;"id="button" href=# onclick="random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();">Click on me to add another 10 graphs!</button>
  <br />
  <br />
  <button style="width: 300px; position: fixed; margin: auto; left: 50%; margin-left: -150px;" id="button" href=# onclick="random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();                  random_sin();random_sin();random_sin();random_sin();random_sin();                  random_sin();random_sin();random_sin();random_sin();random_sin();                  random_sin();random_sin();random_sin();random_sin();random_sin();                  random_sin();random_sin();random_sin();random_sin();random_sin();                   random_sin();random_sin();random_sin();random_sin();random_sin();                   random_sin();random_sin();random_sin();random_sin();random_sin();                   random_sin();random_sin();random_sin();random_sin();random_sin();                   random_sin();random_sin();random_sin();random_sin();random_sin();                  random_sin();random_sin();random_sin();random_sin();random_sin();                   random_sin();random_sin();random_sin();random_sin();random_sin();                   random_sin();random_sin();random_sin();random_sin();random_sin();                   random_sin();random_sin();random_sin();random_sin();random_sin();                   random_sin();random_sin();random_sin();random_sin();random_sin();                  random_sin();random_sin();random_sin();random_sin();random_sin();                   random_sin();random_sin();random_sin();random_sin();random_sin();                   random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();random_sin();">Click on me to add another 100 graphs!</button>
  <br />
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
    echo '<br />' . '<button style="position: fixed; margin: auto; left: 50%; width: 50px; margin-left: -25px;" id="button" onclick="getImg()">Save</button>' . '<br />';
    }
?>
<script>
function getImg() {
  var img = myCanvas.toDataURL();
      console.log(img)

  $.ajax({
    type: 'POST',
    data: { imgBase64: img,
            category: 'number16'
        },
    url: 'processingimages.php',
  });
  document.getElementById("message").innerHTML = "Saved!";
};
</script>
<p style="text-align: center;" id="message"></p>
</body>

</html>
