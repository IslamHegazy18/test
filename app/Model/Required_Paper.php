
<?php

class Required_Paper extends AppModel {

    //public $useDbConfig = 'mysql';
    //Employee belongs to Permission
     public $useTable = 'required_papers';
     
    public $hasMany = array(
        'Paper_Transaction' => array(
            'className' => 'Paper_Transaction',
        //'conditions' => array('Employee.id' => 'Feedback.employee_id'),
        ),
    );
     public $belongsTo = array(
        'Service_Type' => array(
            'className' => 'Service_Type',
            'foreignKey' => 'service_type_id'
        )
    );

}

?>