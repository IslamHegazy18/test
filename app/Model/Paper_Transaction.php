
<?php

class Paper_Transaction extends AppModel {

    //public $useDbConfig = 'mysql';
    //Employee belongs to Permission
    public $useTable = 'paper_transactions';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'Required_Paper' => array(
            'className' => 'Required_Paper',
            'foreignKey' => 'required_paper_id'
        )
    );

}

?>