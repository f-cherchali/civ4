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
        $crud->setTable("admin");
        $crud->unsetJquery();
        $crud->unsetBootstrap();
        $gcRender = $crud->render();
        // END RENDER GROCERY CRUD

        $header->setGcCssFiles((array)$gcRender->css_files);
        $header->render();

        
        echo view("admin/grocery",(array)$gcRender);
        
        // END BODY

        // START FOOTER TEMPLATE

        $footer = new AdminFooter();
        $footer->setGcJsFiles((array)$gcRender->js_files);
        $footer->render();

        // END FOOTER TEMPLATE
    }
}

?> 