<?php

class Space_model extends CI_Model {

    private $table = 'space';

    public function get_all_space() {
        return $this->db->select('*')
                        ->from($this->table)
                        ->get();
    }

    public function get_space_by_id($id) {
        return $this->db->select('*')
                        ->from($this->table)
                        ->where('id', $id)
                        ->get();
    }

    public function get_horaires($id) {
        return $this->db->select('*')
                        ->from("horaires_space")
                        ->where('id_space', $id)
                        ->get();
    }

    public function update_space($id, $space) {
        return $this->db->update($this->table, $space, array('id'=>$id));
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
}

?>
