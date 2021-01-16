<?

namespace Functions;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Clothes\Clothes;
use Sessions\Sessions;
use Rakit\Validation\Validator;
    class Functions {
        public static $fileName;
        public function __construct(){
            self::$fileName = "";
        }
        public function uploadPic($file = "",$targetDir = "",$maxFileSize){
            global $DB,$Sessions;
                $targetDir = $targetDir;
                settype($maxFileSize, "integer");
                $files = $_FILES[$file];
                $targetFile = $targetDir . basename($files["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = getimagesize($files["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    $_SESSION['errorMessage'] .= "فایل عکس نیس : {$check["mime"]} |";
                    $uploadOk = 0;
                }

                // Check if file already exists
                if (file_exists($targetFile)) {
                    $_SESSION['errorMessage'] .= "متاسفانه این عکس وجود دارد |";
                    $uploadOk = 0;
                }

                // Check file size
                if ($files["size"] > $maxFileSize) {
                    $_SESSION['errorMessage'] .= "حچم عکس کمتر از ۲ مگابایت باشد |";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $_SESSION['errorMessage'] .= "پسوند عکس نامعتبر است |";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $_SESSION['errorMessage'] .= "خطا هنگام آپلود فایل ! |";
                    // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($files["tmp_name"], $targetFile)) {
                        self::$fileName = $DB->escapeValue(basename($files["name"]));
                        return true;
                    } else {
                        $_SESSION['errorMessage'] .= "خطا هنگام آپلود فایل ! |";
                    }
                }
                    return $Sessions::showErrorMessage();

        }

        public function redirectTo($to,$jsRedirect = false){
            if ($jsRedirect == true){
                ?><script>window.location = '<?= $to ?>';</script><?php
            }else{
                header('Location: '.$to);
            }
        }

        public function checkValue($values = array(),$isset = false,$empty = false){
            $boolArr = array();
            if (is_array($values)){
                foreach ($values as $value) {
                    if($isset == true) {
                        if (isset($value))
                            array_push($boolArr,true);
                        else
                            array_push($boolArr,false);
                    }

                    if ($empty == true) {
                        if (!empty($value) && $value !== "")
                            array_push($boolArr,true);
                        else
                            array_push($boolArr,false);
                    }
                }
            }else{
                if($isset == true) {
                    if (isset($values))
                        array_push($boolArr,true);
                    else
                        array_push($boolArr,false);
                }

                if ($empty == true) {
                    if (!empty($values) && $values !== "")
                        array_push($boolArr,true);
                    else
                        array_push($boolArr,false);
                }
            }
                $failArr = array(false);
                if(array_intersect($boolArr,$failArr))
                    return false;
                else
                    return true;
        }

        public function calcOff($beforeOff = 0,$afterOff = 0){
            if (is_numeric($beforeOff) && is_numeric($afterOff)){
                settype($beforeOff,"integer");
                settype($afterOff,"integer");
                $calc = ($afterOff*100)/$beforeOff;
                return round(100-$calc);
            }else
                return "DB0";
        }

        public function EnFa($value,$toFa = false,$toEn = false){
            $en = array("0","1","2","3","4","5","6","7","8","9");
            $fa = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");
            if ($toFa == true)
                return str_replace($en, $fa, $value);
            if ($toEn == true)
                return str_replace($fa, $en, $value);
        }
        public function showPic($picPath = "",$picName = "",$defaultPic = ""){
            if ($this->checkValue($picName,true,true)){
                $picName = stripslashes($picName);
                if (preg_match('/"/',$picName))
                    return "'" . $picPath.$picName . "'";
                elseif (preg_match("/'/",$picName))
                    return '"' . $picPath.$picName . '"';
                else
                    return '"' . $picPath.$picName . '"';
            }else
                return $defaultPic;
        }

        public function urlValue($value,$encode = ''){
            if ($encode == true)
                $value = str_replace(' ','%20',$value);
            if ($encode == false)
                $value = str_replace('%20',' ',$value);
            return $value;
        }

        public function clothesPagination($tableName,$type,$model,$tableId,$page = 1,$recordsPerPage = 10){
            global $Zebra,$DB;
            if ($type == '*')
                $result = $DB->selectAll('*',$tableName);
            if ($model == '*')
                $result = $DB->selectAll('*',$tableName," WHERE type='{$type}'");
            if ($model !== '*' && $type !== '*')
                $result = $DB->selectAll('*',$tableName,"WHERE type='{$type}' AND model='{$model}'");
            if ($model == '*' && $type == '*')
                $result = $DB->selectAll('*',$tableName);

            $totalRecord = $DB->numRows($result);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }
        public function pagination($tableName,$tableId,$page = 1,$recordsPerPage = 10){
            global $Zebra,$DB;
            $result = $DB->selectAll($tableId,$tableName);
            $totalRecord = $DB->numRows($result);
            $Zebra->records($totalRecord);
            $Zebra->navigation_position('center');
            $Zebra->labels('قبلی', 'بعدی',$page);
            $Zebra->records_per_page($recordsPerPage);
            $Zebra->render();
        }
        public static function nowDataTime(){
            return strftime('%Y-%m-%d %H:%M:%S');
        }

        public function sendMail($sendToAddress,$code){
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;
                $mail->Mailer = "smtp";
                $mail->isSMTP();
                $mail->Host = 'ssl://smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;
//                $mail->SMTPOptions = array(
//                    'ssl' => array(
//                        'verify_peer' => false,
//                        'verify_peer_name' => false,
//                        'allow_self_signed' => true
//                    )
//                );
                $mail->Username   = EMAIL_USERNAME;
                $mail->Password   = EMAIL_PASSWORD;
                $mail->setFrom(EMAIL_USERNAME, EMAIL_FROM);
                $mail->addAddress($sendToAddress);
                $mail->CharSet = 'utf-8';
                $mail->ContentType = 'text/html;charset=utf-8';
                $mail->isHTML(true);

                $mail->Subject = EMAIL_SUBJECT;
                $mail->Body = $code;
                $send = $mail->send();
                if ($send){
                    echo "<br />";
                    echo 'کد با موفقیت به ایمیل ارسال شد';
                }
            }catch(Exception $e){
                echo 'مشکلی در ارسال کد به ایمیل پیش آمده';
            }
            $mail->SmtpClose();
        }

        public function rnd($values){
            global $DB;
            foreach ($values as $key => $value){
                if ($key == 'from' || $key == 'FROM' || $key == 'From' || $key == 'to' || $key == 'TO' || $key == 'To'){
                    if($key == 'from' || $key == 'FROM' || $key == 'From'){
                        $from = $DB->escapeValue($value,true);
                    }
                    if($key == 'to' || $key == 'TO' || $key == 'To'){
                        $to = $DB->escapeValue($value,true);
                        $rnd = rand($from,$to);
                        $_SESSION['randomCode'] = $rnd;
                        return $rnd;
                    }
                }
            }
            if ($key == 'mix' || $key == 'MIX' || $key == 'Mix' || $key == 'mixed' || $key == 'Mixed' || $key == 'MIXED'){
                $length = $value;
                $randomAlpha = md5(random_bytes(64));
                $captchaCode = substr($randomAlpha, 0, $length);
                $_SESSION['randomCode'] = $captchaCode;
                return $captchaCode;
            }

            // Example
            // echo $Funcs->rnd(['mix' => 5]);
            // echo $Funcs->rnd(['from' => 1000,'to' => 9999]);
        }
        public function showCaptcha(){
            $currentDir = getcwd();
            if (preg_match('/\/panel/',$currentDir))
                return '../Classes/captcha.php';
            else
                return 'Classes/captcha.php';
        }

        public function hideEmail($email){
            // extract email text before @ symbol
            $em = explode("@", $email);
            $name = implode(array_slice($em, 0, count($em) - 1), '@');

            // count half characters length to hide
            $length = floor(strlen($name) / 2);

            // Replace half characters with * symbol
            return substr($name, 0, $length-1) . str_repeat('*', $length-1) . substr($name, -1, 1) . "@" . end($em);

        }
        public function nowJalalianDate(){
          return jdate('Y/m/d');
        }
        public function nowTime(){
          return strftime('%H:%M:%S',time());
        }

    }
    $Funcs = new Functions();
    $Functions =& $Funcs;
?>
