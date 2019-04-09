<?php session_start(); ?>

<html>
<head>
  <link href="main.css" type="text/css" rel="stylesheet">
  <title>account</title>
</head>
  <script src="libs/sessions.js"></script>
<body>
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
<?php
session_destroy();
?>
</body>
  u bent uitlgelogd <br>
<a href="login.php">
   <button id='logbackin'>log back in</button>
</a>
</html>