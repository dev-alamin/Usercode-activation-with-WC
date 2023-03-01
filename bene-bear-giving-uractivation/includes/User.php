<?php
namespace Benebear;

class User{
    public function __construct(){
        $form_handler = new \Benebear\Backend\FormHandler();

        $this->dispatch_action( $form_handler );
    }

    public function dispatch_action( $form_handler ){
        add_action( 'admin_init', [ $form_handler, 'Form_handler'] );
    }
}