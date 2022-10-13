<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Category extends AppModel {
    
    public $useTable = 'categories';
    
  public $belongsTo = array(
        'MainCategory' => array(
            'className' => 'MainCategory',
            'foreignKey' => 'main_category_id'
        )
    );
    public $hasMany = array(
        "Service_Provider" => array(
            "calssName" => "Service_Provider",
        )
    );
    

}
