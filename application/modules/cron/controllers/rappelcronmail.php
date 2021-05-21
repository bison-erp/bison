<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cron
 *
 * @author oussema
 */
class rappelcronmail extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function rappelauto()
    {
        $this->load->view('cronview');

    }

}