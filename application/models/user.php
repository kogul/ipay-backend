<?php
class user extends CI_Model{
    function login($email,$pass){
         $this->db->select('*');
         $this->db->where('email',$email);
         $this->db->where('u_pass',$pass);
         $res =$this->db->get('User');
        return $res->row_array();
    }
    function insert($udata){
        $this->db->insert('User',$udata);
    }
    function fetch($email){
        $this->db->select('*');
        $this->db->where('email',$email);
        $res = $this->db->get('User');
        return $res->row_array();
    }
    function updateUser($udata){
        $this->db->where('user_id', $udata['user_id']);
        $this->db->update('User',$udata);
    }
}