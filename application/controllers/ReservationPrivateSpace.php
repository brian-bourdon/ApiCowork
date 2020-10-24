<?php
//https://cowork-paris.000webhostapp.com/index.php/item
require APPPATH . 'libraries/REST_Controller.php';
     
class ReservationPrivateSpace extends REST_Controller {
    
      /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('ReservationPrivateSpace_model');
       $this->load->model('Space_model');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_get($id = 0)
    {
        if(!empty($id)){
            $data = $this->ReservationPrivateSpace_model->get_by_id($id)->row_array();
        }else{
            $data = $this->ReservationPrivateSpace_model->get_all()->result_array();
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
        $res = $this->ReservationPrivateSpace_model->insert($input);
     
        if($res) $this->response(['Reservation created successfully.'], REST_Controller::HTTP_OK);
        else $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
    } 
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    /*public function update_post($id)
    {
        
        $input = $this->input->post();
        $this->db->update('reservation_espace_privatif', $input, array('id'=>$id));
     
        $this->response(['Reservation updated successfully.'], REST_Controller::HTTP_OK);
    }*/
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function disponible_get($id_privative_space = 0, $horaire_debut = "", $horaire_fin = "") {
        if(!empty($id_privative_space) && !empty($horaire_debut)) {
            $horaire_debut = str_replace("+", " ", $horaire_debut);
            $horaire_fin = str_replace("+", " ", $horaire_fin);
            $id_space = $this->ReservationPrivateSpace_model->get_space_by_privative_space_id($id_privative_space)->row_array()["id_space"];
            $res = $this->ReservationPrivateSpace_model->is_disponible($id_privative_space, $horaire_debut, $horaire_fin)->result_array();
            $horaires_space = $this->Space_model->get_horaires($id_space)->row_array();
            $hd = new DateTime($horaire_debut);
            $hf = new DateTime($horaire_fin);
            $interval = $hd->diff($hf)->format("%r%h");
            $response = array();
            
            if(count($res) == 0) {
                if($hd->format("Y-m-d") == $hf->format("Y-m-d")) {
                    if((int)$interval >= 1) {
                        if($hd->format('L') <= 4) $week_type = "horaire_semaine_";
                        else if($hd->format('L') == 5) $week_type = "horaire_vendredi_";
                        else $week_type = "horaire_week_end_";
                        if($hd->format('H:i:s') >= $horaires_space[$week_type."start"] && $hf->format('H:i:s') <= $horaires_space[$week_type."end"]) {
                            $response["status"] = true;
                            $response["msg"] = "Creneau disponible";
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
                    $response["msg"] = "Il est impossible de réserver sur plusieurs jours !";
                }
            }
            else {
                $response["status"] = false;
                $response["msg"] = "L'espace n'est pas disponlible pour ces horaires !";
            }
            $this->response($response, REST_Controller::HTTP_OK);
        }
        else $this->response([
            'status' => FALSE,
            'message' => '404 NOT FOUND'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    public function reservationByPrivateSpace_get($id_espace_privatif = 0, $formDate = 0) {
        if(!empty($id_espace_privatif) && !empty($formDate)) {
            $data = $this->ReservationPrivateSpace_model->get_reservation_by_privative_space($id_espace_privatif, $formDate)->result_array();
            $this->response($data, REST_Controller::HTTP_OK);
        }
        else $this->response([
            'status' => FALSE,
            'message' => '404 NOT FOUND'
            ], REST_Controller::HTTP_NOT_FOUND);
    }

    public function delete_get($id = 0)
    {
        if(!empty($id)) {
            $res = $this->ReservationPrivateSpace_model->delete_user($id);
            if($res) $this->response(['Reservation deleted successfully.'], REST_Controller::HTTP_OK);
            else $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }
        else $this->response([
            'status' => FALSE,
            'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND);
    }
        
}