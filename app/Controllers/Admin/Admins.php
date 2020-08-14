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
    
}

?> 