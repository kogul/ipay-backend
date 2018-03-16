<?php
class order extends CI_Model{
   function addCash($id,$amt){
   		$this->db->set('balance','balance + '.(int)$amt,FALSE);
   		$this->db->where('user_id',$id);
   		$this->db->update('User');
   }
   function addCard($cardInf){
   		$this->db->insert('cards',$cardInf);
   }
   function checkCard($cardNum){
         $this->db->where('cardNum');
         $result = $this->db->get('cards');
         return $result->result()
   }
   function delCard($id,$cardNum){
   		$this->db->where('id',$id);
   		$this->db->where('cardNumber',$cardNumber);
   		$this->db->delete('cards');
   }
   function pay($id,$pass,$amt){
         $this->db->where('user_id',$id);
         $this->db->where('u_pass',$pass);
         $this->db->set('balance','balance - '.(int)$amt,FALSE);
         $this->db->update('User');     
   }
   function checkBalance($id){
         $this->db->where('user_id',$id);
         $result = $this->db->get();
         return $result->row_array();
   }
}