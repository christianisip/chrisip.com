<?php
  session_start();
  echo $_SESSION['sectionpass'];
  require('connect.php');
  $searchq = $_SESSION['regName'];


  $start=0;
  $limit=1;

  if(isset($_GET['blogId']))
  {
      $id=$_GET['blogId'];
      $start=($id-1)*$limit;
  }
  else
  {
      $id=1;
  }

  //Fetch from database first 10 items which is its limit. For that when page open you can see first 10 items.
  // $queryPage = "SELECT * FROM blog LIMIT $start, $limit";
  // $statementPage = $db->prepare($queryPage);
  // $statementPage->execute();
  // $rowsPage = $statementPage->fetchAll();

  $querysearch = "SELECT * FROM blog WHERE (title LIKE '%$searchq%') OR  (content LIKE '%$searchq%') LIMIT $start, $limit";
  $statementsearch = $db->prepare($querysearch);
  $statementsearch->execute();
  $rowssearch = $statementsearch->fetchAll();

  $queryPage2 = "SELECT * FROM blog WHERE (title LIKE '%$searchq%') OR  (content LIKE '%$searchq%')";
  $statementPage2 = $db->prepare($queryPage2);
  $statementPage2->execute();
   $rows = $statementPage2->rowCount();
    $total=ceil($rows/$limit);



    if(isset($_GET['user']))
    {
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
         <div class="row">
            <?php foreach ($rowsPage as $rowsPages): ?>
               <div class="col-md-6 text-center">
                   <div class="box">
                       <div class="box-content">
                         <h2>
                           <a href="show.php?blogId=<?= $rowsPages['blogId'] ?>"> <?= $rowsPages['title'] ?> </a>
                           <small> <a  href = "edit.php?blogId=<?= $rowsPages['blogId'] ?>" class="btn">
                                   <i class="glyphicon glyphicon-pencil"></i>
                                   Edit
                                </a></small>
                         </h2>
                         <small> <b><i> <?= $rowsPages['author'] ?> <?= $rowsPages['section'] ?> </i> </b> <?= date("F d, Y", strtotime($rowsPages['datetime'])); ?></small>
                          <hr />
                          <p>
                           <?= substr($rowsPages['content'], 0, 500) ?>

                          </p>
                            <br />
                           <a href="show.php?blogId=<?= $rowsPages['blogId'] ?>" class="btn btn-block btn-primary">Learn more</a>
                       </div>
                   </div>
               </div>
             <?php endforeach ?>
       </div>
       <div class='paginationcenter'>
       <ul class="pagination">
                  <?php if($id>1): ?>
                    <li ><a href="?blogId=<?= ($id-1)?>">«</a></li>
                  <?php  else: ?>
                    <li class="disabled"><a>«</a></li>
                  <?php endif ?>



                  <?php  for($i=1;$i<=$total;$i++){ ?>
                    <?php if($i==$id): ?>
                      <li class="active"><a href="#"> <?= $i ?> <span class="sr-only">(current)</span></a></li>
                    <?php else: ?>
                       <li><a href="?blogId=<?= $i ?>"> <?= $i ?> </a></li>
                     <?php endif ?>
                  <?php }?>



                  <?php if($id!=$total): ?>
                    <li><a href="?blogId=<?= ($id+1) ?>">»</a></li>
                  <?php else:?>
                    <li class="disabled"><a>»</a></li>
                  <?php endif ?>
        </ul>
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
