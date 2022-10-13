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
                "User.phone" => $Username,
                "User.password" => $Password,
            //"User.otp_status" => '1'
        )));
        return $checkUser;
    }

    public function check_serverrr() {
//$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        //$json = json_decode($data, true);
        //$Username = $json['email'];
        //$Password = $json['password'];
        //$Username = 'alaa.almaazawi@gmail.com';
        //$Password = 'Alaa@1234';

        sleep(3);

        $return ['status'] = "success";
        $return ['result'] = "success";

        echo json_encode($return);
        exit;
    }

    public function check_server() {
//$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);
        if (!empty($json['deviceName']))
            $deviceName = $json['deviceName'];
        if (!empty($json['IpAddress']))
            $IpAddress = $json['IpAddress'];
        if (!empty($json['ApiLevel']))
            $ApiLevel = $json['ApiLevel'];
        if (!empty($json['carrier']))
            $carrier = $json['carrier'];
        if (!empty($json['token']))
            $token = $json['token'];
        if (!empty($json['os']))
            $os = $json['os'];
        if (!empty($json['user_id']))
            $user_id = $json['user_id'];

        //$Username = 'alaa.almaazawi@gmail.com';
        //$Password = 'Alaa@1234';
        sleep(2);

        if (!empty($token)) {
            if ($os == 'ios') {
                $token = $this->convert_APN_token($token);
            }


            $User_Data_arr = array();
            $User_Data_arr['User_Data']['deviceName'] = $deviceName;
            $User_Data_arr['User_Data']['IpAddress'] = $IpAddress;
            $User_Data_arr['User_Data']['ApiLevel'] = $ApiLevel;
            $User_Data_arr['User_Data']['carrier'] = $carrier;
            $User_Data_arr['User_Data']['token'] = $token;
            $User_Data_arr['User_Data']['os'] = $os;
            $User_Data_arr['User_Data']['user_id'] = $user_id;

            $this->loadModel("User_Data");
            $UserData = $this->User_Data->find("first", array('recursive' => -1,
                "conditions" => array(
                    "token" => $token,
            )));
            /* if (!empty($UserData)) {
              $this->loadModel("User_Data");
              $this->User_Data->deleteAll(array('User_Data.id' => $UserData['User_Data']['id']), false);
              } */
            if ($user_id != 0) {
                $this->loadModel('User');
                $this->User->updateAll(
                        array(
                    'User.token' => "'" . $token . "'",
                        ), array(
                    'User.id' => $user_id
                ));
            }
            $this->loadModel("User_Data");
            $this->User_Data->create();
            $this->User_Data->save($User_Data_arr);
        } else {
            $User_Data_arr = array();
            $User_Data_arr['User_Data']['deviceName'] = "";
            $User_Data_arr['User_Data']['IpAddress'] = "";
            $User_Data_arr['User_Data']['ApiLevel'] = "";
            $User_Data_arr['User_Data']['carrier'] = "";
            $User_Data_arr['User_Data']['token'] = "";
            $User_Data_arr['User_Data']['os'] = "";
            if (!empty($json['user_id']))
                $User_Data_arr['User_Data']['user_id'] = $user_id;
            else
                $User_Data_arr['User_Data']['user_id'] = 0;

            $this->loadModel("User_Data");
            $this->User_Data->create();
            $this->User_Data->save($User_Data_arr);
        }








        $return ['status'] = "success";
        $return ['result'] = "success";


        echo json_encode($return);
        exit;
    }

    public function login() {
//$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        //$Username = 'alaa.almaazawi@gmail.com';
        //$Password = 'Alaa@1234';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            $return = array();
            if (!empty($checkUser)) {
                $return ['status'] = "success";
                $return ['result'] = $checkUser;
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
    function convert_APN_token($token) {

        $curl = curl_init();
        //$token = "47bd3cbfcf6bcf2975112486defd58b100ab903f09d92dfc04981ae13f03f167";
        $post_data = array();
        $post_data["application"] = "com.aiwa.group";
        $post_data["sandbox"] = false;
        $post_data["apns_tokens"] = array($token);

        $post_data = json_encode($post_data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://iid.googleapis.com/iid/v1:batchImport",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $post_data,
            CURLOPT_HTTPHEADER => array(
                "authorization: key=AAAA-MuK7d8:APA91bGKbjG0z00_JYaR1lkrswGS4_50UmfCVAAzPMXCxETTJbnJlsiXkeI1Qt3Rbpnn_4gF1E3OH9mtnBsy126zv2jGpQSwR_Tea9wmSn73Y1D3D2VwTOCmeD7vAB0f1mLKVvz1yr1F",
                "cache-control: no-cache",
                "content-type: application/json",
                "postman-token: ec74a8e4-db42-1364-1b10-61d76d73edd1"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            //echo $response;
        }
        $json = json_decode($response, true);
        return $json['results'][0]['registration_token'];
        //exit;
    }

    function sendSms($message, $phonenumber) {
        $URL = 'https://smsmisr.com/api/webapi/?username=2Y6neqid&password=3bSuhEnyzX&language=1&sender=AIWA&mobile=' . $phonenumber . ',&message=' . $message;
        $New_URL = str_replace(' ', '%20', $URL);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $New_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => array(),
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
        //exit;
    }

    public function otp_check() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $phone = $json['phone'];
        $otp = $json['otp'];

        $this->loadModel("User");
        $UserData = $this->User->find("first", array('recursive' => -1,
            "conditions" => array(
                "phone" => $phone,
                "otp" => $otp,
        )));
        if (!empty($UserData)) {
            $this->loadModel('User');
            if ($this->User->updateAll(
                            array(
                        'User.otp_status' => '1',
                        'User.status' => '1',
                            ), array(
                        'User.id' => $UserData['User']['id']
                    ))) {
                $UserData_new = $this->User->find("first", array('recursive' => -1,
                    "conditions" => array(
                        "phone" => $phone
                )));
                $return['status'] = 'success';
                $return['result'] = $UserData_new;
            }
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'Your OTP is wrong...!';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function resend_otp() {
        //$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $email = $json['email'];
        //$password = $json['password'];

        $this->loadModel("User");
        $checkUser = $this->User->find("first", array(
            "conditions" => array(
                "User.phone" => $email,
                //"User.password" => $password,
                "User.otp_status" => '0',
                'User.status' => '0',
        )));
        $return = array();
        if (!empty($checkUser)) {
            $this->loadModel("User");
            $UserData = $this->User->find("first", array('recursive' => -1,
                "conditions" => array(
                    "id" => $checkUser['User']['id']
            )));
            $phone_number = $UserData['User']['phone'];
            $massage_txt = "Thank you for choosing AIWA, Your code is :" . $UserData['User']['otp'];
            $this->sendSms($massage_txt, $phone_number);

            $return['status'] = 'success';
            $return['result'] = $UserData;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'User not found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

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
        if (!empty($json['token']))
            $token = $json['token'];
        if (!empty($json['os']))
            $os = $json['os'];


        if (!empty($token)) {
            if ($os == 'ios') {
                $token = $this->convert_APN_token($token);
            }
        }


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
        $user_arr['User']['status'] = '0';
        $user_arr['User']['token'] = $token;
        $user_arr['User']['os'] = $os;
        $user_arr['User']['status'] = '0';

        $this->loadModel("User");
        $UserIdintifier = $this->User->find("all", array('recursive' => -1,
            "conditions" => array('User.phone' => $phone))); //, 'User.status' => '1'

        if (empty($UserIdintifier)) {
            $this->loadModel("User");
            $UserNotActive = $this->User->find("first", array('recursive' => -1,
                "conditions" => array('User.phone' => $phone, 'User.status' => '0')));
            if (!empty($UserNotActive)) {
                $this->loadModel("User");
                $this->User->deleteAll(array('User.id' => $UserNotActive['User']['id']), false);

                $this->loadModel("Service_Provider");
                $this->Service_Provider->deleteAll(array('Service_Provider.user_id' => $UserNotActive['User']['id']), false);

                $this->loadModel("Company");
                $this->Company->deleteAll(array('Company.user_id' => $UserNotActive['User']['id']), false);

                $this->loadModel("Paper_Transaction");
                $this->Paper_Transaction->deleteAll(array('Paper_Transaction.user_id' => $UserNotActive['User']['id']), false);
            }

            $this->User->create();
            if ($this->User->save($user_arr)) {
                $user_Lastid = $this->User->getLastInsertID();
                $flag = TRUE;

                $otp = "";
                $otp = $this->generateRandomString();
                $this->loadModel('User');
                if ($this->User->updateAll(
                                array(
                            'User.otp' => "'" . $otp . "'",
                                ), array(
                            'User.id' => $user_Lastid
                        ))) {
                    $this->loadModel("User");
                    $UserData = $this->User->find("first", array('recursive' => -1,
                        "conditions" => array(
                            "id" => $user_Lastid
                    )));
                    //$phone_number = $UserData['User']['phone'];
                    //$massage_txt = "Thank you for choosing AIWA, Your code is :" . $UserData['User']['otp'];
                    // $this->sendSms($massage_txt, $phone_number);
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
                $return['result'] = $UserData;
            } else {
                $return['status'] = 'faile';
                $return['result'] = 'Error Happened Please Try Again Later';
            }
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'This phone is already registered';
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
        $idnumber = $json['idnumber'];
        if (!empty($json['token']))
            $token = $json['token'];
        if (!empty($json['os']))
            $os = $json['os'];

        ////////////////////
        $type = $json['type'];
        if ($json['paper5'])
            $paper5 = $json['paper5'];
        if ($json['paper2'])
            $paper2 = $json['paper2'];
        if ($json['paper3'])
            $paper3 = $json['paper3'];
        if ($json['paper4'])
            $paper4 = $json['paper4'];
        if ($json['paper6'])
            $paper6 = $json['paper6'];
        if ($json['paper7'])
            $paper6 = $json['paper7'];

        //////////////////////
        $companyname = $json['companyname'];
        $companyinfo = $json['companyinfo'];
        $companyofficialphone = $json['companyofficialphone'];
        $companyaddress = $json['companyaddress'];
        //////////////////////
        $servicename = $json['servicename'];
        $serviceinfo = $json['serviceinfo'];
        $service_image = $json['service_image'];
        $officialphone = $json['officialphone'];
        $area = $json['area'];
        $address = $json['address'];
        $maincategory_id = $json['maincategory_id'];
        //////////////////////
        if (!empty($token)) {
            if ($os == 'ios') {
                $token = $this->convert_APN_token($token);
            }
        }

        $user_arr = array();
        $user_arr['User']['fname'] = $fname;
        $user_arr['User']['lname'] = $lname;
        $user_arr['User']['email'] = $email;
        $user_arr['User']['phone'] = $phone;
        $user_arr['User']['gender'] = $gender;
        $user_arr['User']['idnumber'] = $idnumber;
        $user_arr['User']['password'] = $password;
        $user_arr['User']['birthday'] = $birthday;
        $user_arr['User']['permission_id'] = '2';
        $user_arr['User']['service_type_id'] = $type;
        $user_arr['User']['token'] = $token;
        $user_arr['User']['os'] = $os;
        $user_arr['User']['status'] = '0';

        $allpaper_arr = array();
        $allpaper_arr_id = array();
        if (!empty($paper5)) {
            $allpaper_arr[] = $paper5;
            $allpaper_arr_id[] = '5';
        }
        if (!empty($paper2)) {
            $allpaper_arr[] = $paper2;
            $allpaper_arr_id[] = '2';
        }
        if (!empty($paper3)) {
            $allpaper_arr[] = $paper3;
            $allpaper_arr_id[] = '3';
        }
        if (!empty($paper4)) {
            $allpaper_arr[] = $paper4;
            $allpaper_arr_id[] = '4';
        }
        if (!empty($paper6)) {
            $allpaper_arr[] = $paper6;
            $allpaper_arr_id[] = '6';
        }
        if (!empty($paper7)) {
            $allpaper_arr[] = $paper7;
            $allpaper_arr_id[] = '7';
        }

        $flag = FALSE;
        $date = new DateTime();
        $Timestamp = $date->getTimestamp();


        $this->loadModel("User");
        $UserIdintifier = $this->User->find("all", array('recursive' => -1,
            "conditions" => array('User.phone' => $phone))); //, 'User.status' => '1'

        $user_Lastid_public = '';
        $Service_Provider_Lastid_public = '';
        if (empty($UserIdintifier)) {
            $this->loadModel("User");
            $UserNotActive = $this->User->find("first", array('recursive' => -1,
                "conditions" => array('User.phone' => $phone))); //, 'User.otp_status' => '0'
            if (!empty($UserNotActive)) {
                $this->loadModel("User");
                $this->User->deleteAll(array('User.id' => $UserNotActive['User']['id']), false);

                $this->loadModel("Service_Provider");
                $this->Service_Provider->deleteAll(array('Service_Provider.user_id' => $UserNotActive['User']['id']), false);

                $this->loadModel("Company");
                $this->Company->deleteAll(array('Company.user_id' => $UserNotActive['User']['id']), false);

                $this->loadModel("Paper_Transaction");
                $this->Paper_Transaction->deleteAll(array('Paper_Transaction.user_id' => $UserNotActive['User']['id']), false);
            }

            $this->loadModel("User");
            $this->User->create();
            if ($this->User->save($user_arr)) {
                $user_Lastid = $this->User->getLastInsertID();
                $user_Lastid_public = $user_Lastid;

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
                $serviceProvider_arr['Service_Provider']['approval_flag'] = '0';


                $this->loadModel("Service_Provider");
                $this->Service_Provider->create();
                if ($this->Service_Provider->save($serviceProvider_arr)) {
                    $otp = "";
                    $otp = $this->generateRandomString();
                    if ($type == 1) {
                        $Service_Provider_Lastid = $this->Service_Provider->getLastInsertID();
                        $Service_Provider_Lastid_public = $Service_Provider_Lastid;
                        $company_arr = array();
                        $company_arr['Company']['name'] = $companyname;
                        $company_arr['Company']['phone'] = $companyofficialphone;
                        $company_arr['Company']['info'] = $companyinfo;
                        $company_arr['Company']['address'] = $companyaddress;
                        $company_arr['Company']['service_provider_id'] = $Service_Provider_Lastid;
                        $company_arr['Company']['user_id'] = $user_Lastid;

                        $this->loadModel("Company");
                        $this->Company->create();

                        if ($this->Company->save($company_arr)) {
                            $count = count($allpaper_arr);

                            for ($index = 1; $index <= $count; $index++) {

                                $destination_path = getcwd() . DIRECTORY_SEPARATOR . 'upload/';
                                $target_path = $destination_path . basename($Service_Provider_Lastid_public . $Timestamp . $index . '.PNG');
                                $data = base64_decode($allpaper_arr[$index - 1]);
                                file_put_contents($target_path, $data);
                                $Imageurl = 'app/webroot/upload/' . $Service_Provider_Lastid_public . $Timestamp . $index . '.PNG';

                                $paper_arr = array();
                                $paper_arr['Paper_Transaction']['user_id'] = $user_Lastid;
                                $paper_arr['Paper_Transaction']['required_paper_id'] = $allpaper_arr_id[$index - 1];
                                $paper_arr['Paper_Transaction']['attachment'] = $Imageurl;
                                $paper_arr['Paper_Transaction']['approval_flag'] = '2';

                                $this->loadModel("Paper_Transaction");
                                $this->Paper_Transaction->create();
                                $this->Paper_Transaction->save($paper_arr);
                            }
                            $this->loadModel('User');
                            if ($this->User->updateAll(
                                            array(
                                        'User.otp' => "'" . $otp . "'",
                                            ), array(
                                        'User.id' => $user_Lastid_public
                                    ))) {
                                $this->loadModel("User");
                                $UserData = $this->User->find("first", array('recursive' => -1,
                                    "conditions" => array(
                                        "User.id" => $user_Lastid_public
                                )));
                                //$phone_number = $UserData['User']['phone'];
                                //$massage_txt = "Thank you for choosing AIWA, Your code is :" . $UserData['User']['otp'];
                                //$this->sendSms($massage_txt, $phone_number);
                                $flag = TRUE;
                            }
                        }
                    } else if ($type == 2) {
                        $count = count($allpaper_arr);

                        for ($index = 1; $index <= $count; $index++) {

                            $destination_path = getcwd() . DIRECTORY_SEPARATOR . 'upload/';
                            $target_path = $destination_path . basename($Service_Provider_Lastid_public . $Timestamp . $index . '.PNG');
                            $data = base64_decode($allpaper_arr[$index - 1]);
                            file_put_contents($target_path, $data);
                            $Imageurl = 'app/webroot/upload/' . $Service_Provider_Lastid_public . $Timestamp . $index . '.PNG';

                            $paper_arr = array();
                            $paper_arr['Paper_Transaction']['user_id'] = $user_Lastid;
                            $paper_arr['Paper_Transaction']['required_paper_id'] = $allpaper_arr_id[$index - 1];
                            $paper_arr['Paper_Transaction']['attachment'] = $Imageurl;
                            $paper_arr['Paper_Transaction']['approval_flag'] = '2';

                            $this->loadModel("Paper_Transaction");
                            $this->Paper_Transaction->create();
                            $this->Paper_Transaction->save($paper_arr);
                        }
                        $this->loadModel('User');
                        if ($this->User->updateAll(
                                        array(
                                    'User.otp' => "'" . $otp . "'",
                                        ), array(
                                    'User.id' => $user_Lastid_public
                                ))) {
                            $this->loadModel("User");
                            $UserData = $this->User->find("first", array('recursive' => -1,
                                "conditions" => array(
                                    "User.id" => $user_Lastid_public
                            )));
                            //$phone_number = $UserData['User']['phone'];
                            //$massage_txt = "Thank you for choosing AIWA, Your code is :" . $UserData['User']['otp'];
                            //$this->sendSms($massage_txt, $phone_number);
                            $flag = TRUE;
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
                $return['result'] = $UserData;
            } else {
                $return['status'] = 'faile';
                $return['result'] = 'Error Happened Please Try Again Later';
            }
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'This phone is already registered';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

////////////////////////////////////////////////////////////////
    public function paper_resubmit() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];

        //$type = $json['type'];
        if ($json['paper5'])
            $paper5 = $json['paper5'];
        if ($json['paper2'])
            $paper2 = $json['paper2'];
        if ($json['paper3'])
            $paper3 = $json['paper3'];
        if ($json['paper4'])
            $paper4 = $json['paper4'];
        if ($json['paper6'])
            $paper6 = $json['paper6'];
        if ($json['paper7'])
            $paper6 = $json['paper7'];


        if (!empty($Username) && !empty($Password)) {
            $this->loadModel("User");
            $checkUser = $this->User->find("first", array('recursive' => -1,
                "conditions" => array('User.phone' => $Username, 'User.password' => $Password))); //, 'User.otp_status' => '1'
            if (!empty($checkUser)) {
                $type = $checkUser['User']['service_type_id'];
                $userID = $checkUser['User']['id'];

                $date = new DateTime();
                $Timestamp = $date->getTimestamp();

                $allpaper_arr = array();
                $allpaper_arr_id = array();
                if (!empty($paper5)) {
                    $allpaper_arr[] = $paper5;
                    $allpaper_arr_id[] = '5';
                }
                if (!empty($paper2)) {
                    $allpaper_arr[] = $paper2;
                    $allpaper_arr_id[] = '2';
                }
                if (!empty($paper3)) {
                    $allpaper_arr[] = $paper3;
                    $allpaper_arr_id[] = '3';
                }
                if (!empty($paper4)) {
                    $allpaper_arr[] = $paper4;
                    $allpaper_arr_id[] = '4';
                }
                if (!empty($paper6)) {
                    $allpaper_arr[] = $paper6;
                    $allpaper_arr_id[] = '6';
                }
                if (!empty($paper7)) {
                    $allpaper_arr[] = $paper7;
                    $allpaper_arr_id[] = '7';
                }

                $count = count($allpaper_arr);

                $saved_flag = FALSE;
                for ($index = 1; $index <= $count; $index++) {

                    $destination_path = getcwd() . DIRECTORY_SEPARATOR . 'upload/';
                    $target_path = $destination_path . basename($userID . $Timestamp . $index . '.PNG');
                    $data = base64_decode($allpaper_arr[$index - 1]);
                    file_put_contents($target_path, $data);
                    $Imageurl = 'app/webroot/upload/' . $userID . $Timestamp . $index . '.PNG';

                    $this->loadModel("Paper_Transaction");
                    $old_paper_data = $this->Paper_Transaction->find("first", array('recursive' => -1,
                        "conditions" => array('Paper_Transaction.required_paper_id' => $allpaper_arr_id[$index - 1], 'Paper_Transaction.user_id' => $userID)));

                    $old_paper_str = "";
                    if (!empty($old_paper_data))
                        $old_paper_str = $old_paper_data['Paper_Transaction']['notes_history'] . '*|*' . $old_paper_data['Paper_Transaction']['attachment'] . '*_*' . $old_paper_data['Paper_Transaction']['admin_notes'] . '*_*' . $old_paper_data['Paper_Transaction']['created'];

                    $paper_arr = array();
                    $paper_arr['Paper_Transaction']['user_id'] = $userID;
                    $paper_arr['Paper_Transaction']['required_paper_id'] = $allpaper_arr_id[$index - 1];
                    $paper_arr['Paper_Transaction']['attachment'] = $Imageurl;
                    $paper_arr['Paper_Transaction']['approval_flag'] = '2';
                    $paper_arr['Paper_Transaction']['notes_history'] = "'" . $old_paper_str . "'";

                    $this->loadModel("Paper_Transaction");
                    $this->Paper_Transaction->deleteAll(array('Paper_Transaction.required_paper_id' => $allpaper_arr_id[$index - 1], 'Paper_Transaction.user_id' => $userID), false);

                    $this->loadModel("Paper_Transaction");
                    $this->Paper_Transaction->create();
                    if ($this->Paper_Transaction->save($paper_arr)) {

                        $saved_flag = TRUE;
                    }
                }
            }
        }

        $return = array();
        if (!empty($saved_flag)) {
            $return['status'] = 'success';
            $return['result'] = 'Saved Successfully';
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function account_activation_status() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];

        $paper_flag = '';
        $paper_flag4 = FALSE;
        $paper_flag3 = FALSE;
        $paper_flag2 = FALSE;
        $paper_flag1 = FALSE;
        if (!empty($Username) && !empty($Password)) {
            $this->loadModel("User");
            $checkUser = $this->User->find("first", array('recursive' => -1,
                "conditions" => array('User.phone' => $Username, 'User.password' => $Password))); //, 'User.otp_status' => '1'
            if (!empty($checkUser)) {
                $type = $checkUser['User']['service_type_id'];
                $userID = $checkUser['User']['id'];
                $Required_Paper_arr = array();
                $Required_Paper_arr = $this->papers_check_fun($type, $userID);
                if (!empty($Required_Paper_arr)) {
                    foreach ($Required_Paper_arr as $key => $value) {
                        if ($value['approval_flag'] == '4') {
                            $paper_flag4 = TRUE;
                        } else if ($value['approval_flag'] == '2') {
                            $paper_flag2 = TRUE;
                        } else if ($value['approval_flag'] == '3') {
                            $paper_flag3 = TRUE;
                        } else {
                            $paper_flag1 = TRUE;
                        }
                    }
                } else {
                    $paper_flag = '0';
                }


                if ($paper_flag3) {
                    $paper_flag = '3';
                } else if ($paper_flag2) {
                    $paper_flag = '2';
                } else if ($paper_flag4) {
                    $paper_flag = '4';
                } else if ($paper_flag1) {
                    $paper_flag = '1';
                }
            }
        }
        $return = array();
        if (!empty($paper_flag)) {
            $return['status'] = 'success';
            $return['result'] = $paper_flag;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function paper_check() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];


        if (!empty($Username) && !empty($Password)) {
            $this->loadModel("User");
            $checkUser = $this->User->find("first", array('recursive' => -1,
                "conditions" => array('User.phone' => $Username, 'User.password' => $Password))); //, 'User.otp_status' => '1'
            if (!empty($checkUser)) {
                $type = $checkUser['User']['service_type_id'];
                $userID = $checkUser['User']['id'];
                $Required_Paper_arr = array();
                $Required_Paper_arr = $this->papers_check_fun($type, $userID);
            }
        }

        $return = array();
        if (!empty($Required_Paper_arr)) {
            $return['status'] = 'success';
            $return['result'] = $Required_Paper_arr;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

///////////////////////////////////////////////////////////////
    function papers_check_fun($type = null, $userID = null) {
        $this->loadModel("Paper_Transaction");
        $Paper_Transactions = $this->Paper_Transaction->find("all", array('recursive' => -1,
            "conditions" => array('Paper_Transaction.user_id' => $userID), 'order' => array('Paper_Transaction.modified DESC')));
        $this->loadModel("Service_Provider");
        $Service_Provider = $this->Service_Provider->find('first', array('conditions' => array('Service_Provider.user_id' => $userID)));
        $this->loadModel("Category");
        $Category = $this->Category->find('first', array('conditions' => array('Category.id' => $Service_Provider['Service_Provider']['category_id'])));

        $papers_arr = array();
        if ($type == 1) {
            $papers_arr[] = '2';
            $papers_arr[] = '4';
            if ($Category['Category']['health_certificate'] == '1') {
                $papers_arr[] = '5';
            }
            if ($Category['Category']['qualification_certificate'] == '1') {
                $papers_arr[] = '6';
            }
            $this->loadModel("Required_Paper");
            $Required_Paper = $this->Required_Paper->find("all", array('recursive' => -1,
                "conditions" => array('Required_Paper.id' => $papers_arr)));
        } else if ($type == 2) {
            $papers_arr[] = '2';
            $papers_arr[] = '3';
            if ($Category['Category']['health_certificate'] == '1') {
                $papers_arr[] = '5';
            }
            if ($Category['Category']['qualification_certificate'] == '1') {
                $papers_arr[] = '6';
            }
            $this->loadModel("Required_Paper");
            $Required_Paper = $this->Required_Paper->find("all", array('recursive' => -1,
                "conditions" => array('Required_Paper.id' => $papers_arr)));
        }
        $Required_Paper_arr = array();
        foreach ($Required_Paper as $key => $Paper) {
            $temp = array();
            $temp['paper_id'] = $Paper['Required_Paper']['id'];
            $temp['paper_name_ar'] = $Paper['Required_Paper']['papername_ar'];
            $temp['paper_name_en'] = $Paper['Required_Paper']['papername_en'];
            if (!empty($Paper_Transactions)) {
                $found_flag = FALSE;
                foreach ($Paper_Transactions as $key => $Transaction) {
                    if ($Transaction['Paper_Transaction']['required_paper_id'] == $Paper['Required_Paper']['id']) {
                        $temp['attachment'] = $Transaction['Paper_Transaction']['attachment'];
                        $temp['approval_flag'] = $Transaction['Paper_Transaction']['approval_flag'];
                        $temp['admin_notes'] = $Transaction['Paper_Transaction']['admin_notes'];
                        $found_flag = TRUE;
                    }
                }
                if (!$found_flag) {
                    $temp['attachment'] = "app/webroot/img/paper" . $Paper['Required_Paper']['id'] . ".png";
                    $temp['approval_flag'] = '4';
                    $temp['admin_notes'] = '';
                }
            } else {
                $temp['attachment'] = "app/webroot/img/paper" . $Paper['Required_Paper']['id'] . ".png";
                $temp['approval_flag'] = '4';
                $temp['admin_notes'] = '';
            }
            array_push($Required_Paper_arr, $temp);
        }
        return $Required_Paper_arr;
    }

    public function review_ratting_add() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Serviceprovider_ID = $json['serviceprovider_id'];
        $review = $json['review'];
        //$ratting = $json['ratting'];

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $statusFlag = FALSE;
                $User_Review_array = array();
                $User_Review_array['User_Review']['user_id'] = $checkUser['User']['id'];
                $User_Review_array['User_Review']['service_provider_id'] = $Serviceprovider_ID;
                $User_Review_array['User_Review']['review'] = $review;
                //$User_Review_array['User_Review']['rate'] = $ratting;


                $this->loadModel('User_Review');
                $this->User_Review->create();
                if ($this->User_Review->save($User_Review_array)) {
                    $statusFlag = TRUE;
                }
            }
        }

        $return = array();
        if (!empty($statusFlag)) {
            $return['status'] = 'success';
            $return['result'] = $checkUser;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function favourit_get() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel("User_Favourit");
                $this->User->unbindModel(array(
                    "hasMany" => array("Paper_Transaction", "Reservation", "Reservation_Details", "User_Review", "User_Favourit", "Address")
                ));
                $this->loadModel("Service_Provider");
                $this->Service_Provider->unbindModel(array(
                    "hasMany" => array("Service_Provider_Category", "Reservation", "Reservation_Details", "Message", "Service_Provider_Complain", "ServiceTracking", "User_Review", "Branch")
                ));
                $this->loadModel("User_Favourit");
                $check_favourit = $this->User_Favourit->find("all", array('recursive' => '2',
                    "conditions" => array(
                        "User_Favourit.user_id" => $checkUser['User']['id'],
                )));
            }
        }
        $return = array();
        if (!empty($check_favourit)) {
            $return['status'] = 'success';
            $return['result'] = $check_favourit;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function payments_transactions() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Type = $json['type'];

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel("Reservation");
                if ($Type == '3') {
                    $Reservations = $this->Reservation->find("all", array(
                        "conditions" => array(
                            "Reservation.user_id" => $checkUser['User']['id'],
                    )));
                } else if ($Type == '2') {
                    $Reservations = $this->Reservation->find("all", array(
                        "conditions" => array(
                            "Reservation.service_provider_id" => $checkUser['User']['id'],
                    )));
                }

                $arr = array();
                $counter = 0;
                foreach ($Reservations as $key1 => $Reservation) {
                    if ($Reservation['Reservation']['trans_ref'] != NULL) {

                        $this->loadModel("FawryPay");
                        $FawryPay = $this->FawryPay->find("first", array(
                            "conditions" => array(
                                "FawryPay.fawryRefNumber" => $Reservation['Reservation']['trans_ref'],
                        )));
                        if (!empty($FawryPay)) {
                            $counter++;
                            $temp = array();
                            $temp['Reservation'] = $Reservation;
                            $temp['fawry_recipte'] = $FawryPay;

                            array_push($arr, $temp);
                        }
                    }
                }
            }
        }
        $return = array();
        if (!empty($arr)) {
            $return['status'] = 'success';
            $return['result'] = $arr;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function favourit_add() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Serviceprovider_ID = $json['serviceprovider_id'];

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $statusFlag = FALSE;
                $User_Favourit_array = array();
                $User_Favourit_array['User_Favourit']['user_id'] = $checkUser['User']['id'];
                $User_Favourit_array['User_Favourit']['service_provider_id'] = $Serviceprovider_ID;

                $this->loadModel('User_Favourit');
                $this->User_Favourit->create();
                if ($this->User_Favourit->save($User_Favourit_array)) {
                    $statusFlag = TRUE;
                }
            }
        }

        $return = array();
        if (!empty($statusFlag)) {
            $return['status'] = 'success';
            $return['result'] = $checkUser;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function favourit_check() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username_ID = $json['user_id'];
        $Serviceprovider_ID = $json['serviceprovider_id'];

        $this->loadModel("User_Favourit");
        $check_favourit = $this->User_Favourit->find("first", array(
            "conditions" => array(
                "User_Favourit.user_id" => $Username_ID,
                "User_Favourit.service_provider_id" => $Serviceprovider_ID
        )));

        $return = array();
        if (!empty($check_favourit)) {
            $return['status'] = 'success';
            $return['result'] = '1';
        } else {
            $return['status'] = 'faile';
            $return['result'] = '0';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function favourit_remove() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Serviceprovider_ID = $json['serviceprovider_id'];

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $statusFlag = FALSE;
                $User_Favourit_array['User']['user_id'] = $checkUser['User']['id'];
                $User_Favourit_array['User']['service_provider_id'] = $Serviceprovider_ID;
                $User_Favourit_array = array();

                $this->loadModel('User_Favourit');
                if ($this->User_Favourit->deleteAll(array('User_Favourit.service_provider_id' => $Serviceprovider_ID, 'User_Favourit.user_id' => $checkUser['User']['id']), false)) {
                    $statusFlag = TRUE;
                }
            }
        }

        $return = array();
        if (!empty($statusFlag)) {
            $return['status'] = 'success';
            $return['result'] = $checkUser;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_MainCategories() {
        $this->loadModel('Category');
        $Categories_data = $this->Category->find('all', array('conditions' => array('Category.parent_id' => '0'), 'order' => array('Category.name_en')));

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

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $page_number = $json['page'];
        $page_number = @$_POST['page'];
        //$Password = $json['password'];
        //$Reservation_ID = $json['reservation_id'];
        // we prepare our query, the cakephp way!

        try {
            $this->loadModel('Category');
            $this->paginate = array(
                'conditions' => array('Category.parent_id' => '0'),
                'limit' => 5,
                'page' => $page_number
                    // 'order' => array('id' => 'desc')
            );
            $Categories_data = $this->paginate('Category');
            $array = array();
            foreach ($Categories_data as $key => $value) {
                $array[$value['Category']['id']] = $value['Category']['name_en'];
            }
        } catch (Exception $ex) {
            
        }

        //$this->loadModel('Category');
        //$Categories_data = $this->Category->find('all', array('conditions' => array('Category.parent_id' => '0')));



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

    public function get_ReviewServiceProvider() {
        //$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $ServiceProvider_id = $json['ServiceProvider_id'];
        //$ServiceProvider_id = '1';

        $this->loadModel('User_Review');

        $this->User_Review->unbindModel(array(
            "hasMany" => array("User", "Service_Provider")
        ));
        $User_Reviews = $this->User_Review->find('all', array('recursive' => '-1',
            'conditions' => array(
                'User_Review.service_provider_id' => $ServiceProvider_id),
            'order' => array('User_Review.created DESC'),
            'limit' => 10
        ));

        $User_Reviews_arr = array();
        foreach ($User_Reviews as $key => $value) {
            $temp = array();
            $temp['profile_pic'] = $value['User']['profile_pic'];
            $temp['username'] = $value['User']['fname'] . ' ' . $value['User']['lname'];
            $temp['created'] = $value['User_Review']['created'];
            $temp['review'] = $value['User_Review']['review'];

            array_push($User_Reviews_arr, $temp);
        }

        $return = array();
        if (!empty($User_Reviews_arr)) {
            $return['status'] = 'success';
            $return['result'] = $User_Reviews_arr;
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
        $SearchKeyword = $json['SearchKeyword'];
        //$CategoryID = '2';

        $this->loadModel('Service_Provider');
        $this->Service_Provider->unbindModel(array(
            "hasMany" => array("ServiceTracking", "Reservation_Details", "Reservation", "Message", "Service_Provider_Complain", "Service_Tracking")
        ));

        if ($SearchKeyword == "") {
            $Service_Providers = $this->Service_Provider->find('all', array(
                'conditions' => array(
                    'Service_Provider.category_id' => $CategoryID,
                    'Service_Provider.approval_flag' => '1'),
            ));
        } else {
            $this->loadModel('Service_Provider_Category');
            $Service_Provider_Category = $this->Service_Provider_Category->find('all', array(
                'conditions' => array(
                    'OR' => array(
                        'Service_Provider_Category.details_en LIKE' => '%' . $SearchKeyword . '%',
                        'Category.name_en LIKE' => '%' . $SearchKeyword . '%',
                        'Category.name_ar LIKE' => '%' . $SearchKeyword . '%',
                    )
                )
            ));
            $Service_Provider_Category_id = array();
            if (!empty($Service_Provider_Category)) {
                foreach ($Service_Provider_Category as $key => $value) {
                    $Service_Provider_Category_id[] = $value['Service_Provider_Category']['service_provider_id'];
                }
            }

            $this->loadModel('Service_Provider');
            $Service_Providers = $this->Service_Provider->find('all', array(
                'conditions' => array(
                    'OR' => array(
                        array(
                            'Service_Provider.approval_flag' => '1',
                            'Service_Provider.id' => $Service_Provider_Category_id,
                        ),
                        'Service_Provider.service_name_en LIKE' => '%' . $SearchKeyword . '%',
                        'Service_Provider.service_description_en LIKE' => '%' . $SearchKeyword . '%',
                        'Category.name_en LIKE' => '%' . $SearchKeyword . '%',
                        'Category.name_ar LIKE' => '%' . $SearchKeyword . '%',
                        'Service_Type.name LIKE' => '%' . $SearchKeyword . '%',
                    //'Service_Provider_Category.details_en LIKE' => '%' . $SearchKeyword . '%',
                    )
                ),
            ));
        }
        // header("Content-Type: application/json", true);
        // echo json_encode($Service_Providers);
        // exit;

        $Service_Providers_arr = array();
        foreach ($Service_Providers as $key => $value) {
            $temp = array();
            $temp['id'] = $value['Service_Provider']['id'];
            $temp['user_id'] = $value['User']['id'];
            $temp['service_name_en'] = $value['Service_Provider']['service_name_en'];
            $temp['service_name_ar'] = $value['Service_Provider']['service_name_ar'];
            $temp['service_description_en'] = $value['Service_Provider']['service_description_en'];
            $temp['service_description_ar'] = $value['Service_Provider']['service_description_ar'];
            $temp['categroty_name_en'] = $value['Category']['name_en'];
            $temp['categroty_name_ar'] = $value['Category']['name_ar'];
            $temp['delivery_flag'] = $value['Service_Provider']['delivery_flag'];
            $temp['covarage_km'] = $value['Service_Provider']['covarage_km'];
            $temp['image'] = $value['Service_Provider']['image'];
            $temp['Service_Type'] = $value['Service_Type']['name'];
            $total_rating = 0;
            $count_rating = 0;
            $review_arr = array();
            foreach (array_reverse($value['User_Review']) as $key1 => $review) {
                /* if (!empty($review['review'])) {
                  $tmep_review = array();
                  $tmep_review['id'] = $review['id'];
                  $tmep_review['review'] = $review['review'];
                  $tmep_review['created'] = $review['created'];
                  $this->loadModel('User');
                  $User_data = $this->User->find('first', array('conditions' => array('User.id' => $review['user_id'])));
                  $tmep_review['username'] = $User_data['User']['fname'] . ' ' . $User_data['User']['lname'];
                  $tmep_review['profile_pic'] = $User_data['User']['profile_pic'];
                  array_push($review_arr, $tmep_review);
                  } */
                if (!empty($review['rate'])) {
                    $count_rating++;
                    $total_rating = $total_rating + $review['rate'];
                }
            }
            if ($count_rating > 0)
                $temp['rating'] = $total_rating / $count_rating;
            else
                $temp['rating'] = 0;
            //$temp['review'] = $review_arr;
            $Icon_arr = array();
            $CATImage_arr = array();
            $CATData_arr = array();
            $BranchData_arr = array();
            foreach ($value['Service_Provider_Category'] as $key4 => $category) {
                if ($category['status'] == '0') {
                    $tempData = array();
                    array_push($CATImage_arr, $category['image']);
                    $this->loadModel('Category');
                    $Categories_data = $this->Category->find('first', array('conditions' => array('Category.id' => $category['category_id'])));
                    array_push($Icon_arr, $Categories_data['Category']['icon']);
                    $tempData['id'] = $Categories_data['Category']['id'];
                    $tempData['name_en'] = $Categories_data['Category']['name_en'];
                    $tempData['name_ar'] = $Categories_data['Category']['name_ar'];
                    $tempData['image'] = $category['image'];
                    $tempData['price'] = $category['price'];
                    $tempData['details_en'] = $category['details_en'];
                    array_push($CATData_arr, $tempData);
                }
            }
            foreach ($value['Branch'] as $key4 => $branch) {
                if ($branch['status'] == '0') {
                    $tempData = array();
                    $tempData['name'] = $branch['name'];
                    $tempData['status'] = $branch['status'];
                    $tempData['address'] = $branch['address'];
                    $tempData['googleaddress'] = $branch['googleaddress'];
                    array_push($BranchData_arr, $tempData);
                }
            }
            $temp['icons'] = $Icon_arr;
            $temp['images'] = $CATImage_arr;
            $temp['catdata'] = $CATData_arr;
            $temp['Branch'] = $BranchData_arr;

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

    public function get_CATServiceProvider_new() {
        //$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $CategoryID = $json['CategoryID'];
        $SearchKeyword = $json['SearchKeyword'];
        //$CategoryID = '2';

        $this->loadModel('Service_Provider');
        $this->Service_Provider->unbindModel(array(
            "hasMany" => array("ServiceTracking", "Reservation_Details", "Reservation", "Message", "Service_Provider_Complain", "Service_Tracking")
        ));

        if ($SearchKeyword == "") {
            $Service_Providers = $this->Service_Provider->find('all', array(
                'conditions' => array(
                    'Service_Provider.category_id' => $CategoryID,
                ), //'Service_Provider.approval_flag' => '1'
            ));
        } else {
            $this->loadModel('Service_Provider_Category');
            $Service_Provider_Category = $this->Service_Provider_Category->find('all', array(
                'conditions' => array(
                    'OR' => array(
                        'Service_Provider_Category.details_en LIKE' => '%' . $SearchKeyword . '%',
                        'Category.name_en LIKE' => '%' . $SearchKeyword . '%',
                        'Category.name_ar LIKE' => '%' . $SearchKeyword . '%',
                    )
                )
            ));
            $Service_Provider_Category_id = array();
            if (!empty($Service_Provider_Category)) {
                foreach ($Service_Provider_Category as $key => $value) {
                    $Service_Provider_Category_id[] = $value['Service_Provider_Category']['service_provider_id'];
                }
            }

            $this->loadModel('Service_Provider');
            $Service_Providers = $this->Service_Provider->find('all', array(
                'conditions' => array(
                    'OR' => array(
                        array(
                            //'Service_Provider.approval_flag' => '1',
                            'Service_Provider.id' => $Service_Provider_Category_id,
                        ),
                        'Service_Provider.service_name_en LIKE' => '%' . $SearchKeyword . '%',
                        'Service_Provider.service_description_en LIKE' => '%' . $SearchKeyword . '%',
                        'Category.name_en LIKE' => '%' . $SearchKeyword . '%',
                        'Category.name_ar LIKE' => '%' . $SearchKeyword . '%',
                        'Service_Type.name LIKE' => '%' . $SearchKeyword . '%',
                    //'Service_Provider_Category.details_en LIKE' => '%' . $SearchKeyword . '%',
                    )
                ),
            ));
        }
        // header("Content-Type: application/json", true);
        // echo json_encode($Service_Providers);
        // exit;

        $Service_Providers_arr = array();
        foreach ($Service_Providers as $key => $value) {
            $temp = array();
            $temp['id'] = $value['Service_Provider']['id'];
            $temp['user_id'] = $value['User']['id'];
            $temp['service_name_en'] = $value['Service_Provider']['service_name_en'];
            $temp['service_name_ar'] = $value['Service_Provider']['service_name_ar'];
            $temp['service_description_en'] = $value['Service_Provider']['service_description_en'];
            $temp['service_description_ar'] = $value['Service_Provider']['service_description_ar'];
            $temp['categroty_name_en'] = $value['Category']['name_en'];
            $temp['categroty_name_ar'] = $value['Category']['name_ar'];
            $temp['delivery_flag'] = $value['Service_Provider']['delivery_flag'];
            $temp['covarage_km'] = $value['Service_Provider']['covarage_km'];
            $temp['image'] = $value['Service_Provider']['image'];
            $temp['Service_Type'] = $value['Service_Type']['name'];
            $temp['approval_flag'] = $value['Service_Provider']['approval_flag'];
            $total_rating = 0;
            $count_rating = 0;
            $review_arr = array();
            foreach (array_reverse($value['User_Review']) as $key1 => $review) {
                /* if (!empty($review['review'])) {
                  $tmep_review = array();
                  $tmep_review['id'] = $review['id'];
                  $tmep_review['review'] = $review['review'];
                  $tmep_review['created'] = $review['created'];
                  $this->loadModel('User');
                  $User_data = $this->User->find('first', array('conditions' => array('User.id' => $review['user_id'])));
                  $tmep_review['username'] = $User_data['User']['fname'] . ' ' . $User_data['User']['lname'];
                  $tmep_review['profile_pic'] = $User_data['User']['profile_pic'];
                  array_push($review_arr, $tmep_review);
                  } */
                if (!empty($review['rate'])) {
                    $count_rating++;
                    $total_rating = $total_rating + $review['rate'];
                }
            }
            if ($count_rating > 0)
                $temp['rating'] = $total_rating / $count_rating;
            else
                $temp['rating'] = 0;
            //$temp['review'] = $review_arr;
            $Icon_arr = array();
            $CATImage_arr = array();
            $CATData_arr = array();
            $BranchData_arr = array();
            foreach ($value['Service_Provider_Category'] as $key4 => $category) {
                if ($category['status'] == '0') {
                    $tempData = array();
                    array_push($CATImage_arr, $category['image']);
                    $this->loadModel('Category');
                    $Categories_data = $this->Category->find('first', array('conditions' => array('Category.id' => $category['category_id'])));
                    array_push($Icon_arr, $Categories_data['Category']['icon']);
                    $tempData['id'] = $Categories_data['Category']['id'];
                    $tempData['name_en'] = $Categories_data['Category']['name_en'];
                    $tempData['name_ar'] = $Categories_data['Category']['name_ar'];
                    $tempData['image'] = $category['image'];
                    $tempData['price'] = $category['price'];
                    $tempData['details_en'] = $category['details_en'];
                    array_push($CATData_arr, $tempData);
                }
            }
            foreach ($value['Branch'] as $key4 => $branch) {
                if ($branch['status'] == '0') {
                    $tempData = array();
                    $tempData['name'] = $branch['name'];
                    $tempData['status'] = $branch['status'];
                    $tempData['address'] = $branch['address'];
                    $tempData['googleaddress'] = $branch['googleaddress'];
                    array_push($BranchData_arr, $tempData);
                }
            }
            $temp['icons'] = $Icon_arr;
            $temp['images'] = $CATImage_arr;
            $temp['catdata'] = $CATData_arr;
            $temp['Branch'] = $BranchData_arr;

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

    public function get_NearbyServiceProvider() {
        //$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Lat = $json['Lat'];
        $Lng = $json['Lng'];
        //$CategoryID = '2';
        //$Lat = '30.071806';
        //$Lng = '31.346023';


        $this->loadModel('Branch');
        /* $result = $this->Branch->query(
          "SELECT * , (3956 * 2 * ASIN(SQRT( POWER(SIN(( $Lat - lat) *  pi()/180 / 2), 2) +COS( $Lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(( $Lng - lng) * pi()/180 / 2), 2) ))) as distance
          from branches
          having  distance <= 10
          order by distance
          LIMIT 20;");
         */
        $branches = $this->Branch->query(
                "SELECT service_provider_id , (3956 * 2 * ASIN(SQRT( POWER(SIN(( $Lat - lat) *  pi()/180 / 2), 2) +COS( $Lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(( $Lng - lng) * pi()/180 / 2), 2) ))) as distance
          from branches
          order by distance
          LIMIT 20;");

        $Service_Provider_IDS = array();
        foreach ($branches as $key => $value) {
            $Service_Provider_IDS[] = $value['branches']['service_provider_id'];
        }
        //debug(array_unique($Service_Provider_IDS));
        //die();
        $this->loadModel('Service_Provider');
        $this->Service_Provider->unbindModel(array(
            "hasMany" => array("Reservation", "Message", "Service_Provider_Complain", "Service_Tracking")
        ));
        $Service_Providers = $this->Service_Provider->find('all', array(
            'conditions' => array(
                'Service_Provider.id' => array_unique($Service_Provider_IDS),
            ), //'Service_Provider.approval_flag' => '1'
        ));

        $Service_Providers_arr = array();
        foreach ($Service_Providers as $key => $value) {

            $temp = array();
            $temp['id'] = $value['Service_Provider']['id'];
            $temp['user_id'] = $value['User']['id'];
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
            foreach (array_reverse($value['User_Review']) as $key1 => $review) {
                /* if (!empty($review['review'])) {
                  $tmep_review = array();
                  $tmep_review['id'] = $review['id'];
                  $tmep_review['review'] = $review['review'];
                  $tmep_review['created'] = $review['created'];
                  $this->loadModel('User');
                  $User_data = $this->User->find('first', array('conditions' => array('User.id' => $review['user_id'])));
                  $tmep_review['username'] = $User_data['User']['fname'] . ' ' . $User_data['User']['lname'];
                  $tmep_review['profile_pic'] = $User_data['User']['profile_pic'];
                  array_push($review_arr, $tmep_review);
                  } */
                if (!empty($review['rate'])) {
                    $count_rating++;
                    $total_rating = $total_rating + $review['rate'];
                }
            }
            if ($count_rating > 0)
                $temp['rating'] = $total_rating / $count_rating;
            else
                $temp['rating'] = 0;
            // $temp['review'] = $review_arr;
            $Icon_arr = array();
            $CATImage_arr = array();
            $CATData_arr = array();
            $BranchData_arr = array();
            foreach ($value['Service_Provider_Category'] as $key4 => $category) {
                if ($category['status'] == '0') {
                    $tempData = array();
                    array_push($CATImage_arr, $category['image']);
                    $this->loadModel('Category');
                    $Categories_data = $this->Category->find('first', array('conditions' => array('Category.id' => $category['category_id'])));
                    array_push($Icon_arr, $Categories_data['Category']['icon']);
                    $tempData['id'] = $Categories_data['Category']['id'];
                    $tempData['name_ar'] = $Categories_data['Category']['name_ar'];
                    $tempData['name_en'] = $Categories_data['Category']['name_en'];
                    $tempData['image'] = $category['image'];
                    $tempData['price'] = $category['price'];
                    $tempData['details_en'] = $category['details_en'];
                    array_push($CATData_arr, $tempData);
                }
            }
            foreach ($value['Branch'] as $key4 => $branch) {
                if ($branch['status'] == '0') {
                    $tempData = array();
                    $tempData['name'] = $branch['name'];
                    $tempData['address'] = $branch['address'];
                    $tempData['googleaddress'] = $branch['googleaddress'];
                    array_push($BranchData_arr, $tempData);
                }
            }
            $temp['icons'] = $Icon_arr;
            $temp['images'] = $CATImage_arr;
            $temp['catdata'] = $CATData_arr;
            $temp['Branch'] = $BranchData_arr;

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

    public function get_NearbyBranches() {
        //$CategoryID = @$_POST['CategoryID'];
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $address_id = $json['address_id'];
        $serviceprovider_id = $json['serviceprovider_id'];
        $distance = $json['distance'];

        $this->loadModel('Address');
        $Address = $this->Address->find('first', array(
            'conditions' => array(
                'Address.id' => $address_id),
        ));
        $Lat = $Address['Address']['lat'];
        $Lng = $Address['Address']['lng'];

        $this->loadModel('Branch');
        $branches = $this->Branch->query(
                "SELECT id, name , address , (3956 * 2 * ASIN(SQRT( POWER(SIN(( $Lat - lat) *  pi()/180 / 2), 2) +COS( $Lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(( $Lng - lng) * pi()/180 / 2), 2) ))) as distance
          from branches
          where service_provider_id = $serviceprovider_id  AND status = 0
          order by distance;");

        $branch_data = '';
        foreach ($branches as $key => $branch) {
            if ((int) $branch[0]['distance'] <= (int) $distance) {
                $branch_data = $branch['branches']['name'] . ' - ' . $branch['branches']['address'];
            }
        }

        $return = array();
        if (!empty($branch_data)) {
            $return['status'] = 'success';
            $return['result'] = $branch_data;
        } else {
            $return['status'] = 'failed';
            $return['result'] = 'The provider is not covaring your area';
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
        if (!empty($ServiceProviderID)) {
            $this->loadModel('Service_Provider_Category');
            $Service_Provider_Categories = $this->Service_Provider_Category->find('all', array('conditions' => array('Service_Provider_Category.service_provider_id' => $ServiceProviderID)));

            $Service_Provider_Categories_arr = array();
            foreach ($Service_Provider_Categories as $key => $value) {
                $temp = array();
                $temp['id'] = $value['Service_Provider']['id'];
                $temp['user_id'] = $value['User']['id'];
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
                    /* if (!empty($review['review'])) {
                      $tmep_review = array();
                      $tmep_review['id'] = $review['id'];
                      $tmep_review['review'] = $review['review'];
                      $tmep_review['created'] = $review['created'];
                      $this->loadModel('User');
                      $User_data = $this->User->find('first', array('conditions' => array('User.id' => $review['user_id'])));
                      $tmep_review['username'] = $User_data['User']['fname'] . ' ' . $User_data['User']['lname'];
                      array_push($review_arr, $tmep_review);
                      } */
                    if (!empty($review['rate'])) {
                        $count_rating++;
                        $total_rating = $total_rating + $review['rate'];
                    }
                }
                if ($count_rating > 0)
                    $temp['rating'] = $total_rating / $count_rating;
                else
                    $temp['rating'] = 0;
                //$temp['review'] = $review_arr;
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
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'missing parameter';
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
                $Reservations = $this->Reservation->find('all', array('recursive' => '-1',
                    'conditions' => array('Reservation.user_id' => $checkUser['User']['id'], 'Reservation.service_provider_id' => $Serviceprovider_ID),
                    'order' => array('Reservation.modified desc')));
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
        //$Password = 'alaa@1234';
        //$Reservation_ID = '16';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('ReservationDetail');
                $ReservationDetail = $this->ReservationDetail->find('all', array('conditions' => array('ReservationDetail.reservation_id' => $Reservation_ID)));


                foreach ($ReservationDetail as $key => $value) {
                    $this->loadModel('ServiceTracking');
                    $ServiceTracking = $this->ServiceTracking->find('first', array('conditions' => array('ServiceTracking.reservation_id' => $Reservation_ID), 'order' => array('ServiceTracking.created DESC')));


                    $this->loadModel('Service_Provider_Category');
                    $Service_Provider_Category = $this->Service_Provider_Category->find('first', array('recursive' => '-1', 'conditions' => array('Service_Provider_Category.category_id' => $value['Category']['id'])));
                    $ReservationDetail[$key]['catdata'] = $Service_Provider_Category['Service_Provider_Category'];
                    $ReservationDetail[$key]['catdata']['quantity'] = $value['ReservationDetail']['quantity'];

                    $this->loadModel('Reservation_Status');
                    $Reservation_Status = $this->Reservation_Status->find('first', array('recursive' => '-1', 'conditions' => array('Reservation_Status.id' => $value['Reservation']['status'])));
                    $ReservationDetail[$key]['Reservation_Status'] = $Reservation_Status['Reservation_Status'];
                    if (!empty($ServiceTracking))
                        $ReservationDetail[$key]['ServiceTracking'] = $ServiceTracking['ServiceTracking'];
                    else
                        $ReservationDetail[$key]['ServiceTracking'] = array();
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
                        if ($value['quantity'] > 0) {
                            $Reservation_Lastid = $this->Reservation->getLastInsertID();

                            $ReservationDetails_array = array();
                            $ReservationDetails_array['ReservationDetail']['reservation_id'] = $Reservation_Lastid;
                            $ReservationDetails_array['ReservationDetail']['service_provider_id'] = $ServiceProvider_ID;
                            $ReservationDetails_array['ReservationDetail']['user_id'] = $checkUser['User']['id'];
                            $ReservationDetails_array['ReservationDetail']['category_id'] = $value['id'];
                            $ReservationDetails_array['ReservationDetail']['price'] = $value['price'];
                            $ReservationDetails_array['ReservationDetail']['quantity'] = $value['quantity'];

                            $this->loadModel('ReservationDetail');
                            $this->ReservationDetail->create();
                            if ($this->ReservationDetail->save($ReservationDetails_array)) {
                                $statusFlag = TRUE;
                            }
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
                    $return['result'] = 'success';
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

    function generateRandomString($length = 4) {
        $characters = '0123456789';
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
        $Trans_Ref = $json['trans_ref'];


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
                            'Reservation.approval_code' => "'" . $randomString . "'",
                            'Reservation.payment_date' => "'" . date('Y-m-d H:i:s') . "'",
                            'Reservation.trans_ref' => "'" . $Trans_Ref . "'",
                                ), array(
                            'Reservation.id' => $Reservation_ID
                        ))) {
                    $statusFlag = TRUE;
                }

                $return = array();
                if (!empty($statusFlag)) {
                    $return['status'] = 'success';
                    $return['result'] = 'success';
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
                $Reservations = $this->Reservation->find('all', array('recursive' => '-1', 'order' => array('Reservation.modified DESC'), 'conditions' => array('Reservation.user_id' => $checkUser['User']['id'])));
                if (!empty($Reservations)) {
                    $Reservations[0]['pendeingflag'] = 'false';
                    foreach ($Reservations as $key => $value) {
                        if ($value['Reservation']['status'] == '1') {
                            $Reservations[0]['pendeingflag'] = 'true';
                        }

                        $this->loadModel('Service_Provider');
                        $Service_Provider = $this->Service_Provider->find('first', array('conditions' => array('Service_Provider.id' => $value['Service_Provider']['id'])));

                        $CATData_arr = array();
                        foreach ($Service_Provider['Service_Provider_Category'] as $key4 => $category) {
                            $tempData = array();
                            $this->loadModel('Category');
                            $Categories_data = $this->Category->find('first', array('conditions' => array('Category.id' => $category['category_id'])));
                            $tempData['id'] = $Categories_data['Category']['id'];
                            $tempData['name'] = $Categories_data['Category']['name_en'];
                            $tempData['image'] = $category['image'];
                            $tempData['price'] = $category['price'];
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
        //$Username = 'sss@aaa.com';
        //$Password = '00000';
        //$Serviceprovider_ID = '2';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {

                $this->loadModel('Reservation');
                $Reservations = $this->Reservation->find('all', array('recursive' => '-1', 'order' => array('Reservation.modified DESC'), 'conditions' => array('Reservation.service_provider_id' => $checkUser['Service_Provider']['id'])));
                if (!empty($Reservations)) {
                    $Reservations[0]['pendeingflag'] = 'false';
                    foreach ($Reservations as $key => $value) {
                        if ($value['Reservation']['status'] == '1') {
                            $Reservations[0]['pendeingflag'] = 'true';
                        }

                        $this->loadModel('Service_Provider');
                        $Service_Provider = $this->Service_Provider->find('first', array('conditions' => array('Service_Provider.id' => $value['Service_Provider']['id'])));

                        $CATData_arr = array();
                        foreach ($Service_Provider['Service_Provider_Category'] as $key4 => $category) {
                            $tempData = array();
                            $this->loadModel('Category');
                            $Categories_data = $this->Category->find('first', array('conditions' => array('Category.id' => $category['category_id'])));
                            $tempData['id'] = $Categories_data['Category']['id'];
                            $tempData['name'] = $Categories_data['Category']['name_en'];
                            $tempData['image'] = $category['image'];
                            $tempData['price'] = $category['price'];
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
            $return['status'] = 'faile';
            $return['result'] = 'missing parameter';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function readd_ServiceProviderReservation() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Reservation_ID = $json['reservation_id'];
        //$DateTime = $json['datetime'];
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
                            'Reservation.service_provider_notes' => "'" . $Reservation['Reservation']['service_provider_notes'] . '\n' . $Notes . "'",
                            'Reservation.status' => '2',
                                ), array(
                            'Reservation.id' => $Reservation_ID
                        ))) {
                    $statusFlag = TRUE;
                }

                $return = array();
                if (!empty($statusFlag)) {
                    $return['status'] = 'success';
                    $return['result'] = 'success';
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

    public function confirm_ServiceProviderReservation() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Reservation_ID = $json['reservation_id'];
        //$DateTime = $json['datetime'];
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
                            'Reservation.service_provider_notes' => "'" . $Reservation['Reservation']['service_provider_notes'] . '\n' . $Notes . "'",
                            'Reservation.status' => '3',
                                ), array(
                            'Reservation.id' => $Reservation_ID
                        ))) {
                    $statusFlag = TRUE;
                }

                $return = array();
                if (!empty($statusFlag)) {
                    $return['status'] = 'success';
                    $return['result'] = 'success';
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

    public function DoneClose_ServiceProviderReservation() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Reservation_ID = $json['reservation_id'];
        $ApprovalCode = $json['approval_code'];
        //$Notes = $json['notes'];
        //$Username = 'laraa@alaa.com';
        //$Password = 'alaa@1234';
        //$Reservation_ID = '16';
        //$ApprovalCode = '578225';
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

                if ($ApprovalCode == $Reservation['Reservation']['approval_code']) {
                    $this->loadModel('Reservation');
                    if ($this->Reservation->updateAll(
                                    array(
                                'Reservation.status' => '5',
                                'Reservation.approval_flag' => '1',
                                'Reservation.approval_datetime' => "'" . date('Y-m-d H:i:s') . "'",
                                    ), array(
                                'Reservation.id' => $Reservation_ID
                            ))) {
                        $statusFlag = TRUE;
                    }
                } else {
                    $statusFlag = FALSE;
                }
                $return = array();
                if (!empty($statusFlag)) {
                    $return['status'] = 'success';
                    $return['result'] = 'success';
                } else {
                    $return['status'] = 'faile';
                    $return['result'] = 'Invalide Code';
                }
            }
        } else {
            $return['status'] = 'missing parameter';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function cancel_Reservation() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Reservation_ID = $json['reservation_id'];
        //$DateTime = $json['datetime'];
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
                            'Reservation.cancel_notes' => "'" . $Reservation['Reservation']['service_provider_notes'] . '\n' . $Notes . "'",
                            'Reservation.status' => '6',
                            'Reservation.cancel_datetime' => '6',
                            'Reservation.cancel_userid' => $checkUser['User']['id'],
                                ), array(
                            'Reservation.id' => $Reservation_ID
                        ))) {
                    $statusFlag = TRUE;
                }

                $return = array();
                if (!empty($statusFlag)) {
                    $return['status'] = 'success';
                    $return['result'] = 'success';
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

    public function complain_Reservation() {

        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $Reservation_ID = $json['reservation_id'];
        $Complain_ID = $json['complain_id'];
        $From_Flag = $json['from_flag'];
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
                $Reservation = $this->Reservation->find('first', array('recursive' => '-1', 'conditions' => array('Reservation.id' => $Reservation_ID)));

                $Service_Provider_Complain_array = array();
                $Service_Provider_Complain_array['Service_Provider_Complain']['from_flag'] = $From_Flag;
                $Service_Provider_Complain_array['Service_Provider_Complain']['user_id'] = $checkUser['User']['id'];
                $Service_Provider_Complain_array['Service_Provider_Complain']['service_provider_id'] = $Reservation['Reservation']['service_provider_id'];
                $Service_Provider_Complain_array['Service_Provider_Complain']['complain_id'] = '1';
                $Service_Provider_Complain_array['Service_Provider_Complain']['reservation_id'] = $Reservation_ID;
                $Service_Provider_Complain_array['Service_Provider_Complain']['status'] = '1';
                $Service_Provider_Complain_array['Service_Provider_Complain']['notes'] = $Notes;


                $this->loadModel('Service_Provider_Complain');
                $this->Service_Provider_Complain->create();
                if ($this->Service_Provider_Complain->save($Service_Provider_Complain_array)) {
                    $statusFlag = TRUE;
                }


                $return = array();
                if (!empty($statusFlag)) {
                    $return['status'] = 'success';
                    $return['result'] = 'complain added';
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

    public function update_Profile() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['emaillogin'];
        $Password = $json['password'];
        //$Username = 'lara@alaa.com';
        //$Password = 'alaa@1234';

        $fname = $json['fname'];
        $lname = $json['lname'];
        $email = $json['email'];
        // $gender = $json['gender'];
        //$birthday = $json['birthday'];
        $profile_pic = $json['profile_pic'];
        //$profile_pic = "";

        $date = new DateTime();
        $Timestamp = $date->getTimestamp();

        $statusFlag = FALSE;
        $UserData = array();
        $return = array();

        if (!empty($Username) && !empty($Password)) {

            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $user_id = $checkUser['User']['id'];
                $Imageurl = "";
                if (!empty($profile_pic)) {
                    $destination_path = getcwd() . DIRECTORY_SEPARATOR . 'upload/';
                    $target_path = $destination_path . basename($user_id . $Timestamp . '.PNG');
                    $data = base64_decode($profile_pic);
                    file_put_contents($target_path, $data);
                    $Imageurl = 'app/webroot/upload/' . $user_id . $Timestamp . '.PNG';
                }

                $this->loadModel('User');
                if ($this->User->updateAll(
                                array(
                            'User.fname' => "'" . $fname . "'",
                            'User.lname' => "'" . $lname . "'",
                            'User.email' => "'" . $email . "'",
                            //'User.gender' => "'" . $gender . "'",
                            //'User.birthday' => "'" . $birthday . "'",
                            'User.profile_pic' => "'" . $Imageurl . "'",
                                ), array(
                            'User.id' => $user_id
                        ))) {
                    $statusFlag = TRUE;
                    $this->loadModel("User");
                    $UserData = $this->User->find("first", array('recursive' => -1,
                        "conditions" => array(
                            "id" => $user_id
                    )));
                }
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }



        if ($statusFlag) {
            $return['status'] = 'success';
            $return['result'] = $UserData;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_Company() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        //$companyID = '1';
        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {

                $this->loadModel('Company');
                $Company_data = $this->Company->find('first', array('conditions' => array('Company.user_id' => $checkUser['User']['id'])));
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }

        $return = array();
        if (!empty($Company_data)) {
            $return['status'] = 'success';
            $return['result'] = $Company_data;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function update_Company() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['emaillogin'];
        $Password = $json['password'];

        $company_id = $json['company_id'];
        $companyname = $json['companyname'];
        $companyinfo = $json['companyinfo'];
        $companyofficialphone = $json['companyofficialphone'];
        $companyaddress = $json['companyaddress'];

        $statusFlag = FALSE;
        $Company_data = array();

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Company');
                if ($this->Company->updateAll(
                                array(
                            'Company.name' => "'" . $companyname . "'",
                            'Company.info' => "'" . $companyinfo . "'",
                            'Company.phone' => "'" . $companyofficialphone . "'",
                            'Company.address' => "'" . $companyaddress . "'",
                                ), array(
                            'Company.id' => $company_id
                        ))) {
                    $statusFlag = TRUE;
                    $this->loadModel('Company');
                    $Company_data = $this->Company->find('first', array('conditions' => array('Company.id' => $company_id)));
                }
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }



        $return = array();
        if ($statusFlag) {
            $return['status'] = 'success';
            $return['result'] = $Company_data;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_Service() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];

        //$Username = 'lara@alaa.com';
        //$Password = 'alaa@1234';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Service_Provider');
                $this->Service_Provider->unbindModel(array(
                    "hasMany" => array("Reservation", "Message", "Service_Provider_Complain", "ServiceTracking", "Service_Provider_Category", "ReservationDetail", "User_Review")
                ));
                $Service_Provider_data = $this->Service_Provider->find('first', array('conditions' => array('Service_Provider.user_id' => $checkUser['User']['id'])));
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }


        $return = array();
        if (!empty($Service_Provider_data)) {
            $return['status'] = 'success';
            $return['result'] = $Service_Provider_data;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function update_Service() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['emaillogin'];
        $Password = $json['password'];

        $service_id = $json['serviceid'];
        $servicename_en = $json['servicename'];
        $servicename_ar = $json['servicename'];
        $serviceinfo_en = $json['serviceinfo'];
        $serviceinfo_ar = $json['serviceinfo'];
        //$service_image = $json['service_image'];
        $officialphone = $json['officialphone'];
        //$Imageurl = $json['image'];
        //$area = $json['area'];
        $address = $json['address'];

        $statusFlag = FALSE;
        $Service_Provider_data = array();

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Service_Provider');
                if ($this->Service_Provider->updateAll(
                                array(
                            'Service_Provider.service_name_en' => "'" . $servicename_en . "'",
                            'Service_Provider.service_name_ar' => "'" . $servicename_ar . "'",
                            'Service_Provider.service_description_en' => "'" . $serviceinfo_en . "'",
                            'Service_Provider.service_description_ar' => "'" . $serviceinfo_ar . "'",
                            'Service_Provider.phone' => "'" . $officialphone . "'",
                            'Service_Provider.address' => "'" . $address . "'",
                                //'Service_Provider.area_id' => "'" . $area . "'",
                                //'Service_Provider.image' => "'" . $service_image . "'",
                                ), array(
                            'Service_Provider.id' => $service_id
                        ))) {
                    $statusFlag = TRUE;
                    $this->loadModel('Service_Provider');
                    $this->Service_Provider->unbindModel(array(
                        "hasMany" => array("Reservation", "Message", "Service_Provider_Complain", "ServiceTracking", "Service_Provider_Category", "ReservationDetail", "User_Review")
                    ));
                    $Service_Provider_data = $this->Service_Provider->find('first', array('conditions' => array('Service_Provider.id' => $service_id)));
                }
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }




        $return = array();
        if ($statusFlag) {
            $return['status'] = 'success';
            $return['result'] = $Service_Provider_data;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_SubService() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        //$serviceprovider_ID = $json['service_provider_id'];
        //$Username = 'alaa.naser@citystars.com';
        //$Password = 'alaa@1234';
        //$serviceprovider_ID = '1';


        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Service_Provider');
                $Service_Provider_data = $this->Service_Provider->find('first', array('recursive' => -1, 'conditions' => array('Service_Provider.user_id' => $checkUser['User']['id'])));
                $serviceprovider_ID = $Service_Provider_data['Service_Provider']['id'];

                $this->loadModel('Service_Provider_Category');
                $Service_Provider_Category_data = $this->Service_Provider_Category->find('all', array('conditions' => array('Service_Provider_Category.service_provider_id' => $serviceprovider_ID)));
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }


        $return = array();
        if (!empty($Service_Provider_Category_data)) {
            $return['status'] = 'success';
            $return['result'] = $Service_Provider_Category_data;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_AllSubService() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        //$serviceprovider_ID = $json['service_provider_id'];
        //$Username = 'laraa@alaa.com';
        //$Password = 'alaa@1234';
        //$serviceprovider_ID = '1';


        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Service_Provider');
                $Service_Provider_data = $this->Service_Provider->find('first', array('conditions' => array('Service_Provider.user_id' => $checkUser['User']['id'])));

                $this->loadModel('Category');
                $Category = $this->Category->find('all', array('recursive' => -1, 'conditions' => array('Category.parent_id' => $Service_Provider_data['Service_Provider']['category_id'])));
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }


        $return = array();
        if (!empty($Category)) {
            $return['status'] = 'success';

            $return['result']['Category'] = $Category;
            $return['result']['serviceprovider_ID'] = $Service_Provider_data['Service_Provider']['id'];
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function add_SubService() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $serviceprovider_ID = $json['service_provider_id'];
        $category_ID = $json['category_ID'];
        $serviceprovider_image = $json['image'];
        $serviceprovider_price = $json['price'];
        $serviceprovider_details_en = $json['details_en'];
        $serviceprovider_details_ar = $json['details_ar'];
        $date = new DateTime();
        $Timestamp = $date->getTimestamp();

        $statusFlag = FALSE;
        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Service_Provider');
                $Service_Provider_data = $this->Service_Provider->find('first', array('conditions' => array('Service_Provider.id' => $serviceprovider_ID)));
                $serviceprovider_categoryID = $Service_Provider_data['Service_Provider']['category_id'];

                $destination_path = getcwd() . DIRECTORY_SEPARATOR . 'upload/';
                $target_path = $destination_path . basename($serviceprovider_ID . $Timestamp . '.PNG');
                $data = base64_decode($serviceprovider_image);
                file_put_contents($target_path, $data);
                $Imageurl = 'app/webroot/upload/' . $serviceprovider_ID . $Timestamp . '.PNG';

                $Service_Provider_Category_arr = array();
                $Service_Provider_Category_arr['Service_Provider_Category']['service_provider_id'] = $serviceprovider_ID;
                $Service_Provider_Category_arr['Service_Provider_Category']['category_id'] = $category_ID;
                $Service_Provider_Category_arr['Service_Provider_Category']['image'] = $Imageurl;
                $Service_Provider_Category_arr['Service_Provider_Category']['price'] = $serviceprovider_price;
                $Service_Provider_Category_arr['Service_Provider_Category']['details_en'] = $serviceprovider_details_en;
                $Service_Provider_Category_arr['Service_Provider_Category']['details_ar'] = $serviceprovider_details_ar;


                $this->loadModel("Service_Provider_Category");
                $this->Service_Provider_Category->create();
                if ($this->Service_Provider_Category->save($Service_Provider_Category_arr)) {
                    $statusFlag = TRUE;
                }
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }


        $return = array();
        if ($statusFlag) {
            $return['status'] = 'success';
            // $return['result'] = $Service_Provider_Category_data;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function disable_SubService() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $status = $json['status'];
        $Service_Provider_Category_ID = $json['Service_Provider_Category_ID'];

        $statusFlag = FALSE;

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Service_Provider_Category');
                if ($this->Service_Provider_Category->updateAll(
                                array(
                            'Service_Provider_Category.status' => $status,
                                ), array(
                            'Service_Provider_Category.id' => $Service_Provider_Category_ID
                        ))) {
                    $statusFlag = TRUE;
                }
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }




        $return = array();
        if ($statusFlag) {
            $return['status'] = 'success';
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_Branches() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        //$serviceprovider_ID = $json['service_provider_id'];
        //$Username = 'alaa.naser@citystars.com';
        //$Password = 'alaa@1234';
        //$serviceprovider_ID = '8';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel("Service_Provider");
                $Service_Provider = $this->Service_Provider->find('first', array('conditions' => array('Service_Provider.user_id' => $checkUser['User']['id']))); //, 'Service_Provider.approval_flag' => '1'

                $this->loadModel('Branch');
                $Branch_data = $this->Branch->find('all', array('recursive' => -1, 'conditions' => array('Branch.status' => '0', 'Branch.service_provider_id' => $Service_Provider['Service_Provider']['id'])));
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }


        $return = array();
        if (!empty($Branch_data)) {
            $return['status'] = 'success';
            $return['result'] = $Branch_data;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function add_Branch() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $branchName = $json['branch_name'];
        $branchAddress = $json['branch_address'];
        $googleAddress = $json['google_address'];
        $lat = $json['lat'];
        $lng = $json['lng'];
        $area = $json['area'];

        //$Username = 'alaa.naser@citystars.com';
        //$Password = 'alaa@1234';
        //$branchName = '';
        //$branchAddress = '';
        //$googleAddress = '';
        //$lat = '';
        // $lng = '';
        //$area = '';
        $return = array();
        if (!empty($Username) && !empty($Password)) {

            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel("Service_Provider");
                $Service_Provider = $this->Service_Provider->find('first', array('conditions' => array('Service_Provider.user_id' => $checkUser['User']['id']))); //, 'Service_Provider.approval_flag' => '1'


                $newBranch = array();
                $newBranch['Branch']['service_provider_id'] = $Service_Provider['Service_Provider']['id'];
                $newBranch['Branch']['name'] = $branchName;
                $newBranch['Branch']['address'] = $branchAddress;
                $newBranch['Branch']['googleaddress'] = $googleAddress;
                $newBranch['Branch']['lat'] = $lat;
                $newBranch['Branch']['lng'] = $lng;
                $newBranch['Branch']['area'] = $area;
                $this->loadModel('Branch');
                $this->Branch->create();
                if ($this->Branch->save($newBranch)) {
                    $checkUser = $this->check_User($Username, $Password);
                    $return['status'] = 'success';
                    $return['result'] = $checkUser;
                } else {
                    $return['status'] = 'faile';
                    $return['result'] = 'Error happened, Please try again later';
                }
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function disable_Branch() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $status = $json['status'];
        $Branch_ID = $json['Branch_ID'];

        $statusFlag = FALSE;

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Branch');
                if ($this->Branch->updateAll(
                                array(
                            'Branch.status' => $status,
                                ), array(
                            'Branch.id' => $Branch_ID
                        ))) {
                    $statusFlag = TRUE;
                }
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }

        $return = array();
        if ($statusFlag) {
            $return['status'] = 'success';
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_Addresses() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        //$serviceprovider_ID = $json['service_provider_id'];
        //$Username = 'alaa.naser@citystars.com';
        //$Password = 'alaa@1234';
        //$serviceprovider_ID = '8';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Address');
                $Address_data = $this->Address->find('all', array('recursive' => -1, 'conditions' => array('Address.status' => '0', 'Address.user_id' => $checkUser['User']['id'])));
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }
        $return = array();
        if (!empty($Address_data)) {
            $return['status'] = 'success';
            $return['result'] = $Address_data;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function add_Address() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $addressName = $json['address_name'];
        $Address = $json['address_address'];
        $googleAddress = $json['google_address'];
        $lat = $json['lat'];
        $lng = $json['lng'];
        $area = $json['area'];

        //$Username = 'alaa.naser@citystars.com';
        //$Password = 'alaa@1234';
        //$branchName = '';
        //$branchAddress = '';
        //$googleAddress = '';
        //$lat = '';
        // $lng = '';
        //$area = '';
        $return = array();
        if (!empty($Username) && !empty($Password)) {

            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $newAddress = array();
                $newAddress['Address']['user_id'] = $checkUser['User']['id'];
                $newAddress['Address']['name'] = $addressName;
                $newAddress['Address']['address'] = $Address;
                $newAddress['Address']['googleaddress'] = $googleAddress;
                $newAddress['Address']['lat'] = $lat;
                $newAddress['Address']['lng'] = $lng;
                $newAddress['Address']['area'] = $area;
                $this->loadModel('Address');
                $this->Address->create();
                if ($this->Address->save($newAddress)) {
                    $checkUser = $this->check_User($Username, $Password);
                    $return['status'] = 'success';
                    $return['result'] = $checkUser;
                } else {
                    $return['status'] = 'faile';
                    $return['result'] = 'Error happened, Please try again later';
                }
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function disable_Address() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $status = $json['status'];
        $Address_ID = $json['Address_ID'];

        $statusFlag = FALSE;

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Address');
                if ($this->Address->updateAll(
                                array(
                            'Address.status' => $status,
                                ), array(
                            'Address.id' => $Address_ID
                        ))) {
                    $statusFlag = TRUE;
                }
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }

        $return = array();
        if ($statusFlag) {
            $return['status'] = 'success';
            $checkUser = $this->check_User($Username, $Password);
            $return['result'] = $checkUser;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function update_Configration() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $delivery_flag = $json['delivery_flag'];
        $covarage_km = $json['covarage_km'];
        $traking_flag = $json['traking_flag'];

        $statusFlag = FALSE;

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            $this->loadModel("Service_Provider");
            $Service_Provider = $this->Service_Provider->find('first', array('conditions' => array('Service_Provider.user_id' => $checkUser['User']['id']))); //, 'Service_Provider.approval_flag' => '1'
            if ($delivery_flag)
                $delivery_flag = 1;
            else
                $delivery_flag = 0;
            if ($traking_flag)
                $traking_flag = 1;
            else
                $traking_flag = 0;


            if (!empty($checkUser)) {
                $this->loadModel('Service_Provider');
                if ($this->Service_Provider->updateAll(
                                array(
                            'Service_Provider.delivery_flag' => $delivery_flag,
                            'Service_Provider.covarage_km' => $covarage_km,
                            'Service_Provider.traking_flag' => $traking_flag,
                                ), array(
                            'Service_Provider.id' => $Service_Provider['Service_Provider']['id']
                        ))) {
                    $statusFlag = TRUE;
                    $checkUser = $this->check_User($Username, $Password);
                }
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }

        $return = array();
        if ($statusFlag && !empty($checkUser)) {
            $return['status'] = 'success';
            $return ['result'] = $checkUser;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_Messages_user() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $serviceprovider_ID = $json['service_provider_id'];
        $user_ID = $json['user_id'];



        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Message');
                $Message_data = $this->Message->find('all', array('recursive' => -1, 'conditions' => array('Message.service_provider_id' => $serviceprovider_ID, 'Message.user_id' => $user_ID), "order" => array('Message.created')));
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }
        $return = array();
        if (!empty($Message_data)) {
            $return['status'] = 'success';
            $return['result'] = $Message_data;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function add_Message() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        $serviceprovider_ID = $json['service_provider_id'];
        $user_ID = $json['user_id'];
        $Message = $json['message'];



        $return = array();
        if (!empty($Username) && !empty($Password)) {

            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {

                if ($checkUser['User']['permission_id'] == '3') {
                    $user_serviceprovider_flag = '1';
                } else {
                    $user_serviceprovider_flag = '2';
                }
                $newMessage = array();
                $newMessage['Message']['user_id'] = $user_ID;
                $newMessage['Message']['user_serviceprovider_flag'] = $user_serviceprovider_flag;
                $newMessage['Message']['massage'] = $Message;
                $newMessage['Message']['service_provider_id'] = $serviceprovider_ID;
                $this->loadModel('Message');
                $this->Message->create();
                if ($this->Message->save($newMessage)) {
                    $return['status'] = 'success';
                    $return['result'] = 'success';
                } else {
                    $return['status'] = 'faile';
                    $return['result'] = 'Error happened, Please try again later';
                }
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

    public function get_Messages_serviceProvied() {
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $Username = $json['email'];
        $Password = $json['password'];
        //$serviceprovider_ID = $json['service_provider_id'];
        //$Username = '01001887161';
        //$Password = '123456';
        //$serviceprovider_ID = '1';

        if (!empty($Username) && !empty($Password)) {
            $checkUser = $this->check_User($Username, $Password);
            if (!empty($checkUser)) {
                $this->loadModel('Message');
                $Message_data = $this->Message->find('all', array('conditions' => array('Message.service_provider_id' => $checkUser['Service_Provider']['id'], 'Message.user_serviceprovider_flag' => '1'), "order" => array('Message.created'), "group" => array('Message.user_id')));
            }
        } else {
            $return['status'] = 'faile';
            $return['status'] = 'missing parameter';
        }
        $return = array();
        if (!empty($Message_data)) {
            $return['status'] = 'success';
            $return['result'] = $Message_data;
        } else {
            $return['status'] = 'faile';
            $return['result'] = 'no data found';
        }

        header("Content-Type: application/json", true);
        echo json_encode($return);
        exit;
    }

}
