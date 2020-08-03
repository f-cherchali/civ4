<?php namespace App\Controllers\Admin;
use \App\Controllers\BaseController;
use \App\Models\AdminModel;
class Login extends BaseController{
    public function index(){
        $session = $this->session;
        if(isset($session->admin_id)){
            return redirect()->to(site_url("admin/dashboard"));
         }
        echo view("admin/login");
    }
    public function Connect(){
        $adminModel = new AdminModel;
        $session = $this->session;
        if($this->request->isAjax() || $this->request->getMethod == "POST"){
            $email = $this->request->getPost("email");
            $password = $this->request->getPost("password");
            $validation = \Config\Services::validation();
            $validation->setRule("email","Email","required|valid_email");
            $validation->setRule("password","Mot de passe","required|min_length[8]");

            if($validation->withRequest($this->request)->run() !== FALSE){
                if($adminModel->checkAccountExists($email,$password)){
                    if($adminModel->checkAccountActive($email)){
                        $adminData = $adminModel->getAdminData($email);
                        helper("cookie");
                        if($this->request->getPost("remember")=="1"){
                            if(get_cookie("remember_login") == NULL){
                                set_cookie("remember_login",$adminData->admin_id,(86000*90));
                            }else{
                                if(get_cookie("remember_login")!=$adminData->admin_id){
                                    delete_cookie("remember_login");
                                    set_cookie("remember_login",$adminData->admin_id,(86000*90));
                                }
                            }
                        }else{
                            delete_cookie("remember_login");
                        }
                        $userData=[
                            "admin_id"=>$adminData->admin_id,
                            "admin_first_name"=>$adminData->first_name,
                            "admin_last_name"=>$adminData->last_name,
                            "admin_email"=>$adminData->email,
                            "admin_photo"=>$adminData->photo,
                            "admin_access_privileges"=>$adminData->access_privileges
                        ];
                        $session->set($userData);
                        echo json_encode([
                            "status"=>true
                        ]);
                    }else{
                        echo json_encode([
                            "status"=>false,
                            "message"=>["error"=>"Votre compte a été desactivé"]
                        ]);
                    }
                }else{
                    echo json_encode([
                        "status"=>false,
                        "message"=>["error"=>"Email ou mot de passe incorrect"]
                    ]);
                }
                
            }else{
                echo json_encode([
                    "status"=>false,
                    "message"=>$validation->getErrors()
                ]);
            }
        }else{
            echo json_encode([
                "status"=>false,
                "message"=>["error"=>"Forbidden"]
            ]);
        }
    }
    function remember($key=null){
        if($key==null){
            echo view("admin/remember");
        }else{
            $adminModel = new AdminModel();
            if($adminModel->validKeyRecover($key)){
                if($this->request->getMethod()=="post"){
                    
                    $validation = \Config\Services::validation();
                    $validation->setRule("password","Nouveau mot de passe","required|min_length[8]");
                    $newpass = $this->request->getPost("password");
                    $hash_password = password_hash($newpass,PASSWORD_DEFAULT);
                    if($validation->withRequest($this->request)->run()!== FALSE){
                        $adminModel->setRecoverNewPassword($hash_password,$key);
                        return redirect()->to(site_url("admin/login/successrecover"));
                    }else{
                        $session = $this->session;
                        $session->setFlashdata('message', '<div class="alert alert-danger">'.$validation->getErrors()['password'].'</div>');
                        $data['key']=$key;
                        echo view("admin/doremember",$data);
                    }
                }else{
                    $data['key']=$key;
                    echo view("admin/doremember",$data);
                }
                
            }else{
                return $this->response->setStatusCode(404, 'Page introuvable ou le lien a expiré');
            }
        }
    }
    function doremember(){
        $adminModel = new AdminModel();
        if($this->request->isAjax() && $this->request->getMethod()=="post"){
            $email = $this->request->getPost("email");
            $validation = \Config\Services::validation();
            $validation->setRule("email","Email","required|valid_email");
            if($validation->withRequest($this->request)->run() !== FALSE){
                if($adminModel->checkAccountExistsToResetPassword($email) && $adminModel->checkAccountActive($email)){
                    $myconfig = $this->myConfig;
                    $email = \Config\Services::email();
                    helper("myfunctions");
                    $key = generate_token(32);
                    $email->initialize($myconfig->mail_config);
                    $email->setFrom('your@example.com', 'CI V4 Admin Panel');
                    $email->setTo($myconfig->server_email);
                    $email->setSubject('Vous avez demandé la récupération du mot de passe de votre compte administratif');
                    $email->setMessage("<strong>Bonjour,</strong><br><p>Vous avez demandé la réinitialisation du mot de passe. Veuillez accéder au lien suivant afin de redéfinir votre mot de passe : <strong>".site_url("admin/login/remember/".$key)."</strong><p/><br/><p>Bonne réception</p>");
                    $sendingEmail = $email->send();
                    if($sendingEmail){
                        $adminModel->setKeyRecover($email,$key);
                        echo json_encode([
                            "status"=>true
                        ]);
                    }else{
                        echo json_encode([
                            "status"=>false,
                            "message"=>[
                                'error'=>"Une érreur est survenue lors de l'envoi de l'email, veuillez réessayer ou contacter le webmaster"
                            ]
                        ]);
                    }
                }else{
                    echo json_encode([
                        "status"=>true
                    ]);
                }
            }else{
                echo json_encode([
                    "status"=>false,
                    "message"=>$validation->getErrors()
                ]);
            }
        }else{
            echo json_encode([
                "status"=>false,
                "message"=>['error'=>"Forbidden"]
            ]);
        }
    }
    function successrecover(){
        echo view("admin/successrecover");
    }
}
?>