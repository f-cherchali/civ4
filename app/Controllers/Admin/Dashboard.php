<?php namespace App\Controllers\Admin;
use \App\Controllers\BaseController;
use \App\Controllers\Loaders\AdminHeader;
use \App\Controllers\Loaders\AdminFooter;  
    class Dashboard extends BaseController{
        public function index(){
            $session = $this->session;
            if(!isset($session->admin_id)){
                return redirect()->to(site_url("admin/login"));
            }
            // START HEAD TEMPLATE
            $header = new AdminHeader();
            $header->setTitle("Tableau de bord");
            $header->setPrincipalTitle("Tableau de bord");
            $header->setBreadCrumb("Dashboard","false");
            $header->render();
            // END HEAD TEMPLATE



            // START FOOTER TEMPLATE
            $footer = new AdminFooter();
            $footer->render();
            // END FOOTER TEMPLATE
        }
    }
?>