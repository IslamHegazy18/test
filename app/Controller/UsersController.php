<?php

App::uses('AppController', 'Controller');

//require_once "ImapClient/ImapClientException.php";
//require_once "ImapClient/ImapClient.php";
//use SSilence\ImapClient\ImapClientException;
//use SSilence\ImapClient\ImapClient as Imap;

class UsersController extends AppController {


    public function terms_ar()
    {

    }
    public function terms_en()
    {

    }
    public function welcome()
    {
        $this->loadModel("Service_Provider");
        $Active_Service_Provider = $this->Service_Provider->find("count", array("conditions" =>
            array("Service_Provider.approval_flag" => '1')));

        $this->loadModel("Service_Provider");
        $Pending_Service_Provider = $this->Service_Provider->find("count", array("conditions" =>
            array("Service_Provider.approval_flag" => '0')));

        $this->loadModel("Service_Provider");
        $Rejected_Service_Provider = $this->Service_Provider->find("count", array("conditions" =>
            array("Service_Provider.approval_flag" => '3')));

        $this->loadModel("User");
        $Active_User = $this->User->find("count", array("conditions" =>
            array("User.otp_status" => '1' , "User.permission_id" => '3')));

        $this->loadModel("User");
        $Pending_User = $this->User->find("count", array("conditions" =>
            array("User.otp_status" => '0' , "User.permission_id" => '3')));


        $this->set("Active_Service_Provider", $Active_Service_Provider);
        $this->set("Pending_Service_Provider", $Pending_Service_Provider);
        $this->set("Rejected_Service_Provider", $Rejected_Service_Provider);
        $this->set("Active_User", $Active_User);
        $this->set("Pending_User", $Pending_User);
    }

    public function contact_us()
    {
    }

    //Delete all the session and cookies in the application then redirect on the login screen
    public function logout()
    {

        $this->Session->delete("User");
        $this->Session->destroy();
        $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }

    public function login()
	{
        $this->set('fialdMassage', '');
        if (!empty($this->request->data))
		{
            $this->loadModel("User");
            $checkUser = $this->User->find("first", array(
                "conditions" => array(
                    "User.fname" => $this->request->data["User"]["name"],
                    "User.password" => $this->request->data["User"]["password"],
                    "User.status" => '1',
                    "User.permission_id IN" => array('777' , '888'),
            )));

            if (!empty($checkUser))
			{
                $this->Session->delete("User");
                $this->Session->write('User', $checkUser);

                $this->redirect(array("controller" => "users", "action" => "welcome"));
            } else {
                $fialdMassage = 'Login faild, Please check username and password';
                $this->set('fialdMassage', $fialdMassage);
            }
        }
    }

	public function showall()
	{
        $this->loadModel('User');
        $this->User->unbindModel(array(
            "hasMany" => array("Paper_Transaction", "Reservation", "Reservation_Details", "User_Favourit", "User_Review", "Address")
            ), array("hasOne" => array("Service_Provider"))
        );

        $this->paginate = array(
            'limit' => 10,
            'order' => array('User.modified' => 'desc')
        );

        $users = $this->paginate('User');

        $user_types = array();
        $user_types[1] = 'All';
        $user_types[2] = 'ServiceProvider';
        $user_types[3] = 'NormalUser';


        $this->set("users", $users);
        $this->set("user_types", $user_types);

        if (!empty($this->request->data))
		{
            $this->loadModel("User");
            $this->User->unbindModel(array(
                "hasMany" => array("Paper_Transaction", "Reservation", "Reservation_Details", "User_Favourit", "User_Review", "Address")
                ), array("hasOne" => array("Service_Provider"))
            );

            $user_name = $this->request->data['Users']['user_name'];

            $user_type = $this->request->data['Users']['service_type_id'];

            if ($user_type == 1)
			{
                $this->paginate = array(
                    'conditions' => array('User.fname LIKE' => "%" . $user_name . "%"),
                    'limit' => 10,
                    'order' => array('User.modified' => 'desc')
                );

                $users = $this->paginate('User');
            } else {

                $this->paginate = array(
                    'conditions' => array('User.permission_id' => $user_type, 'User.fname LIKE' => "%" . $user_name . "%"),
                    'limit' => 10,
                    'order' => array('User.modified' => 'desc')
                );

                $users = $this->paginate('User');
            }

            $this->set("users", $users);
        }
	}

	public function details($User_id = null)
	{
        $this->loadModel("User");
        $User = $this->User->find("first", array("conditions" => array("User.id" => $User_id)));

        $type   = $User['User']['service_type_id'];
        $userID = $User['User']['id'];

        $this->loadModel("Notification");
        $Notifications = $this->Notification->find("all", array("conditions" => array("Notification.user_id" => $userID)));

        $this->loadModel("Area");
        $Areas = $this->Area->find("all");

        $this->loadModel("Reservation");
        $Reservation = $this->Reservation->find("all", array("conditions" => array("Reservation.user_id" => $userID)));


        $action_flag = FALSE;
        $missing_flag = FALSE;


        $this->loadModel('Service_Type');
        $Service_Type = $this->Service_Type->find('all', array('recursive' => -1));

        $Service_Type_names = array();
        foreach ($Service_Type as $key => $array)
		{
            $Service_Type_names[$array['Service_Type']['id']] = $array['Service_Type']['name'];
        }


        $this->loadModel('Permission');
        $User_Permission_type = $this->Permission->find('all', array('recursive' => -1));

		$User_Permissions = array();
        foreach ($User_Permission_type as $key => $array)
		{
            $User_Permissions[$array['Permission']['id']] = $array['Permission']['name'];
        }


        if (!empty($User))
		{
            $this->set("User", $User);
            $this->set("Notifications", $Notifications);
            $this->set("Reservation", $Reservation);
            $this->set("action_flag", $action_flag);
            $this->set("missing_flag", $missing_flag);
            $this->set("Service_Type_names", $Service_Type_names);
			$this->set("User_Permissions", $User_Permissions);

        }

    }

   


}
