
<?php

class Service_Type extends AppModel {

    //public $useDbConfig = 'mysql';
    //Employee belongs to Permission
     public $useTable = 'service_types';
     
    public $hasMany = array(
        'User' => array(
            'className' => 'User',
        ),
        'Required_Paper' => array(
            'className' => 'Required_Paper',
        ),
        'Service_Provider' => array(
            'className' => 'Service_Provider',
        ),
    );

}

?>