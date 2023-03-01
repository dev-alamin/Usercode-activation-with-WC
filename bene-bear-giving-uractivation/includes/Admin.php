<?php 
namespace Benebear;

class Admin{
    public function __construct(){
        new \Benebear\Backend\Cpt();
        new \Benebear\Backend\Metabox(); // Metabox for cpt
        new \Benebear\Backend\AdminColumn(); // Admin column
        
    }
}