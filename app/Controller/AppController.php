<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    function beforeFilter() {
        ini_set('display_errors', 'On');
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
        parent::beforeFilter();

        $webservice_array = array();
        $webservice_array = array('webservices' => array('check_User', 'login', 'sendSms', 'convert_APN_token', 'otp_check', 'resend_otp', 'register_user', 'register_serviceprovider', 'paper_resubmit', 'account_activation_status', 'paper_check', 'papers_check_fun', 'review_ratting_add', 'favourit_get', 'payments_transactions', 'favourit_add', 'favourit_check', 'favourit_remove', 'get_MainCategories', 'get_MainCategoriesList', 'get_ReviewServiceProvider', 'get_CATServiceProvider', 'get_NearbyServiceProvider', 'get_NearbyBranches', 'get_ServiceProviderServices', 'get_UserReservations_OnProvider', 'get_UserReservation_Details', 'add_UserReservation', 'readd_UserReservation', 'generateRandomString', 'pay_UserReservation', 'get_UserReservations', 'get_ServiceProviderReservations', 'readd_ServiceProviderReservation', 'confirm_ServiceProviderReservation', 'DoneClose_ServiceProviderReservation', 'cancel_Reservation', 'complain_Reservation', 'update_Profile', 'get_Company', 'update_Company', 'get_Service', 'update_Service', 'get_SubService', 'get_AllSubService', 'add_SubService', 'disable_SubService', 'get_Branches', 'add_Branch', 'disable_Branch', 'get_Addresses', 'add_Address', 'disable_Address', 'update_Configration', 'get_Messages_user', 'add_Message', 'get_Messages_serviceProvied'),
            'serviceproviders' => array(), 'paymentservices' => array(), 'pages' => array(), 'users' => array('terms_en' , 'terms_ar'));
        // if (!in_array(strtolower($this->request->params['action']), $webservice_array[strtolower($this->request->params['controller'])])) {
        if (in_array(!strtolower($this->request->params['controller']), array('webservices' , 'webservicestest' , 'users')) ) {
            if ($this->request->params['action'] != 'login') {
                if (empty($this->Session->read('User.User')))
                    $this->redirect(array("controller" => "users", "action" => "login"));
            }
            //$this->Check_Permissions();
        }
    }

    public function Check_Permissions() {

        $SuperAdmin = array('users' => array('welcome', 'login', 'logout', 'forget_password', 'profile', 'add', 'showall', 'edit'), 'areas' => array('add', 'get_areas', 'edit'), 'customers' => array('add', 'get_areas', 'showall', 'edit'), 'lines' => array('add', 'showall', 'edit'), 'publicholidays' => array('add', 'showall', 'edit'), 'products' => array('add', 'showall', 'edit'), 'ordersapproval' => array('showall', 'approve_order_fun'), 'dailyallowance' => array('showall', 'visits_details', 'set_dailyallowance'), 'reports' => $reports_array); //degree = 1
        $LineManager = array('users' => array('welcome', 'login', 'logout', 'forget_password', 'profile', 'add', 'showall', 'edit'), 'dailyallowance' => array('showall', 'visits_details', 'set_dailyallowance', 'get_reps'), 'ordersapproval' => array('showall', 'approve_order_fun', 'get_reps'), 'reports' => $reports_array); // degree = 2


        if (!in_array($this->Session->read('User.Employee.degree'), array(1, 6))) {
            if ($this->Session->read('User.Employee.degree') == 2) {
                if (!in_array(strtolower($this->request->params['action']), $LineManager[strtolower($this->request->params['controller'])])) {
                    $this->redirect(array("controller" => "users", "action" => "welcome"));
                }
            } else if ($this->Session->read('User.Employee.degree') == 4) {
                if (!in_array(strtolower($this->request->params['action']), $SuperVisor[strtolower($this->request->params['controller'])])) {
                    $this->redirect(array("controller" => "users", "action" => "welcome"));
                }
            } else if ($this->Session->read('User.Employee.degree') == 5) {
                if (!in_array(strtolower($this->request->params['action']), $Representative[strtolower($this->request->params['controller'])])) {
                    $this->redirect(array("controller" => "users", "action" => "welcome"));
                }
            }
        }
    }

}
