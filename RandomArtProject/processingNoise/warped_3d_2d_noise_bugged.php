
<html>

<head>
  <link href="main.css" type="text/css" rel="stylesheet">
  <title>Random Art Project</title>
  <script src="processingJS.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/p5.min.js" crossorigin=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/addons/p5.dom.min.js" crossorigin=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/addons/p5.sound.min.js" crossorigin=""></script>
  <div id="container">
    <div id="kop">
      <a href="index.php" class="newanchor">Random Art Project</a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    $(function() {
      $("#navbar").load("navbar.html");
    });
    </script>
    <div id="navbar"></div>
  </div>
</head>
<body>
 <script type="text/processing" data-processing-target="mycanvas">
var screenwidth = $( window  ).width();
var screenheight = $( window  ).height();
int displayWidth = screenwidth;
int displayHeight = screenheight;
float scale = 1.0;
int maxHeight = 50;

void setup() {
 colorMode(HSB);
 size(500,500,P3D);
 canvaslocationheight = ((screenheight - height) / 2) + "px";
 canvaslocationwidth = ((screenwidth - width) / 2) + "px";
 document.getElementById("mycanvas").style.marginTop = canvaslocationheight;
 document.getElementById("mycanvas").style.marginLeft = canvaslocationwidth;
 beginCamera();
 camera();
 endCamera();
 lights();
 getNoiseLandscape();
}

void getNoiseLandscape() {;
 for(int x = 0; x < width; x += scale) {
   for(int y = 0; y < height; y += scale) {
     color Color = warp(x*0.0105,y*0.01);
     noStroke();
     pushMatrix();
     fill(Color);
     translate(x,y,round(Color)/2);
     box(scale,scale,round(Color * maxHeight));
     popMatrix();
   }
 }
}

color warp(float x, float y) {
  //warps
  float warpX1 = noise(x + 1, y + 1);
  float warpY1 = noise(x + 2, y + 2);
  float warpX2 = noise(x + 3 * warpX1, y + 3 * warpY1);
  float warpY2 = noise(x + 4 * warpX1, y + 4 * warpY1);
  float warpX3 = noise(x + 5 * warpX2, y + 5 * warpY2);
  float warpY3 = noise(x + 6 * warpX2, y + 6 * warpY2);

  float H = noise(x + 3 * warpX1, y + 3 * warpY1);
  float S = noise(x + 3.1 * warpX2, y + 3.1 * warpY2);
  float B = noise(x + 3.2 * warpX3, y + 3.2 * warpY3);
  color Color = color((H*360), (S*360), (B*360));
  return Color;
}
 </script>
 <canvas id="mycanvas"></canvas>
   <?php
  session_start();
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
  var img = mycanvas.toDataURL();
  $.ajax({
    type: 'POST',
    data: { imgBase64: img,
            category: 'number5'
        },
    url: 'https://infgc.tk/~17h_lieuweb/RandomArtProject/processingimages.php',
  });
  document.getElementById("message").innerHTML = "Saved!";
};
</script>
<p style="text-align: center;" id="message"></p>
</body>

</html>
