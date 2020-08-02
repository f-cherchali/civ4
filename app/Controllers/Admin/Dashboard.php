<?php namespace App\Controllers\Admin;
use \App\Controllers\BaseController;
use \Config\MyConfig;
    class Dashboard extends BaseController{
        public function index(){
            $session = session();
            if(!isset($session->admin_id)){
                return redirect()->to(site_url("admin/login"));
            }
            $myConfig =new  MyConfig();
            $data_head=[];
            $data_head['admin_first_name']=$session->admin_first_name;
            $data_head['admin_photo']=$session->admin_photo;
            $data_head['admin_last_name']=$session->admin_last_name;
            $data_head['myConfig']=$myConfig;
            $data_head['title']="Tableau de bord";
            $data_head['principal_title']="Tableau de bord";
            $data_head['breadcrumb']=[
                [
                    "title"=>"Dashboard",
                    "link"=>false
                ]
            ];
            echo view("admin//layout/template_head.php",$data_head);

            $data_footer['myConfig']=$myConfig;
            echo view("admin//layout/template_footer.php",$data_footer);
        }
    }
?>