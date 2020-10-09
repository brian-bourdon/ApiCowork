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
}

?>
