<?php


session_start();
if(!isset($_SESSION['getuserId']))
{
  $_SESSION['getuserId'] ='';
}
$testerror = '';
$duplicateNameFlag = false;
$userStatus = false;
  require('connect.php');
  $newUserNameValidate = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $queryNav = "SELECT navName FROM navigation ";
  $statementNav = $db->prepare($queryNav);
  $statementNav->execute();
  $rowsNav = $statementNav->fetchAll();

  $queryCheckUsername = "SELECT username FROM users";
  $statementUsername = $db->prepare($queryCheckUsername);
  $statementUsername->execute();
  $rowsCheckUsername = $statementUsername->fetchAll();


  $errorLogin = false;

  if($_SERVER['REQUEST_METHOD'] == "POST")
  {
    if(isset($_POST['create']))
    {
      $usernameduplicatevalidate = $_POST['username'];

      foreach ($rowsCheckUsername as $key)
      {
        if($key['username'] ==  $usernameduplicatevalidate)
        {
            $duplicateNameFlag = true;
            $testerror = '<p> error </p>';
        }
      }
      if($duplicateNameFlag == false)
      {
          $url = 'https://www.google.com/recaptcha/api/siteverify';
          $privatekey = '6LccsB0TAAAAAPwjEVvLM7ln1Bn8-WeChT2JbIT9';

          $response = file_get_contents($url."?secret=".$privatekey.
          "&response=".$_POST['g-recaptcha-response']);
          $data = json_decode($response);

          if(isset($data->success) AND $data->success == true)
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
        }
    }


    if(isset($_POST['login']))
    {

            $userTest = $_POST['username'];
            $password = ($_POST['userpassword']);
      $newUserNameValidate = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $getuserId = 'SELECT userId FROM users WHERE username = :username LIMIT 1';
      $statementgetId = $db->prepare($getuserId);
      $statementgetId->bindValue(':username', $userTest);
      $statementgetId->execute();
      $rowsgetuserId = $statementgetId->fetchAll();
      foreach ($rowsgetuserId as $rowsgetuserIdKey)
      {
        $_SESSION['getuserId'] = $rowsgetuserIdKey['userId'];
      }


      $validateLogin = 'SELECT userpassword FROM users WHERE username = :username LIMIT 1';
      $statementLogin = $db->prepare($validateLogin);
      $statementLogin->bindValue(':username', $userTest);
      $statementLogin->execute();
      $user = $statementLogin->fetch(PDO::FETCH_OBJ);

      if(($statementLogin->rowcount() != 0) && (hash_equals($user->userpassword, crypt($password, $user->userpassword)) ))
      {
        $ten_minutes_from_now = time() + 600;
        setcookie('name', $userTest, $ten_minutes_from_now);
        $_SESSION['remember'] = $userTest;
          header('Location:login.php');
      }
      else
      {
        $errorLogin = true;
      }
    }
  }




  if(isset($_GET['user']))
  {
    unset($_SESSION['getuserId']);
    unset($_SESSION['remember']);
    header('Location:index.php');
  }


