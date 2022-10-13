
<?php

class Service_Provider extends AppModel {

    //public $useDbConfig = 'mysql';
    //Employee belongs to Permission
     public $useTable = 'service_providers';
     
    public $hasMany = array(
        'Service_Provider_Category' => array(
            'className' => 'Service_Provider_Category',
        ),
        'Reservation' => array(
            'className' => 'Reservation',
        ),
        'Reservation_Details' => array(
            'className' => 'ReservationDetail',
        ),
        'Message' => array(
            'className' => 'Message',
        ),
        'Service_Provider_Complain' => array(
            'className' => 'Service_Provider_Complain',
        ),
        'ServiceTracking' => array(
            'className' => 'ServiceTracking',
        ),
        'User_Review' => array(
            'className' => 'User_Review',
        ),
        'Branch' => array(
            'className' => 'Branch',
        )
    );
     public $belongsTo = array(
        'Service_Type' => array(
            'className' => 'Service_Type',
            'foreignKey' => 'service_type_id'
        ),
         'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
         'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id'
        )
    );

}

?>