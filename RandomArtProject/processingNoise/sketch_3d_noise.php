
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
int totalAddTo = 0;
float scale = 2.0;
float increment = 0.015 * scale;
int total = 0;
int maxHeight = 50;
var screenwidth = $( window  ).width();
var screenheight = $( window  ).height();

void setup() {
 size(500,500,P3D);
 canvaslocationheight = ((screenheight - height) / 2) + "px";
 canvaslocationwidth = ((screenwidth - width) / 2) + "px";
 document.getElementById("mycanvas").style.marginTop = canvaslocationheight;
 document.getElementById("mycanvas").style.marginLeft = canvaslocationwidth;
 beginCamera();
 camera();
 rotateX(-0.75);
 endCamera();
 lights();
 getNoiseLandscape();
}

float[] heightMap = new float[64000000];
float xPos = width/2;
float yPos = height/4;

void getNoiseLandscape() {;
 noiseDetail(10,0.5);
 float xOff = 0;
 for(int x = 0; x < width; x += scale) {
   xOff += increment;
   float yOff = 0;
   for(int y = 0; y < height/2; y += scale) {
   yOff += increment;
   float Noise = noise(xOff * scale, yOff * scale);
   heightMap[totalAddTo] = round(Noise * maxHeight);
   totalAddTo += 1;
   }
 }
 for(int y = 0; y < height/2; y += scale) {
    for(int x = 0; x < width; x += scale) {
      noStroke();
      pushMatrix();
      translate(xPos,yPos-height/2,-100);
      box(scale,scale,heightMap[total]);
      popMatrix();
      total += 1;
      xPos += scale;
    }
    xPos = 0.0;
    yPos += scale;
  }
  yPos = 0.0;
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
