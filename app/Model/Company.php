<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Company extends AppModel {
    
    public $useTable = 'companies';
    
  public $belongsTo = array(
        'Service_Provider' => array(
            'className' => 'Service_Provider',
            'foreignKey' => 'service_provider_id'
        ),
      'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
    

}
