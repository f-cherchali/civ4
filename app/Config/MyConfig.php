<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class MyConfig extends BaseConfig{
    public $server_email = 'fethi.cherchali@gmail.com';
    public $mail_config = [
        'protocol'    => 'smtp',
        'SMTPHost'    => 'ssl://smtp.gmail.com',
        'SMTPPort'    => '465',
        'SMTPTimeout' => '7',
        'SMTPUser'  =>'no-reply@erp.qadigitin.com',
        'SMTPPass'    => '',
        'charset'    => 'utf-8',
        'newline'    => "\r\n",
        'mailType' => 'html' // or html	
    ];
    public $charscrypt="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";
}