<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Service_Provider_Complain extends AppModel {

    public $useTable = 'service_provider_complains';
    public $belongsTo = array(
        'Service_Provider' => array(
            'className' => 'Service_Provider',
            'foreignKey' => 'service_provider_id'
        ),
        'Complain' => array(
            'className' => 'Complain',
            'foreignKey' => 'complain_id'
        ),
        'Reservation' => array(
            'className' => 'Reservation',
            'foreignKey' => 'reservation_id'
        )
    );

}
