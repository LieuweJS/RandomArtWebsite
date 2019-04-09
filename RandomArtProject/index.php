<html>
<head>
  <link href="new.css" type="text/css" rel="stylesheet">
  <title>homepage</title>
</head>
<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/p5.min.js" crossorigin=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/addons/p5.dom.min.js" crossorigin=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/addons/p5.sound.min.js" crossorigin=""></script>

    <div id="menuknoppen" style="z-index: 2;">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    $(function() {
      $("#navbar").load("navbarHUB.html");
    });
    </script>
    <div id="navbar" style="z-index: 1;">
    </div>   
  
  </div>
  <style>
  body {
    font-family: 'Cardo', serif;
  }
  h1 {
    color:white; 
    font-size:46; 
    text-shadow: -2px 0 black, 0 2px black, 2px 0 black, 0 -2px black;
  }
  
  p {
    color:white; 
    font-size:24; 
    text-shadow: -2px 0 black, 0 2px black, 2px 0 black, 0 -2px black;
  }
  </style>
  <body>
  <a href="https://infgc.tk/~17h_lieuweb/RandomArtProject/showposttestrewritten.php">
    <div class="grow" id="SocialMediaSection">
      <h1>&nbsp;Social Media section</h1>
      <p>&nbsp;&nbsp;Here you can view other people's RandomArt, and also your own!</p>
    </div>
  </a>
  <a href="https://infgc.tk/~17h_lieuweb/RandomArtProject/Number1.php">
    <div class="grow" id="RandomArtSection">
      <h1>&nbsp;Random Art section</h1>
      <p>&nbsp;&nbsp;Art here is saveable for the social media section!</p>
    </div>
  </a>

  <a href="https://infgc.tk/~17h_lieuweb/RandomArtProject/processingNoise/analizing_1d_noise.php">
    <div class="grow" id="NoiseSection">
      <h1>&nbsp;Noise Art section</h1>
      <p>&nbsp;&nbsp;Noise art is also saveable, but different then the random art, this art is semi-random, check it out!</p>
    </div>
  </a>
  <div id="HomePageAnimationSection">

  </div>
    <script> 
    
var counter = 0;
var xCount = 0;
var xincrement = 0.01;
var y = 0;
var colorVal = 0
var yincrement = 1;

function setup() {
  var height1 = document.getElementById('HomePageAnimationSection').offsetHeight;
  var width1 = document.getElementById('HomePageAnimationSection').offsetWidth;
  canvas = createCanvas(width1, height1);
  canvas.parent('HomePageAnimationSection');
  frameRate(60);
  colorMode(HSB);
  this.colorChangeWhen = 1 / Math.round(height / 360);
}

function draw() {
  
  colorVal = colorVal + this.colorChangeWhen;
  var x = noise(xCount) * width;
  xCount += xincrement;
  y += yincrement;
  counter = counter + 0.005;
  getnoise = map(noise(counter), 0, 1, 0, 200);
  shape = getnoise * abs(sin(frameCount * PI / 400)) + 20;

  strokeWeight(1)
  stroke(0, 0, 0);
  fill(colorVal, 100, 100);
  ellipse(x, y, shape, shape);
  if (y > 900) {
    y = 0;
    colorVal = 0;
  }
}
</script>
  </body>
  </head>
  </html>