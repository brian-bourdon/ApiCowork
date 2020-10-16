<?php
//https://cowork-paris.000webhostapp.com/index.php/item
require APPPATH . 'libraries/REST_Controller.php';
     
class Space extends REST_Controller {
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
        parent::__construct();
        $this->load->database();
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
            $data = $this->Space_model->get_space_by_id($id)->row_array();
        }else{
            $data = $this->Space_model->get_all_space()->result_array();
        }
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function horaires_get($id = 0)
    {
        if(!empty($id)){
            $data = $this->Space_model->get_horaires($id)->row_array();
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

}