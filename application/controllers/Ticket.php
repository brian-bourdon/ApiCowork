<?php
//https://cowork-paris.000webhostapp.com/index.php/item
require APPPATH . 'libraries/REST_Controller.php';
     
class Ticket extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
     }

     public function index_get($id = 0)
    {
        if(!empty($id)){
            $data = $this->db->get_where("ticket", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("ticket")->result();
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
        if($res) $this->response(['Created successfully.'], REST_Controller::HTTP_OK);
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
        $this->db->update('ticket', $input, array('id'=>$id));
     
        $this->response(['Updated successfully.'], REST_Controller::HTTP_OK);
    }

}