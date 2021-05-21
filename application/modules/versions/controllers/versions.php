<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Versions extends Base_Controller {

    public function index() {
        
        $versions = getVersionsApp();
        
        $this->layout->set(
                array(
                    'versions' => $versions,
                )
        );
        $this->layout->buffer('content', 'versions/index');
        $this->layout->render();
    }

}
