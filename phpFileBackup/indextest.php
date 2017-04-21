<?php
  session_start();

  $_SESSION['sectionpass'] = 'test';
  require('connect.php');
  $test ='';
  $output = '';
  $queryBody = "SELECT * FROM blog ORDER BY blogId DESC LIMIT 5";
  $statementBody = $db->prepare($queryBody);
  $statementBody->execute();
  $rowsBody = $statementBody->fetchAll();
  foreach($rowsBody as $rowBody);

  $queryNav = "SELECT navName FROM navigation";
  $statementNav = $db->prepare($queryNav);
  $statementNav->execute();
  $rowsNav = $statementNav->fetchAll();
  foreach($rowsNav as $rowNav);

  $queryPictures = "SELECT * FROM blog WHERE imagepath IS NOT NULL AND TRIM(imagepath) <> '' ORDER BY RAND() LIMIT 2";
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
 <html lang="en">
 	<head>
     <meta charset="UTF-8"/>
     <link rel="stylesheet" type="text/css" href="indexcss.css"/>
     <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     <title> Chrisip - Home </title>
   </head>
 <body>
    <div id="container-test">
   <div class="container-fluid" width="300">
    <!-- Second navbar for search -->
    <nav class="navbar container-fluid" width="300">
      <div class="container" width="300">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header" width="300">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-3">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img src="chrisiplogo.png" alt="chrisiplogo" align="middle" style="width:300px; height:80px;">
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse-3" width="300">
          <ul class="nav navbar-nav navbar-right" width="300">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Works</a></li>
            <li>
              <a   data-toggle="collapse" href="#nav-collapse3" aria-expanded="false" aria-controls="nav-collapse3">Search</a>
            </li>
          </ul>
          <div class="collapse nav navbar-nav nav-collapse slide-down" id="nav-collapse3">
            <form class="navbar-form navbar-right" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search" />
              </div>
              <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </form>
          </div>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

</div><!-- /.container-fluid -->
</div>
 </body>
 </html>
