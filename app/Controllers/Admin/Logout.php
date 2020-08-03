<?php namespace App\Controllers\Admin;
use \App\Controllers\BaseController;
class Logout extends BaseController{
    public function index(){
        $session = $this->session;
        $session_items = ['admin_id', 'admin_first_name','admin_last_name','admin_email','admin_photo','admin_access_privileges'];
        $session->remove($session_items);
        helper("cookie");
        delete_cookie("remember_login");
        return redirect()->to(site_url("admin/login"));
    }
}