<?php

class products extends CI_Controller{
    function getProducts(){
       $this->load->model('product');
       $products = $this->product->getProducts();
       echo json_encode(array("success"=>true,"data"=>$products));
    }
}