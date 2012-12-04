<?php

/**
 * Description of State_model
 *
 * @author ashpakov
 */
class State_model extends CI_Model
{
    public function get_data() {
        $query = $this->db->get('state_lkup');
        return $query->result();
    }

    // get state by id
    function get_by_id($id){
        $this->db->from('state_lkup');
        $this->db->where('state_id', $id);
        $result = $this->db->get();
        $text = $result->row();
        return $text;
    }

    // add new state
    function save($state){
        $this->db->insert('state_lkup', $state);
    }

    // update state by id
    function update($id, $state){
        $this->db->where('state_id', $id);
        $this->db->update('state_lkup', $state);
    }

    // delete state by id
    function delete($id){
        $this->db->where('state_id', $id);
        $this->db->delete('state_lkup');
    }
}

?>
