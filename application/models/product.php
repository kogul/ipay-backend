<?php
class product extends CI_Model{
     function getProducts(){
        $results = $this->db->get('products');
        return $results->result();
     }
}