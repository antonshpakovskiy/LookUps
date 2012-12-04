<?php

/**
 * Description of Skill_controller
 *
 * @author ashpakov
 */
class Skill_controller extends CI_Controller
{
    function __construct(){
        parent::__construct();
        // URL Helper file contains functions for working with URLs.
        $this->load->helper('url');
        $config['base_url'] = site_url('Skill_controller/index/');
    }
    
    function index(){
        $this->load->model('Skill_model');
        $skills = $this->Skill_model->get_data();
        
        // generate table data
        $this->load->library('table');
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('ID', 'Skill', 'Updated Date', 
                                  'Updated By', 'Actions');
        foreach ($skills as $skill){
            $this->table->add_row($skill->skill_id, $skill->skill_txt,
                    $skill->update_dt_tm, $skill->update_user_id,
            anchor('Skill_controller/update/'.$skill->skill_id,'update',
                        array('class'=>'update')).'  '.
            anchor('Skill_controller/delete/'.$skill->skill_id,'delete',
                        array('class'=>'delete','onclick'=>
                        "return confirm('Are you sure want to delete this skill?')"))
            );
        }
        $lkup_data['skill_table'] = $this->table->generate();

        // load view
        $this->load->view('skill_view', $lkup_data);
    }
        
    function add(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // reset common properties
        $datetime = date('Y-m-d H:i:s');
        
        $data['title'] = 'Add new Skill';
        $data['action'] = site_url('Skill_controller/add');
        $data['message'] = validation_errors();
        $data['skill_id'] = '';
        $data['skill_txt'] = '';
        $data['update_dt_tm'] = $datetime;
        $data['update_user_id'] = '';
        $data['link_back'] = anchor('Skill_controller/index/',
                'Back to the Skills Table',array('class'=>'back'));
        
        // run validation
        $this->form_validation->set_rules('skill_id','Skill ID');
        $this->form_validation->set_rules('skill_txt','Skill Name',
                'trim|min_length[3]|max_length[30]|required');
        $this->form_validation->set_rules('update_dt_tm','Updated Date');
        $this->form_validation->set_rules('update_user_id','Updating User');
        
        // show errors
        $this->form_validation->set_message('required', '* required');
		$this->form_validation->set_message('isset', '* required');
		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        
        if($this->form_validation->run() == FALSE){
            // load view again
            $data['message'] = validation_errors();
            $this->load->view('skill_edit', $data);
            
        }else{
            // save data to DB
            $skill = array('skill_txt' => $this->input->post('skill_txt'));
            
            $this->load->model('Skill_model');
            $this->Skill_model->save($skill);
            // set user message
            $data['message'] = '<div class="success">New skill was successfuly added!</div>';
            $this->load->view('skill_edit', $data);     
        }
        
    }
    
    function delete($id){
        $this->load->model('Skill_model');
        $this->Skill_model->delete($id);
        
        // redirect to the main view
        redirect('Skill_controller/index/','refresh');
    }
    
    function update($id){
        // load librares
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        // get values for form population
        $this->load->model('Skill_model');
        $skill = $this->Skill_model->get_by_id($id);

        // set common properties
        $data['title'] = 'Update Skill';
        $data['message'] = '';
        $data['skill_id'] = $skill->skill_id;
        $data['skill_txt'] = $skill->skill_txt;
        $data['update_dt_tm'] = $skill->update_dt_tm;
        $data['update_user_id'] = $skill->update_user_id;
        $data['action'] = site_url('Skill_controller/update/'.$id);
        $data['link_back'] = anchor('Skill_controller/index/',
                'Back to the Skills Table',array('class'=>'back'));

        // run validation
        $this->form_validation->set_rules('skill_txt','Skill Name',
                'trim|min_length[3]|max_length[30]|required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        
        if($this->form_validation->run() == FALSE){
            // load view again
            $data['message'] = validation_errors();
            $this->load->view('skill_edit', $data);
            
        }else{
            // save data to DB
            $skills = array('skill_txt' => $this->input->post('skill_txt'));
            $this->Skill_model->update($id, $skills);
            
// set user message
            $data['message'] = '<div class="success">'.
                    'Selected skill was successfuly updated!</div>';
            $this->load->view('skill_edit', $data);
        }
    }
}

?>