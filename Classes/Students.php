<?php
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
      public function sendSmsToParentBYIds($ids = [],$group_name)
      {
        global $DB,$Funcs;
        $fatherContacts = [];
        $motherContacts = [];
        foreach ($ids as $id)
        {
          $studentResult = $DB->selectById('students',$id);
          if ($studentRow = $DB->fetchArray($studentResult))
          {
            $absence = $studentRow['absence'] = $studentRow['absence'] + 1;
            $DB->update('students','absence',$absence,"WHERE id={$id}");
            if (!empty($studentRow['father_tell']) || !empty($studentRow['mother_tell']))
            {
              if (!(filter_var($studentRow['father_tell'],FILTER_VALIDATE_INT)) && !is_numeric($studentRow['father_tell']) && !is_int($studentRow['father_tell']))
              {
                if (strlen($studentRow['father_tell']) > 8)
                {
                  array_push($fatherContacts,$studentRow['father_tell']);
                }
              }
              if (!(filter_var($studentRow['mother_tell'],FILTER_VALIDATE_INT)) && !is_numeric($studentRow['mother_tell']) && !is_int($studentRow['mother_tell']))
              {
                if (strlen($studentRow['mother_tell']) > 8)
                {
                  array_push($motherContacts,$studentRow['mother_tell']);
                }
              }
            }else{
              $_SESSION['errorMessage'] .= "شماره مادر یا پدر ";
              $_SESSION['errorMessage'] .= '(' . $studentRow['first_name'] . ' ' . $studentRow['last_name'] . ')';
              $_SESSION['errorMessage'] .= ' خالی است|';
            }
          }
          if (!empty($fatherContacts)) {
            foreach ($fatherContacts as $contact) {
              SMS::pattern('ie7i1nlhlm', [
                  'date' => $date,
              ], [$contact]);
            }
          }
          if (!empty($motherContacts)) {
            foreach ($motherContacts as $contact) {
              SMS::pattern('ie7i1nlhlm', [
                  'date' => $date,
              ], [$contact]);
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
