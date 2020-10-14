<?php

class ResAbonnement_model extends CI_Model {

    private $table = 'res_abonnement';

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function get_by_user($id_user) {
        return $this->db->select('*')
                        ->from($this->table)
                        ->where('id_user', $id_user)
                        ->get();
    }

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

    public function delete($id) {
        return $this->db->delete($this->table, array('id'=>$id));
    }
}