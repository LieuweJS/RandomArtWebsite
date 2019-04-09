<?php session_start(); ?>
<html>

<head>
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
  <title>display test</title>

  <body>
    <?php
      include 'serverinfo.php';
      $mysqli = mysqli_connect($server, $user, $password, $database);
      if ($mysqli->connect_error) {
         die("Connection failed: " . $mysqli->connect_error);
      }
      if(EMPTY($_SESSION['gebruikersnaam'])) {
        print("u bent niet ingelogd en kunt geen kunst opslaan.");
      }
      else {
        $gebruikersnaam = $_SESSION['gebruikersnaam'];
        $sql = "SELECT artnr, category FROM art WHERE user = '$gebruikersnaam'";
        $result = $mysqli->query($sql);
        while ($row = $result->fetch_assoc()) {
          $artnumber = ($row['artnr']);
          $cat = ($row['category']);
          echo "<button id=button onClick=artPost($artnumber)>artnumber $artnumber category $cat</button>";
          echo '<br />';
          }
      }
      ?>
      <canvas id="myCanvas" width="500" height="500" style="z-index:1000; position: absolute; top: 200px; left: 700px;border:1px solid #000000"></canvas>
      <script>
        var dataUrl;
        var img;
        var ctx;
        var myCanvas;

        function artPost($artnumber) {
          var artnr = $artnumber
          console.log(artnr)
          $.post("getArtphp.php", {
              artnr: artnr
            },
            function(response) {
              console.log(response)
              var data = response
              dataUrl = data.split('')
              drawImg()
            })
        }

        function drawImg() {
          imgUrl = dataUrl.join('')
          myCanvas = document.getElementById('myCanvas')
          ctx = myCanvas.getContext('2d')
          img = new Image()
          img.src = imgUrl
          ctx.drawImage(img, 0, 0)
          console.log('succes')
        }
      </script>
  </body>

</html>
