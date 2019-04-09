<?php session_start(); ?>
<html>
<head>
  <link href="main.css" type="text/css" rel="stylesheet">
  <title>test post display</title>
</head>
<body>
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
  <br />
  <br />
<?php
  if(EMPTY($_SESSION['gebruikersnaam'])) {
    print("you are not logged in");
    echo '<a href="login.php">
          <button>login page</button>
          </a>';
  }
  else {
    $gebruikersnaam = $_SESSION['gebruikersnaam'];
    include 'serverinfo.php';
    $mysqli = mysqli_connect($server, $user, $password, $database);
    $getArtnr = mysqli_query($mysqli,"SELECT artnr FROM art");
    while ($row = $getArtnr->fetch_assoc()) {
      $artnr = ($row['artnr']);
      drawInfo($artnr);
    }
  }
  function drawInfo($artnr) {
    $mysqli = $GLOBALS["mysqli"];
    $getDBinfo = mysqli_query($mysqli,"SELECT artnr, user, category FROM art WHERE artnr = '$artnr'");
    while ($row = $getDBinfo->fetch_assoc()) {
      $user = ($row['user']);
      $category = ($row['category']);
    }
    $likes = getLikes($artnr);
    $dislikes = getDislikes($artnr);
    $likeToDislikeRatio = getLikeDislikeRatio($artnr);

    //create div
    $infoDiv = $artnr.'info';
    $styleButtonLike = getStyleLike($artnr);
    $styleButtonDislike = getStyleDislike($artnr);
    $likeID = $artnr.'like';
    $dislikeID = $artnr.'dislike';
    $likesOnPostID = $artnr.'likesOnPost';
    $dislikesOnPostID = $artnr.'dislikesOnPost';
    $likeToDislikeRatioOnPost = $artnr.'likeToDislikeRatio';
    echo "<div class=postSectionDIV>";
    echo "<div id=$infoDiv class=infoDIV>
    <p>user: $user</p>
    <p>category: $category</p>
    <p>artnr: $artnr</p>
    <button id='$likeID' style='$styleButtonLike' onClick='like($artnr)'></button>
    <button id='$dislikeID' style='$styleButtonDislike' onClick='dislike($artnr)'></button>
    <p id='$likesOnPostID'>likes this post has gained: $likes</p>
    <p id='$dislikesOnPostID'>dislikes this post has gained: $dislikes</p>
    <p id='$likeToDislikeRatioOnPost'>like to dislike ratio on this post: $likeToDislikeRatio</p>
    </div>";
    drawArt($artnr);
  }

  function drawArt($artnr) {
    $mysqli = $GLOBALS["mysqli"];
    $gebruikersnaam = $GLOBALS["gebruikersnaam"];
    $getArt = mysqli_query($mysqli, "SELECT art, width, height FROM art WHERE artnr = $artnr");
    $canvasID = $artnr.'canvas';
    while ($row = $getArt->fetch_assoc()) {
    $art = ($row['art']);
    $width = ($row['width']);
    $height = ($row['height']);
    $artDiv = 'artDiv' . $canvasID;
    echo "<div id=$artDiv class=artDIV>";
    echo "</div>";
    //img.scr cuts off rest off the script
    echo "<script>
      artDivHeight = $($artDiv).height();
      artDivWidth = $($artDiv).width();

      canvasheight = '$height';
      canvaswidth = '$width';

      canvaslocationheight = ((artDivHeight - canvasheight) / 2) + 'px';
      canvaslocationwidth = ((artDivWidth - canvaswidth) / 2) + 'px';
      var canvas = document.createElement('canvas');

      canvas.id = '$canvasID';
      canvas.width = '$width';
      canvas.height = '$height';
      canvas.style.border = '1px solid black';
      var artDIV = document.getElementById('$artDiv');
      artDIV.appendChild(canvas);
      var ctx = canvas.getContext('2d');
      var img = new Image;
      img.src = '$art';
      img.onload = function() {
       ctx.drawImage(img, 0, 0);

      }


      document.getElementById('$canvasID').style.marginLeft = canvaslocationwidth;

      </script>";
      drawComments($artnr);
      echo "</div>";
    }

  }

  function drawComments($artnr) {
    $mysqli = $GLOBALS["mysqli"];
    //div for comments underneath artwork
    $commentonart = $artnr.'comment';
    $commentDiv = $artnr.'commentdiv';
    echo "<div id=$commentDiv class=commentDIV>
      <p>comments</p>
      <input type='text' id='$commentonart' value=''></input>
      <button id='comment' onClick='commentOnArt($artnr)'>post comment</button><p></p>";
      $comments = mysqli_query($mysqli, "SELECT user_name, art_commented, comment FROM comments WHERE art_commented = '$artnr'");
      while ($row = $comments->fetch_assoc()) {
        $comment = ($row['comment']);
        $user_name = ($row['user_name']);
        $art_commented = ($row['art_commented']);
        echo "<p>$user_name";
        echo "<p>$comment";
      }
     echo "</div>";
  }

  function getLikes($artnr) {
    $mysqli = $GLOBALS["mysqli"];
    $likesgained = mysqli_query($mysqli, "SELECT * From likes WHERE art_liked = '$artnr'  AND liked_state = 'like'");
    $amountoflikes = mysqli_num_rows($likesgained);

    return $amountoflikes;
  }

  function getDislikes($artnr) {
    $mysqli = $GLOBALS["mysqli"];
    $dislikesgained = mysqli_query($mysqli,"SELECT * From likes WHERE art_liked = '$artnr' AND liked_state = 'dislike'");
    $amountofdislikes = mysqli_num_rows($dislikesgained);

    return $amountofdislikes;
  }

  function getLikeDislikeRatio($artnr) {
    $likes = getLikes($artnr);
    $dislikes = getDislikes($artnr);
    //calculation
     if ($dislikes > 0 AND $likes > 0) {
        $liketodislikeratio = $likes/$dislikes;
        $liketodislikeratio = round($liketodislikeratio,2);
        if (strlen($liketodislikeratio) === 1) {
          $liketodislikeratio = $liketodislikeratio . '.00';
        }
        if (strlen($liketodislikeratio) === 3) {
          $liketodislikeratio = $liketodislikeratio . '0';
        }
      }
      if ($dislikes === 0) {
        $liketodislikeratio = $likes . '.00';
      }
      if ($likes === 0) {
        $liketodislikeratio = '-' . $dislikes . '.00';
      }
      if ($dislikes === 0 AND $likes === 0) {
        $liketodislikeratio = '0.00';
      }
      return $liketodislikeratio;
  }

  function getStyleLike($artnr) {
    $mysqli = $GLOBALS["mysqli"];
    $gebruikersnaam = $GLOBALS["gebruikersnaam"];
    $isLiked = mysqli_query($mysqli, "SELECT ID FROM likes WHERE liked_state = 'like' AND art_liked = '$artnr' AND user_name = '$gebruikersnaam'");
    if (mysqli_num_rows($isLiked) > 0) {
      $styleButtonDislike = 'background: url(images/like_icon_blue.png); height: 35px; width: 35px;';
    } else {
      $styleButtonDislike = 'background: url(images/like_icon.png); height: 35px; width: 35px;';
    }
    return $styleButtonDislike;
  }

  function getStyleDislike($artnr) {
    $mysqli = $GLOBALS["mysqli"];
    $gebruikersnaam = $GLOBALS["gebruikersnaam"];
    $isLiked = mysqli_query($mysqli, "SELECT ID FROM likes WHERE liked_state = 'dislike' AND art_liked = '$artnr' AND user_name = '$gebruikersnaam'");
    if (mysqli_num_rows($isLiked) > 0) {
      $styleButtonDislike = 'background: url(images/dislike_icon_blue.png); height: 35px; width: 35px;';
    } else {
      $styleButtonDislike = 'background: url(images/dislike_symbol.png); height: 35px; width: 35px;';
    }
    return $styleButtonDislike;
  }
