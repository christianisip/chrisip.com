<?php
  require('connect.php');
  session_start();

  if(!empty($_GET['blogId']))
  {
    $_SESSION['id'] = $_GET['blogId'];
  }

  $query = "SELECT * FROM blog WHERE blogId = '$_SESSION[id]'";
  $statement = $db->prepare($query);
  $statement->execute();
  $rowsBody = $statement->fetchAll();
  foreach($rowsBody as $rowBody);

  $queryNav = "SELECT navName FROM navigation";
  $statementNav = $db->prepare($queryNav);
  $statementNav->execute();
  $rowsNav = $statementNav->fetchAll();
  foreach($rowsNav as $rowNav);


  $queryComment = "SELECT * FROM blogcomments WHERE blogId = $_SESSION[id]" ;
  $statementComment = $db->prepare($queryComment);
  $statementComment->execute();
  $rowsComment = $statementComment->fetchAll();



  $output = "";
  if (isset($_POST['search']))
  {
    $searchq = $_POST['search'];
    $querysearch = "SELECT * FROM blog WHERE title LIKE '%$searchq%'";
    $statementsearch = $db->prepare($querysearch);
    $statementsearch->execute();
    $rowssearch = $statementsearch->fetchAll();
    foreach($rowssearch as $rowsearch);

    $title = $rowsearch['title'];
    $output .= '<p>' . $title.' </p>';
  }

  if (isset($_POST['create']))
  {
    session_start();
    $code = $_SESSION['digit'];
    $user = $_POST['captcha'];
    if ($code === $user)
    {
        $userId = $_SESSION['getuserId'];
        $newCommentValidate = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $newCommentIdValidate = filter_input(INPUT_GET, $_GET['blogId'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $queryComment = "INSERT INTO blogcomments (blogComment, blogId) VALUES (:comment, '".$_GET["blogId"]."')";
        // $queryComment = "INSERT INTO blogcomments (blogComment, blogId, userId) VALUES (:comment, '".$_GET["blogId"]."', '".$userId."')";
        $statementComment = $db->prepare($queryComment);
        $statementComment->bindValue(':comment', $newCommentValidate);
        $statementComment->execute();
        header("Location: show.php?blogId=".$_SESSION['id']);
        exit();
    }
  }

  if(isset($_POST['deletepic']))
  {
  		$id = filter_input(INPUT_GET, 'blogId', FILTER_SANITIZE_NUMBER_INT);
  		$query = "UPDATE blog SET imagepath = null WHERE blogId = '$_GET[blogId]'";
  		$statement = $db->prepare($query);
  		$statement->execute();
  }

  if(isset($_GET['commentId']))
  {
  		$id = filter_input(INPUT_GET, 'commentId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  		$query = "DELETE FROM blogcomments WHERE commentId = '$_GET[commentId]'";
  		$statement = $db->prepare($query);
  		$statement->bindValue('$_GET[commentId]', $id, PDO::PARAM_INT);
  		$statement->execute();
  		header("Location: show.php?blogId=".$_SESSION['id']);
  		exit();
  }


  if(isset($_GET['user']))
  {
    unset($_SESSION['remember']);
    header('Location:show.php');
  }
?>
<script>
</script>
 <html lang="en">
 	<head>
     <meta charset="UTF-8"/>
     <link href="index.css" rel="stylesheet" media="screen">
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
                   <li><a href="section.php?section=<?= $rowNav['navigationname'] ?>"> <?= $rowNav['navigationname'] ?></a></li>
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
      <enter>
       <div class="container">
 <div class="row">
   <h2 class="text-center">Blog</h2>
         <div class="row">
            <?php if (!empty($rowsBody)): ?>
            <?php foreach ($rowsBody as $rowBody): ?>
             <div class="col-md-12 text-center">
                 <div class="box">
                     <div class="box-content">
                       <h2>
                         <a href="show.php?blogId=<?= $rowBody['blogId'] ?>"> <?= $rowBody['blogtitle'] ?> </a>
                         <small> <a  href = "edit.php?blogId=<?= $rowBody['blogId'] ?>" class="btn">
                                 <i class="glyphicon glyphicon-pencil"></i>
                                 Edit
                              </a></small>
                       </h2>
                       <small> <b><i> <?= $rowBody['blogauthor'] ?> <?= $rowBody['blogsection'] ?> </i> </b> <?= date("F d, Y", strtotime($rowBody['blogdatetime'])); ?></small>
                        <hr />
                        <p>
                         <?= $rowBody['blogcontent'] ?>
                        </p>
                          <br />
                     </div>
                     <div id="comment">
                     <form method="post">
                       <fieldset>
                         <?php if (!empty($rowsComment)): ?>
                           <?php foreach ($rowsComment as $rowComment): ?>
                              <p> <?= $rowComment['blogComment'] ?>
                              <small>
                                <a href = "?commentId=<?= $rowComment['commentId'] ?>" class="btn">
                                      <i class="glyphicon glyphicon-erase"></i>
                                        Delete
                                      </a></small></p>
                           <?php endforeach ?>
                         <?php endif ?>
                         <!-- <legend> comments </legend>


                        <p>
                          <input type="text" size="6" maxlength="5" name="captcha" id="captcha" value="">
                          <img src="captcha.php" width="120" height="30" border="1" alt="CAPTCHA">
                        </p>
                            <p><small>Enter the CAPTCHA number</small></p>
                          <br>


                         <p>
                           <label for="title"> Comment</label>
                           <input name="comment" id="comment">
                         </p>
                         <p> <input type="submit" name="create" value="Post Comment"></p> -->
                       </fieldset>
                     </form>
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
 <script type="text/javascript">

   function checkForm(form)
   {
     if(!form.captcha.value.match(/^\d{5}$/))
     {
       alert('Please enter the CAPTCHA digits in the box provided');
       form.captcha.focus();
       return false;
     }

     return true;
   }

 </script>
 </html>
