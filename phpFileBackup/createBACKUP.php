<?php
session_start();
require('connect.php');

$queryNav = "SELECT navName FROM navigation";
$statementNav = $db->prepare($queryNav);
$statementNav->execute();
$rowsNav = $statementNav->fetchAll();
foreach($rowsNav as $rowNav);


  function file_upload_path($original_filename, $upload_subfolder_name = 'uploads')
  {
       $current_folder = dirname(__FILE__);

       // Build an array of paths segment names to be joins using OS specific slashes.
       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

       // The DIRECTORY_SEPARATOR constant is OS specific.
       return join(DIRECTORY_SEPARATOR, $path_segments);
  }
      // file_is_an_image() - Checks the mime-type & extension of the uploaded file for "image-ness".
  function file_is_an_image($temporary_path, $new_path)
  {
    $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

    $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type        = getimagesize($temporary_path)['mime'];

    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

    return $file_extension_is_valid && $mime_type_is_valid;
  }

  $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
  $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);

  if ($image_upload_detected)
  {
      $image_filename        = $_FILES['image']['name'];
      $temporary_image_path  = $_FILES['image']['tmp_name'];
      $new_image_path        = file_upload_path($image_filename);
      if (file_is_an_image($temporary_image_path, $new_image_path))
      {
          move_uploaded_file($temporary_image_path, $new_image_path);
      }
      $_SESSION['imagename'] = $image_filename ;
  }

if(isset($_POST['create']))
{
  $filename = $_SESSION['imagename'];
  $newTitleValidate = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $newContentValidate = filter_input(INPUT_POST, "content",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $newAuthorValidate = filter_input(INPUT_POST, "author",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $newSectionValidate = filter_input(INPUT_POST, "section",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $newSubSectionValidate = filter_input(INPUT_POST, "subsection",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $newImagePathValidate = filter_input(INPUT_POST, $filename,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  if(!empty($filename))
  {
      $query="INSERT INTO blog (title, content, author, section, subsection, imagepath) VALUES (:title, :content, :author, :section, :subsection, :filename)";
      $statement = $db->prepare($query);
      $statement->bindValue(':title', $newTitleValidate);
      $statement->bindValue(':content', $newContentValidate);
      $statement->bindValue(':author', $newAuthorValidate);
      $statement->bindValue(':section', $newSectionValidate);
      $statement->bindValue(':subsection', $newSubSectionValidate);
      $statement->bindValue(':filename', $filename);
      $statement->execute();
      session_destroy();
    }
    else
    {
      $query="INSERT INTO blog (title, content, author, section, subsection) VALUES (:title, :content, :author, :section, :subsection)";
      $statement = $db->prepare($query);
      $statement->bindValue(':title', $newTitleValidate);
      $statement->bindValue(':content', $newContentValidate);
      $statement->bindValue(':author', $newAuthorValidate);
      $statement->bindValue(':section', $newSectionValidate);
      $statement->bindValue(':subsection', $newSubSectionValidate);
      $statement->execute();
      session_destroy();
    }
}

/*
$filename = $_SESSION['imagename'];

$query="INSERT INTO pictures (title) VALUES (:filename)";
$statement = $db->prepare($query);
$statement->bindValue(':filename', $newImagePathValidate);
$statement->execute();
session_destroy();
*/

$queryNav = "SELECT navName FROM navigation";
$statementNav = $db->prepare($queryNav);
$statementNav->execute();
$rowsNav = $statementNav->fetchAll();



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
     <form method="post" enctype="multipart/form-data">
          <label for="image">Image Filename:</label>
          <input type="file" name="image" id="image">
          <input type="submit" name="upload" value="Upload Image">
      </form>
      <?php if (isset($_FILES['image']) && $_FILES['image']['error'] > 0): ?>
          <p>Error Number: <?= $_FILES['image']['error'] ?></p>
      <?php elseif (isset($_FILES['image'])): ?>
          <p>Client-Side Filename: <?= $_FILES['image']['name'] ?></p>
          <p>Apparent Mime Type:   <?= $_FILES['image']['type'] ?></p>
          <p>Size in Bytes:        <?= $_FILES['image']['size'] ?></p>
          <p>Temporary Path:       <?= $_FILES['image']['tmp_name'] ?></p>
      <?php endif ?>

     <form method="post">
         <legend> New Blog Post </legend>
         <p>
           <label for="title"> Title </label>
           <input name="title" id="title">
           <label for="author"> Author</label>
           <input name="author" id="author">
         </p>
         <p>
           <label for="content"> Content</label>
           <textarea cols='50' rows='10' name="content" id="content"></textarea>
         </p>
         <p>
             <?php if (!empty($rowsNav)): ?>
               <?php foreach ($rowsNav as $rowNav): ?>
                 <input type="radio" name="section" value="<?= $rowNav['navName']?>"> <?= $rowNav['navName']?>
               <?php endforeach ?>
             <?php endif ?>
         </p>

         <p>
           <label for="subsection"> Sub-Tag </label>
           <input name="subsection" id="subsection">
         </p>
         <p> <input type="submit" name="create" value="create"></p>
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
