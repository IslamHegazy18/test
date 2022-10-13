<?php

App::uses('AppController', 'Controller');

//require_once "ImapClient/ImapClientException.php";
//require_once "ImapClient/ImapClient.php";
//use SSilence\ImapClient\ImapClientException;
//use SSilence\ImapClient\ImapClient as Imap;

class AiwacsmessagesController extends AppController {

    public function index()
    {
        
        $this->loadModel('aiwa_cs_messages');
        
        $messagesQuery = "SELECT aiwa_cs_messages.id , aiwa_cs_messages.message , aiwa_cs_messages.created , aiwa_cs_messages.fromuserid_flag , users.fname,lname FROM `aiwa_cs_messages` left JOIN users ON users.id = aiwa_cs_messages.fromuserid 
                            where aiwa_cs_messages.seen = 0 AND aiwa_cs_messages.fromuserid_flag IN (2,3) GROUP by users.id;";

        $messages = $this->aiwa_cs_messages->query($messagesQuery);

            
        if (!empty($messages))
		{
            $this->set('messages',$messages);
            
        } else {
            $this->Session->setFlash("No Record Found", "default", array("class" => "error-message"));
        }
  
    }

    public function view($id = null)
    {
      
        $this->loadModel('aiwa_cs_messages'); 
        

        $mesUser = "SELECT aiwa_cs_messages.id , aiwa_cs_messages.message , aiwa_cs_messages.created , aiwa_cs_messages.fromuserid_flag , users.fname,lname FROM `aiwa_cs_messages` left JOIN users ON users.id = aiwa_cs_messages.fromuserid where aiwa_cs_messages.id = $id;";

        
        $userMsg = $this->aiwa_cs_messages->query($mesUser);
        
        if (!empty($userMsg))
		{
            $this->set('userMsg',$userMsg);
            
        } else {
            $this->Session->setFlash("No Record Found", "default", array("class" => "error-message"));
        }
         

    }


    public function add() {
        
        if ($this->request->is('post')) {

            $this->aiwa_cs_messages->create();

            if ($this->aiwa_cs_messages->save($this->request->data)) {

                return $this->redirect(array('action' => 'index'));

            } else {

                $this->Session->setFlash(__('The post could not be saved. Please, try again.'));

            }
        }
    }
    
}