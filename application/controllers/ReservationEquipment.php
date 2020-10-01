<?php
//https://cowork-paris.000webhostapp.com/index.php/item
require APPPATH . 'libraries/REST_Controller.php';
     
class ReservationEquipment extends REST_Controller {
    
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
            $data = $this->db->get_where("reservation_equipment", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("reservation_equipment")->result();
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
        $this->db->insert('reservation_equipment', $input);
     
        $this->response(['Reservation created successfully.'], REST_Controller::HTTP_OK);
    } 
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function update_post($id)
    {
        
        $input = $this->input->post();
        $this->db->update('reservation_equipment', $input, array('id'=>$id));
     
        $this->response(['Reservation updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('reservation_equipment', array('id'=>$id));
       
        $this->response(['Reservation deleted successfully.'], REST_Controller::HTTP_OK);
    }
        
}