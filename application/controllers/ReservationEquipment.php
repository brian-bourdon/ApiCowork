<?php
//https://cowork-paris.000webhostapp.com/index.php/item
require APPPATH . 'libraries/REST_Controller.php';
     
class ReservationEquipment extends REST_Controller {
    
      /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('ReservationEquipment_model');
       $this->load->model('Space_model');
       $this->load->model('Equipment_model');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_get($id = 0)
    {
        if(!empty($id)){
            $data = $this->db->get_where("reservation_equipment", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("reservation_equipment")->result();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $input = $this->input->post();
        $this->db->set($input);
        $res = $this->ReservationEquipment_model->insert($input);
        if($res) $this->response(['Reservation created successfully.'], REST_Controller::HTTP_OK);
        else $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
    } 
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function update_post($id)
    {
        
        $input = $this->input->post();
        $this->db->update('reservation_equipment', $input, array('id'=>$id));
     
        $this->response(['User updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('reservation_equipment', array('id'=>$id));
       
        $this->response(['Reservation deleted successfully.'], REST_Controller::HTTP_OK);
    }

    public function disponible_get($id_equipment = 0, $horaire_debut = "", $horaire_fin = "") {
        if(!empty($id_equipment) && !empty($horaire_debut)) {
            $horaire_debut = str_replace("+", " ", $horaire_debut);
            $horaire_fin = str_replace("+", " ", $horaire_fin);
            $id_space = $this->ReservationEquipment_model->get_space_by_equipment_id($id_equipment)->row_array()["id_space"];
            $res = $this->ReservationEquipment_model->is_disponible($id_equipment, $horaire_debut, $horaire_fin)->result_array();
            $horaires_space = $this->Space_model->get_horaires($id_space)->row_array();
            $hd = new DateTime($horaire_debut);
            $hf = new DateTime($horaire_fin);
            $interval_hours = $hd->diff($hf)->format("%r%h");
            $interval_days = $hd->diff($hf)->format("%r%a");
            $response = array();

            if((int)$interval_days <= 7) { // max 1 semaines
                if((int)$interval_hours >= 1) { // au moins 1h de diff
                    if($hd->format('L') <= 4) $week_type = "horaire_semaine_";
                    else if($hd->format('L') == 5) $week_type = "horaire_vendredi_";
                    else $week_type = "horaire_week_end_";
                    if($hd->format('H:i:s') >= $horaires_space[$week_type."start"] && $hf->format('H:i:s') <= $horaires_space[$week_type."end"]) { // si ouvert
                        if(count($res) == 0) { // si dispo
                            $response["status"] = true;
                            $response["msg"] = "Equipement disponible";
                        }
                        else {
                            $response["status"] = false;
                            $response["msg"] = "L'equipement n'est pas disponlible pour ces horaires !";
                        }
                        
                    }else {
                        $response["status"] = false;
                        $response["msg"] = "Le ".$this->Space_model->get_space_by_id($id_space)->row_array()["nom"]." n'est pas ouvert à ces horaires !";
                    }
                }
                else {
                    $response["status"] = false;
                    $response["msg"] = "Le créneau doit être au moins d'une heure !";
                }
            } else {
                $response["status"] = false;
                $response["msg"] = "Il est impossible d'effectuer un prêt de plus d'une semaine !";
            }
            $this->response($response, REST_Controller::HTTP_OK);
        }
        else $this->response([
            'status' => false,
            'message' => '404 NOT FOUND'
            ], REST_Controller::HTTP_NOT_FOUND);
    }

    public function reservationByEquipment_get($id_equipment = 0, $formDate = 0) {
        if(!empty($id_equipment) && !empty($formDate)) {
            $data = $this->ReservationEquipment_model->get_reservation_by_equipment($id_equipment, $formDate)->result_array();
            $this->response($data, REST_Controller::HTTP_OK);
        }
        else $this->response([
            'status' => FALSE,
            'message' => '404 NOT FOUND'
            ], REST_Controller::HTTP_NOT_FOUND);
    }

    public function equipment_get($id_equipment = 0) {
        if(!empty($id_equipment)) {
            $id_space = $this->Equipment_model->get_by_id($id_equipment)->row();
            if(!empty($id_space)) {
                $res = $this->Equipment_model->get_by_space($id_space->id_space)->result_array();
                if($res) $this->response($res, REST_Controller::HTTP_OK);
                else $this->response(array(), REST_Controller::HTTP_BAD_REQUEST);
            } else $this->response(array(), REST_Controller::HTTP_OK);
        }
        else $this->response([
            'status' => FALSE,
            'message' => 'No equipment found'
            ], REST_Controller::HTTP_NOT_FOUND);
    }
        
}