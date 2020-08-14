<?php namespace App\Controllers\Admin;
    use \App\Controllers\BaseController;
    use \App\Models\AdminModel;
    class Ajax extends BaseController{
        function updateprofilepicture(){
            $session = $this->session;
            if($this->request->isAjax() && $this->request->getMethod()=="post" && $this->request->getFile("croppedImage")!=null && isset($session->admin_id)){
                $adminid= $session->admin_id;
                $file= $this->request->getFile('croppedImage');
                if($file->isValid() && !$file->hasMoved()){
                    $newName = $file->getRandomName();
                    $writedFile= $file->move("./uploads/images",$newName);
                    if(!$writedFile){
                        echo json_encode([
                            "status"=>false,
                            "message"=>"Une érreur est survenue lors de la mise en ligne de la photo. Veuillez réessayer"
                        ]);
                    }else{
                        $adminModel = new AdminModel();
                        $oldPicture = $adminModel->getAdminPicture($adminid);
                        if($oldPicture!="" && $oldPicture==null){
                            echo json_encode([
                                "status"=>false,
                                "message"=>"Une érreur est survenue. Veuillez recharger la page"
                            ]);
                        }else{
                            $adminModel->setAdminPicture($adminid,$newName);
                            if($oldPicture!=""){
                                unlink("uploads/images/".$oldPicture);
                            }
                            $session->set("admin_photo",$newName);
                            echo json_encode([
                                "status"=>true,
                                "filename"=>$newName
                            ]);
                        }

                    }
                }else{
                    echo json_encode([
                        "status"=>false,
                        "message"=>"Votre fichier n'est pas valide, veuillez en choisir un autre"
                    ]);
                }
            }else{
                echo json_encode([
                    "status"=>false,
                    "message"=>"Non autorisé ! Veuillez contacter le webmaster"
                ]);
            }
        }
    }
?>