<?php namespace App\Controllers\Admin;

    use \App\Controllers\BaseController;
    use \App\Models\AdminModel;
    use \App\Controllers\Loaders\AdminHeader;
    use \App\Controllers\Loaders\AdminFooter;  

    class Profile extends BaseController{
        public function index(){
            $session= $this->session;
            $adminModel = new AdminModel();
            if(!isset($session->admin_id)){
                redirect()->to(site_url("admin/login"));
            }
            if($this->request->getPost("last_name") && $this->request->getPost("first_name") ){
                $validation = \Config\Services::validation();
                $validation->setRule("first_name","Prénom","required|min_length[3]");
                $validation->setRule("last_name","Nom","required|min_length[3]");
                if($validation->withRequest($this->request)->run()!==FALSE){
                    $first_name=$this->request->getPost("first_name");
                    $last_name=$this->request->getPost("last_name");
                    $adminModel->updateProfileData($first_name,$last_name,$session->admin_id);
                    $session->set([
                        "admin_first_name"=>$first_name,
                        "admin_last_name"=>$last_name    
                    ]);
                    $session->setFlashdata("success_message","Profile modifié avec succès");
                }else{
                    if($validation->hasError("first_name")){
                        $session->setFlashdata("first_name",$validation->getError("first_name"));
                    }
                    if($validation->hasError("last_name")){
                        $session->setFlashdata("last_name",$validation->getError("last_name"));
                    }
                }
            }
            if($this->request->getPost("password") || $this->request->getPost("newpassword")){
                $validation = \Config\Services::validation();
                $validation->setRule("password","Mot de passe actuel","required|min_length[8]");
                $validation->setRule("newpassword","Nouveau mot de passe","required|min_length[8]");
                if($validation->withRequest($this->request)->run()!==FALSE){
                    $password=$this->request->getPost("password");
                    $newPassword=$this->request->getPost("newpassword");
                    if($adminModel->isValidPassword($password,$session->admin_id)){
                        $adminModel->setNewPassword($newPassword,$session->admin_id);
                        $session->setFlashdata("success_message","Mot de passe modifié avec succès");
                    }else{
                        $session->setFlashdata("password","Le mot de passe actuel que vous avez saisi est incorrect");
                    }
                }else{
                    if($validation->hasError("password")){
                        $session->setFlashdata("password",$validation->getError("password"));
                    }
                    if($validation->hasError("newpassword")){
                        $session->setFlashdata("newpassword",$validation->getError("newpassword"));
                    }
                }
            }


            // START HEAD TEMPLATE
            $header = new AdminHeader();
            $header->setTitle("Mon profile");
            $header->setPrincipalTitle("Paramètres du compte");
            $header->setBreadCrumb("Dashboard","admin/dashboard");
            $header->setBreadCrumb("Profile",false);
            $header->setCssFile('public/assets/css/cropper.min.css');
            $header->render();
            // END HEAD TEMPLATE

            // START BODY
            

            $data['adminData'] = $adminModel->getAdminDataById($session->admin_id);
            echo view("admin/profile",$data);
            // END BODY

            // START FOOTER TEMPLATE
            
            $footer = new AdminFooter();
            $footer->setJsFile("public/assets/js/cropper.min.js");
            $footer->setJsFile("public/assets/js/jquery-cropper.min.js");
            $footer->setScript(view("admin/script_profile",['sessview'=>$session]));
            $footer->render();
            // END FOOTER TEMPLATE
        }
    }
?>