<?php

/**
 * Description of Mobilecarrier_model
 *
 * @author ashpakov
 */
class  Mobilecarrier_model extends CI_Model
{
    public function get_data() {
        $query = $this->db->get('mobilecarrier_lkup');
        return $query->result();
    }

    // get carrier by id
    function get_by_id($id){
        $this->db->from('mobilecarrier_lkup');
        $this->db->where('carrier_id', $id);
        $result = $this->db->get();
        $text = $result->row();
        return $text;
    }

    // add new carrier
    function save($carrier){
        $this->db->insert('mobilecarrier_lkup', $carrier);
    }

    // update carrier by id
    function update($id, $carrier){
        $this->db->where('carrier_id', $id);
        $this->db->update('mobilecarrier_lkup', $carrier);
    }

    // delete carrier by id
    function delete($id){
        $this->db->where('carrier_id', $id);
        $this->db->delete('mobilecarrier_lkup');
    }
}

?>
