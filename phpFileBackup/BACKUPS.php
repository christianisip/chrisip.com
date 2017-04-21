<div class = "dropdown">
  <li> <a href="csv.php"> Section </a> </li>
   <div class="dropdown-content">
     <?php if (!empty($rowsNav)): ?>
       <?php foreach ($rowsNav as $rowNav): ?>
         <a href = "section.php?section=<?= $rowNav['navName']?>" class="sectionpage"> <?= $rowNav['navName']?> </a>
         <div class="navsectionstyle">
         </div>
       <?php endforeach ?>
     <?php endif ?>
   </div>
 </div>


 <div id ="search">
   <form  method="get" action="search.php">
     <input type="text" name="regName" />
     <input type="submit" value="search "></p>
     <select>

        <?php if (!empty($rowsNav)): ?>
          <?php foreach ($rowsNav as $rowNav): ?>
            <option value='<?= $rowNav['navName']?>'> <?= $rowNav['navName']?> </option>
          <?php endforeach ?>
        <?php endif ?>
      </select>
   </form>
 </div>
