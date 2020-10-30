<?php

class ResAbonnement_model extends CI_Model {

    private $table = 'res_abonnement';

    public function insert($data) {
        $now = new DateTime();
        $data["created_at"] = $now->format("Y-m-d H:i:s");
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

    public function update($id, $data) {
        return $this->db->update($this->table, $data, array('id'=>$id));
    }
}