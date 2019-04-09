<?php session_start(); ?>

<html>

<head>
  <div id='topAnchor'></div>
  <div id="container">
    <div id="menuknoppen">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script>
        $(function() {
          $("#navbar").load("navbarSM.html");
        });
      </script>
      <div id="navbar"></div>
    </div>
  </div>
  <link href="main.css" type="text/css" rel="stylesheet">
  <title>display test</title>
  <br />
  <br />
  <br />

  <body>
    <?php
    error_reporting(0);
    include 'serverinfo.php';
    $mysqli = mysqli_connect($server, $user, $password, $database);
    if ($mysqli->connect_error) {
       die("Connection failed: " . $mysqli->connect_error);
    }
    if(EMPTY($_SESSION['gebruikersnaam'])) {
      print("you are not logged in so you cannot view any of your own art.");
    }
    else {
      $gebruikersnaam = $_SESSION['gebruikersnaam'];
      $sql = "SELECT artnr, category FROM art WHERE user = '$gebruikersnaam'";
      $result = $mysqli->query($sql);
      while ($row = $result->fetch_assoc()) {
        $artnumber = ($row['artnr']);
        $cat = ($row['category']);
        echo "
        <form action='display.php' method='post'>
        <button id='button' type='submit' name='artnr' value=$artnumber>artnr: $artnumber  category: $cat</button>
        </form>
        ";
        }

      if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['artnr'])) {
        $artnr = $_POST['artnr'];
        $gebruikersnaam = $_SESSION['gebruikersnaam'];
        $sql = "SELECT artnr, user, art, category, width, height FROM art WHERE user = '$gebruikersnaam' AND artnr = '$artnr'";
        $result = $mysqli->query($sql);

        while ($row = $result->fetch_assoc()) {
          $artnr = ($row['artnr']);
          $user = ($row['user']);
          $art = ($row['art']);
          $category = ($row['category']);
          $width = ($row['width']);
          $height = ($row['height']);
        }
        $artUrl = json_encode($art);

        $artnummr = $_POST['artnr'];
        echo "<button style='width: 50px; position: fixed; margin: auto; left: 50%; top: 85%; margin-left: -25px;' id='button' onclick=deleteImg($artnummr)>Delete</button>";
      }
    }
    ?>

    <script>
    screenheight = $(window).height();
    screenwidth = $(window).width();

    canvasheight = <?php echo $height ?>;
    canvaswidth = <?php echo $width ?>;
    //calculate position of canvas
    canvaslocationheight = ((screenheight - canvasheight) / 2) + "px";
    canvaslocationwidth = ((screenwidth - canvaswidth) / 2) + "px";

    var canvas = document.createElement('canvas');
    canvas.id = "canv";
    canvas.style.position = "fixed";
    canvas.style.zIndex = 100;
    canvas.width = <?php echo $width ?>;
    canvas.height = <?php echo $height ?>;
    document.getElementById('menuknoppen').appendChild(canvas);
    //draw image
    var ctx = canvas.getContext('2d');
    var img = new Image;
    img.onload = function() {
      canvas.style.border = '1px solid black';
      ctx.drawImage(img, 0, 0);
      document.getElementById("canv").style.marginTop = canvaslocationheight;
      document.getElementById("canv").style.marginLeft = canvaslocationwidth;
    }
    //image source, htis is used to draw thje image onto the canvas
    img.src = <?php echo $artUrl ?>;
    //confirm delete image function
    function deleteImg($artnummr) {
      var deleteConfirm = confirm("do you really want to delete this image?");
      if (deleteConfirm == true) {
        console.log("image deleted.");
        deleteImgconfirm($artnummr);
      } else {
        location.reload(true);
      }
    }
    //delete image if confirmed
    function deleteImgconfirm($artnummr) {
      var artnummr = $artnummr
      $.post("displayphp.php", {
          artnr: $artnummr
        },
        function(response) {
          data = response
          console.log(data)
          location.reload(true);
        })
    }
    </script>
  </body>
</html>
