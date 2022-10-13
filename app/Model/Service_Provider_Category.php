<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Service_Provider_Category extends AppModel {

    public $useTable = 'service_provider_categories';
    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id'
        ),
        'Service_Provider' => array(
            'className' => 'Service_Provider',
            'foreignKey' => 'service_provider_id'
        )
    );
    

}
