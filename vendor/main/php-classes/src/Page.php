<?php
    namespace main;
    use Rain\Tpl;

    class Page
    {
        private $tpl;
        private $options = []; 
        private $defaults = [
            "header" => true,
            "footer" => true,
            "data" => [
                "active" => "",
                "category_active" => ""
            ]
        ];

        public function __construct($debug,$opts = array(),$tpl_dir = "/eco/views/store/")
        {
            
            //mescla default e opts, dando prioridade a opts
            $this->options = array_merge($this->defaults, $opts);
            
            $config = array(
            //configuro a pasta de views
            "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir,
            "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/eco/views-cache/store/",
            "debug"         => true // set to false to improve the speed
            );
            Tpl::configure( $config );
            $this->tpl = new Tpl;          
            // envio os dados para o template
            $this->setData($this->options["data"]);    
        
     
            // desenha header
            if($this->options["header"])
                $this->tpl->draw("header");
        }

        public function __destruct()
        {
            // desenha footer
            if($this->options["footer"])
                $this->tpl->draw("footer");
        }
        
        //configuro os dados no template
        public function setData($data = array()){
            foreach($data as $key => $value)
            {
                $this->tpl->assign($key,$value);
            }
        }

        // nome do template, variaveis, exibição
        public function setTpl($name, $data = array(), $returnHtml = false){
            //envio dados para o template
            $this->setData($data);
            return $this->tpl->draw($name,$returnHtml);
        }

    }
?>