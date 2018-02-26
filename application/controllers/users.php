<?php

class users extends CI_Controller{
    function login(){
        if($_POST){
            $u_email = $_POST['uname'];
            $u_pass = $_POST['pass'];
            $this->load->model('user');
            $udata = $this->user->login($u_email,$u_pass);
            unset($udata['u_pass']);
            $this->load->library('encryption');
            $this->encryption->initialize(
                array(
                    'cipher' => 'aes-256',
                    'mode' => 'ctr',
                    'key' => 'passwordauthenticationsucks'
                    )
            );
            $udata['token'] = $this->encryption->encrypt($udata['user_id']);
            echo json_encode($udata);
        }
    }
    function register(){
        if($_POST){
            $u_name = $this->input->post('uname',true);
            $phnum = $this->input->post('ph_num',true);
            $u_email = $this->input->post('u_mail',true);
            $pass = $this->input->post('psw',true);
            $conpass = $this->input->post('cpsw',true);
            $this->load->model('user');
            $check= $this->user->fetch($u_email);
            if(empty($check)){
            if(strlen($pass)>6){
                if($pass == $conpass){
                  if(is_numeric($phnum)){
                    $pass = md5($pass);
                      $udata = array(
                          'u_name' => $u_name,
                          'u_pass' => $pass,
                          'email' => $u_email,
                          'phone' => $phnum
                      );
                     $this->user->insert($udata);
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
                      $msg ="";
                      $this->load->library('email', $config);
                      $this->email->set_newline("\r\n");
                      $this->email->from('coder30597@gmail.com'); // change it to yours
                      $this->email->to($u_email);// change it to yours
                      $this->email->subject('Thanks for Registering with us');
                      $this->email->message($msg);
                      if ($this->email->send()) {
                          echo json_encode(array('success' => true, 'message' => "You have registered successfully. Please Login"));
                      } else {
                          show_error($this->email->print_debugger());
                      }
                  }else{
                      $msg = "Phone Number should only be numbers";
                       echo json_encode(array('success' => false, 'message' => $msg));
                  }
                }else{
                    $msg = "Enter the same password in both the fields";
                     echo json_encode(array('success' => false, 'message' => $msg));
                }
            }else{
                $msg = "Password should be more than 6 characters";
                 echo json_encode(array('success' => false, 'message' => $msg));
            }
            }else{
                $msg ="Already registered";
                echo json_encode(array('success' => false, 'message' => $msg));
            }
        }
    }
  }