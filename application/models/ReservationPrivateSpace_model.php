<?php

class ReservationPrivateSpace_model extends CI_Model {

    private $table = 'reservation_espace_privatif';

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

    public function get_space_by_privative_space_id($id) {
        return $this->db->select('*')
                        ->from("espace_privatif")
                        ->where('id', $id)
                        ->get();
    }

    public function get_by_user($id) {
        return $this->db->select('*')
                        ->from($this->table)
                        ->where('id_user', $id)
                        ->get();
    }

    public function is_disponible($id_space, $horaire_debut, $horaire_fin) {
        $hd = new DateTime($horaire_debut);
        $hf = new DateTime($horaire_fin);
        return $this->db->select('*')
                        ->from($this->table)
                        ->where('id_espace_privatif', $id_space)
                        ->where('horaire_fin >', $hd->format("Y-m-d H:i"))
                        ->where('horaire_debut <', $hf->format("Y-m-d H:i"))
                        ->get();
    }

    public function insert($input) {
        if(isset($input["horaire_debut"], $input["horaire_fin"], $input["id_espace_privatif"], $input["id_user"])) {
            $hd = new DateTime($input["horaire_debut"]);
            $hf = new DateTime($input["horaire_fin"]);
            $interval = $hd->diff($hf)->format("%r%h");
            if(count($this->is_disponible($input["id_espace_privatif"], $input["horaire_debut"], $input["horaire_fin"])->result_array()) == 0 && ($hd->format("Y-m-d") == $hf->format("Y-m-d")) && ((int)$interval >= 1)) {
                $data = array(
                    'horaire_debut' => $input["horaire_debut"],
                    'horaire_fin' => $input["horaire_fin"],
                    'id_espace_privatif' => $input["id_espace_privatif"],
                    'id_user' => $input["id_user"]
                );
                $this->db->set($data);
                $res = $this->db->insert($this->table, $data);
                //$idUser = $this->db->insert_id();
            }else $res = false;
        } else{
            $res = false;
        }
        return $res;
    }

    public function get_reservation_by_privative_space($id_espace_privatif, $formDate) {
        return $this->db->select("horaire_debut, horaire_fin")
                        ->from($this->table)
                        ->where('id_espace_privatif', $id_espace_privatif)
                        ->where("DATE_FORMAT(horaire_debut,'%Y-%m-%d') =", $formDate)
                        ->get();
    }

    public function delete_user($id) {
        return $this->db->delete($this->table, array('id'=>$id));
    }

}

?>
