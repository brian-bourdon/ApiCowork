<?php

class ReservationEquipment_model extends CI_Model {

    private $table = 'reservation_equipment';

    public function get_space_by_equipment_id($id) {
        return $this->db->select('*')
                        ->from("equipment")
                        ->where('id', $id)
                        ->get();
    }
    
    public function is_disponible($id_equipment, $horaire_debut, $horaire_fin) {
        $hd = new DateTime($horaire_debut);
        $hf = new DateTime($horaire_fin);
        return $this->db->select('*')
                        ->from($this->table)
                        ->where('id_equipment', $id_equipment)
                        ->where('horaire_fin >', $hd->format("Y-m-d H:i"))
                        ->where('horaire_debut <', $hf->format("Y-m-d H:i"))
                        ->where('rendu', 'non')
                        ->get();
    }

    public function get_reservation_by_equipment($id_equipment, $formDate) {
        return $this->db->select("horaire_debut, horaire_fin")
                        ->from($this->table)
                        ->where('id_equipment', $id_equipment)
                        ->where("DATE_FORMAT(horaire_debut,'%Y-%m-%d') =", $formDate)
                        ->where("rendu", "non")
                        ->get();
    }

    public function insert($input) {
        if(isset($input["horaire_debut"], $input["horaire_fin"], $input["id_equipment"], $input["id_user"])) {
            $hd = new DateTime($input["horaire_debut"]);
            $hf = new DateTime($input["horaire_fin"]);
            $interval_hours = $hd->diff($hf)->format("%r%h");
            $interval_days = $hd->diff($hf)->format("%r%a");
            if(count($this->is_disponible($input["id_equipment"], $input["horaire_debut"], $input["horaire_fin"])->result_array()) == 0 && (int)$interval_days <= 7 && ((int)$interval_hours >= 1)) {
                $data = array(
                    'horaire_debut' => $input["horaire_debut"],
                    'horaire_fin' => $input["horaire_fin"],
                    'id_equipment' => $input["id_equipment"],
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

}