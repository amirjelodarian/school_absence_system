<?
namespace Classes;
    class Sessions{
        public function __construct(){
            global $Funcs;
            session_start();
            if(!isset($_SESSION['errorMessage'])){
                $_SESSION['errorMessage'] = "";
            }
            if(!isset($_SESSION['alertMessage'])){
                $_SESSION['alertMessage'] = "";
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
        public static function showAlertMessage(){
            global $Funcs;
            if ($Funcs->checkValue(array($_SESSION["alertMessage"]),false,true)){
                $_SESSION['alertMessage'] = explode('|',$_SESSION['alertMessage']);
                $_SESSION['alertMessage'] = implode("\\n",$_SESSION['alertMessage']);
                return $_SESSION["alertMessage"];
            }
        }

        public function unsetErrorMessage(){
            $_SESSION["alertMessage"] = "";
            $_SESSION["errorMessage"] = "";
        }
    }
    $Sessions = new Sessions();
    $SS =& $Sessions;
?>
