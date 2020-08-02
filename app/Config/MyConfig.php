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
    public $app_name = "Codeigniter V4 Admin Panel";
    public $app_version = "1.0";
    public $app_developer_name="DIGITALL IN";
    public $app_customer_name="DIGITALL IN";
    public $app_developper_link="https://digitall-agency.com";
}