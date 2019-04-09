<?php session_start(); ?>
<html>
<head>
  <link href="main.css" type="text/css" rel="stylesheet">
  <title>register</title>
</head>
<body>
<div style="position: fixed; top: 50%; left:50%; margin-left:-5%;">
  <h1>Register</h1>
  <input type='email' onfocus="this.value=''" value="e-mail" type='text' id='emailRegister'></input><br /><br />
  <input type='text' onfocus="this.value=''" value="username" id='userRegister'></input><br /><br />
  <input type='password' type='text' onfocus="this.value=''" value="password" id='passwordRegister'></input><br /><br />
  <input type='password' type='text' onfocus="this.value=''" value="password" id='comfirmpassRegister'></input><br /><br />
  <button id='submitLogin' onClick='register()'>register</button><br /><br />
  <p style="text-align: center;" id="message"></p>
</div>
  <div id="container">
    <div id="kop">
      <a href="index.php" class="newanchor"> register</a>
    </div>
    <div id="menuknoppen">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script>
        $(function() {
          $("#navbar").load("navbarHUB.html");
        });
      </script>
      <div id="navbar"></div>
      <script>
       function register() {
         var email = document.getElementById('emailRegister').value;
         var user = document.getElementById('userRegister').value;
         var pass = document.getElementById('passwordRegister').value;
         var passconfirm = document.getElementById('comfirmpassRegister').value;
         $.post("registerphp.php", {
             email: email,
             user: user,
             pass: pass,
             passconfirm: passconfirm
           },
           function(response) {
             document.getElementById("message").innerHTML = response;
           })
       }
      </script>
    </div>
  </div>
</body>

</html>