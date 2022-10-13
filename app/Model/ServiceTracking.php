<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ServiceTracking extends AppModel {

    //public $useTable = 'servicetracking';
    public $belongsTo = array(
        "Reservation" => array(
            "calssName" => "Reservation",
            "foreignKey" => "reservation_id"
        ),
        "Service_Provider" => array(
            "calssName" => "Service_Provider",
            "foreignKey" => "service_provider_id"
        )
    );

}
