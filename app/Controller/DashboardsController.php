<?php

/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class DashboardsController extends AppController {
    //public $helpers = array('GoogleMap');

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();
    var $components = array('Cookie');

    public function totals() {
        if (!empty($this->request->data)) {

            if (!empty($this->request->data['Service_Provider']['VisitDate_from']) && !empty($this->request->data['Service_Provider']['VisitDate_to'])) {
                $this->loadModel("Service_Provider");

                // $this->Service_Provider->virtualFields['grade'] = '(SUM(Visit.visit_grade)/SUM(Visit.total_grade))*100';
                $TotalServiceProvider = $this->Service_Provider->find("count", array('recursive' => -1,
                    "conditions" => $this->filter($this->request->data['Service_Provider']['VisitDate_from'], $this->request->data['Service_Provider']['VisitDate_to'])));

                $Service_Providers_date = $this->Service_Provider->find("all", array('recursive' => -1,
                    "conditions" => $this->filter($this->request->data['Service_Provider']['VisitDate_from'], $this->request->data['Service_Provider']['VisitDate_to']),
                    'fields' => array('DATE(Service_Provider.created) as day', 'COUNT(*) as Service_ProviderCount'),
                    'group' => array('DATE(Service_Provider.created)'),
                    'order' => array('day ASC')));

                $Service_Providers_type = $this->Service_Provider->find("all", array('recursive' => -1,
                    "conditions" => $this->filter($this->request->data['Service_Provider']['VisitDate_from'], $this->request->data['Service_Provider']['VisitDate_to']),
                    'fields' => array('Service_Provider.category_id', 'COUNT(*) as Service_ProviderCount'),
                    'group' => array('Service_Provider.category_id')));

                $this->loadModel("User");
                $Users_type = $this->User->find("all", array('recursive' => -1,
                    "conditions" => $this->filter_User($this->request->data['Service_Provider']['VisitDate_from'], $this->request->data['Service_Provider']['VisitDate_to']),
                    'fields' => array('User.service_type_id', 'COUNT(*) as UserCount'),
                    'group' => array('User.service_type_id')));


                $jsonARR_Service_Providers = array();
                $jsonARR_Service_Providers_day = array();
                $jsonARR_User = array();


                foreach ($Service_Providers_type as $key => $Service_Provider) {
                    $temp = array();

                    $this->loadModel("Category");
                    $Category = $this->Category->find("first", array('recursive' => -1, 'conditions' => array('Category.id' => $Service_Provider['Service_Provider']['category_id'])));

                    $temp['y'] = (int) $Service_Provider[0]["Service_ProviderCount"];
                    $temp['label'] = $Category['Category']['name_en'];

                    array_push($jsonARR_Service_Providers, $temp);
                }

                foreach ($Service_Providers_date as $key => $Service_Provider) {
                    $temp = array();


                    $temp['y'] = (int) $Service_Provider[0]["Service_ProviderCount"];
                    $temp['label'] = $Service_Provider[0]['day'];
                    array_push($jsonARR_Service_Providers_day, $temp);
                }

                foreach ($Users_type as $key => $User) {
                    $temp = array();

                    $this->loadModel("Service_Type");
                    $Service_Type = $this->Service_Type->find("first", array('recursive' => -1, 'conditions' => array('Service_Type.id' => $User['User']['service_type_id'])));


                    $temp['y'] = (int) $User[0]["UserCount"];
                    $temp['label'] = $Service_Type['Service_Type']['name'];
                    array_push($jsonARR_User, $temp);
                }

                $this->set("TotalServiceProvider", $TotalServiceProvider);
                $this->set("Alldata_Service_Providers_day", json_encode($jsonARR_Service_Providers_day));
                $this->set("Alldata_Service_Providers", json_encode($jsonARR_Service_Providers));
                $this->set("Alldata_User", json_encode($jsonARR_User));
            } else {
                $this->Session->setFlash("Error ,Please Fill All The Requierd Data", "default", array("class" => "error-message"));
            }
        }
    }

    function filter($Date_From = null, $Date_To = null) {
        $conditions = array();
        if (!empty($Date_From) && !empty($Date_To)) {
            $date_from = date("Y-m-d H:i:s", strtotime($Date_From));
            $date_to = date("Y-m-d H:i:s", strtotime($Date_To));
            $conditions['Service_Provider.created <='] = $date_to;
            $conditions['Service_Provider.created >='] = $date_from;
        } else if (!empty($Date_From) && empty($Date_To)) {
            $date_from = date("Y-m-d H:i:s", strtotime($Date_From));
            $conditions['Service_Provider.created >='] = $date_from;
        } else if (empty($Date_From) && !empty($Date_To)) {
            $date_to = date("Y-m-d H:i:s", strtotime($Date_To));
            $conditions['Service_Provider.created <='] = $date_to;
        }

        //$conditions['Visit.visit_status'] = '1';
        //$conditions['Visit.visit_type'] = array('0', '1', '2');
        //$conditions['YEAR(Order.date)'] = $Year;
        return $conditions;
    }

    function filter_User($Date_From = null, $Date_To = null) {
        $conditions = array();
        if (!empty($Date_From) && !empty($Date_To)) {
            $date_from = date("Y-m-d H:i:s", strtotime($Date_From));
            $date_to = date("Y-m-d H:i:s", strtotime($Date_To));
            $conditions['User.created <='] = $date_to;
            $conditions['User.created >='] = $date_from;
        } else if (!empty($Date_From) && empty($Date_To)) {
            $date_from = date("Y-m-d H:i:s", strtotime($Date_From));
            $conditions['User.created >='] = $date_from;
        } else if (empty($Date_From) && !empty($Date_To)) {
            $date_to = date("Y-m-d H:i:s", strtotime($Date_To));
            $conditions['User.created <='] = $date_to;
        }

        //$conditions['Visit.visit_status'] = '1';
        //$conditions['Visit.visit_type'] = array('0', '1', '2');
        //$conditions['YEAR(Order.date)'] = $Year;
        return $conditions;
    }

}
