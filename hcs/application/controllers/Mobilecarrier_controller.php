<?php

/**
 * Description of Mobilecarrier_controller
 *
 * @author ashpakov
 */
class Mobilecarrier_controller extends CI_Controller
{
    function __construct(){
        parent::__construct();
        // URL Helper file contains functions for working with URLs.
        $this->load->helper('url');
        $config['base_url'] = site_url('Mobilecarrier_controller/index/');
    }
    
    function index(){
        $this->load->model('Mobilecarrier_model');
        $carriers = $this->Mobilecarrier_model->get_data();
        
        // generate table data
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('ID', 'Text Address', 'Updated Date', 
                                  'Updated By', 'Actions');
        foreach ($carriers as $carrier){
            $this->table->add_row($carrier->carrier_id, $carrier->text_address,
                    $carrier->update_dt_tm, $carrier->update_user_id,
            anchor('Mobilecarrier_controller/update/'.$carrier->carrier_id,'update',
                        array('class'=>'update')).'  '.
            anchor('Mobilecarrier_controller/delete/'.$carrier->carrier_id,'delete',
                        array('class'=>'delete','onclick'=>
                        "return confirm('Are you sure want to delete this record?')"))
            );
        }
        $lkup_data['carrier_table'] = $this->table->generate();

        // load view
        $this->load->view('carrier_view', $lkup_data);
    }
        
    function add(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // reset common properties
        $datetime = date('Y-m-d H:i:s');
        
        $data['title'] = 'Add new Carrier';
        $data['action'] = site_url('Mobilecarrier_controller/add');
        $data['message'] = validation_errors();
        $data['carrier_id'] = '';
        $data['text_address'] = '';
        $data['update_dt_tm'] = $datetime;
        $data['update_user_id'] = '';
        $data['link_back'] = anchor('Mobilecarrier_controller/index/',
                'Back to the Carriers Table',array('class'=>'back'));
        
        // run validation
        $this->form_validation->set_rules('carrier_id','Carrier ID');
        $this->form_validation->set_rules('text_address','Address',
                'trim|min_length[3]|max_length[64]|required');
        $this->form_validation->set_rules('update_dt_tm','Updated Date');
        $this->form_validation->set_rules('update_user_id','Updating User');
        
        // show errors
        $this->form_validation->set_message('required', '* required');
		$this->form_validation->set_message('isset', '* required');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        
        if($this->form_validation->run() == FALSE){
            // load view again
            $data['message'] = validation_errors();
            $this->load->view('carrier_edit', $data);
            
        }else{
            // save data to DB
            $carrier = array('text_address' => $this->input->post('text_address'));
            
            $this->load->model('Mobilecarrier_model');
            $this->Mobilecarrier_model->save($carrier);
            // set user message
            $data['message'] = '<div class="success">New address was successfuly added!</div>';
            $this->load->view('carrier_edit', $data);     
        }
        
    }
    
    function delete($id){
        $this->load->model('Mobilecarrier_model');
        $this->Mobilecarrier_model->delete($id);
        
        // redirect to the main view
        redirect('Mobilecarrier_controller/index/','refresh');
    }
    
    function update($id){
        // load librares
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // get values for form population
        $this->load->model('Mobilecarrier_model');
        $carrier = $this->Mobilecarrier_model->get_by_id($id);

        // set common properties
        $data['title'] = 'Update a Carrier';
        $data['message'] = '';
        $data['carrier_id'] = $carrier->carrier_id;
        $data['text_address'] = $carrier->text_address;
        $data['update_dt_tm'] = $carrier->update_dt_tm;
        $data['update_user_id'] = $carrier->update_user_id;
        $data['action'] = site_url('Mobilecarrier_controller/update/'.$id);
        $data['link_back'] = anchor('Mobilecarrier_controller/index/',
                'Back to the Carriers Table',array('class'=>'back'));

        // run validation
        $this->form_validation->set_rules('text_address','SMS Address',
                'trim|min_length[3]|max_length[64]|required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        
        if($this->form_validation->run() == FALSE){
            // load view again
            $data['message'] = validation_errors();
            $this->load->view('carrier_edit', $data);
            
        }else{
            // save data to DB
            $carriers = array('text_address' => $this->input->post('text_address'));
            $this->Mobilecarrier_model->update($id, $carriers);
            
            // set user message
            $data['message'] = '<div class="success">'.
                    'Selected carrier was successfuly updated!</div>';
            $this->load->view('carrier_edit', $data);
        }
    }
}

?>