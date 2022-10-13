<?php

/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 55
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * get_DailyVisitsCustomersList
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

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 * aa
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class WebServicesController extends AppController {

    public function check_User($Username = null, $Password = null) {
        $this->loadModel("User");
        $checkUser = $this->User->find("first", array(
            "conditions" => array(
                "email" => $Username,
                "password" => $Password,
                "status" => '1'
        )));
        return $checkUser;
    }

    public function login() {
//$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            $return = array();
            if (!empty($checkUser)) {
                $return ['status'] = "success";
                $return ['result'] = $checkUser['User'];
            } else {
                $return ['status'] = "failed";
            }
        } else {
            $return ['status'] = "Missing Parameter";
        }
        echo json_encode($return);
        exit;
    }

//
    public function register_user() {
        //$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $fname = $json['fname'];
        $lname = $json['lname'];
        $email = $json['email'];
        $phone = $json['phone'];
        $gender = $json['gender'];
        $password = $json['password'];
        $birthday = $json['birthday'];


        $user_arr = array();
        $user_arr['User']['fname'] = $fname;
        $user_arr['User']['lname'] = $lname;
        $user_arr['User']['email'] = $email;
        $user_arr['User']['phone'] = $phone;
        $user_arr['User']['gender'] = $gender;
        $user_arr['User']['password'] = $password;
        $user_arr['User']['birthday'] = $birthday;
        $user_arr['User']['permission_id'] = '3';
        $user_arr['User']['service_type_id'] = '0';
        $user_arr['User']['status'] = '1';

        $this->loadModel("User");
        $UserIdintifier = $this->User->find("all", array('recursive' => -1,
            "conditions" => array(
                'OR' => array(
                    'User.email' => $email,
                    'User.phone' => $phone,
                )
        )));

        if (empty($UserIdintifier)) {
            $this->loadModel("User");
            $this->User->create();
            if ($this->User->save($user_arr)) {
                $user_Lastid = $this->User->getLastInsertID();
                $flag = TRUE;
                $this->loadModel("User");
                $UserData = $this->User->find("first", array('recursive' => -1,
                    "conditions" => array(
                        "id" => $user_Lastid
                )));
            } else {
                $return['status'] = 'faile';
                $return['result'] = 'Cannot Insert User';
                header("Content-Type: application/json", true);
                echo json_encode($return);
                exit;
            }

            $return = array();
            if ($flag) {
                $return['status'] = 'success';
                $return['result'] = $UserData['User'];
            } else {
                $return['status'] = 'faile';
                $return['result'] = 'Error Happened Please Try Again Later';
            }
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'This emai/phone is already registered';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function register_serviceprovider() {
        //$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $fname = $json['fname'];
        $lname = $json['lname'];
        $email = $json['email'];
        $phone = $json['phone'];
        $gender = $json['gender'];
        $password = $json['password'];
        $birthday = $json['birthday'];
        ////////////////////
        $type = $json['type'];
        $paper1 = $json['paper1'];
        $paper2 = $json['paper2'];
        $paper3 = $json['paper3'];
        $paper4 = $json['paper4'];
        //////////////////////
        $servicename = $json['servicename'];
        $serviceinfo = $json['serviceinfo'];
        $service_image = $json['service_image'];
        $officialphone = $json['officialphone'];
        $area = $json['area'];
        $address = $json['address'];
        $maincategory_id = $json['maincategory_id'];
        //////////////////////


        $user_arr = array();
        $user_arr['User']['fname'] = $fname;
        $user_arr['User']['lname'] = $lname;
        $user_arr['User']['email'] = $email;
        $user_arr['User']['phone'] = $phone;
        $user_arr['User']['gender'] = $gender;
        $user_arr['User']['password'] = $password;
        $user_arr['User']['birthday'] = $birthday;
        $user_arr['User']['permission_id'] = '2';
        $user_arr['User']['service_type_id'] = $type;
        $user_arr['User']['status'] = '1';





        $allpaper_arr = array();
        $allpaper_arr[] = $paper1;
        $allpaper_arr[] = $paper2;
        $allpaper_arr[] = $paper3;
        $allpaper_arr[] = $paper4;
        $flag = FALSE;
        $date = new DateTime();
        $Timestamp = $date->getTimestamp();


        $this->loadModel("User");
        $UserIdintifier = $this->User->find("all", array('recursive' => -1,
            "conditions" => array(
                'OR' => array(
                    'User.email' => $email,
                    'User.phone' => $phone,
                )
        )));

        if (empty($UserIdintifier)) {
            $this->loadModel("User");
            $this->User->create();
            if ($this->User->save($user_arr)) {
                $user_Lastid = $this->User->getLastInsertID();

                $destination_path = getcwd() . DIRECTORY_SEPARATOR . 'upload/';
                $target_path = $destination_path . basename($user_Lastid . $Timestamp . '.PNG');
                $data = base64_decode($service_image);
                file_put_contents($target_path, $data);
                $Imageurl = 'app/webroot/upload/' . $user_Lastid . $Timestamp . '.PNG';


                $serviceProvider_arr = array();
                $serviceProvider_arr['Service_Provider']['service_name_en'] = $servicename;
                $serviceProvider_arr['Service_Provider']['service_name_ar'] = $servicename;
                $serviceProvider_arr['Service_Provider']['service_description_en'] = $serviceinfo;
                $serviceProvider_arr['Service_Provider']['service_description_ar'] = $serviceinfo;
                $serviceProvider_arr['Service_Provider']['service_type_id'] = $type;
                $serviceProvider_arr['Service_Provider']['category_id'] = $maincategory_id;
                $serviceProvider_arr['Service_Provider']['phone'] = $officialphone;
                $serviceProvider_arr['Service_Provider']['address'] = $address;
                $serviceProvider_arr['Service_Provider']['government_id'] = '1';
                $serviceProvider_arr['Service_Provider']['area_id'] = $area;
                $serviceProvider_arr['Service_Provider']['user_id'] = $user_Lastid;
                $serviceProvider_arr['Service_Provider']['image'] = $Imageurl;
                $serviceProvider_arr['Service_Provider']['approval_flag'] = '1';


                $this->loadModel("Service_Provider");
                $this->Service_Provider->create();
                if ($this->Service_Provider->save($serviceProvider_arr)) {
                    $Service_Provider_Lastid = $this->Service_Provider->getLastInsertID();

                    for ($index = 1; $index <= 4; $index++) {

                        $destination_path = getcwd() . DIRECTORY_SEPARATOR . 'upload/';
                        $target_path = $destination_path . basename($Service_Provider_Lastid . $Timestamp . $index . '.PNG');
                        $data = base64_decode($allpaper_arr[$index - 1]);
                        file_put_contents($target_path, $data);
                        $Imageurl = 'app/webroot/upload/' . $Service_Provider_Lastid . $Timestamp . $index . '.PNG';

                        $paper_arr = array();
                        $paper_arr['Paper_Transaction']['user_id'] = $user_Lastid;
                        $paper_arr['Paper_Transaction']['required_paper_id'] = $index;
                        $paper_arr['Paper_Transaction']['attachment'] = $Imageurl;
                        $paper_arr['Paper_Transaction']['approval_flag'] = '2';

                        $this->loadModel("Paper_Transaction");
                        $this->Paper_Transaction->create();
                        if ($this->Paper_Transaction->save($paper_arr)) {
                            $flag = TRUE;
                            $this->loadModel("User");
                            $UserData = $this->User->find("first", array('recursive' => -1,
                                "conditions" => array(
                                    "id" => $user_Lastid
                            )));
                        }
                    }
                }
            } else {
                $return['status'] = 'faile';
                $return['result'] = 'Cannot Insert User';
                header("Content-Type: application/json", true);
                echo json_encode($return);
                exit;
            }

            $return = array();
            if ($flag) {
                $return['status'] = 'success';
                $return['result'] = $UserData['User'];
            } else {
                $return['status'] = 'faile';
                $return['result'] = 'Error Happened Please Try Again Later';
            }
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'This emai/phone is already registered';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_MainCategories() {
        $this->loadModel('Category');
        $Categories_data = $this->Category->find('all', array('conditions' => array('Category.parent_id' => '0')));



        $return = array();
        if (!empty($Categories_data)) {
            $return['status'] = 'success';
            $return['result'] = $Categories_data;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_MainCategoriesList() {
        $this->loadModel('Category');
        $Categories_data = $this->Category->find('all', array('conditions' => array('Category.parent_id' => '0')));

        $array = array();
        foreach ($Categories_data as $key => $value) {
            $array[$value['Category']['id']] = $value['Category']['name_en'];
        }


        $return = array();
        if (!empty($array)) {
            $return['status'] = 'success';
            $return['result'] = $array;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_CATServiceProvider() {
        //$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $CategoryID = $json['CategoryID'];
        //$CategoryID = '2';

        $this->loadModel('Service_Provider');
        $this->Service_Provider->unbindModel(array(
            "hasMany" => array("Reservation", "Message", "Service_Provider_Complain", "Service_Tracking")
        ));


        $Service_Providers = $this->Service_Provider->find('all', array('conditions' => array('Service_Provider.category_id' => $CategoryID, 'Service_Provider.approval_flag' => '1')));

        $Service_Providers_arr = array();
        foreach ($Service_Providers as $key => $value) {
            $temp = array();
            $temp['id'] = $value['Service_Provider']['id'];
            $temp['service_name_en'] = $value['Service_Provider']['service_name_en'];
            $temp['service_name_ar'] = $value['Service_Provider']['service_name_ar'];
            $temp['service_description_en'] = $value['Service_Provider']['service_description_en'];
            $temp['service_description_ar'] = $value['Service_Provider']['service_description_ar'];
            $temp['categroty_name_en'] = $value['Category']['name_en'];
            $temp['categroty_name_ar'] = $value['Category']['name_ar'];
            $temp['image'] = $value['Service_Provider']['image'];
            $temp['Service_Type'] = $value['Service_Type']['name'];
            $total_rating = 0;
            $count_rating = 0;
            $review_arr = array();
            foreach ($value['User_Review'] as $key1 => $review) {
                if (!empty($review['review'])) {
                    $tmep_review = array();
                    $tmep_review['id'] = $review['id'];
                    $tmep_review['review'] = $review['review'];
                    $tmep_review['created'] = $review['created'];
                    $this->loadModel('User');
                    $User_data = $this->User->find('first', array('conditions' => array('User.id' => $review['user_id'])));
                    $tmep_review['username'] = $User_data['User']['fname'] . ' ' . $User_data['User']['lname'];
                    array_push($review_arr, $tmep_review);
                }
                if (!empty($review['rate'])) {
                    $count_rating++;
                    $total_rating = $total_rating + $review['rate'];
                }
            }
            if ($count_rating > 0)
                $temp['rating'] = $total_rating / $count_rating;
            else
                $temp['rating'] = 0;
            $temp['review'] = $review_arr;
            $Icon_arr = array();
            $CATImage_arr = array();
            $CATData_arr = array();
            foreach ($value['Service_Provider_Category'] as $key4 => $category) {
                $tempData = array();
                array_push($CATImage_arr, $category['image']);
                $this->loadModel('Category');
                $Categories_data = $this->Category->find('first', array('conditions' => array('Category.id' => $category['category_id'])));
                array_push($Icon_arr, $Categories_data['Category']['icon']);
                $tempData['id'] = $Categories_data['Category']['id'];
                $tempData['name'] = $Categories_data['Category']['name_en'];
                $tempData['image'] = $category['image'];
                $tempData['price'] = $category['price'] . ' EGP';
                $tempData['details_en'] = $category['details_en'];
                array_push($CATData_arr, $tempData);
            }
            $temp['icons'] = $Icon_arr;
            $temp['images'] = $CATImage_arr;
            $temp['catdata'] = $CATData_arr;

            array_push($Service_Providers_arr, $temp);
        }

        $return = array();
        if (!empty($Service_Providers)) {
            $return['status'] = 'success';
            $return['result'] = $Service_Providers_arr;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_ServiceProviderServices() {
        //$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $ServiceProviderID = $json['ServiceProviderID'];
        //$CategoryID = '1';

        $this->loadModel('Service_Provider_Category');
        $Service_Provider_Categories = $this->Service_Provider_Category->find('all', array('conditions' => array('Service_Provider_Category.service_provider_id' => $ServiceProviderID)));

        $Service_Provider_Categories_arr = array();
        foreach ($Service_Provider_Categories as $key => $value) {
            $temp = array();
            $temp['id'] = $value['Service_Provider']['id'];
            $temp['service_name_en'] = $value['Service_Provider']['service_name_en'];
            $temp['service_name_ar'] = $value['Service_Provider']['service_name_ar'];
            $temp['service_description_en'] = $value['Service_Provider']['service_description_en'];
            $temp['service_description_ar'] = $value['Service_Provider']['service_description_ar'];
            $temp['categroty_name_en'] = $value['Category']['name_en'];
            $temp['categroty_name_ar'] = $value['Category']['name_ar'];
            $temp['image'] = $value['Service_Provider']['image'];
            $temp['Service_Type'] = $value['Service_Type']['name'];
            $total_rating = 0;
            $count_rating = 0;
            $review_arr = array();
            foreach ($value['User_Review'] as $key1 => $review) {
                if (!empty($review['review'])) {
                    $tmep_review = array();
                    $tmep_review['id'] = $review['id'];
                    $tmep_review['review'] = $review['review'];
                    $tmep_review['created'] = $review['created'];
                    $this->loadModel('User');
                    $User_data = $this->User->find('first', array('conditions' => array('User.id' => $review['user_id'])));
                    $tmep_review['username'] = $User_data['User']['fname'] . ' ' . $User_data['User']['lname'];
                    array_push($review_arr, $tmep_review);
                }
                if (!empty($review['rate'])) {
                    $count_rating++;
                    $total_rating = $total_rating + $review['rate'];
                }
            }
            if ($count_rating > 0)
                $temp['rating'] = $total_rating / $count_rating;
            else
                $temp['rating'] = 0;
            $temp['review'] = $review_arr;
            $Icon_arr = array();
            $CATImage_arr = array();
            foreach ($value['Service_Provider_Category'] as $key4 => $category) {
                array_push($CATImage_arr, $category['image']);
                $this->loadModel('Category');
                $Categories_data = $this->Category->find('first', array('conditions' => array('Category.id' => $category['category_id'])));
                array_push($Icon_arr, $Categories_data['Category']['icon']);
            }
            $temp['icons'] = $Icon_arr;
            $temp['images'] = $CATImage_arr;

            array_push($Service_Providers_arr, $temp);
        }

        $return = array();
        if (!empty($Service_Providers)) {
            $return['status'] = 'success';
            $return['result'] = $Service_Providers_arr;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_UserReservations_OnProvider() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Serviceprovider_ID = $json['serviceprovider_id'];

        //$Username = 'alaa.almaazawi@gmail.com';
        //$Password = '123456';
        //$Serviceprovider_ID = '2';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Reservation');
                $this->Reservation->unbindModel(array(
                    "belongsTo" => array("User", "Service_Provider")
                ));
                $Reservations = $this->Reservation->find('all', array('recursive' => '-1', 'conditions' => array('Reservation.user_id' => $checkUser['User']['id'], 'Reservation.service_provider_id' => $Serviceprovider_ID)));
                if (!empty($Reservations)) {
                    $Reservations[0]['pendeingflag'] = 'false';
                    foreach ($Reservations as $key => $value) {
                        if ($value['Reservation']['status'] == '1') {
                            $Reservations[0]['pendeingflag'] = 'true';
                        }
                    }
                }
                $return = array();
                if (!empty($Reservations)) {
                    $return['status'] = 'success';
                    $return['result'] = $Reservations;
                } else {
                    $return['status'] = 'faile';
                    $return['result'] = 'no data found';
                }
            }
        } else {
            $return['status'] = 'missing parameter';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_UserReservation_Details() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Reservation_ID = $json['reservation_id'];

        //$Username = 'alaa.almaazawi@gmail.com';
        //$Password = '123456';
        // $Reservation_ID = '1';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('ReservationDetail');

                $ReservationDetail = $this->ReservationDetail->find('all', array('conditions' => array('ReservationDetail.reservation_id' => $Reservation_ID)));


                foreach ($ReservationDetail as $key => $value) {
                    $this->loadModel('Service_Provider_Category');
                    $Service_Provider_Category = $this->Service_Provider_Category->find('first', array('recursive' => '-1', 'conditions' => array('Service_Provider_Category.category_id' => $value['Category']['id'])));
                    $ReservationDetail[$key]['catdata'] = $Service_Provider_Category['Service_Provider_Category'];

                    $this->loadModel('Reservation_Status');
                    $Reservation_Status = $this->Reservation_Status->find('first', array('recursive' => '-1', 'conditions' => array('Reservation_Status.id' => $value['Reservation']['status'])));
                    $ReservationDetail[$key]['Reservation_Status'] = $Reservation_Status['Reservation_Status'];
                }


                $return = array();
                if (!empty($ReservationDetail)) {
                    $return['status'] = 'success';
                    $return['result'] = $ReservationDetail;
                } else {
                    $return['status'] = 'faile';
                    $return['result'] = 'no data found';
                }
            }
        } else {
            $return['status'] = 'missing parameter';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function add_UserReservation() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $ServiceProvider_ID = $json['serviceprovider_id'];
        $DateTime = $json['datetime'];
        $Notes = $json['notes'];
        $Services_ARR = $json['services'];
        $Amount = $json['amount'];

        //$Username = 'alaa.almaazawi@gmail.com';
        //$Password = '123456';
        //$ServiceProvider_ID = '1';
        //$DateTime = '2020-06-10 00:00:00';
        //$Notes = 'mafeesh nooooootes';
        //$Services_ARR = ['8', '9', '10'];
        //$Amount = '1585';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $statusFlag = FALSE;
                $Reservation_array = array();
                $Reservation_array['Reservation']['user_id'] = $checkUser['User']['id'];
                $Reservation_array['Reservation']['service_provider_id'] = $ServiceProvider_ID;
                $Reservation_array['Reservation']['status'] = '1';
                $Reservation_array['Reservation']['user_notes'] = $Notes;
                $Reservation_array['Reservation']['date_user'] = $DateTime;
                $Reservation_array['Reservation']['amount'] = $Amount;


                $this->loadModel('Reservation');
                $this->Reservation->create();
                if ($this->Reservation->save($Reservation_array)) {
                    foreach ($Services_ARR as $key => $value) {
                        $Reservation_Lastid = $this->Reservation->getLastInsertID();

                        $ReservationDetails_array = array();
                        $ReservationDetails_array['ReservationDetail']['reservation_id'] = $Reservation_Lastid;
                        $ReservationDetails_array['ReservationDetail']['service_provider_id'] = $ServiceProvider_ID;
                        $ReservationDetails_array['ReservationDetail']['user_id'] = $checkUser['User']['id'];
                        $ReservationDetails_array['ReservationDetail']['category_id'] = $value;

                        $this->loadModel('ReservationDetail');
                        $this->ReservationDetail->create();
                        if ($this->ReservationDetail->save($ReservationDetails_array)) {
                            $statusFlag = TRUE;
                        }
                    }

                    $return = array();
                    if (!empty($statusFlag)) {
                        $return['status'] = 'success';
                        $return['result'] = 'reservation added';
                    } else {
                        $return['status'] = 'faile';
                        $return['result'] = 'no data found';
                    }
                }
            } else {
                $return['status'] = 'missing parameter';
            }
            header("Content-Type: application/json", true);
            echo json_encode($return);
            exit;
        }
    }

    public function readd_UserReservation() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Reservation_ID = $json['reservation_id'];
        $DateTime = $json['datetime'];
        $Notes = $json['notes'];

        //$Username = 'alaa.almaazawi@gmail.com';
        //$Password = '123456';
        //$Reservation_ID = '1';
        //$DateTime = '2022-06-10 00:00:00';
        //$Notes = 'mafeesh nooooootes';
        //$Services_ARR = ['8', '9', '10'];
        //$Amount = '1585';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $statusFlag = FALSE;
                $this->loadModel('Reservation');
                $this->Reservation->unbindModel(array(
                    "belongsTo" => array("User", "Service_Provider")
                ));
                $Reservation = $this->Reservation->find('first', array('recursive' => '-1', 'conditions' => array('Reservation.id' => $Reservation_ID)));

                $this->loadModel('Reservation');
                if ($this->Reservation->updateAll(
                                array(
                            'Reservation.date_user' => "'" . $DateTime . "'",
                            'Reservation.user_notes' => "'" . $Reservation['Reservation']['user_notes'] . '\n' . $Notes . "'",
                            'Reservation.status' => '1',
                                ), array(
                            'Reservation.id' => $Reservation_ID
                        ))) {
                    $statusFlag = TRUE;
                }

                $return = array();
                if (!empty($statusFlag)) {
                    $return['status'] = 'success';
                    $return['result'] = 'reservation readded';
                } else {
                    $return['status'] = 'faile';
                    $return['result'] = 'no data found';
                }
            }
        } else {
            $return['status'] = 'missing parameter';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    function generateRandomString($length = 15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$%';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function pay_UserReservation() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Reservation_ID = $json['reservation_id'];


        //$Username = 'alaa.almaazawi@gmail.com';
        //$Password = '123456';
        //$Reservation_ID = '1';
        $randomString = '';
        //$DateTime = '2022-06-10 00:00:00';
        //$Notes = 'mafeesh nooooootes';
        //$Services_ARR = ['8', '9', '10'];
        //$Amount = '1585';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $statusFlag = FALSE;
                $randomString .= $this->generateRandomString();

                $this->loadModel('Reservation');

                if ($this->Reservation->updateAll(
                                array(
                            'Reservation.status' => '4',
                            'Reservation.approval_code' => "'" . $randomString . "'"
                                ), array(
                            'Reservation.id' => $Reservation_ID
                        ))) {
                    $statusFlag = TRUE;
                }

                $return = array();
                if (!empty($statusFlag)) {
                    $return['status'] = 'success';
                    $return['result'] = 'reservation payed';
                } else {
                    $return['status'] = 'faile';
                    $return['result'] = 'no data found';
                }
            }
        } else {
            $return['status'] = 'missing parameter';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_UserReservations() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        //$Serviceprovider_ID = $json['serviceprovider_id'];
        //$Username = 'alaa.almaazawi@gmail.com';
        //$Password = '123456';
        //$Serviceprovider_ID = '2';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Reservation');
                $Reservations = $this->Reservation->find('all', array('recursive' => '-1','order' => array('Reservation.modified DESC'), 'conditions' => array('Reservation.user_id' => $checkUser['User']['id'])));
                if (!empty($Reservations)) {
                    $Reservations[0]['pendeingflag'] = 'false';
                    foreach ($Reservations as $key => $value) {
                        if ($value['Reservation']['status'] == '1') {
                            $Reservations[0]['pendeingflag'] = 'true';
                        }
                        
                        $this->loadModel('Service_Provider');
                        $Service_Provider = $this->Service_Provider->find('first', array( 'conditions' => array('Service_Provider.id' => $value['Service_Provider']['id'])));
                        
                        $CATData_arr = array();
                        foreach ($Service_Provider['Service_Provider_Category'] as $key4 => $category) {
                            $tempData = array();
                            $this->loadModel('Category');
                            $Categories_data = $this->Category->find('first', array('conditions' => array('Category.id' => $category['category_id'])));
                            $tempData['id'] = $Categories_data['Category']['id'];
                            $tempData['name'] = $Categories_data['Category']['name_en'];
                            $tempData['image'] = $category['image'];
                            $tempData['price'] = $category['price'] . ' EGP';
                            $tempData['details_en'] = $category['details_en'];
                            array_push($CATData_arr, $tempData);
                        }
                        $Reservations[$key]['catdata'] = $CATData_arr;
                    }
                }
                $return = array();
                if (!empty($Reservations)) {
                    $return['status'] = 'success';
                    $return['result'] = $Reservations;
                } else {
                    $return['status'] = 'faile';
                    $return['result'] = 'no data found';
                }
            }
        } else {
            $return['status'] = 'missing parameter';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

     public function get_ServiceProviderReservations() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        //$Serviceprovider_ID = $json['serviceprovider_id'];
        //$Username = 'alaa.almaazawi@gmail.com';
        //$Password = 'Alaa@1234';
        //$Serviceprovider_ID = '2';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                
                $this->loadModel('Reservation');
                $Reservations = $this->Reservation->find('all', array('recursive' => '-1','order' => array('Reservation.modified DESC'), 'conditions' => array('Reservation.service_provider_id' => $checkUser['Service_Provider'][0]['id'])));
                if (!empty($Reservations)) {
                    $Reservations[0]['pendeingflag'] = 'false';
                    foreach ($Reservations as $key => $value) {
                        if ($value['Reservation']['status'] == '1') {
                            $Reservations[0]['pendeingflag'] = 'true';
                        }
                        
                        $this->loadModel('Service_Provider');
                        $Service_Provider = $this->Service_Provider->find('first', array( 'conditions' => array('Service_Provider.id' => $value['Service_Provider']['id'])));
                        
                        $CATData_arr = array();
                        foreach ($Service_Provider['Service_Provider_Category'] as $key4 => $category) {
                            $tempData = array();
                            $this->loadModel('Category');
                            $Categories_data = $this->Category->find('first', array('conditions' => array('Category.id' => $category['category_id'])));
                            $tempData['id'] = $Categories_data['Category']['id'];
                            $tempData['name'] = $Categories_data['Category']['name_en'];
                            $tempData['image'] = $category['image'];
                            $tempData['price'] = $category['price'] . ' EGP';
                            $tempData['details_en'] = $category['details_en'];
                            array_push($CATData_arr, $tempData);
                        }
                        $Reservations[$key]['catdata'] = $CATData_arr;
                    }
                }
                $return = array();
                if (!empty($Reservations)) {
                    $return['status'] = 'success';
                    $return['result'] = $Reservations;
                } else {
                    $return['status'] = 'faile';
                    $return['result'] = 'no data found';
                }
            }
        } else {
            $return['status'] = 'missing parameter';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

}
