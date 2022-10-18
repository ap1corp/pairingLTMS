<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class PHPMailerAutoload {
    public function PHPMailerAutoload() {
        require_once(APPPATH.'/third_party/PHPMailer/PHPMailerAutoload.php');
    }
}