?>
<script>
  //post with ajax on button press (likes/dislikes) this one is for likes
  function like(artnr) {
    var idLiked = artnr + 'like';
    var idDisliked = artnr + 'dislike';
    $.post("like.php", {
        artnr: artnr,
        whatlike: 'like'
      },
      function(response) {
        if (response === 'liked') {
          document.getElementById(idLiked).style.background='url(images/like_icon_blue.png)';
          document.getElementById(idDisliked).style.background='url(images/dislike_symbol.png)';
        } else if (response === 'unliked') {
          document.getElementById(idLiked).style.background='url(images/like_icon.png)';
          document.getElementById(idDisliked).style.background='url(images/dislike_symbol.png)';
        }
        updateLikeToDislikeRatio(artnr);
        updateDislikes(artnr);
        updateLikes(artnr);
      })
  }
  //post with ajax on button press (likes/dislikes) this one is for dislikes
  function dislike(artnr) {
    var idLiked = artnr + 'like';
    var idDisliked = artnr + 'dislike';
    $.post("like.php", {
        artnr: artnr,
        whatlike: 'dislike'
      },
      function(response) {
      if (response === 'liked') {
          document.getElementById(idDisliked).style.background = 'url(images/dislike_icon_blue.png)';
          document.getElementById(idLiked).style.background = 'url(images/like_icon.png)';
        } else if (response === 'unliked') {
          document.getElementById(idDisliked).style.background = 'url(images/dislike_symbol.png)';
          document.getElementById(idLiked).style.background = 'url(images/like_icon.png)';
        }
        updateLikeToDislikeRatio(artnr);
        updateDislikes(artnr);
        updateLikes(artnr);
      })
  }
  //for commenting
  function commentOnArt(artnr) {
    var textbox = artnr + 'comment';
    var comment = document.getElementById(textbox).value;
    var user = "<?php echo $gebruikersnaam;?>";
    var divID = artnr + 'commentdiv';
    var Div = document.getElementById(divID);
    var content = document.createTextNode(comment);
    var userinsert = document.createTextNode(user);
    var pStart = document.createElement("p");
    var br = document.createElement("br");
    Div.appendChild(pStart);
    Div.appendChild(userinsert);
    Div.appendChild(pStart);
    Div.appendChild(content);
    Div.appendChild(br);
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

  function updateLikes(artnr) {
    var id = artnr + 'likesOnPost';
    var update = 'likes';
    $.post("update.php", {
        update: update,
        artnr: artnr
      },
      function(response) {
        document.getElementById(id).innerHTML = 'likes this post has gained: ' + response;
      })
  }

  function updateDislikes(artnr) {
    var id = artnr + 'dislikesOnPost';
    var update = 'dislikes';
    $.post("update.php", {
        update: update,
        artnr: artnr
      },
      function(response) {
        console.log(response);
        document.getElementById(id).innerHTML = 'dislikes this post has gained: ' + response;

      })
  }

  function updateLikeToDislikeRatio(artnr) {
    var id = artnr + 'likeToDislikeRatio';
    var update = 'ratio';
    $.post("update.php", {
        update: update,
        artnr: artnr
      },
      function(response) {
        document.getElementById(id).innerHTML = 'like to dislike ratio on this post: ' + response;
      })
  }
</script>
</body>
</html>
