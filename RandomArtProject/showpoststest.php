<?php session_start(); ?>
<html>
<head>
  <link href="main.css" type="text/css" rel="stylesheet">
  <link href="buttonlike.css" type="text/css" rel="stylesheet">
  <title>test post display</title>
</head>
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
include 'serverinfo.php';
$mysqli = mysqli_connect($server, $user, $password, $database);
if ($mysqli->connect_error) {
   die("Connection failed: " . $mysqli->connect_error);
}

if(EMPTY($_SESSION['gebruikersnaam'])) {
  print("you are not logged in");
  echo '<a href="login.php">
        <button id="LoginButton">login page</button>
        </a>';
}
else {
  $numberOfPost = 0;
  $numberOfPostCanvas = 0;
  $gebruikersnaam = $_SESSION['gebruikersnaam'];
  $sql = "SELECT * FROM art";
  $result = $mysqli->query($sql);
  while ($row = $result->fetch_assoc()) {
    $artnr = ($row['artnr']);
    $user = ($row['user']);
    $art = ($row['art']);
    $category = ($row['category']);
    $width = ($row['width']);
    $height = ($row['height']);
    $numberOfPost = $numberOfPost + 1;
    $numberOfPostCanvas = $numberOfPost + 1;
    //check for amount of likes
    $likesgained = "SELECT * From likes WHERE art_liked = '$artnr'  AND liked_state = 'like'";
    $result2 = $mysqli->query($likesgained);
    $amountoflikes = mysqli_num_rows($result2);
    //check for amount of dislikes
    $dislikesgained = "SELECT * From likes WHERE art_liked = '$artnr' AND liked_state = 'dislike'";
    $result3 = $mysqli->query($dislikesgained);
    $amountofdislikes = mysqli_num_rows($result3);
    //like to dislike ratio
    if ($amountofdislikes > 0 AND $amountoflikes > 0) {
      $liketodislikeratio = $amountoflikes/$amountofdislikes;
      $liketodislikeratio = round($liketodislikeratio,2);
      if (strlen($liketodislikeratio) === 1) {
        $liketodislikeratio = $liketodislikeratio . '.00';
      }
      if (strlen($liketodislikeratio) === 3) {
        $liketodislikeratio = $liketodislikeratio . '0';
      }
    }
    if ($amountofdislikes === 0) {
      $liketodislikeratio = $amountoflikes . '.00';
    }
    if ($amountoflikes === 0) {
      $liketodislikeratio = '-' . $amountofdislikes . '.00';
    }
    if ($amountofdislikes === 0 AND $amountoflikes === 0) {
      $liketodislikeratio = '0.00';
    }
    $ifliked = mysqli_query($mysqli,"SELECT user_name FROM likes WHERE user_name = '$gebruikersnaam' AND art_liked = '$artnr' AND liked_state = 'like'");
    $iflikedresult = mysqli_num_rows($ifliked);

    $ifdisliked = mysqli_query($mysqli,"SELECT user_name FROM likes WHERE user_name = '$gebruikersnaam' AND art_liked = '$artnr' AND liked_state = 'dislike'");
    $ifdislikedresult = mysqli_num_rows($ifdisliked);
    if ($iflikedresult > 0) {
      $styleButtonLike = 'background: url(images/like_icon_blue.png)';
      $styleButtonDislike = 'background: url(images/dislike_symbol.png)';
    } else if ($ifdislikedresult > 0) {
       $styleButtonDislike = 'background: url(images/dislike_icon_blue.png)';
       $styleButtonLike = 'background: url(images/like_icon.png)';
    } else {
       $styleButtonDislike = 'background: url(images/dislike_symbol.png)';
       $styleButtonLike = 'background: url(images/like_icon.png)';
    }
    //create artwork
    echo "<div id=$numberOfPost style='background-color:lightgray'>
    <h3>postnr: $numberOfPost</h3>
    <p>user: $user</p>
    <p><script>
    screenheight = $(document).height();
    screenwidth = $(document).width();

    canvasheight = $height;
    canvaswidth = $width;

    canvaslocationheight = ((screenheight - canvasheight) / 2) + 'px';
    canvaslocationwidth = ((screenwidth - canvaswidth) / 2) + 'px';
    var canvas = document.createElement('canvas');

    canvas.id = '$numberOfPostCanvas';
    canvas.width = $width;
    canvas.height = $height;
    canvas.style.border = '1px solid black';
    var body = document.getElementsByTagName('body')[0];
    body.appendChild(canvas);
    canvass = document.getElementById('$numberOfPostCanvas');
    var ctx = canvas.getContext('2d')
    var img = new Image
    img.src = '$art'
    img.onload = function() {
     ctx.drawImage(img, 0, 0);
     document.getElementById($numberOfPostCanvas).style.marginLeft = canvaslocationwidth;
    }
    </script>
    </p>
    <p>category: $category</p>
    <p>artnr: $artnr</p>
    <button id='like' style='$styleButtonLike' onClick='like($artnr)'></button>
    <button id='dislike' style='$styleButtonDislike' onClick='dislike($artnr)'></button>
    <p>likes this post has gained: $amountoflikes</p>
    <p>dislikes this post has gained: $amountofdislikes</p>
    <p>like to dislike ratio on this post: $liketodislikeratio</p>
    </div>";
    $commentonart = $artnr.'comment';
    $comments = mysqli_query($mysqli, "SELECT user_name, art_commented, comment FROM comments WHERE art_commented = '$artnr'");


    echo "<div id=comment style='background-color:lightgray'>
    <p>comments</p>
    <input type='text' id='$commentonart' value=''></input>
    <button id='comment' onClick='commentOnArt($artnr)'>post comment</button>";
    while ($row = $comments->fetch_assoc()) {
      $comment = ($row['comment']);
      $user_name = ($row['user_name']);
      $art_commented = ($row['art_commented']);
      echo "<p>$user_name:</p>";
      echo "<p>$comment</p>";
    }
   echo "</div>";
  }
}
?>
<script>
  //post with ajax on button press (likes/dislikes) this one is for likes
  function like(artnr) {
    $.post("like.php", {
        artnr: artnr,
        whatlike: 'like'
      },
      function(response) {
        if (response != '') {
          alert(response)
        }
      })
  }
  //post with ajax on button press (likes/dislikes) this one is for dislikes
  function dislike(artnr) {
    $.post("like.php", {
        artnr: artnr,
        whatlike: 'dislike'
      },
      function(response) {
        if (response != '') {
          alert(response)
        }
      })
  }

  function commentOnArt(artnr) {
    var textbox = artnr + 'comment'
    var comment = document.getElementById(textbox).value;
    console.log(comment)
    var user = "<?php echo $gebruikersnaam;?>";
    console.log(comment)
    console.log(user)
    $.post("comments.php", {
        artnr: artnr,
        user: user,
        comment: comment
      },
      function(response) {
        if (response != '') {
          alert(response)
        }
      })
  }
</script>
</body>
</html>
