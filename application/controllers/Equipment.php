<?php
//https://cowork-paris.000webhostapp.com/index.php/item
require APPPATH . 'libraries/REST_Controller.php';
     
class Equipment extends REST_Controller {
    
      /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
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
            $data = $this->Equipment_model->get_by_id($id)->row_array();
        }else{
            $data =  $data = $this->Equipment_model->get_all()->result_array();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function space_get($id = 0)
    {
        if(!empty($id)){
            $data = $this->Equipment_model->get_by_space($id)->result_array();
            $this->response($data, REST_Controller::HTTP_OK);
        }
        else $this->response($data, REST_Controller::HTTP_OK);
    }


    public function index_post()
    {
        $input = $this->input->post();
        $res = $this->Equipment_model->insert($input);
     
        if($res) $this->response(['Created successfully.'], REST_Controller::HTTP_OK);
        else $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
    }

    public function update_post($id)
    {
        $input = $this->input->post();
        $res = $this->Equipment_model->update($id, $input);

        if($res) $this->response(['User updated successfully.'], REST_Controller::HTTP_OK);
        else $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST);
    }
}