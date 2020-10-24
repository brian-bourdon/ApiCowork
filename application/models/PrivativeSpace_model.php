<?php

class PrivativeSpace_model extends CI_Model {

    private $table = 'espace_privatif';

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

    public function update_privative_space($id, $space) {
        return $this->db->update($this->table, $space, array('id'=>$id));
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
}

?>
