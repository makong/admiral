<?php

Class galleryController Extends baseController {
    
    protected $registry;
    
    function __construct($registry) {
        parent::__construct($registry);
        
        $this->model = new Gallery($registry);
        $this->tags  = $this->model->get_flickr_tags();
        $this->tag   = current($this->tags);
    }
    
    public function index(){
        $this->view();
    }
        
    public function tags(){
        $this->tag = $this->registry->router->param;
        $this->view();
    }
    
    public function view($tpl = 'index'){
        $this->registry->template->data = array(
            'tags_count' => $this->model->tags_count,
            'tags'       => $this->tags,
            'tag'        => $this->tag,
            'images'     => $this->model->get_flickr_images($this->tag)
        );
        
        $this->registry->template->show('header');
        $this->registry->template->show($tpl);
        $this->registry->template->show('footer');
    }
    
    public function __call($name, $arguments){
        $this->view();
    }
}?>
