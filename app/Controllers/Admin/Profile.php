<?php namespace App\Controllers\Admin;

    use \App\Controllers\BaseController;
    use \App\Models\AdminModel;
    
    class Profile extends BaseController{
        public function index(){
            $session= $this->session;
            $adminModel = new AdminModel();
            if(!isset($session->admin_id)){
                redirect()->to(site_url("admin/login"));
            }
            $myConfig =$this->myConfig;
            $data_head=[];
            $data_head['admin_first_name']=$session->admin_first_name;
            $data_head['admin_photo']=$session->admin_photo;
            $data_head['admin_last_name']=$session->admin_last_name;
            $data_head['myConfig']=$myConfig;
            $data_head['title']="Mon profile";
            $data_head['principal_title']="Paramètres du compte";
            $data_head['breadcrumb']=[
                [
                    "title"=>"Dashboard",
                    "link"=>site_url("admin/dashboard")
                ],
                [
                    "title"=>"Profile",
                    "link"=>false
                ]
            ];
            $data_head['css_files']=[
                site_url('assets/css/cropper.min.css')
            ];
            echo view("admin//layout/template_head.php",$data_head);

            $data['adminData'] = $adminModel->getAdminDataById($session->admin_id);
            echo view("admin/profile",$data);

            $data_footer['js_files']=[
                site_url("assets/js/cropper.min.js"),
                site_url("assets/js/jquery-cropper.min.js")
                
            ];
            $data_footer['sessview']=$session;
            $data_footer['scripts_footer']=[
                view("admin/script_profile",['sessview'=>$session])
            ];
            $data_footer['myConfig']=$myConfig;
            echo view("admin//layout/template_footer.php",$data_footer);
        }
    }
?>