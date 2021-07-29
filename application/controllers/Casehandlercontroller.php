<?php
    class Casehandlercontroller extends CI_Controller{
        
        public function casehandler_summary(){
            $this->load->view('templates/header');
            $this->load->view('templates/navbar');
            $this->load->view('pages/opms/casehandler/summary');
            $this->load->view('templates/footer');

        } 
        
    }
?>