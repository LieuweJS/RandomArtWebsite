<?php session_start(); ?>
<html>

<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/p5.min.js" crossorigin=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/addons/p5.dom.min.js" crossorigin=""></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.7.2/addons/p5.sound.min.js" crossorigin=""></script>
  <div id='topAnchor'></div>
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
  <link href="main.css" type="text/css" rel="stylesheet">
  <title>p5 test</title>
    <body>
      <p style="position: fixed; left: 41%; top: 20%;"> red off</p>
      <p style="position: fixed; left: 41%; top: 11%;"> green off</p>
      <p style="position: fixed; left: 41%; top: 12%;"> blue off</p>
      <p style="position: fixed; left: 55%; top: -24px;"> draw image backwards</p>
      <p style="position: fixed; left: 55%; top: -25px;"> sort the pixels in image (by brightness)</p>
    <script>
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
    var counter = 0;
    var counterIndex = 0;
    var finalCounter = 0;

    var checkboxRed;
    var checkboxGreen;
    var checkboxBlue;
    var drawBackwards;
     
    var checkboxRedhExists = 0
    function setup() {
      frameRate(60);
      alreadyLoaded = '0';

      var xCanvas = (windowWidth - width) / 2;
      var yCanvas = (windowHeight - height) / 2;
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

      sortPixels = createInput();
      sortPixels.attribute("type", "checkbox");
      sortPixels.position(xCanvas + 100, 200);

      checkboxSortR = createInput();
      checkboxSortR.attribute("type", "checkbox");
      checkboxSortR.position();

      checkboxSortB = createInput();
      checkboxSortB.attribute("type", "checkbox");
      checkboxSortB.position();

      checkboxSortG = createInput();
      checkboxSortG.attribute("type", "checkbox");
      checkboxSortG.position();

      checkboxSortTotValue = createInput();
      checkboxSortTotValue.attribute("type", "checkbox");
      checkboxSortTotValue.position();

      checkboxSortAverageDistance = createInput();
      checkboxSortAverageDistance.attribute("type", "checkbox");
      checkboxSortAverageDistance.position();
      
      checkboxSortHue = createInput();
      checkboxSortHue.attribute("type", "checkbox");
      checkboxSortHue.position(); 
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
      input.style("background-color", "#4CAF50")
      input.style("color", "#FFFFFF");
      if (img) {
        if (alreadyLoaded == '0') {
          alreadyLoaded = '0';
          //resize image to 480p
          size = Math.round(img.width / 480 /* /480 is for 480p canvas*/ );
          setTimeout(function() {
            pixelDensity(1);
            widthRatio = img.width / size;
            heightRatio = img.height / size;
            canvas = createCanvas(widthRatio, heightRatio);
            background(255, 255, 255)
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
          }, 1000);
        }

        //if the image is loaded use this algorithm
        if (alreadyLoaded == '1') {
          pixelDensity(1);
          widthRatio = img.width / size;
          heightRatio = img.height / size;
          canvas = createCanvas(widthRatio, heightRatio);
          var xCanvas = (windowWidth - width) / 2;
          var yCanvas = ((windowHeight - height) / 2) + height / 2;
          canvas.position(xCanvas, yCanvas);
          background(255, 255, 255);
          if (img) {
            loadPixels();
            img.loadPixels();


            if (sortPixels.elt.checked) {
              canvas.style('border', '1px solid #000000');
              var imgPixelArray = [];
              var totalValueArray = [];
              if (checkboxRedhExists === 0) {
              checkboxRedh = createInput();
              checkboxRedh.attribute("type", "checkbox");
              checkboxRedh.position();
              checkboxRedhExists = 1;
              }
              for (var y = 0; y < height; y++) {
                for (var x = 0; x < width; x++) {
                  var index = (x + y * width) * 4;
                  var imgIndex = (x + y * img.width) * sizeRatio;
                  var color = new Object()
                  color.r = img.pixels[imgIndex + 0]; //red
                  color.g = img.pixels[imgIndex + 1]; //green
                  color.b = img.pixels[imgIndex + 2]; //blue
                  color.a = img.pixels[imgIndex + 3]; //alpha
                  var r_bDistance = sqrt((color.r - color.b) * (color.r - color.b));
                  var r_gDistance = sqrt((color.r - color.g) * (color.r - color.g));
                  var g_rDistance = sqrt((color.g - color.r) * (color.g - color.r));
                  var g_bDistance = sqrt((color.g - color.b) * (color.g - color.b));
                  var b_rDistance = sqrt((color.b - color.r) * (color.b - color.r));
                  var b_gDistance = sqrt((color.b - color.g) * (color.b - color.g));
                  color.Hue = getHue(color.r, color.g, color.b);
                  color.averageDistance = (r_bDistance + r_gDistance + g_bDistance + g_rDistance + b_gDistance + b_rDistance) / 6;
                  color.totValue = img.pixels[imgIndex] + img.pixels[imgIndex + 1] + img.pixels[imgIndex + 2]; //total - alpha
                  imgPixelArray.push(color);
                }
              }
              if (checkboxSortR.elt.checked) {
                imgPixelArray.sort(sortArrayValueR);
              } else {
                if (checkboxSortG.elt.checked) {
                  imgPixelArray.sort(sortArrayValueG);
                } else {
                  if (checkboxSortB.elt.checked) {
                    imgPixelArray.sort(sortArrayValueB);
                  } else {
                    if (checkboxSortTotValue.elt.checked) {
                      imgPixelArray.sort(sortArrayValueTotValue);
                    } else {
                      if (checkboxSortAverageDistance.elt.checked) {
                        imgPixelArray.sort(sortArrayValueAverageDistance);
                      } else {
                        if (checkboxSortHue.elt.checked) {
                          imgPixelArray.sort(sortArrayValueHue);
                        }
                      }
                    }
                  }
                }
              }
              for (var q = 0; q < height; q++) {
                for (var w = 0; w < width; w++) {
                  var index = (w + q * width) * 4;
                  var imgIndex = (w + q * width);
                  pixels[index] = imgPixelArray[imgIndex].r;
                  pixels[index + 1] = imgPixelArray[imgIndex].g;
                  pixels[index + 2] = imgPixelArray[imgIndex].b;
                  pixels[index + 3] = imgPixelArray[imgIndex].a;
                }
              }

            } else {
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
                    if (finalCounter < 0) {
                      counter = 0;
                      counterIndex = 0;
                      x = 0
                      y = 0

                    }
                    var index = (width + height * width) * 4
                    var imgIndex = (x + y * img.width) * sizeRatio;
                    counterIndex = counterIndex + 4;
                    counter = counter + 4;
                    finalCounter = index - counter;

                    if (checkboxRed.elt.checked) {
                      pixels[index - counterIndex - 4] = 0;
                    } else {
                      pixels[index - counterIndex - 4] = img.pixels[imgIndex];
                    }

                    if (checkboxGreen.elt.checked) {
                      pixels[index - counterIndex - 3] = 0;
                    } else {
                      pixels[index - counterIndex - 3] = img.pixels[imgIndex + 1];
                    }

                    if (checkboxBlue.elt.checked) {
                      pixels[index - counterIndex - 2] = 0;
                    } else {
                      pixels[index - counterIndex - 2] = img.pixels[imgIndex + 2];
                    }

                    pixels[index - counterIndex - 1] = img.pixels[imgIndex + 3];
                  }
                }
                alreadyLoaded = '1';
              }
            }
          }
        }
        updatePixels();
      }
    }

    function getHue(r, g, b) {
      var max = Math.max(r, g, b)
      var min = Math.min(r, g, b)
      if (max === r && max === g && max === b) {
        var Hue = 0;
        return Hue;
      } else if (max === r) {
        var Hue = Math.round((g - b) / (max - min) * 60)
        if (Hue < 0) {
          Hue = Hue + 360;
        }
        return Hue;
      } else if (max === g) {
        var Hue = Math.round((2 + (b - r) / (max - min)) * 60)
        if (Hue < 0) {
          Hue = Hue + 360;
        }
        return Hue;
      } else if (max === b) {
        var Hue = Math.round((4 + (r - g) / (max - min)) * 60)
        if (Hue < 0) {
          Hue = Hue + 360;
        }
        return Hue;
      }
    }
    //sort functions
    function sortArrayValueR(a, b) {
      if (a.r < b.r)
        return -1;
      if (a.r > b.r)
        return 1;
      return 0;
    }

    function sortArrayValueG(a, b) {
      if (a.g < b.g)
        return -1;
      if (a.g > b.g)
        return 1;
      return 0;
    }

    function sortArrayValueB(a, b) {
      if (a.b < b.b)
        return -1;
      if (a.b > b.b)
        return 1;
      return 0;
    }

    function sortArrayValueTotValue(a, b) {
      if (a.totValue < b.totValue)
        return -1;
      if (a.totValue > b.totValue)
        return 1;
      return 0;
    }

    function sortArrayValueAverageDistance(a, b) {
      if (a.averageDistance < b.averageDistance)
        return -1;
      if (a.averageDistance > b.averageDistance)
        return 1;
      return 0;
    }

    function sortArrayValueHue(a, b) {
      if (a.Hue < b.Hue)
        return -1;
      if (a.Hue > b.Hue)
        return 1;
      return 0;
    }
    </script>
  </body>

</html>