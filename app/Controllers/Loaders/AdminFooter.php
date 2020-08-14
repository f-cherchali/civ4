<?php 
    namespace App\Controllers\Loaders;
    use \App\Controllers\BaseController;
    use \Config\MyConfig;
    class AdminFooter extends BaseController{
        private $jsFiles=[];
        private $jsLinks=[];
        private $scripts=[];
        private $gcJsFiles;
        public function setJsFile($file){
            $this->jsFiles[] = $file;
        }
        public function setJsLink($link){
            $this->jsLinks[]=$link;
        }
        public function setScript($script){
            $this->scripts[]=$script;
        }
        public function setGcJsFiles($files){
            $this->gcJsFiles = $files;
        }
        public function render(){
            $data=[
                "myConfig"=>new MyConfig(),
                "js_files"=>$this->jsFiles,
                "js_links"=>$this->jsLinks,
                "scripts_footer"=>$this->scripts,
                "groceryJsFiles"=>$this->gcJsFiles
            ];
            echo view("admin/layout/template_footer.php",$data);
        }
    }
?> 