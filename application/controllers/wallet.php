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
        $cardNum = $this->input->post('cardNumber');
        $card = $this->cash->checkCard($cardNum);
        if(empty($card)){
            $this->cash->addCard(array('cardNumber' => $cardNum, 'user_id' => $id));        
        }
        $this->cash->addCash($id,$amt);
        echo json_encode(array('success' => true, "message" => "You wallet balance has been updated"));
    }
    function makePayment(){
        $pass = $this->db->post('pass');
        $amt = $this->db->post('amount');
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
        $balance = $this->cash->checkBalance($id);
        $balance = $balance['wallet'];
        if(intval($balance)>intval($amt)){
            echo json_encode(array('success' => false, "message" => "Insufficient Balance"));
        }else{
        $this->cash->pay($id,md5($pass),$amt);
        echo json_encode(array('success' => true, "message" => "Payment Successful"));
    }
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