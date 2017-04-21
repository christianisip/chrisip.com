<?php
  session_start();
  require('connect.php');
  if(isset($_POST['create']))
  {
      $newNewNavValidate = filter_input(INPUT_POST, "newnav", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $query="INSERT INTO navigation (navName) VALUES (:newnav)";
      $statement = $db->prepare($query);
      $statement->bindValue(':newnav', $newNewNavValidate);
      $statement->execute();
      header('Location:admin.php');
  }

  $queryNav = "SELECT navName FROM navigation";
  $statementNav = $db->prepare($queryNav);
  $statementNav->execute();
  $rowsNav = $statementNav->fetchAll();
  foreach($rowsNav as $rowNav);

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
   </head>
 <body>
   <nav class="navbar navbar-default navbar-fixed-top">
     <div class="container">
         <!-- Brand and toggle get grouped for better mobile display -->
         <div class="navbar-header page-scroll">
             <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                 <span class="sr-only">Toggle navigation</span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
             </button>
             <a class="navbar-brand" href="#page-top">Start Bootstrap</a>
         </div>

         <!-- Collect the nav links, forms, and other content for toggling -->
         <div class="collapse navbar-collapse" id="navbar-collapse-2">
           <ul class="nav navbar-nav navbar-right">
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
              <li><a href="#">Messages <span class="badge pull-right">  </span></a></li>
             <li><a href="?user=logout"> Sign Out <span class="glyphicon glyphicon-log-out pull-right"></span></a></li>
             </ul>
             </li>
            <a class="btn btn-default btn-outline btn-circle"  data-toggle="collapse" href="#nav-collapse2" aria-expanded="false" aria-controls="nav-collapse2">Section</a>

           </ul>
           <div class="collapse nav navbar-nav nav-collapse slide-down" id="nav-collapse2">
             <ul class="nav navbar-nav navbar-right">
               <?php   foreach($rowsNav as $rowNav): ?>
                 <li><a href="section.php?section=<?= $rowNav['navName'] ?>"> <?= $rowNav['navName'] ?></a></li>
               <?php endforeach ?>
             </ul>
           </div>
         </div><!-- /.navbar-collapse -->
         <!-- /.navbar-collapse -->
     </div>
     <!-- /.container-fluid -->
 </nav>
 <header id="page-top">
     <div class="container">
         <div class="row">
             <div class="col-lg-12">
                 <img class="img-responsive" src="http://ironsummitmedia.github.io/startbootstrap-freelancer/img/profile.png" alt="">
                 <div class="intro-text">
                     <span class="name">Inspired by PureCSS.io</span>
                     <hr class="star-light">
                     <p class="skills">Landing Page Layout</p>
                     <p class="skills">Scroll to see the effect</p>
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
           <form method="post">

               <p>
                 <label for="newnav"> New Navigation on Section </label>
                 <input name="newnav" id="newnav">
               <input type="submit" name="create" value="create"></p>
               <p><a href="create.php"> Create New Blog Post</a> </p>
           </form>
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
