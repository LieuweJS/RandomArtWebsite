<?php session_start(); ?>
<html>
<head>
  <link href="main.css" type="text/css" rel="stylesheet">
  <title>login</title>
</head>
<body>
<div style="position: fixed; top: 50%; left:50%; margin-left:-5%;">
<h1>Login</h1>
  <input type='email' onfocus="this.value=''" value="e-mail" type='text' id='emailLogin'></input><br /><br />
  <input type='text' onfocus="this.value=''" value="username" id='userLogin'></input><br /><br />
  <input type='password' type='text' onfocus="this.value=''" value="password" id='passwordLogin'></input><br /><br />
  <button id='submitLogin' onClick='login()'>login</button><br /><br />
  <p style="text-align: center;" id="message"></p>
</div>
  <div id="container">
    <div id="kop">
      <a href="index.php" class="newanchor"> login</a>
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
        function login() {
          var email = document.getElementById('emailLogin').value;
          var user = document.getElementById('userLogin').value;
          var pass = document.getElementById('passwordLogin').value;
          $.post("loginphp.php", {
              email: email,
              user: user,
              pass: pass,
            },
            function(response) {
              if (response === '') {
                document.getElementById("message").innerHTML = 'your credentials are wrong, please try again with the right credentials.';
              } else {
                document.getElementById("message").innerHTML = response;
              }
            })
        }
      </script>
    </div>
  </div>
</body>

</html>