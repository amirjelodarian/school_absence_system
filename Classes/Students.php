<?php
// another : amir jelodarian
// email : amirjelodarian@gmail.com
// github : http://github.com/amirjelodarian/
namespace Classes;
  Class Students{
      public $first_name;
      public $last_name;
      public $student_tell;
      public $father_name;
      public $mother_name;
      public $father_tell;
      public $mother_tell;
      public $home_tell;
      public $address;
      public $group_name;
      public $absence;

      public function addStudent($values=[]){
        global $DB,$Funcs;
          $DB->insert("students", $DB->dbColsByClass($this), $values);
          $_SESSION['errorMessage'] = "با موفقیت اضافه شد";
          $Funcs->redirectTo('addStudent.php');
      }
      public function editStudent($id,$values=[]){
        global $DB,$Funcs;
          $cols = $DB->dbColsByClass($this);
          $cols = explode(',',$cols);
          array_pop($cols);
          $cols = implode(',',$cols);
          $DB->update("students",$cols , $values," WHERE id={$id}");
          $_SESSION['errorMessage'] = "با موفقیت ویرایش شد";
          $Funcs->redirectTo("editStudent.php?id={$id}");
      }
      public function allGroup(){
        global $DB;
        $result = $DB->selectAll('DISTINCT(group_name)','students');
        return $result;
      }
      public function selectStudentsByGroupName($group_name,$redirectIfFalse = ""){
        global $DB,$Funcs;
        $studentsResult = $DB->selectAll('*','students',"WHERE group_name='{$group_name}'");
        if ($DB->numRows($studentsResult) !== 0)
          return $studentsResult;
        else
          $Funcs->redirectTo($redirectIfFalse);
      }
      public function fillStudentAttr($id){
        global $DB;
        $studentResult = $DB->selectById('students',$id);
          if ($studentRow = $DB->fetchArray($studentResult)){
              $arrKey = $DB->classAttribute($this);
              foreach ($arrKey as $key)
                  $this->{$key} = $studentRow[$key];
              $DB->freeResult($studentResult);
          }
      }
      public function sendAbsenceSmsToParentBYIds($ids = [],$group_name)
      {
        global $DB,$Funcs,$SMS;
        foreach ($ids as $id)
        {
          $studentResult = $DB->selectById('students',$id);
          if ($studentRow = $DB->fetchArray($studentResult))
          {
            $absence = $studentRow['absence'] = $studentRow['absence'] + 1;
            $DB->update('students','absence',$absence,"WHERE id={$id}");
            if (!empty($studentRow['father_tell']) || !empty($studentRow['mother_tell']))
            {
              // if (!(filter_var($studentRow['father_tell'],FILTER_VALIDATE_INT)) && !is_numeric($studentRow['father_tell']) && !is_int($studentRow['father_tell']))
              // {
              if (strlen($studentRow['mother_tell']) || strlen($studentRow['father_tell'])) {
                $_SESSION['errorMessage'] .= "به ";
              }
              if (strlen($studentRow['father_tell']) > 8)
              {
                $SMS->pattern('42owqhtta0', [
                    'date' => $Funcs->nowJalalianDate(),
                    'name' => $studentRow['first_name'] . " " . $studentRow['last_name'],
                ], [$studentRow['father_tell']]);
                $_SESSION['errorMessage'] .= "(پدر)";
              }
              // }
              // if (!(filter_var($studentRow['mother_tell'],FILTER_VALIDATE_INT)) && !is_numeric($studentRow['mother_tell']) && !is_int($studentRow['mother_tell']))
              // {
              if (strlen($studentRow['mother_tell']) > 8)
              {
                $SMS->pattern('42owqhtta0', [
                    'date' => $Funcs->nowJalalianDate(),
                    'name' => $studentRow['first_name'] . " " . $studentRow['last_name'],
                ], [$studentRow['mother_tell']]);
                $_SESSION['errorMessage'] .= "(مادر)";
              }
              if (strlen($studentRow['mother_tell']) || strlen($studentRow['father_tell'])) {
                $_SESSION['errorMessage'] .= '(' . $studentRow['first_name'] . " " . $studentRow['last_name'] . ') ';
                $_SESSION['errorMessage'] .= "ارسال شد|";
              }
              // }
            }else{
              $_SESSION['errorMessage'] .= "شماره مادر یا پدر ";
              $_SESSION['errorMessage'] .= '(' . $studentRow['first_name'] . ' ' . $studentRow['last_name'] . ')';
              $_SESSION['errorMessage'] .= ' خالی است|';
            }
          }
        }
        $Funcs->redirectTo('group.php?group_name='.$group_name);
      }

      public function sendBookSmsToParentBYIds($ids = [],$group_name)
      {
          global $DB,$Funcs,$SMS;
          foreach ($ids as $id)
          {
              $studentResult = $DB->selectById('students',$id);
              if ($studentRow = $DB->fetchArray($studentResult))
              {
                  if (!empty($studentRow['father_tell']) || !empty($studentRow['mother_tell']))
                  {
                      // if (!(filter_var($studentRow['father_tell'],FILTER_VALIDATE_INT)) && !is_numeric($studentRow['father_tell']) && !is_int($studentRow['father_tell']))
                      // {
                      if (strlen($studentRow['mother_tell']) || strlen($studentRow['father_tell'])) {
                          $_SESSION['errorMessage'] .= "به ";
                      }
                      if (strlen($studentRow['father_tell']) > 8)
                      {
                          $SMS->pattern('8viz40thmx', [
                              'name' => $studentRow['first_name'] . " " . $studentRow['last_name'],
                          ], [$studentRow['father_tell']]);
                          $_SESSION['errorMessage'] .= "(پدر)";
                      }
                      // }
                      // if (!(filter_var($studentRow['mother_tell'],FILTER_VALIDATE_INT)) && !is_numeric($studentRow['mother_tell']) && !is_int($studentRow['mother_tell']))
                      // {
                      if (strlen($studentRow['mother_tell']) > 8)
                      {
                          $SMS->pattern('8viz40thmx', [
                              'name' => $studentRow['first_name'] . " " . $studentRow['last_name'],
                          ], [$studentRow['mother_tell']]);
                          $_SESSION['errorMessage'] .= "(مادر)";
                      }
                      if (strlen($studentRow['mother_tell']) || strlen($studentRow['father_tell'])) {
                          $_SESSION['errorMessage'] .= '(' . $studentRow['first_name'] . " " . $studentRow['last_name'] . ') ';
                          $_SESSION['errorMessage'] .= "پیام کتاب ارسال شد|";
                      }
                      // }
                  }else{
                      $_SESSION['errorMessage'] .= "شماره مادر یا پدر ";
                      $_SESSION['errorMessage'] .= '(' . $studentRow['first_name'] . ' ' . $studentRow['last_name'] . ')';
                      $_SESSION['errorMessage'] .= ' خالی است|';
                  }
              }
          }
          $Funcs->redirectTo('group.php?group_name='.$group_name);
      }

      public function deleteStudentsByIds($ids = [],$group_name)
      {
        global $DB,$Funcs;
        foreach ($ids as $id) $DB->delete('students','id',$id);
        $Funcs->redirectTo('group.php?group_name='.$group_name);
      }
  }
  $Students = new Students();
  $stdtns =& $Students;
  $std =& $Students;
?>
