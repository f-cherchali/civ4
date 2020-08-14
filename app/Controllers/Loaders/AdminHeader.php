<?php 
    namespace App\Controllers\Loaders;
    use \App\Controllers\BaseController;
    use \Config\MyConfig;
    class AdminHeader extends BaseController{
        private $title;
        private $principalTitle;
        private $breadcrumb=[];
        private $cssFiles=[];
        private $cssLinks=[];

        // public function setConfig($conf){
        //     $this->myConfig = $conf;
        // }
        public function setTitle($title){
            $this->title = $title;
        }
        public function setPrincipalTitle($principalTitle){
            $this->principalTitle = $principalTitle;
        }
        public function setBreadcrumb($title="",$link=false){
            $this->breadcrumb[]=[
                "title"=>$title,
                "link"=>$link
            ];
        }
        public function setCssFile($cssFile){
            $this->cssFiles[]=$cssFile;
        }
        public function setCssLink($cssLink){
            $this->cssLinks[]=$cssLink;
        }
        public function render(){
            $data=[
                "myConfig"=>new MyConfig(),
                "title"=>$this->title,
                "principal_title"=>$this->principalTitle,
                "breadcrumb"=>$this->breadcrumb,
                "css_files"=>$this->cssFiles,
                "css_links"=>$this->cssLinks
            ];
            echo view("admin/layout/template_head.php",$data);
        }
    }
?>