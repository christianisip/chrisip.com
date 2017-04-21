<?php
session_start();

  require('connect.php');
  $newUserNameValidate = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $queryNav = "SELECT navName FROM navigation";
  $statementNav = $db->prepare($queryNav);
  $statementNav->execute();
  $rowsNav = $statementNav->fetchAll();


  if(isset($_POST['create']))
  {
    $newUserNameValidate = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userTest = $_POST['username'];
    $password = ($_POST['userpassword']);
    $cost = 10;
    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
    $salt = sprintf("$2a$%02d$", $cost) . $salt;
    $hash = crypt($password, $salt);
    $query="INSERT INTO users (username, userpassword) VALUES (:username, :userpassword)";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $newUserNameValidate);
    $statement->bindValue(':userpassword', $hash);
    $statement->execute();
  }

  if(isset($_POST['login']))
  {
      $newUserNameValidate = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userTest = $_POST['username'];
    $password = ($_POST['userpassword']);
    $validateLogin = 'SELECT userpassword FROM users WHERE username = :username LIMIT 1';
    $statementLogin = $db->prepare($validateLogin);
    $statementLogin->bindValue(':username', $userTest);
    $statementLogin->execute();
    $user = $statementLogin->fetch(PDO::FETCH_OBJ);
    $usertest = $statementLogin->fetch();

    if(($statementLogin->rowcount() != 0) && (hash_equals($user->userpassword, crypt($password, $user->userpassword)) ))
    {
      $ten_minutes_from_now = time() + 600;
      setcookie('name', $userTest, $ten_minutes_from_now);
      $_SESSION['remember'] = $userTest;
      echo $_SESSION['remember'];

    }
    else
    {
      echo "NOT SUCESS";
    }
  }

  if(isset($_POST['logout']))
  {
    session_destroy();

  }

?>
 <html lang="en">
 	<head>
     <meta charset="UTF-8"/>
     <link href="indexTEST.css" rel="stylesheet" media="screen">
     <link href="css/bootstrap.min3rd.css" rel="stylesheet" media="screen">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <title> Chrisip - Home </title>
   </head>
 <body>
<div class="container">
  <img class='navbar-brand' src="chrisiplogo.png" alt="chrisiplogo" align="middle" style="width:300px; height:80px;">
     <nav class="navbar-findcond ">
        <!-- Second navbar for sign in -->
    <nav class="navbar navbar-default">
      <div class="">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-2">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse-2">

          <ul class="nav navbar-nav navbar-right">

            <li>
              <form  method="get" action="search.php" class="navbar-form navbar-right" role="search">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Search" name="regName">
                </div>
                <button type="submit" class="btn-danger"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                </form>
                      </li>
            <li><a href=index.php>Home</a></li>
            <li><a href=create.php> Create</a></li>
            <li>
              <a class="navbar-brand"  data-toggle="collapse" href="#nav-collapse2" aria-expanded="false" aria-controls="nav-collapse2">Section</a>
            </li>
          </ul>
          <div class="collapse nav navbar-nav nav-collapse slide-down" id="nav-collapse2">


                <ul class="nav navbar-nav navbar-right">
                  <li><a href=indexBACKUP.php>Home</a></li>
                  <li><a href=create.php> Create</a></li>
              </ul>


          </div>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->



   </nav>




   <div id="content-mycss" class="col-md-8 col-xs-6">

     <form method="post">
   <p>
     <label for="username"> User Name </label>
     <input name="username" id="username">
   </p>
   <p>
     <label for="userpassword"> Password  </label>
     <input type='password' name="userpassword" id="userpassword">
   </p>
   <p> <input type="submit" name="create" value="create"></p>
   <p> <input type="submit" name="login" value="login"></p>
     <p> <input type="submit" name="logout" value="logout"></p>

</form>
     </div>

 <div id = "rightcontent-mycss" class="col-md-4 col-xs-5">
   <center>
     <p> My Social Media: </p>
     <div class="rightborderstyle">
     </div>

     <div class="rightbordercontent">
       <a href="https://www.facebook.com/christian.isip09" class="image-link"> <img src="fblogo.png" alt="fblogo" border="0"/> </a>
       <a href="https://twitter.com/ChristianIsip09" class="twitter-follow-button" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @ChristianIsip09</a>
       <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
       <a href="https://www.instagram.com/crisip09/" class="image-link"> <img src="instagramlogo.png" alt="instagramlogo" style="width:29px; height:29px;"> </a>
     </div>
     <p> Who Am I: </p>
  </center>
   <div class="rightborderstyle">
   </div>

   <div class="">
     <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ornare lacus leo, hendrerit efficitur turpis cursus quis.  Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut at dolor interdum, ultricies libero et, hendrerit metus. Phasellus ac magna fermentum, fermentum neque non, posuere dui. </p>
   </div>
 <div id="myCarousel" class="carousel slide" data-ride="carousel">
<!-- Indicators -->

<ol class="carousel-indicators">
 <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
 <li data-target="#myCarousel" data-slide-to="1"></li>
 <li data-target="#myCarousel" data-slide-to="2"></li>
 <li data-target="#myCarousel" data-slide-to="3"></li>
</ol>


<div class="carousel-inner" role="listbox">
  <?php if (!empty($rowsPictures)): ?>
    <?php foreach ($rowsPictures as $rowsPicture): ?>
      <div class="item active">
         <img src="uploads/<?= $rowsPicture['imagepath'] ?>" alt="test" height="150" width="300">
      </div>
  <?php endforeach ?>
<?php endif ?>



<!-- Left and right controls -->
<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
 <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
 <span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
 <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
 <span class="sr-only">Next</span>
</a>
</div>
    <div class="rightborderstyle">
    </div>
   </div>
 </div>
   </div>
 </div>
 </body>
 </html>
