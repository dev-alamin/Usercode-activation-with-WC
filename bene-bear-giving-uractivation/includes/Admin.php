<?php 
namespace Woo\MC;

class Admin{
    public function __construct(){
        new \Woo\MC\Backend\Cpt();
        new \Woo\MC\Backend\Metabox(); // Metabox for cpt
        new \Woo\MC\Backend\AdminColumn(); // Admin column
        
    }
}