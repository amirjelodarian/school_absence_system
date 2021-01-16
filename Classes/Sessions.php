<?
namespace Classes;
    class Sessions{
        public function __construct(){
            global $Funcs;
            session_start();
            if(!isset($_SESSION['errorMessage'])){
                $_SESSION['errorMessage'] = "";
                $_SESSION['randomCode'] = "";
            }
        }
        public static function showErrorMessage(){
            global $Funcs;
            if ($Funcs->checkValue(array($_SESSION["errorMessage"]),false,true)){
                $_SESSION['errorMessage'] = explode('|',$_SESSION['errorMessage']);
                $_SESSION['errorMessage'] = implode("<br />",$_SESSION['errorMessage']);
                return $_SESSION["errorMessage"];
            }
        }
        public function unsetErrorMessage(){
            $_SESSION["errorMessage"] = "";
            unset($specSess);
        }
    }
    $Sessions = new Sessions();
    $SS =& $Sessions;
?>
