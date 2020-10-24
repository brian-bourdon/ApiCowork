<?php

class Events_model extends CI_Model {

    private $table = 'events';

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

    public function update($id, $space) {
        return $this->db->update($this->table, $space, array('id'=>$id));
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
}

?>
