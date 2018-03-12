<?php
class order extends CI_Model{
   function addCash($id,$amt){
   		$this->db->set('balance','balance + '.(int)$amt,FALSE);
   		$this->db->where('user_id',$id);
   		$this->db->update('wallet');
   }
   function addCard($cardInf){
   		$this->db->insert('cards',$cardInf);
   }
   function delCard($id,$cardNum){
   		$this->db->where('id',$id);
   		$this->db->where('cardNumber',$cardNumber);
   		$this->db->delete('cards');
   }
}