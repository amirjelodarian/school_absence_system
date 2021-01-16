<?php include "Includes/header.php"; ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h1 class="school-title">Ahrar</h1>

      <div class="row">
      <?php
        $groupResult = $std->allGroup();
        while ($groupRow = $DB->fetchArray($groupResult)){ ?>
          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a href="group.php?group_name=<?= urlencode($groupRow["group_name"]) ?>" class="group-link">
              <div class="group-name-index">
                <p><?= $groupRow['group_name'] ?></p>
                <span class="group-count"><?= $DB->count('students','id',"WHERE group_name='{$groupRow["group_name"]}'") ?></span>
              </div>
            </a>
          </div>
        <?php }
      ?>
      </div>
    </div>
</div>

<div class="add-student">
  <a href="addStudent.php">
    افزودن دانش آموز +
  </a>
</div>

<?php include "Includes/footer.php"; ?>
