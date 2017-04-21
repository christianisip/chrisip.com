<?php
  require('connect.php');
  $id = $_GET['blogId'];
  $query = "SELECT * FROM blog WHERE blogId = '$id'";
  $statement = $db->prepare($query);
  $statement->execute();
  $rowsBody = $statement->fetchAll();

  foreach($rowsBody as $rowBody);

  $queryNav = "SELECT navName FROM navigation";
  $statementNav = $db->prepare($queryNav);
  $statementNav->execute();
  $rowsNav = $statementNav->fetchAll();
  foreach($rowsNav as $rowNav);


  $queryComment = "SELECT blogComment FROM blogcomments WHERE blogId = $id" ;
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
    $newCommentValidate = filter_input(INPUT_POST, "comment", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $newCommentIdValidate = filter_input(INPUT_GET, $_GET['blogId'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $queryComment = "INSERT INTO blogcomments (blogComment, blogId) VALUES (:comment, '".$_GET["blogId"]."')";
    $statementComment = $db->prepare($queryComment);
    $statementComment->bindValue(':comment', $newCommentValidate);
    $statementComment->execute();
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
                  <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn-danger"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                </form>
                      </li>
            <li><a href=indexBACKUP.php>Home</a></li>
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
     <div id = "all_blogs">
       <?php if (!empty($rowsBody)): ?>
       <?php foreach($rowsBody as $rowBody): ?>
         <div class="blog_post">
           <h2>
             <a href="show.php<?= $rowBody['title'] ?>"> <?= $rowBody['title'] ?> </a>
             <small> <a class="yesdecoration" href = "edit.php?blogId=<?= $rowBody['blogId'] ?>"> edit</a> </small>
           </h2>
           <small> <b><i> <?= $rowBody['author'] ?> <?= $rowBody['section'] ?> </i> </b> <?= date("F d, Y", strtotime($rowBody['datetime'])); ?></small>
           <p>
            <?= substr($rowBody['content'], 0, 200) ?>
            <?php if(strlen($rowBody['content']) > 200): ?>
              <a class="yesdecoration" href = "show.php?id=<?= $rowBody['id'] ?>"> Read Full Post... </a>
            <?php endif ?>
           </p>
         </div>
       <?php endforeach ?>
       <?php endif ?>
     </div>
     <form method="post" enctype="multipart/form-data">
        <label for="image">Image Filename:</label>
        <input type="file" name="image" id="image">
        <input type="submit" name="submit" value="Upload Image">
     </form>
     <?php if (isset($_FILES['image']) && $_FILES['image']['error'] > 0): ?>
        <p>Error Number: <?= $_FILES['image']['error'] ?></p>
     <?php elseif (isset($_FILES['image'])): ?>
        <p>Client-Side Filename: <?= $_FILES['image']['name'] ?></p>
        <p>Apparent Mime Type:   <?= $_FILES['image']['type'] ?></p>
        <p>Size in Bytes:        <?= $_FILES['image']['size'] ?></p>
        <p>Temporary Path:       <?= $_FILES['image']['tmp_name'] ?></p>
     <?php endif ?>

     <div id="comment">
     <form method="post">
       <fieldset>
         <?php if (!empty($rowsComment)): ?>
           <?php foreach ($rowsComment as $rowComment): ?>
              <p> <?= $rowComment['blogComment'] ?> </p>
           <?php endforeach ?>
         <?php endif ?>
         <legend> comments </legend>
         <p>
           <label for="title"> Title Comment</label>
           <input name="comment" id="comment">
         </p>
         <p> <input type="submit" name="create" value="create"></p>
       </fieldset>
     </form>
     </div>
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