?>
<script>
</script>
 <html lang="en">
 	<head>
     <meta charset="UTF-8"/>
     <link href="indexTEST.css" rel="stylesheet" media="screen">
     <link href="css/bootstrap.min3rd.css" rel="stylesheet" media="screen">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <title> Chrisip - Home </title>
      <script src='https://www.google.com/recaptcha/api.js'></script>
   </head>
 <body>
   <nav class="navbar-findcond ">
     <nav class="navbar navbar-default navbar-fixed-top">
       <div class="container">
           <!-- Brand and toggle get grouped for better mobile display -->
           <div class="navbar-header page-scroll">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-2">
                   <span class="sr-only">Toggle navigation</span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
               </button>
               <a href="#page-top"> <img class="img-responsive, navbar-brand" src="chrisiplogo.png" alt="" width="120" height="200"> </a>
           </div>

           <!-- Collect the nav links, forms, and other content for toggling -->
           <div class="collapse navbar-collapse" id="navbar-collapse-2">
             <ul class="nav navbar-nav navbar-right navbar-findcond">
               <li>
                 <form method="post" class="navbar-form navbar-right">
                   <div class="form-group">
                     <input type="text" class="form-control" placeholder="Search for title" name="regName">
                   </div>
                   <!-- <input type="submit" name="search" class="btn-danger"> -->
                   <button type="submit" name="search" class="btn-danger"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                   </form>
                 </li>
               <li><a href=index.php>Home</a></li>
               <li><a href=#about>About</a></li>
               <li class="dropdown">
                 <?php if(isset($_SESSION['remember'])): ?>
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?= $_SESSION['remember'] ?> <span class="glyphicon glyphicon-user pull-right"></span></a>
                 <?php else: ?>
                         <a href="login.php"> Login/Register <span class="glyphicon glyphicon-user pull-right"></span></a>
                 <?php endif ?>
            <ul class="dropdown-menu">
              <?php if($_SESSION['remember'] == 'testq'): ?>
                <li><a href="admin.php"> Admin <span class="glyphicon glyphicon-cog pull-right"></span></a></li>
              <?php endif ?>
              <li><a href="#">User stats <span class="glyphicon glyphicon-stats pull-right"></span></a></li>
                <li><a href="#">Messages <span class="badge pull-right">  <?=    $_SESSION['getuserId'] ?> </span></a></li>
              <li><a href="?user=logout"> Sign Out <span class="glyphicon glyphicon-log-out pull-right"></span></a></li>
            </ul>
          </li>
              <a id="notstyl"class="btn btn-default btn-outline btn-circle"  data-toggle="collapse" href="#nav-collapse2" aria-expanded="false" aria-controls="nav-collapse2">Section</a>

             </ul>
             <div class="collapse nav navbar-nav nav-collapse slide-down" id="nav-collapse2">
               <ul class="nav navbar-nav navbar-right">
                 <li><a href=index.php>Home</a></li>
               </ul>
             </div>
           </div><!-- /.navbar-collapse -->
           <!-- /.navbar-collapse -->
       </div>
       <!-- /.container-fluid -->
     </nav>
   </nav>
   <header id="page-top">
       <div class="container">
           <div class="row">
               <div class="col-lg-12">
                   <div class="intro-text">
                       <span class="name"> WELCOME TO MY BLOG!</span>
                       <hr class="star-light">
                       <p class="skills">There is nothing more urgent right now</p>
                       <p class="skills">because later might never come.</p>
                   </div>
               </div>
           </div>
       </div>
   </header>

 <div class="content-wrapper">
     <section class="primary" id="portfolio">
       <div class="container">
 <div class="row">
   <h2 class="text-center"> BLOG </h2>
      <center>
         <div class="row">
           <?=   $_SESSION['getuserId'] ?>
         <?= $testerror ?>
                <form method="post" action="login.php">
              <p>
                <label for="username"> User Name </label>
                <input name="username" id="username">
              </p>
              <p>
                <label for="userpassword"> Password  </label>
                <input type='password' name="userpassword" id="userpassword">
              </p>
              <p> <input type="submit" name="create" value="create">
             <input type="submit" name="login" value="login"></p>
            <div class="g-recaptcha" data-sitekey="6LccsB0TAAAAAL1PFumdIbz-QXh7XPHveDHeTswx"></div>
           </form>
           <?php if($errorLogin == true): ?>
             <p> the username and password doenst matcht </p>
           <?php endif ?>
           <?= $testerror ?>
       </div>
     </center>
 </div>
</div>
     </section>
     <section class="success" id="about">
         <div class="container">
             <div class="row">
                 <div class="col-lg-12 text-center">
                     <h2>About</h2>
                     <hr class="star-light">
                 </div>
             </div>
             <div class="row">
                 <div class="col-lg-4 col-lg-offset-2">
                     <p> Im just a guy who codes</p>
                 </div>
                 <div class="col-lg-4">
                     <p>soon more stuff</p>
                 </div>
             </div>
         </div>
     </section>

 </div>

 </body>

 </html>
