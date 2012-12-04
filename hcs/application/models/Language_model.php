<?php

/**
 * Description of Language_model
 *
 * @author ashpakov
 */
class Language_model extends CI_Model
{
    public function get_data() {
        $query = $this->db->get('language_lkup');
        return $query->result();
    }

    // get language by id
    function get_by_id($id){
        $this->db->from('language_lkup');
        $this->db->where('language_id', $id);
        $result = $this->db->get();
        $text = $result->row();
        return $text;
    }

    // add new language
    function save($lang){
        $this->db->insert('language_lkup', $lang);
    }

    // update language by id
    function update($id, $lang){
        $this->db->where('language_id', $id);
        $this->db->update('language_lkup', $lang);
    }

    // delete language by id
    function delete($id){
        $this->db->where('language_id', $id);
        $this->db->delete('language_lkup');
    }
}

?>
