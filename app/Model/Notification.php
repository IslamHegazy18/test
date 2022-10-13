
<?php

class Notification extends AppModel {

    //public $useDbConfig = 'mysql';
    //Employee belongs to Permission
    public $useTable = 'notifications';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );

}

?>