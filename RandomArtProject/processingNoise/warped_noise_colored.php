
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
 //takes a while to load
 var screenwidth = $( window  ).width();
var screenheight = $( window  ).height();
int displayWidth = screenwidth;
int displayHeight = screenheight;
void setup() {
  size(500,500);
  canvaslocationheight = ((screenheight - height) / 2) + "px";
  canvaslocationwidth = ((screenwidth - width) / 2) + "px";
  document.getElementById("mycanvas").style.marginTop = canvaslocationheight;
  document.getElementById("mycanvas").style.marginLeft = canvaslocationwidth;
  colorMode(HSB);
  for(int y=0; y<height; y++) {
    for(int x=0; x<width; x++) {
      color Color = warp(x*0.01,y*0.01);
      fill(Color);
      stroke(Color);
      rect(x, y, x, y);
    }
  }
}

color warp(float x, float y) {
  float warp1 = noise(x + 1, y + 1);//first warp
  float warp2 = noise(x * warp1, y * warp1);//second warp
  float warp3 = noise(x * warp2, y * warp2);//third warp
  float warp4 = noise(x * warp3, y * warp3);//fourth warp
  color Color = color((warp4*360),360,360);
  return color(Color);
}

/*
warp distorts the noise field, so it looks a lot more interesing,
for a more detailed explanation see: http://www.nolithius.com/articles/world-generation/world-generation-techniques-domain-warping
*/
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
