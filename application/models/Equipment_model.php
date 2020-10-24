<?php

class Equipment_model extends CI_Model {

    private $table = 'equipment';

    public function get_all() {
        return $this->db->select('*')
                        ->from($this->table)
                        ->get();
    }

    public function get_by_id($id) {
        return $this->db->select('*')
                        ->from($this->table)
                        ->where('id', $id)
                        ->get();
    }

    public function update($id, $equipment) {
        return $this->db->update($this->table, $equipment, array('id'=>$id));
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
}

?>
