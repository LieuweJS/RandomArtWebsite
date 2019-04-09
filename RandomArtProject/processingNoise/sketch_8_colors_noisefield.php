
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
color color1 = color(99, 186, 170);
color color2 = color(72, 156, 147);
color color3 = color(65, 139, 150);
color color4 = color(84,148,129);
color color5 = color(40,91,102);
color color6 = color(61,99,83);
color color7 = color(21,51,61);
color color8 = color(40,61,49);

float increment = 0.02;
void setup() {
 size(500,500);
 canvaslocationheight = ((screenheight - height) / 2) + "px";
 canvaslocationwidth = ((screenwidth - width) / 2) + "px";
 document.getElementById("mycanvas").style.marginTop = canvaslocationheight;
 document.getElementById("mycanvas").style.marginLeft = canvaslocationwidth;
 loadPixels();
noiseDetail(10,0.5);
 float xOff = 0;
 for(int x = 0; x < width; x++) {
   xOff += increment;
   float yOff = 0;
   for(int y = 0; y < height; y++) {
     yOff += increment;
     float Noise = noise(xOff, yOff);
     if (Noise < 0.2) {
       pixels[x+y*width] = color1;
     } else if (Noise < 0.25) {
       pixels[x+y*width] = color2;
     } else if (Noise < 0.3) {
       pixels[x+y*width] = color3;
     }else if (Noise < 0.4) {
       pixels[x+y*width] = color4;
     }else if (Noise < 0.55) {
       pixels[x+y*width] = color5;
     }else if (Noise < 0.65) {
       pixels[x+y*width] = color6;
     }else if (Noise < 0.8) {
       pixels[x+y*width] = color7;
     }else if (Noise < 1) {
       pixels[x+y*width] = color8;
     }
   }
 }
 updatePixels();
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
