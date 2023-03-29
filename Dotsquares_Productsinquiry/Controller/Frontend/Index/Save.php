<?php
namespace Dotsquares\Productsinquiry\Controller\Index;

class Save extends \Magento\Framework\App\Action\Action{
/**
* @var Google reCaptcha Options
*/
private static $_siteVerifyUrl = "https://www.google.com/recaptcha/api/siteverify?";
private $_secret;
private static $_version = "php_1.0";
protected $_helper;
/**
* Save Form Data
*
* @return array
*/
public function __construct(

){

}
public function execute()
{$captcha = $this->getRequest()->getParam('g-recaptcha-response');
$secret = "<--your secret key-->"; //Replace with your secret key
$response = null;$path = self::$_siteVerifyUrl;$dataC = array (
'secret' => $secret,
'remoteip' => $_SERVER["REMOTE_ADDR"],
'v' => self::$_version,
'response' => $captcha);$req = "";
foreach ($dataC as $key => $value) {     $req .= $key . '=' . urlencode(stripslashes($value)) . '&';
}
// Cut the last '&'$req = substr($req, 0, strlen($req)-1);$response = file_get_contents($path . $req);$answers = json_decode($response, true);
if(trim($answers ['success']) == true) {
    // Captcha Validated
    // Save Form Data
}else{
    
}
}
}