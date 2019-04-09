
<html>

<head>
  <link href="main.css" type="text/css" rel="stylesheet">
  <title>Random Art Project</title>
  <script src="processingJS.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/p5.min.js" crossorigin=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/addons/p5.dom.min.js" crossorigin=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/addons/p5.sound.min.js" crossorigin=""></script>
  <div id="container">
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
float increment = 0.015 * scale;
int maxHeight = round(random(1000));

int R = round(random(255));
int G = round(random(255));
int B = round(random(255));
color gradientStart = color(R,G,B);

void setup() {
  size(500,500,P3D);
  canvaslocationheight = ((screenheight - height) / 2) + "px";
  canvaslocationwidth = ((screenwidth - width) / 2) + "px";
  document.getElementById("mycanvas").style.marginTop = canvaslocationheight;
  document.getElementById("mycanvas").style.marginLeft = canvaslocationwidth;
  beginCamera();
  camera();
  rotateX(radians(0));
  endCamera();
  lights();
  getNoiseLandscape();
}

void getNoiseLandscape() {
  for(int y=0; y<height; y+=scale) {
    for(int x=0; x<width; x+=scale) {
      float xWarp = x * 0.001;
      float yWarp = y * 0.001;
      float warpX1 = noise(xWarp + 1, yWarp + 1);
      float warpY1 = noise(xWarp + 2, yWarp + 2);
      float warpX2 = noise(xWarp + 3 * warpX1, yWarp + 3 * warpY1);
      float warpY2 = noise(xWarp + 4 * warpX1, yWarp + 4 * warpY1);
      float warpX3 = noise(xWarp + 5 * warpX2, yWarp + 5 * warpY2);

      color gradientEnd = color(warpX1*255,warpY1*255,warpX2*255);

      int r = round(map(warpX3, 0, 1, red(gradientStart), red(gradientEnd)));
      int g = round(map(warpX3, 0, 1, green(gradientStart), green(gradientEnd)));
      int b = round(map(warpX3, 0, 1, blue(gradientStart), blue(gradientEnd)));

      color Color = color(r,g,b);
      noStroke();
      pushMatrix();
      fill(Color);
      translate(x,y,(warpX3 * maxHeight)/2);
      box(scale,scale,warpX3 * maxHeight);
      popMatrix();
    }
  }
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
