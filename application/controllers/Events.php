<?php
//https://cowork-paris.000webhostapp.com/index.php/item
require APPPATH . 'libraries/REST_Controller.php';
     
class Events extends REST_Controller {
    
      /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('Events_model');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_get($id = 0)
    {
        if(!empty($id)){
            $data = $this->Events_model->get_by_id($id)->row_array();
        }else{
            $data = $this->Events_model->get_all()->result_array();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        $input = $this->input->post();
        $res = $this->Events_model->insert($input);
     
        if($res) $this->response(['Created successfully.'], REST_Controller::HTTP_OK);
        else $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
    } 

    public function update_post($id)
    {
        $input = $this->input->post();
        $res = $this->Events_model->update($id, $input);
     
        if($res) $this->response(['User updated successfully.'], REST_Controller::HTTP_OK);
        else $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function space_get($id = 0)
    {
        if(!empty($id)){
            $res = $this->db->get_where("events", ['id_space' => $id])->result_array();
            if($res) $this->response($data, REST_Controller::HTTP_OK);
        }else{
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}