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
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_get($id = 0)
    {
        if(!empty($id)){
            $data = $this->db->get_where("user", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("user")->result();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
    }
    
    public function show_get($mail = "")
    {
        if(!empty($mail)){
            $data = $this->db->get_where("user", ['email' => $mail])->result_array();
        }else{
            $data = [];
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
        $this->db->insert('user', $input);
     
        $this->response(['User created successfully.'], REST_Controller::HTTP_OK);
    } 
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function update_post($id)
    {
        
        $input = $this->input->post();
        $this->db->update('user', $input, array('id'=>$id));
     
        $this->response(['User updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('user', array('id'=>$id));
       
        $this->response(['User deleted successfully.'], REST_Controller::HTTP_OK);
    }
        
}