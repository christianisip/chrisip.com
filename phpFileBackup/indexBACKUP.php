<?php
  session_start();

  $_SESSION['sectionpass'] = 'test';
  require('connect.php');
  $test ='';
  $output = '';
  $queryBody = "SELECT * FROM blog ORDER BY blogId DESC LIMIT 2";
  $statementBody = $db->prepare($queryBody);
  $statementBody->execute();
  $rowsBody = $statementBody->fetchAll();
  foreach($rowsBody as $rowBody);

  $queryNav = "SELECT navName FROM navigation";
  $statementNav = $db->prepare($queryNav);
  $statementNav->execute();
  $rowsNav = $statementNav->fetchAll();
  foreach($rowsNav as $rowNav);

  $queryPictures = "SELECT * FROM blog WHERE imagepath IS NOT NULL AND TRIM(imagepath) <> '' ORDER BY RAND() LIMIT 5";
  $statementPictures = $db->prepare($queryPictures);
  $statementPictures->execute();
  $rowsPictures = $statementPictures->fetchAll();


  $output = "";
  if (isset($_POST['search']))
  {
    $searchq = $_POST['search'];
    $querysearch = "SELECT * FROM blog WHERE (title LIKE '%$searchq%') OR  (content LIKE '%$searchq%')";
    $statementsearch = $db->prepare($querysearch);
    $statementsearch->execute();
    $rowssearch = $statementsearch->fetchAll();

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
   </head>
 <body>
       <nav class="navbar-findcond ">
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
               <form  method="get" action="search.php" class="navbar-form navbar-right" role="search">
                 <div class="form-group">
                   <input type="text" class="form-control" placeholder="Search" name="regName">
                 </div>
                 <button type="submit" class="btn-danger"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                 </form>
                       </li>
             <li><a href=index.php>Home</a></li>
             <li><a href=create.php> Create</a></li>

            <a class="btn btn-default btn-outline btn-circle"  data-toggle="collapse" href="#nav-collapse2" aria-expanded="false" aria-controls="nav-collapse2">Sign in</a>

           </ul>
           <div class="collapse nav navbar-nav nav-collapse slide-down" id="nav-collapse2">
             <ul class="nav navbar-nav navbar-right">
               <li><a href=index.php>Home</a></li>
               <li><a href=create.php> Create</a></li>
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
   <h2 class="text-center">Services Blocks</h2>
         <div class="row">

              <?php if (!empty($rowsBody)): ?>
              <?php foreach ($rowsBody as $rowBody): ?>
               <div class="col-md-6 text-center">
                   <div class="box">
                       <div class="box-content">
                         <h2>

                           <a href="show.php?blogId=<?= $rowBody['blogId'] ?>"> <?= $rowBody['title'] ?> </a>
                           <small> <a  href = "edit.php?blogId=<?= $rowBody['blogId'] ?>" class="btn">
                                   <i class="glyphicon glyphicon-pencil"></i>
                                   Edit
                                </a></small>
                         </h2>
                         <small> <b><i> <?= $rowBody['author'] ?> <?= $rowBody['section'] ?> </i> </b> <?= date("F d, Y", strtotime($rowBody['datetime'])); ?></small>
                          <hr />
                          <p>
                           <?= substr($rowBody['content'], 0, 200) ?>
                           <?php if(strlen($rowBody['content']) > 200): ?>
                             <a  href = "show.php?id=<?= $rowBody['id'] ?>" class="btn btn-block btn-primary">Learn more</a>
                           <?php endif ?>
                          </p>
                            <br />
                           <a href="ppc.html" class="btn btn-block btn-primary">Learn more</a>
                       </div>
                   </div>
               </div>
             <?php endforeach ?>
             <?php endif ?>



       </div>
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
                     <p>Freelancer is a free bootstrap theme created by Start Bootstrap. The download includes the complete source files including HTML, CSS, and JavaScript as well as optional LESS stylesheets for easy customization.</p>
                 </div>
                 <div class="col-lg-4">
                     <p>Whether you're a student looking to showcase your work, a professional looking to attract clients, or a graphic artist looking to share your projects, this template is the perfect starting point!</p>
                 </div>
             </div>
         </div>
     </section>

 </div>
 </body>
 </html>
