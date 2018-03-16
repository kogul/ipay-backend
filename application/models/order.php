<?php
class order extends CI_Model{
    function getAllOrders($id){
    	$this->db->select("id,product,cost,data_of_order,date_of_delivery,address,mode_of_payment,u_name");
    	$this->db->from('orders');
    	$this->db->join('User','orders.user_id = User.user_id');
        $this->db->where('orders.user_id',$id);
        $query = $this->db->get();
        return $query->result();
    }
    function placeOrder(){
    	
    }
}