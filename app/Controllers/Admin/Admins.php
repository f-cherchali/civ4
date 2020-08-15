<?php 
namespace App\Controllers\Admin;
use \App\Controllers\GcController;
use \App\Models\AdminModel;
use \App\Controllers\Loaders\AdminHeader;
use \App\Controllers\Loaders\AdminFooter; 

class Admins extends GcController{
    public function index(){
        $adminModel = new AdminModel();
        if(!isset($this->session->admin_id)){
            redirect()->to(site_url("admin/login"));
        }

        // START HEAD TEMPLATE
        $header = new AdminHeader();
        $header->setTitle("Gestion des administrateurs");
        $header->setPrincipalTitle("Comptes administrateurs");
        $header->setBreadCrumb("Tableau de bord","admin/dashboard");
        $header->setBreadCrumb("Gestion des administrateurs",false);
        // START BODY

        //Starting Grocery Crud
        $crud = $this->_getGroceryCrudEnterprise();

        $crud->setTable('admin');
        $crud->fields(["photo","email","first_name","last_name","active"]);
        $crud->columns(["photo","email","first_name","last_name","active"]);
        $crud->setFieldUpload("photo","public/uploads/images",site_url("public/uploads/images"));
        $crud->callbackBeforeUpdate(function ($stateParameters) {

            $newImage = $stateParameters->data['photo'];
            $db = \Config\Database::connect();
            $builder = $db->table("admin");
            $query = $builder->where("admin_id",$stateParameters->primaryKeyValue)->get();
            $result = $query->getResult()[0];
            if($result->photo!=$newImage && strlen(trim($result->photo))!=0){
                unlink("public/uploads/images/".$result->photo);
            }
            return $stateParameters;
        });
        $crud->callbackUpload(function($uploadData){

            if($uploadData==null){
                return false;
            }
    
            $uploadPath = 'public/uploads/images'; // directory of the drive
    
            $publicPath = site_url("public/uploads/images"); // public directory (at the URL)
        
            $fieldName = $uploadData->field_name;
    
            $storage = new \Upload\Storage\FileSystem($uploadPath);
            $file = new \Upload\File($fieldName, $storage);
            
            $filename=null;
            if(isset($_FILES[$fieldName])){
                $extension = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
            }
            $filename= uniqid(rand(), true).".". $extension;
            
            if ($filename === null) {
                return false;
            }
        
            // The library that we are using want us to remove the file extension as it is adding it by itself!
            $filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
            // Replace illegal characters with an underscore
            $filename = preg_replace("/([^a-zA-Z0-9\-\_]+?){1}/i", '_', $filename);
        
            $file->setName($filename);
        
            // Validate file upload
            $file->addValidations([
                new \Upload\Validation\Extension(['jpeg', 'jpg', 'png']),
                new \Upload\Validation\Size('20M')
            ]);
        
            // Work around so the try catch will work as expected.
            // Upload file will not yield any error if the error_reporting is 0
            $display_errors = ini_get('display_errors');
            $error_reporting = error_reporting();
            ini_set('display_errors', 'on');
            error_reporting(E_ALL);
        
            // Upload file
            try {
                // Success!
                $file->upload();
        
            } catch (\Upload\Exception\UploadException $e) {
                // Upload error, return a custom message
                $errors = print_r($file->getErrors(), true);
                return (new \GroceryCrud\Core\Error\ErrorMessage())->setMessage("Une érreur est survenue lors du chargement du fichier:\n" . $errors);
            } catch (\Exception $e) {
                throw $e;
            }
        
            ini_set('display_errors', $display_errors);
            error_reporting($error_reporting);
        
            $filename = $file->getNameWithExtension();
        
            // Make sure that you return the results
            $uploadData->filePath = $publicPath . '/' . $filename;
            $uploadData->filename = $filename;
        
            return $uploadData;
        });
        $crud->callbackColumn("photo",[$this,"_callback_photo"]);
        $crud->unsetJquery();
        $crud->unsetBootstrap();
        $crud->displayAs("first_name","Prénom");
        $crud->displayAs("last_name","Nom");
        $crud->displayAs("active","Etat du compte");
        $crud->fieldType("active","checkbox_boolean",[0=>"Desactivé",1=>"Activé"]);
        $output = $crud->render();

        $groceryRender=$this->_example_output($output);
        
        // END RENDER GROCERY CRUD

        $header->setGcCssFiles((array)$output->css_files);
        $header->render();
        
        echo $groceryRender;
        
        // END BODY

        // START FOOTER TEMPLATE

        $footer = new AdminFooter();
        $footer->setGcJsFiles((array)$output->js_files);
        $footer->render();

        // END FOOTER TEMPLATE
    }
    function _callback_photo($value, $row){
        if(strlen(trim($value))==0){
            return '<img target="_blank" src="'.site_url("public/assets/img/defaultuser.png").'" alt="" width="150" height="150">';
        }
        return '<img target="_blank" src="'.site_url("public/uploads/images/".$value).'" alt="" width="150" height="150">';
    }
}

?> 