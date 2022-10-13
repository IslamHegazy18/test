<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User extends AppModel {

    public $useTable = 'users';
    
    public $belongsTo = array(
        'Permission' => array(
            'className' => 'Permission',
            'foreignKey' => 'permission_id'
        ),
        'Service_Type' => array(
            'className' => 'Service_Type',
            'foreignKey' => 'service_type_id'
        )
    );
    public $hasOne = array(
        'Service_Provider' => array(
            'className' => 'Service_Provider',
            //'conditions' => array('Profile.published' => '1'),
            //'dependent' => true
        )
    );
    public $hasMany = array(
        "Paper_Transaction" => array(
            "calssName" => "Paper_Transaction",
        ),
        "Reservation" => array(
            "calssName" => "Reservation",
        ),
        'Reservation_Details' => array(
            'className' => 'ReservationDetail',
        ),
        "User_Review" => array(
            "calssName" => "User_Review",
        ),
        "User_Favourit" => array(
            "calssName" => "User_Favourit",
        ),
        "Address" => array(
            "calssName" => "Address",
        ),
        //"Message" => array(
        //    "calssName" => "Message",
        //    'conditions' => array('Employee.id' => 'Feedback.employee_id'),
       // )
    );

}
