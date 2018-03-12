<?php

class wallet extends CI_Controller{
    function addBalance(){
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
        $this->load->model('cash');
        $amt = $this->input->post('amount');
        $this->cash->addCash($id,$amt);
        echo json_encode(array('success' => true, "message" => "You wallet balance has been updated"));
      
    }
    function makePayment(){

    }
    function addCard(){
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
        $cardNum = $this->input->post('card_num');

        $this->load->model('cash');
        $this->cash->addCard(array('cardNumber' => $cardNum, 'user_id' => $id));
        echo json_encode(array('success' => true, "message" => "Your card has successfully been added"));
    }
    function deleteCard(){
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
        $cardNum = $this->input->post('card_num');

        $this->load->model('cash');
        $this->cash->delCard($id,$cardNum);
    }
}