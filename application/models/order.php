<?php
class order extends CI_Model{
    function getAllOrders($id){
        $this->db->where('user_id',$id);
        $query = $this->db->get('orders');
        return $query->result();
    }
}