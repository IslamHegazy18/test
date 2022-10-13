
<?php

class Permission extends AppModel {

    //public $useDbConfig = 'mysql';
    //Employee belongs to Permission
     public $useTable = 'permissions';
     
    public $hasMany = array(
        'User' => array(
            'className' => 'User',
        //'conditions' => array('Employee.id' => 'Feedback.employee_id'),
        ),
    );

}

?>