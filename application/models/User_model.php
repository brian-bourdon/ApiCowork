<?php

class User_model extends CI_Model {

    private $table = 'user';

    public function get_all_user() {
        return $this->db->select('*')
                        ->from($this->table)
                        ->get();
    }

    public function get_user_by_id($id) {
        return $this->db->select('*')
                        ->from($this->table)
                        ->where('id', $id)
                        ->get();
    }

    public function get_user_by_mail($mail) {
        return $this->db->select('*')
                        ->from($this->table)
                        ->where('email', $mail)
                        ->get();
    }

    public function get_privative_reservation($id) {
        return $this->db->select('*')
                        ->from("reservation_espace_privatif")
                        ->where('id_user', $id)
                        ->get();
    }

    public function get_equipment_reservation($id) {
        return $this->db->select('*')
                        ->from("reservation_equipment")
                        ->where('id_user', $id)
                        ->get();
    }

    public function get_meal_reservation($id) {
        return $this->db->select('*')
                        ->from("reservation_meal")
                        ->where('id_user', $id)
                        ->get();
    }

    public function get_events($id) {
        return $this->db->select('*')
                        ->from("reservation_events")
                        ->where('id_user', $id)
                        ->get();
    }

    public function insert_user($user) {
        $res = true;
        if(isset($user["firstname"], $user["lastname"], $user["date_naissance"], $user["email"], $user["pwd"])) {
            if(count($this->get_user_by_mail($user["email"])->result_array()) == 0) {
                $data = array(
                    'firstname' => $user["firstname"],
                    'lastname' => $user["lastname"],
                    'date_naissance' => $user["date_naissance"],
                    'email' => $user["email"],
                    'pwd' => $user["pwd"]
                );
                $this->db->set($data);
                $res &= $this->db->insert($this->table, $data);
                if(isset($user["id_abonnement"]) && !empty($user["id_abonnement"])) {
                    $this->load->model('ResAbonnement_model');
                    $res &= $this->ResAbonnement_model->insert(array("id_abonnement" => $user["id_abonnement"], "id_user" => $this->db->insert_id()));
                }
                //$idUser = $this->db->insert_id();
            }else $res &= false;
        } else {
            $res &= false;
        }
        return $res;
    }

    public function update_user($id, $user) {
        if(isset($user["firstname"]) || isset($user["lastname"]) || isset($user["date_naissance"]) || isset($user["email"]) || isset($user["pwd"]) || isset($user["id_abonnement"])) {
            $res = $this->db->update('user', $user, array('id'=>$id));
        }else $res = false;
        return $res;
    }

    public function delete_user($id) {
        return $this->db->delete('user', array('id'=>$id));
    }

}

?>
