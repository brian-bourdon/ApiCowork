<?php

class Abonnement_model extends CI_Model {

    private $table = 'abonnement';

    public function get_all_abonnement() {
        return $this->db->select('*')
                        ->from($this->table)
                        ->get();
    }

    public function get_abonnement_by_id($id) {
        return $this->db->select('*')
                        ->from($this->table)
                        ->where('id', $id)
                        ->get();
    }
}