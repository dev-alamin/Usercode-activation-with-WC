<?php
namespace Woo\MC;

class User{
    public function __construct(){
        $form_handler = new \Woo\MC\Backend\FormHandler();

        $this->dispatch_action( $form_handler );
    }

    public function dispatch_action( $form_handler ){
        add_action( 'admin_init', [ $form_handler, 'Form_handler'] );
    }
}