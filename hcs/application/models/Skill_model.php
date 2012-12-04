<?php

/**
 * Description of Skill_model
 *
 * @author ashpakov
 */
class Skill_model extends CI_Model
{
    public function get_data() {
        $query = $this->db->get('skill_lkup');
        return $query->result();
    }

    // get skill by id
    function get_by_id($id){
        $this->db->from('skill_lkup');
        $this->db->where('skill_id', $id);
        $result = $this->db->get();
        $text = $result->row();
        return $text;
    }

    // add new skill
    function save($skill){
        $this->db->insert('skill_lkup', $skill);
//        return $this->db->insert_id();
    }

    // update skill by id
    function update($id, $skill){
        $this->db->where('skill_id', $id);
        $this->db->update('skill_lkup', $skill);
    }

    // delete skill by id
    function delete($id){
        $this->db->where('skill_id', $id);
        $this->db->delete('skill_lkup');
    }
}

?>
