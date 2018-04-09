<?php
class order extends CI_Model{
    function getAllOrders($id){
    	$this->db->select("*");
    	$this->db->from('orders');
    	$this->db->join('cart','orders.user_id = cart.user_id');
        $this->db->where('orders.user_id',$id);
        $this->db->where('cart.ord_id is NOT NULL',NULL,FALSE);
        $query = $this->db->get();
        return $query->result();
    }
    function addCart($data){
        $this->db->insert('cart',$data);    	
    }
    function removeCart($id,$pName){
        $this->db->where('user_id',$id);
        $this->db->where('ord_id is NOT NULL', NULL, FALSE);
        $this->db->where('prod_name',$pName);
        $this->db->delete('cart');
    }
    function placeOrder($data){
        $this->db->insert('orders',$data);
    }
    function confirmOrder($cluster_ind,$ord_id){
        $this->db->set('ord_id',$ord_id);
        $this->db->where('cluster_index',$cluster_ind);
        $this->db->update('cart');
    }
    function getAllCart($id){
        $this->db->where('user_id',$id);
        $this->db->where('ord_id is NULL',NULL, FALSE);
        $result = $this->db->get('cart');
        return $result->result();
    }
}