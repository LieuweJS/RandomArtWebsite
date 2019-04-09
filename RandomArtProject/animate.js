/*
var counter = 0;
var xCount = 0;
var xincrement = 0.01;
var y = 0;
var yincrement = 1;
this.drawn = 0;
function setup() {
  var canvas = createCanvas((windowWidth - 5), (windowHeight - 142));
  frameRate(60);
  colorMode(HSB);
}

function draw() {
  var x = noise(xCount) * width;
  xCount+= xincrement;
  y += yincrement;
	if (y > height){
    
	  y = 0;	
    //colorscheme implementation here maybe?
    //H = 360 max
	}
  counter = counter + 0.005;
  getnoise = map(noise(counter), 0, 1, 99, 200);
  shape = getnoise*abs(sin(frameCount*PI/400))+20;
  var r = random(255);
  var b = random(255);
  var g = random(255);

  strokeWeight(1)
  stroke(r,g,b);
  fill(r,g,b);
  ellipse(x, y, shape, shape);
  this.drawn = this.drawn + 1;
}*/

var counter = 0;
var xCount = 0;
var xincrement = 0.01;
var y = 0;
var colorActual = 0;
var colorVal = 0
var yincrement = 1;
function setup() {
  var canvas = createCanvas((windowWidth - 5), (windowHeight - 142));
  frameRate(60);
  colorMode(HSB);
  this.colorChangeWhen = 1/Math.round(height/360);
	
}

function draw() {
	colorVal = colorVal + this.colorChangeWhen;
  var x = noise(xCount) * width;
  xCount+= xincrement;
  y += yincrement;
	if (Number.isInteger(colorVal)) {
	  colorActual = colorActual + 1;
  }
  counter = counter + 0.005;
  getnoise = map(noise(counter), 0, 1, 99, 200);
  shape = getnoise*abs(sin(frameCount*PI/400))+20;

  strokeWeight(1)
  stroke(0,0,0);
  fill(colorActual, 100, 100);
  ellipse(x, y, shape, shape);
	if (y > height){
	  y = 0;	
    colorVal = 0;
		colorActual = 0;
    clear()
	}
}

