<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ReservationDetail extends AppModel {

    public $useTable = 'reservation_details';
    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id'
        ), 'Service_Provider_Category' => array(
            'className' => 'Service_Provider_Category',
            'foreignKey' => 'service_provider_category_id'
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'Service_Provider' => array(
            'className' => 'Service_Provider',
            'foreignKey' => 'service_provider_id'
        ),
        'Reservation' => array(
            'className' => 'Reservation',
            'foreignKey' => 'reservation_id'
        )
    );

}
