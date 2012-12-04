<?php

/**
 * Description of State_controller
 *
 * @author ashpakov
 */
class State_controller extends CI_Controller
{
    function __construct(){
        parent::__construct();
        // URL Helper file contains functions for working with URLs.
        $this->load->helper('url');
        $config['base_url'] = site_url('State_controller/index/');
    }
    
    function index(){
        $this->load->model('State_model');
        $states = $this->State_model->get_data();
        
        // generate table data
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('ID', 'Abbreviation',
                'State Name','City Name','ZIP Code', 'Country',
                'Updated Date', 'Updated By', 'Actions');
        foreach ($states as $state){
            $this->table->add_row($state->state_id, $state->abbrv,
                    $state->name, $state->city, $state->zip, $state->country,
                    $state->update_dt_tm, $state->update_user_id,
            anchor('State_controller/update/'.$state->state_id,'update',
                        array('class'=>'update')).'  '.
            anchor('State_controller/delete/'.$state->state_id,'delete',
                        array('class'=>'delete','onclick'=>
                        "return confirm('Are you sure want to delete this record?')"))
            );
        }
        $lkup_data['state_table'] = $this->table->generate();

        // load view
        $this->load->view('state_view', $lkup_data);
    }
        
    function add(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // reset common properties
        $datetime = date('Y-m-d H:i:s');
        
        $data['title'] = 'Add new State';
        $data['action'] = site_url('State_controller/add');
        $data['message'] = validation_errors();
        $data['state_id'] = '';
        $data['abbrv'] = '';
        $data['name'] = '';
        $data['city'] = '';
        $data['zip'] = '';
        $data['country'] = '';
        $data['update_dt_tm'] = $datetime;
        $data['update_user_id'] = '';
        $data['link_back'] = anchor('State_controller/index/',
                'Back to the States Table',array('class'=>'back'));
        
        // run validation
        $this->form_validation->set_rules('state_id','State ID');
        $this->form_validation->set_rules('abbrv','Abbreviation',
                'trim|exact_length[2]|required');
        $this->form_validation->set_rules('name','State Name',
                'trim|min_length[3]|max_length[30]|required');
        $this->form_validation->set_rules('city','City Name',
                'trim|min_length[3]|max_length[64]|required');
        $this->form_validation->set_rules('zip','ZIP Code',
                'trim|exact_length[5]|required');
        $this->form_validation->set_rules('country','Country',
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
            $this->load->view('state_edit', $data);
            
        }else{
            // save data to DB
            $state = array('abbrv' => $this->input->post('abbrv'),
                'name' => $this->input->post('name'), 
                'city' => $this->input->post('city'),
                'zip' => $this->input->post('zip'), 
                'country' => $this->input->post('country'));
            
            $this->load->model('State_model');
            $this->State_model->save($state);
            // set user message
            $data['message'] = '<div class="success">New record was successfuly added!</div>';
            $this->load->view('state_edit', $data);     
        }
    }
    
    function delete($id){
        $this->load->model('State_model');
        $this->State_model->delete($id);
        
        // redirect to the main view
        redirect('State_controller/index/','refresh');
    }
    
    function update($id){
        // load librares
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // get values for form population
        $this->load->model('State_model');
        $state = $this->State_model->get_by_id($id);

        // set common properties
        $data['title'] = 'Update State';
        $data['message'] = '';
        $data['state_id'] = $state->state_id;
        $data['abbrv'] = $state->abbrv;
        $data['name'] = $state->name;
        $data['city'] = $state->city;
        $data['zip'] = $state->zip;
        $data['country'] = $state->country;
        $data['update_dt_tm'] = $state->update_dt_tm;
        $data['update_user_id'] = $state->update_user_id;
        $data['action'] = site_url('State_controller/update/'.$id);
        $data['link_back'] = anchor('State_controller/index/',
                'Back to the States Table',array('class'=>'back'));

        // run validation
        $this->form_validation->set_rules('state_id','State ID');
        $this->form_validation->set_rules('abbrv','Abbreviation',
                'trim|exact_length[2]|required');
        $this->form_validation->set_rules('name','State Name',
                'trim|min_length[3]|max_length[30]|required');
        $this->form_validation->set_rules('city','City Name',
                'trim|min_length[3]|max_length[64]|required');
        $this->form_validation->set_rules('zip','ZIP Code',
                'trim|exact_length[5]|required');
        $this->form_validation->set_rules('country','Country',
                'trim|min_length[3]|max_length[64]|required');
        $this->form_validation->set_rules('update_dt_tm','Updated Date');
        $this->form_validation->set_rules('update_user_id','Updating User');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        
        if($this->form_validation->run() == FALSE){
            // load view again
            $data['message'] = validation_errors();
            $this->load->view('state_edit', $data);
            
        }else{
            // save data to DB
            $state = array('abbrv' => $this->input->post('abbrv'),
                'name' => $this->input->post('name'), 
                'city' => $this->input->post('city'),
                'zip' => $this->input->post('zip'), 
                'country' => $this->input->post('country'));
            $this->State_model->update($id, $state);
            
// set user message
            $data['message'] = '<div class="success">'.
                    'Selected record was successfuly updated!</div>';
            $this->load->view('state_edit', $data);
        }
    }
}

?>