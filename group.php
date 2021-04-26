<?php include "Includes/header.php"; ?>
<?php
 if (isset($_GET['group_name']) && !empty($_GET['group_name'])){
   $group_name = $DB->escapeValue($_GET['group_name']);

   if (isset($_POST['submit_send_absence_sms']) && isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['group_name']))
       $std->sendAbsenceSmsToParentBYIds($_POST['id'],$group_name);

   if (isset($_POST['submit_delete_student']) && isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['group_name']))
       $std->deleteStudentsByIds($_POST['id'],$group_name);

     if (isset($_POST['submit_send_book_sms']) && isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['group_name']))
         $std->sendBookSmsToParentBYIds($_POST['id'],$group_name);
   echo "<p class='group-name-title'><span style='color:red;font-size:20px'>({$DB->count('students','id',"WHERE group_name='{$group_name}'")})</span>{$group_name}</p>"; ?>
   <span style="font-family: IRANSansW">انتخاب همه</span>&nbsp;<input type="checkbox" id="select-all-inputs" />
   <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])."?group_name=" . urlencode($group_name) ?>" method="post">
   <table class="table table-hover table-bordered" id="student-table">
    <thead>
      <tr>
        <th scope="col">شماره منزل</th>
        <th scope="col">شماره مادر</th>
        <th scope="col">شماره پدر</th>
        <th scope="col">نام مادر</th>
        <th scope="col">نام پدر</th>
        <th scope="col">شماره دانش آموز</th>
        <th scope="col">نام خانوادگی</th>
        <th scope="col">نام</th>
        <th scope="col">غیبت</th>
        <th scope="col">#</th>
      </tr>
    </thead>
   <?php
   $studentsResult = $std->selectStudentsByGroupName($group_name,'index.php'); ?>
        </tbody>
        <input type="hidden" name="group_name" value="<?= $group_name ?>" />
        <input type="submit" name="submit_send_absence_sms" value="ارسال پیامک غیبت" class="btn btn-success AreYouSure" id="submit-send-sms" />
        <input type="submit" name="submit_delete_student" value="حدف" class="btn btn-danger AreYouSure" id="submit-delete-student" />
        <input type="submit" name="submit_send_book_sms" value="ارسال پیامک کتاب" style="margin-right: 10px" class="btn btn-primary AreYouSure" id="submit-send-sms" />
  </table>
</form>
 <?php }
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    </div>
</div>

<div class="add-student">
  <a href="index.php">
 <    بازگشت
  </a>
</div>
<script>
$(document).ready(function() {
  var data = [
    <?php while ($studentsRow = $DB->fetchArray($studentsResult)) { ?>
        <?="["?>
          <?="'".$studentsRow['home_tell']."',"?>
          <?="'".$studentsRow['mother_tell']."',"?>
          <?="'".$studentsRow['father_tell']."',"?>
          <?="'".$studentsRow['mother_name']."',"?>
          <?="'".$studentsRow['father_name']."',"?>
          <?="'".$studentsRow['student_tell']."',"?>
          <?="'".$studentsRow['last_name']."',"?>
          <?="'".$studentsRow['first_name']."',"?>
          <?="'".$studentsRow['absence']."',"?>
          <?="'".$studentsRow['id']."',"?>
        <?="],"?>
      <?php } ?>
  ]
  var Otable = $('#student-table').DataTable( {
      data: data,
     "lengthMenu": [[-1, 5, 10, 15, 20, 25, 50, 75, 100, 125, 150], ["All", 5, 10, 15, 20, 25, 50, 75, 100, 125, 150]],
      select: {
        style: 'multi'
      },
      columnDefs: [
            {
                targets:-1, // Start with the last
                render: function ( data, type, row, meta ) {
                    if(type === 'display'){
                        data = '<a class="edit-user" href="editStudent.php?id=' + encodeURIComponent(data) + '">ویرایش</a><input type="checkbox" id="student-checkbox" name="id[]" value="' + encodeURIComponent(data) +'" />';
                    }
                    return data;
                }
            }
        ]
  });
  $('#student-table tr').click(function(){
    var checkbox = $(this).find('input[type=checkbox]');
    checkbox.prop("checked", !checkbox.prop("checked"));
  });
  $('#select-all-inputs').click(function(){
    var checkbox = $("#student-table_wrapper").find('input[type=checkbox]');
    checkbox.prop("checked", !checkbox.prop("checked"));
  });
});
</script>
<?php include "Includes/footer.php"; ?>
