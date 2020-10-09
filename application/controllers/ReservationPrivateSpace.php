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
    public function disponible_get($id_space = 0, $horaire_debut = "", $horaire_fin = "") {
        if(!empty($id_space) && !empty($horaire_debut)) {
            $horaire_debut = str_replace("+", " ", $horaire_debut);
            $horaire_fin = str_replace("+", " ", $horaire_fin);
            $res = $this->ReservationPrivateSpace_model->is_disponible($id_space, $horaire_debut, $horaire_fin)->result_array();
            count($res) == 0 ? $response = true : $response = false;
            $this->response([$response], REST_Controller::HTTP_OK);
        }
        else $this->response([
            'status' => FALSE,
            'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    public function index_delete($id = 0)
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