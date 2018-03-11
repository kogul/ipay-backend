<?php

class orders extends CI_Controller{
    function getOrders(){
        $headers = $this->input->request_headers();
         $this->load->library('encryption');
         $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => 'passwordauthenticationsucks'
                    )
        );
        $id = $this->encryption->decrypt($headers["auth"]);
        $this->load->model('order');
        $orders = $this->order->getAllOrders($id);
        echo json_encode(array('success' => true, 'data'=>$orders));
    }
}