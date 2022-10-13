
<?php

class Voucher extends AppModel {

    //public $useDbConfig = 'mysql';
    //Employee belongs to Permission
     public $useTable = 'vouchers';
     public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'Service_Provider' => array(
            'className' => 'Service_Provider',
            'foreignKey' => 'service_provider_id'
        )
    );
 
   
}

?>