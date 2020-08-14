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
        $header->render();
        // END HEAD TEMPLATE


        // START BODY

        // $crud= $this->_getGroceryCrudEnterprise();

        // END BODY

        // START FOOTER TEMPLATE

        $footer = new AdminFooter();
        $footer->render();

        // END FOOTER TEMPLATE
    }
}

?> 