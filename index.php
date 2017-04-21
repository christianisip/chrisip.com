<?php


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
   </head><?= $row['author'] ?>
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
                <li><a href="#">Messages <span class="badge pull-right">  </span></a></li>
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
  <section class="primary" id="blog">
    <div class="container">
      <div class="row">
        <h2 class="text-center"> BLOG </h2>
         <div class="row">
            <?php foreach ($rowsPage as $rowsPages): ?>
               <div class="col-md-6 text-center">
                   <div class="box">
                       <div class="box-content">
                         <?php if(!empty($rowsPages['imagepath'])): ?>
                           <img  src="uploads/imagesResize/resized_<?=$rowsPages['imagepath']?>" alt="" > </a>
                         <?php endif ?>
                         <h2>
                           <a href="show.php?blogId=<?= $rowsPages['blogId'] ?>"> <?= $rowsPages['title'] ?> </a>
                           <?php if(isset($_SESSION['remember']) && ($_SESSION['remember'] == 'testq')): ?>
                             <small> <a  href = "edit.php?blogId=<?= $rowsPages['blogId'] ?>" class="btn">
                                     <i class="glyphicon glyphicon-pencil"></i>
                                     Edit
                                  </a></small>
                           <?php endif ?>

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
                    <li ><a href="?blogId=<?= ($id-1)?>#blog">«</a></li>
                  <?php  else: ?>
                    <li class="disabled"><a>«</a></li>
                  <?php endif ?>

                  <?php  for($i=1;$i<=$total;$i++){ ?>
                    <?php if($i==$id): ?>
                      <li class="active"><a href="#"> <?= $i ?> <span class="sr-only">(current)</span></a></li>
                    <?php else: ?>
                       <li><a href="?blogId=<?= $i ?>#blog"> <?= $i ?> </a></li>
                     <?php endif ?>
                  <?php }?>



                  <?php if($id!=$total): ?>
                    <li><a href="?blogId=<?= ($id+1) ?>#blog  ">»</a></li>
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
