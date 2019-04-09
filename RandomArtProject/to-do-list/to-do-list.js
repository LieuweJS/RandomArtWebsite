/*


BUG!! 
DISPLAY.PHP WILL NOT LOAD FIRST IMAGE

*/




//make social media aspect
//testen website tot nu toe
//finish login system
//figure out how to download image without user interaction and upload that same image to the database
//improve login system (check if account already exists when a new account is created, check database with both email and username)
//add comments
//looks of site in general
//replace all results with mysqli_query($mysqli, ... )

//email verificatie bot gemaakt, -lieuwe
//verify.php gemaakt, -lieuwe 
//login- en registratie syteem verbeterd, -lieuwe
//opslaan kunst klaar, -lieuwe
//terughalen kunst bijna klaar, -lieuwe
//added get image art feature, -lieuwe
//added delete image art feature, -lieuwe
//post system done, but some pieces not working (sometimes some postss arent working, i suspect it to be a loading issue(UPDATE: works fine on pc at home)), -lieuwe


//plan image system
//-save canvas images to images folder on server
//save location of art folder and connected art to phpmyadmin
//misschien 15 en 16 niet toevoegen omdat ze zoveel opslag gebruiken?
//voeg toe naam, categorie en artnr bij display.php
//take button press with jqyuery then send to php then take var with echo in php in js var and use it that way???
//test register die()
//replace forms with jquery post
//add a way to check length and width of canvas with each 
//remove libs session.js from every page

//PROBLEEM we kunnen nummer 4 niet opslaan omdat hij te groot is, we kunnen hem kleiner maken, dat werkt hij wel 

//document.write(' <?php function here  ?> ');//voor callen functies php in js




//comments toevoegen
//symbooltjes wanneer like/dislike
//look van de site
//add instant updates to likedislikeratio
//let user give art a title


/* makes animation of flipped image, keep it 


var img;
var imgConfirmed = 0;
var imgSize;

var input;

var canvasCreated = 0;
var canvas;

var alreadyLoaded = '0';
var counter = 0;

var size;
var widthRatio;
var heightRatio;

var checkboxRed;
var checkboxGreen;
var checkboxBlue;
var drawBackwards;

function setup() {
  frameRate(60);
  alreadyLoaded = '0';
  console.log(alreadyLoaded + 'setup')
  var xCanvas = (windowWidth - width) / 2;
  var yCanvas = ((windowHeight - height) / 2) + 100;
  input = createFileInput(handleFile);
  input.position(xCanvas + 100, 150);
  input.style('background-color', '#00ff00')

  checkboxRed = createInput();
  checkboxRed.attribute("type", "checkbox");
  checkboxRed.position(xCanvas, 150);

  checkboxGreen = createInput();
  checkboxGreen.attribute("type", "checkbox");
  checkboxGreen.position(xCanvas, 175);

  checkboxBlue = createInput();
  checkboxBlue.attribute("type", "checkbox");
  checkboxBlue.position(xCanvas, 200);

  drawBackwards = createInput();
  drawBackwards.attribute("type", "checkbox");
  drawBackwards.position(xCanvas + 100, 175);
}

function handleFile(file) {
  if (file.type === 'image') {
    alreadyLoaded = '0';
    img = loadImage(file.data)
    alreadyLoaded = '0';
  } else {
    console.log('this is not an image file!');
  }
}


function draw() {
  input.style("background-color", "#4CAF50");
  input.style("color", "#FFFFFF");
  if (img) {
    if (alreadyLoaded == '0') {
      alreadyLoaded = '0';
      //resize image to 480p
      size = Math.round(img.width / 480 /* /480 is for 480p canvas );
      //console.log(alreadyLoaded + 'it should be 0')
      setTimeout(function() {
        pixelDensity(1);
        widthRatio = img.width / size;
        heightRatio = img.height / size;
        //console.log(widthRatio + ' ' + heightRatio)
        //console.log(img.width + ' ' + img.height)
        canvas = createCanvas(widthRatio, heightRatio);
        background(255, 255, 255)
        //console.log(img.width, img.height)
        var xCanvas = (windowWidth - width) / 2;
        var yCanvas = ((windowHeight - height) / 2) + height / 2;
        canvas.position(xCanvas, yCanvas);

        if (img) {
          loadPixels();
          img.loadPixels();
          sizeRatio = 4 * size;
          for (var y = 0; y < height; y++) {
            for (var x = 0; x < width; x++) {
              var index = (x + y * width) * 4;
              var imgIndex = (x + y * img.width) * sizeRatio;
              pixels[index] = img.pixels[imgIndex];
              pixels[index + 1] = img.pixels[imgIndex + 1];
              pixels[index + 2] = img.pixels[imgIndex + 2];
              pixels[index + 3] = img.pixels[imgIndex + 3]
            }
          }
          updatePixels();
        }
        updatePixels();
        alreadyLoaded = '1';
        //console.log(alreadyLoaded + 'it should be 1')
      }, 1000 /* set back to 2000 after testing small img );
    }

    //if the image is loaded use this algorithm
    if (alreadyLoaded == '1') {
      //console.log(alreadyLoaded + 'it should be 1')
      pixelDensity(1);
      widthRatio = img.width / size;
      heightRatio = img.height / size;
      canvas = createCanvas(widthRatio, heightRatio);
      //console.log(img.width, img.height)
      var xCanvas = (windowWidth - width) / 2;
      var yCanvas = ((windowHeight - height) / 2) + height / 2;
      canvas.position(xCanvas, yCanvas);
      background(255, 255, 255);
      if (img) {
        loadPixels();
        img.loadPixels();
        for (var y = 0; y < height; y++) {
          for (var x = 0; x < width; x++) {

            if (!drawBackwards.elt.checked) {
              var index = (x + y * width) * 4;
              var imgIndex = (x + y * img.width) * sizeRatio;
              //remove R, G B
              if (checkboxRed.elt.checked) {
                pixels[index] = 0;
              } else {
                pixels[index] = img.pixels[imgIndex];
              }
              if (checkboxGreen.elt.checked) {
                pixels[index + 1] = 0;
              } else {
                pixels[index + 1] = img.pixels[imgIndex + 1];
              }
              if (checkboxBlue.elt.checked) {
                pixels[index + 2] = 0;
              } else {
                pixels[index + 2] = img.pixels[imgIndex + 2];
              }
              pixels[index + 3] = img.pixels[imgIndex + 3];
            }

            //draw image backwards
            if (drawBackwards.elt.checked) {
              var imgSize = ((widthRatio * heightRatio) - 4)* 4;
              var index = (x + y * width) * 4;
              var imgIndex = imgSize - counter;
              counter = counter + sizeRatio
              if (imgIndex === 0) {
                console.log(index)
                console.log(imgIndex)
                counter = 0;
              }
              if (checkboxRed.elt.checked) {
                pixels[index] = 0;
              } else {
                pixels[index] = img.pixels[imgIndex - 4];
              }
              //console.log('img.pixels ' + img.pixels[(imgSize - counter) - 3]);
              //console.log('pixels ' + pixels[index]);
              if (checkboxGreen.elt.checked) {
                pixels[index + 1] = 0;
              } else {
                pixels[index + 1] = img.pixels[imgIndex - 3];
              }
              if (checkboxBlue.elt.checked) {
                pixels[index + 2] = 0;
              } else {
                pixels[index + 2] = img.pixels[imgIndex - 2];
              }
              pixels[index + 3] = img.pixels[imgIndex - 1];
            }
          }
        }
      }
      alreadyLoaded = '1';
    }
    updatePixels();
  }
}
*/