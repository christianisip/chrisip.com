


<!-- REFERENCE Section.php #1  -->
<!-- REFERENCE Search.php #2  -->
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


<!-- REFERENCE index.php #1  -->
<ul class="dropdown-menu">
  <?php if($_SESSION['remember'] == 'testq'): ?>
    <li><a href="admin.php"> Admin <span class="glyphicon glyphicon-cog pull-right"></span></a></li>
  <?php endif ?>
  <li><a href="#">User stats <span class="glyphicon glyphicon-stats pull-right"></span></a></li>
    <li><a href="#">Messages <span class="badge pull-right">  </span></a></li>
  <li><a href="?user=logout"> Sign Out <span class="glyphicon glyphicon-log-out pull-right"></span></a></li>
</ul>


<!-- REFERRENCE show.php #1 -->
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
