<?php
//https://cowork-paris.000webhostapp.com/index.php/item
require APPPATH . 'libraries/REST_Controller.php';
     
class PrivativeSpace extends REST_Controller {
    
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
            $data = $this->db->get_where("espace_privatif", ['id_space' => $id])->result_array();
        }else{
            $data = $this->db->get("espace_privatif")->result();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
    }
}