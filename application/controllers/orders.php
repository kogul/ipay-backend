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
    function addOrder(){
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
        $dateOforder=date('y-m-d');
        $dateOfdelivery="Pending";
        $address = $this->input->post('address',true);
        $mop = $this->input->post('mop',true);
        $u_email = $this->input->post('email',true);
        $this->load->model('order');
        $this->load->helper('string',true);
        $cardNum="";
        if($this->input->post('cardNum')){
        $cardNum = $this->input->post('cardNum',true);
    }
        $clustInd = $this->input->post('clusterInd'); 
        $ord_id = random_string('alnum', 16);
        $this->order->placeOrder(array(
                'id' => $ord_id,
                'user_id'=>$id,
                'data_of_order'=>$dateOforder,
                'date_of_delivery'=>$dateOfdelivery,
                'address'=>$address,
                'mode_of_payment'=>$mop,
                'card_num'=>$cardNum
        ));
        $this->order->confirmOrder($clustInd,$ord_id);
         $config = Array(
                          "ssl" => array(
                             "verify_peer" => false,
                             "verify_peer_name" => false,
                             "allow_self_signed" => true
                          ),
                          'protocol' => 'smtp',
                          'smtp_host' => 'ssl://smtp.googlemail.com',
                          'smtp_port' => 465,
                          'smtp_user' => 'coder30597@gmail.com', // change it to yours
                          'smtp_pass' => 'swagmeansitsme', // change it to yours
                          'smtp_crypto' => 'security', //can be 'ssl' or 'tls' for example
                          'mailtype' => 'html',
                          'charset' => 'iso-8859-1',
                          'wordwrap' => TRUE
                      );
                      $msg ="Your order has been placed. Your order number is ".$ord_id;
                      $this->load->library('email', $config);
                      $this->email->set_newline("\r\n");
                      $this->email->from('coder30597@gmail.com'); // change it to yours
                      $this->email->to($u_email);// change it to yours
                      $this->email->subject('Order Placed');
                      $this->email->message($msg);
        echo json_encode(array('success'=>true,'message'=>"Your order has been placed"));
    }
    function addToCart(){
         $this->load->helper('string');
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
         $pName = $this->input->post('pname');
         $qty = $this->input->post('quant');
         $cost = $this->input->post('cost');
         $this->load->model('order');
         $this->order->addCart(array(
            'user_id' => $id,
            'prod_name' =>$pName,
            'cluster_index'=>random_string('alnum', 16),
            'qty' =>$qty,
            'cost'=>$cost
         ));
         echo json_encode(array('success'=>true,'message'=>"Product has been added to cart."));
    }
    function deleteFromCart(){
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
         $pName = $this->input->post('pname');
         $this->load->model('order');
         $this->order->removeCart($id,$pName);
         echo json_encode(array('success'=>true,'message'=>"Product has been removed from cart"));
    }
    function getCart(){
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
         $cart = $this->order->getAllCart($id);
         echo json_encode(array('success'=>true,'data'=>$cart));
    }
}