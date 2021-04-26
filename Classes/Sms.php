<?php
// another : amir jelodarian
// email : amirjelodarian@gmail.com
// github : http://github.com/amirjelodarian/
class SMS
{
    private static $username = '09120191685';
    private static $password = '3309876357';
//"tracking-code" => "1054 4-41", "name" => "پنل"
    public function pattern($pattern_code, array $input_data , array $receivers, $from = "+983000505")
    {
        $url = "https://ippanel.com/patterns/pattern?username=" . self::$username . "&password=" . urlencode(self::$password) . "&from={$from}&to=" . json_encode($receivers) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=".$pattern_code;
        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($handler, CURLOPT_POSTFIELDS, $input_data);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handler);
        $_SESSION['errorMessage'] .= $response ."|";
    }
}
$SMS = new SMS();
$sms =& $SMS;
$Sms =& $SMS;
