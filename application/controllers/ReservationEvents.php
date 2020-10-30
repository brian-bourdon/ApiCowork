<?php
//https://cowork-paris.000webhostapp.com/index.php/item
require APPPATH . 'libraries/REST_Controller.php';
     
class ReservationEvents extends REST_Controller {
    
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
            $data = $this->db->get_where("reservation_events", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("reservation_events")->result();
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
        $this->db->insert('reservation_events', $input);
        
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
        $this->db->update('reservation_events', $input, array('id'=>$id));
     
        $this->response(['Reservation updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('reservation_events', array('id'=>$id));
       
        $this->response(['Reservation deleted successfully.'], REST_Controller::HTTP_OK);
    }

    public function total_get($id) {
        if(!empty($id)){
            $this->db->where('id_events', $id);
            $this->db->from('reservation_events');
            $data = $this->db->count_all_results();
            $this->response($data, REST_Controller::HTTP_OK);
        }
    }

    public function isResByUser_get($id_user) {
        if(!empty($id_user)){
            $this->db->where('id_user', $id_user);
            $this->db->from('reservation_events');
            $data = $this->db->count_all_results();
            $this->response($data, REST_Controller::HTTP_OK);
        }
    }

    public function events_get($id_events = 0) {
        if(!empty($id_events)) {
            $id_space = $this->Events_model->get_by_id($id_events)->row();
            if(!empty($id_space)) {
                $res = $this->Events_model->get_by_space($id_space->id_space)->result_array();
                if($res) $this->response($res, REST_Controller::HTTP_OK);
                else $this->response(array(), REST_Controller::HTTP_BAD_REQUEST);
            } else $this->response(array(), REST_Controller::HTTP_OK);
        }
        else $this->response([
            'status' => FALSE,
            'message' => 'No equipment found'
            ], REST_Controller::HTTP_NOT_FOUND);
    }
}