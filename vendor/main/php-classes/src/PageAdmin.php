<?php
    namespace main;
    use Rain\Tpl;

    class PageAdmin extends Page
    {
        public function __construct($debug,$opts = array(),$tpl_dir = "/eco/views/admin/")
        {
             parent::__construct($debug,$opts,$tpl_dir);   
        }     
    }
?>