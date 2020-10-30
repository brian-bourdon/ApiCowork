<?php
//https://cowork-paris.000webhostapp.com/index.php/item
require APPPATH . 'libraries/REST_Controller.php';
     
class Abonnement extends REST_Controller {
    
      /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('Abonnement_model');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_get($id = 0)
    {
        if(!empty($id)){
            $data = $this->Abonnement_model->get_abonnement_by_id($id)->row_array();
        }else{
            $data = $this->Abonnement_model->get_all_abonnement()->result_array();
        }
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function delete_get($id = 0)
    {
        if(!empty($id)) {
            $res = $this->Abonnement_model->delete($id);
            if($res) $this->response(['Reservation deleted successfully.'], REST_Controller::HTTP_OK);
            else $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }
        else $this->response([
            'status' => FALSE,
            'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND);
    }

}