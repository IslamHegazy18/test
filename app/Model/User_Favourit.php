<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_Favourit extends AppModel {

    public $useTable = 'user_favourits';
    public $belongsTo = array(
        "User" => array(
            "calssName" => "User",
            "foreignKey" => "user_id"
        ),
        "Service_Provider" => array(
            "calssName" => "Service_Provider",
            "foreignKey" => "service_provider_id"
        )
    );

}
