<?php
session_start();
require('connect.php');
include_once("ak_php_img_lib_1.0.php");

$queryNav = "SELECT navigationname FROM topnavigation";
$statementNav = $db->prepare($queryNav);
$statementNav->execute();
$rowsNav = $statementNav->fetchAll();
foreach($rowsNav as $rowNav);


  function file_upload_path($original_filename, $upload_subfolder_name = 'uploads/images')
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

      $kaboom = explode(".", $image_filename  ); // Split file name into an array using the dot
		$fileExt = end($kaboom); // Now target the last array element to get the file extension
		// START PHP Image Upload Error Handling
	 	if (file_is_an_image($temporary_image_path, $new_image_path))
        {
            move_uploaded_file($temporary_image_path, $new_image_path);
            //Img_Resize($new_image_path);
        }
		$target_file = "uploads/images/$image_filename";
		$resized_file = "uploads/imagesResize/resized_$image_filename";
		$wmax = 200;
		$hmax = 150;
		ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
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
      $query="INSERT INTO blog (blogtitle, blogcontent, blogauthor, blogsection, subsection, imagepath) VALUES (:title, :content, :author, :section, :subsection, :filename)";
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
      $query="INSERT INTO blog (blogtitle, blogcontent, blogauthor, blogsection) VALUES (:title, :content, :author, :section)";
      $statement = $db->prepare($query);
      $statement->bindValue(':title', $newTitleValidate);
      $statement->bindValue(':content', $newContentValidate);
      $statement->bindValue(':author', $newAuthorValidate);
      $statement->bindValue(':section', $newSectionValidate);
      $statement->execute();
      session_destroy();
    }
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
                       <input type="radio" name="section" value="<?= $rowNav['navigationname']?>"> <?= $rowNav['navigationname']?>
                     <?php endforeach ?>
                   <?php endif ?>
               </p>

               <p> <input type="submit" name="create" value="create"></p>
           </form>
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
