<?php
//https://cowork-paris.000webhostapp.com/index.php/item
require APPPATH . 'libraries/REST_Controller.php';
     
class User extends REST_Controller {
    
      /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('User_model');
       $this->load->model('ResAbonnement_model');
       
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_get($id = 0)
    {
        if(!empty($id)){
            $data = $this->User_model->get_user_by_id($id)->row_array();
        }else{
            $data = $this->User_model->get_all_user()->result_array();
        }
        $this->response($data, REST_Controller::HTTP_OK);
    }
    
    public function show_get($mail = "")
    {
        if(!empty($mail)){
            $data = $this->User_model->get_user_by_mail($mail)->row_array();
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function privative_get($id = 0) {
        if(!empty($id)){
            $data = $this->User_model->get_privative_reservation($id)->result_array();
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function equipment_get($id = 0) {
        if(!empty($id)){
            $data = $this->User_model->get_equipment_reservation($id)->result_array();
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function meal_get($id = 0) {
        if(!empty($id)){
            $data = $this->User_model->get_meal_reservation($id)->result_array();
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function events_get($id = 0) {
        if(!empty($id)){
            $data = $this->User_model->get_events($id)->result_array();
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $input = $this->input->post();
        $res = $this->User_model->insert_user($input);
     
        if($res) $this->response(['User created successfully.'], REST_Controller::HTTP_OK);
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
        $res = $this->User_model->update_user($id, $input);
     
        if($res) $this->response(['User updated successfully.'], REST_Controller::HTTP_OK);
        else $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id = 0)
    {
        if(!empty($id)) {
            $res = $this->User_model->delete_user($id);
            if($res) $this->response(['User deleted successfully.'], REST_Controller::HTTP_OK);
            else $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }
        else $this->response([
            'status' => FALSE,
            'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND);
    }

    public function abonnement_get($id = 0) {
        if(!empty($id)){
            $data = $this->ResAbonnement_model->get_by_user($id)->result_array();
            $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}