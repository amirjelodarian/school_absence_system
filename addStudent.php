<?php include "Includes/header.php"; ?>
<div class="add-student">
  <a href="index.php">
 <    بازگشت
  </a>
</div>
<?php
use \Validate\Validate;
  if (isset($_POST["student_submit"])) {
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['group_name'])) {
      Validate::validate([
                      $_POST['first_name'] => 'required|min:3|max:255',
                      $_POST['last_name'] => 'required|min:3|max:255',
                      $_POST['group_name'] => 'required|min:3|max:255',
                  ]);
                  if (Validate::showErrors()){
                      echo "<div class='e-message'>";
                          foreach (Validate::showErrors() as $error)
                              echo "<p>{$error}</p>";
                      echo "</div>";
                  }
                  if (Validate::$errors == ""){
                      $std->addStudent([$_POST['first_name'],$_POST['last_name'],$_POST['student_tell'],$_POST['father_name'],$_POST['mother_name'],$_POST['father_tell'],$_POST['mother_tell'],$_POST['home_tell'],$_POST['address'],$_POST['group_name'],0]);
                  }
    }else{
      echo "<div class='e-message'>";
              echo "<p>برخی از فیلد ها خالیست</p>";
      echo "</div>";
    }

  }
?>
<div class="row add-student-form">
  <div class="col-lg-3 col-md-3"></div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 add-student-form-inside">
    <p class="add-student-p">افزودن دانش آموز</p>
    <form action='<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>' method="post">
    <div class="form-row">
      <div class="form-group col-md-6">
        <span style="color:red">*</span><label for="first-name">نام</label>
        <input type="text" class="form-control" name="first_name" id="first-name" placeholder="نام" required />
      </div>
      <div class="form-group col-md-6">
        <span style="color:red">*</span><label for="last-name">نام خانوادگی</label>
        <input type="text" class="form-control" name="last_name" id="last-name" placeholder="نام خانوادگی" required />
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="student-tell">موبایل دانش آموز</label>
        <input type="text" class="form-control" name="student_tell" id="student-tell" placeholder="موبایل دانش آموز">
      </div>
      <div class="form-group col-md-6">
        <label for="home-tell">تلفن منزل</label>
        <input type="text" class="form-control" name="home_tell" id="home-tell" placeholder="تلفن منزل">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="father-name">نام پدر</label>
        <input type="text" class="form-control" name="father_name" id="father-name" placeholder="نام پدر">
      </div>
      <div class="form-group col-md-6">
        <label for="mother-name">نام مادر</label>
        <input type="text" class="form-control" name="mother_name" id="mother-name" placeholder="نام مادر">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="father-tell">موبایل پدر</label>
        <input type="text" class="form-control" name="father_tell" id="father-tell" placeholder="موبایل پدر">
      </div>
      <div class="form-group col-md-6">
        <label for="mother-tell">موبایل مادر</label>
        <input type="text" class="form-control" name="mother_tell" id="mother-tell" placeholder="موبایل مادر">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4"></div>
      <div class="form-group col-md-4">
        <label for="group-name">نام گروه</label>
        <select id="group-name" name="group_name" class="form-control">
          <?php
            $groupResult = $std->allGroup();
            while ($groupRow = $DB->fetchArray($groupResult)) echo "<option>{$groupRow['group_name']}</option>";
          ?>

        </select>
      </div>
      <div class="form-group col-md-4"></div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="address">آدرس</label>
        <textarea type="address" class="form-control" name="address" id="address" placeholder="آدرس"></textarea>
      </div>
    </div>
    <input type="submit" class="btn btn-primary" id="student-submit" name="student_submit" value="افزودن دانش آموز" />
    </form>
  </div>
  <div class="col-lg-3 col-md-3"></div>
</div><hr />
<script>
$(function () {
  $("#group-name").select2({
    placeholder: 'انتخاب گروه',
    tags: "true",
   allowClear: true
  });
  $('.flash-message').fadeOut(3000);
});
</script>
<?php include "Includes/footer.php"; ?>
