<?php
	require('connect.php');
  $newTitleValidate = filter_input(INPUT_POST, "title", FILTER_UNSAFE_RAW);
	$newContentValidate = filter_input(INPUT_POST, "content", FILTER_UNSAFE_RAW);
	$newIdValidate = filter_input(INPUT_POST, $_GET['blogId'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $newSectionValidate = filter_input(INPUT_POST, "section", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	echo $_GET['blogId'];


	$queryNav = "SELECT navName FROM navigation";
	$statementNav = $db->prepare($queryNav);
	$statementNav->execute();
	$rowsNav = $statementNav->fetchAll();
	foreach($rowsNav as $rowNav);

	if(isset($_POST['update']))
	{
		$query = "UPDATE blog SET blogtitle = '$_POST[title]', blogcontent = '$_POST[content]', blogsection = '$_POST[section]' WHERE blogId = '$_GET[blogId]'";
		$statement = $db->prepare($query);
		$statement->bindValue('$_POST[title]');
		$statement->bindValue('$_POST[content]', $newContentValidate);
		$statement->bindValue('$_GET[blogId]', $newIdValidate, PDO::PARAM_INT);
		$statement->bindValue('$_GET[section]', $newSectionValidate, PDO::PARAM_INT);
		$statement->execute();
		header('Location: index.php');
		exit;
	}

	if(isset($_POST['delete']))
	{
			$id = filter_input(INPUT_GET, 'blogId', FILTER_SANITIZE_NUMBER_INT);
			$query = "DELETE FROM blog WHERE blogId = '$_GET[blogId]'";
			$statement = $db->prepare($query);
			$statement->bindValue('$_GET[blogId]', $id, PDO::PARAM_INT);
			$statement->execute();
			header('Location: index.php');
			exit;
	}
	else
	{
			$queryId = "SELECT * FROM blog WHERE blogId = '$_GET[blogId]'";
	 		$statement = $db->prepare($queryId);
	 		$statement->execute();
	 		$rows = $statement->fetchAll();
	}
?>

<html lang="en">
	<head>
   <meta charset="UTF-8"/>
   <link href="index.css" rel="stylesheet" media="screen">
   <link href="css/bootstrap.min3rd.css" rel="stylesheet" media="screen">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	 <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>

	<script> tinymce.init({

	  selector: 'textarea',
		 font_formats: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n',
	  height: 300,
	  theme: 'modern',
	  plugins:
		[
	    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
	    'searchreplace wordcount visualblocks visualchars code fullscreen',
	    'insertdatetime media nonbreaking save table contextmenu directionality',
	    'emoticons template paste textcolor colorpicker textpattern imagetools'
	  ],
	  toolbar1: 'insertfile undo redo | styleselect | bold italic  |alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	  toolbar2: 'print preview media | forecolor backcolor emoticons sizeselect | bold italic | fontselect |  fontsizeselect',
	  image_advtab: true,
	  templates: [
	    { title: 'Test template 1', content: 'Test 1' },
	    { title: 'Test template 2', content: 'Test 2' }
	  ],
	  content_css:
		[
	    '//www.tinymce.com/css/codepen.min.css'
	  ]
	 });</script>
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
          	 <!-- Edit.php reference #1 -->
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
	    	<center>
			    <div class="row">
			      <form method="post">
		   		 	<?php foreach ($rows as $row): ?>
			 		 		<legend> New Blog Post </legend>
		     		 		<p>
		     		 			<label for="title"> Title</label>
		     		 			<input name="title" id="title" value=<?= $row['blogtitle'] ?>>
		     		 		</p>
		     		 		<p> <label for="content"> Content</label> </p>
								<h1>TinyMCE Quick Start Guide</h1>
								<textarea
								 	name="content" id="mytextarea"><?= $row['blogcontent'] ?>
								</textarea>
		     		 		<p>
		     		 			<label for="author"> Author</label>
		     		 			<input name="author" id="author" value=<?= $row['blogauthor'] ?>></p>
		   		 			<p>
			   		 			<?php if (!empty($rowsNav)): ?>
			   		 				<?php foreach ($rowsNav as $rowNav): ?>
			   		 					<input type="radio" name="section" value="<?= $rowNav['navName']?>"> <?= $rowNav['navName']?>
			   		 				<?php endforeach ?>
			   		 			<?php endif ?>
		     		 		</p>
		     		 		<p> <input type="submit" name="update" value="update">
		     		 		 		<input type="submit" name="delete" value="delete"></p>
						<?php endforeach ?>
				 		</form>
	     	</div>
	    </center>
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
 	</body>
 </html>
