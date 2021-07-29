<?php
    class Reportscontroller extends CI_Controller{
        
        public function index(){
           
            $this->load->view('templates/header');
            $this->load->view('templates/navbar');
            $this->load->view('dashboard');
            $this->load->view('templates/footer');
        }

        public function pto(){
            $this->form_validation->set_rules('from_date', 'Date',
            'required');

            if($this->form_validation->run() === FALSE){
                $data['region'] =  $this->opms_model->region();
                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/pto', $data);
                $this->load->view('templates/footer');
              
            }else{
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                $region = $this->input->post('region');
                
                $data['sregion'] =  $region;
                $data['datefrom'] =  $from_date;
                $data['dateto'] =  $to_date;

                $data['pto'] =  $this->opms_model->pto($from_date, $to_date, $region);
                $data['region'] =  $this->opms_model->region();
                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/pto', $data);
                $this->load->view('templates/footer');
            }
        }

        public function dp(){
            $this->form_validation->set_rules('from_date', 'Date',
            'required');

            if($this->form_validation->run() === FALSE){
                $data['region'] =  $this->opms_model->region();

                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/dp',$data);
                $this->load->view('templates/footer');
              
            }else{
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                $region = $this->input->post('region');

                $data['sregion'] =  $region;
                $data['datefrom'] =  $from_date;
                $data['dateto'] =  $to_date;

                $data['dp'] =  $this->opms_model->dp($from_date, $to_date, $region);
                $data['region'] =  $this->opms_model->region();

                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/dp', $data);
                $this->load->view('templates/footer');
            }
        }
        
        public function sqi(){
            $this->form_validation->set_rules('from_date', 'Date',
            'required');

            if($this->form_validation->run() === FALSE){
                $data['region'] =  $this->opms_model->region();
                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/sqi', $data);
                $this->load->view('templates/footer');
              
            }else{
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                $region = $this->input->post('region');

                $data['sregion'] =  $region;
                $data['datefrom'] =  $from_date;
                $data['dateto'] =  $to_date;

                $data['sqi'] =  $this->opms_model->sqi($from_date, $to_date, $region);
                $data['region'] =  $this->opms_model->region();
                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/sqi', $data);
                $this->load->view('templates/footer');

                // echo json_encode($data['sqi']);
            }
        }

        public function coc(){
            $this->form_validation->set_rules('from_date', 'Date',
            'required');

            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/coc');
                $this->load->view('templates/footer');
              
            }else{
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');

                $data['datefrom'] =  $from_date;
                $data['dateto'] =  $to_date;

                $data['coc'] =  $this->opms_model->coc($from_date, $to_date);;
                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/coc', $data);
                $this->load->view('templates/footer');

                // echo json_encode($data['coc']);
            }
        }

        public function pcl(){
            $this->form_validation->set_rules('from_date', 'Date',
            'required');

            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/pcl');
                $this->load->view('templates/footer');
              
            }else{
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');

                $data['datefrom'] =  $from_date;
                $data['dateto'] =  $to_date;

                $data['pcl'] =  $this->opms_model->pcl($from_date, $to_date);;
                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/pcl', $data);
                $this->load->view('templates/footer');

                // echo json_encode($data['pcl']);
            }
        }

        public function pmpin(){
            $this->form_validation->set_rules('from_date', 'Date',
            'required');

            if($this->form_validation->run() === FALSE){
                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/pmpin');
                $this->load->view('templates/footer');
              
            }else{
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');

                $data['datefrom'] =  $from_date;
                $data['dateto'] =  $to_date;

                $data['pmpin'] =  $this->opms_model->pmpin($from_date, $to_date);;
                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/pmpin', $data);
                $this->load->view('templates/footer');

                // echo json_encode($data['pmpin']);
            }
        }

        public function ccor(){
            $this->form_validation->set_rules('from_date', 'Date',
            'required');

            if($this->form_validation->run() === FALSE){
                $data['region'] =  $this->opms_model->region();

                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/ccor',$data);
                $this->load->view('templates/footer');
              
            }else{
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                $region = $this->input->post('region');

                $data['sregion'] =  $region;
                $data['datefrom'] =  $from_date;
                $data['dateto'] =  $to_date;

                $data['ccor'] =  $this->opms_model->ccor($from_date, $to_date, $region);
                $data['region'] =  $this->opms_model->region();

                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/ccor', $data);
                $this->load->view('templates/footer');
            }
        }

        public function ccoi(){
            $this->form_validation->set_rules('from_date', 'Date',
            'required');

            if($this->form_validation->run() === FALSE){
                $data['region'] =  $this->opms_model->region();

                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/ccoi',$data);
                $this->load->view('templates/footer');
              
            }else{
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                $region = $this->input->post('region');

                $data['sregion'] =  $region;
                $data['datefrom'] =  $from_date;
                $data['dateto'] =  $to_date;

                $data['ccoi'] =  $this->opms_model->ccoi($from_date, $to_date, $region);
                $data['region'] =  $this->opms_model->region();

                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/ccoi', $data);
                $this->load->view('templates/footer');
            }
        }

        public function odsir(){
            $this->form_validation->set_rules('from_date', 'Date',
            'required');

            if($this->form_validation->run() === FALSE){

                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/odsir');
                $this->load->view('templates/footer');
              
            }else{
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                $region = $this->input->post('region');

                $data['datefrom'] =  $from_date;
                $data['dateto'] =  $to_date;

                $data['odsir'] =  $this->opms_model->odsir($from_date, $to_date);
                $data['region'] =  $this->opms_model->region();

                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/odsir', $data);
                $this->load->view('templates/footer');
            }
        }

        public function odsic(){
            $this->form_validation->set_rules('from_date', 'Date',
            'required');

            if($this->form_validation->run() === FALSE){

                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/odsic');
                $this->load->view('templates/footer');
              
            }else{
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                $region = $this->input->post('region');

                $data['datefrom'] =  $from_date;
                $data['dateto'] =  $to_date;

                $data['odsic'] =  $this->opms_model->odsic($from_date, $to_date);
                $data['region'] =  $this->opms_model->region();

                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/odsic', $data);
                $this->load->view('templates/footer');
            }
        }

        public function odsr(){
            $this->form_validation->set_rules('from_date', 'Date',
            'required');

            if($this->form_validation->run() === FALSE){
                $data['region'] =  $this->opms_model->region();

                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/odsr',$data);
                $this->load->view('templates/footer');
              
            }else{
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');
                $region = $this->input->post('region');

                $data['sregion'] =  $region;
                $data['datefrom'] =  $from_date;
                $data['dateto'] =  $to_date;

                $data['odsr'] =  $this->opms_model->odsr($from_date, $to_date, $region);
                $data['region'] =  $this->opms_model->region();

                $this->load->view('templates/header');
                $this->load->view('templates/navbar');
                $this->load->view('pages/opms/odsr', $data);
                $this->load->view('templates/footer');
            }
        }
        
    }
?>