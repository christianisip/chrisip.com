


<!-- Edit.php reference #1 -->
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
