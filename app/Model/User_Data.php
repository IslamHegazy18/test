<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_Data extends AppModel {
    
    public $useTable = 'users_data';
    
  public $belongsTo = array(
  
      'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
    

}
