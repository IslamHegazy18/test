<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Reservation extends AppModel {

    public $useTable = 'reservations';
    
    public $belongsTo = array(
        "User" => array(
            "calssName" => "User",
            "foreignKey" => "user_id"
        ),
        "Address" => array(
            "calssName" => "Address",
            "foreignKey" => "address_id"
        ),
        "Service_Provider" => array(
            "calssName" => "Service_Provider",
            "foreignKey" => "service_provider_id"
        ),
        "Reservation_Status" => array(
            "calssName" => "Reservation_Status",
            "foreignKey" => "status"
        )
    );
    /*public $hasOne = array(
        'FawryPay' => array(
            'className' => 'FawryPay',
            'foreignKey' => 'fawryRefNumber',
            'conditions' => array('Reservation.trans_ref' => 'FawryPay.fawryRefNumber' ),
        )
    );*/
    public $hasMany = array(
        'Service_Traking' => array(
            'className' => 'ServiceTracking',
        //'conditions' => array('Employee.id' => 'Feedback.employee_id'),
        ),
        'Reservation_Details' => array(
            'className' => 'ReservationDetail',
        //'conditions' => array('Employee.id' => 'Feedback.employee_id'),
        ),
        'Service_Provider_Complain' => array(
            'className' => 'Service_Provider_Complain',
        //'conditions' => array('Employee.id' => 'Feedback.employee_id'),
        ),
    );

}
