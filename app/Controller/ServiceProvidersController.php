<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class ServiceProvidersController extends AppController {

    //get all the employees and set them to showall view
    public $components = array('Session', 'Paginator');

    public function showall_needaction() {

        $this->loadModel("Service_Provider");
        $this->Service_Provider->unbindModel(array(
            "hasMany" => array("Service_Provider_Category", "Reservation", "Reservation_Details", "Message", "Service_Provider_Complain", "ServiceTracking", "User_Review", "Branch")
        ));
        $Service_Providers_new = array();
        //$Service_Providers = $this->Service_Provider->find("all", array('conditions' =>
        //   array('Service_Provider.approval_flag' => '0'),
        //  'order' => 'Service_Provider.modified DESC'));
        // we prepare our query, the cakephp way!
        $this->paginate = array(
            'conditions' => array('Service_Provider.approval_flag' => '0'),
            'limit' => 10,
            'order' => array('Service_Provider.modified' => 'desc')
        );

        // we are using the 'User' model
        $Service_Providers = $this->paginate('Service_Provider');




        $freelance_count = 0;
        $coorporate_count = 0;

        foreach ($Service_Providers as $key => $value) {

            if ($value['Service_Provider']['service_type_id'] == '1')
                $coorporate_count++;
            else if ($value['Service_Provider']['service_type_id'] == '2')
                $freelance_count++;

            $this->loadModel("Paper_Transaction");
            $Paper_Transactions = $this->Paper_Transaction->find("first", array('conditions' => array('Paper_Transaction.user_id' => $value['Service_Provider']['user_id'])));
            if (!empty($Paper_Transactions)) {
                $type = $value['Service_Provider']['service_type_id'];
                $userID = $value['User']['id'];

                $Required_Paper_arr = $this->papers_check_fun($type, $userID);
                $action_flag = FALSE;
                $missing_flag = FALSE;
                $papers_status_details = '';
                foreach ($Required_Paper_arr as $keyy => $valueee) {

                    if ($valueee["approval_flag"] == '1') {
                        $papers_status_details = $papers_status_details . $valueee["paper_name_en"] . '<span style="color:green"> <b> Approved </b></span>' . '<br>';
                    } else if ($valueee["approval_flag"] == '2') {
                        $papers_status_details = $papers_status_details . $valueee["paper_name_en"] . '<span style="color:red"> <b>  Need Action </b></span>' . '<br>';
                    } else if ($valueee["approval_flag"] == '3') {
                        $papers_status_details = $papers_status_details . $valueee["paper_name_en"] . '<span style="color:red"> <b>  Rejected </b></span>' . '<br>';
                    } else if ($valueee["approval_flag"] == '4') {
                        $papers_status_details = $papers_status_details . $valueee["paper_name_en"] . '<span style="color:gold"> <b>  Missing </b></span>' . '<br>';
                    }
                }
                //debug($Required_Paper_arr);
                $value['Service_Provider']['papers_status_details'] = $papers_status_details;
                //$value['Service_Provider']['action_flag'] = $action_flag;
                // foreach ($Paper_Transactions as $key1 => $paper) {
                //if ($paper['Paper_Transaction']['approval_flag'] == 2) {
                // continue 2;
                //}
                //}
            } else {
                $value['Service_Provider']['papers_status_details'] = "No Papers Uploaded Yet";
            }
            $Service_Providers_new[] = $value;
        }
        //debug($Service_Providers_new);die();
        $this->set("Service_Providers", $Service_Providers_new);
        $this->set("freelance_count", $freelance_count);
        $this->set("coorporate_count", $coorporate_count);
    }

    public function showall_pending() {

        $this->loadModel("Service_Provider");
        $this->Service_Provider->unbindModel(array(
            "hasMany" => array("Service_Provider_Category", "Reservation", "Reservation_Details", "Message", "Service_Provider_Complain", "ServiceTracking", "User_Review", "Branch")
        ));
        // $Service_Providers = $this->Service_Provider->find("all", array('conditions' => array('Service_Provider.approval_flag' => '0'), 'order' => 'Service_Provider.modified DESC'));


        $this->paginate = array(
            'conditions' => array('Service_Provider.approval_flag' => '0'),
            'limit' => 10,
            'order' => array('Service_Provider.modified' => 'desc')
        );

        // we are using the 'User' model
        $Service_Providers = $this->paginate('Service_Provider');

        $serviceprovider_types = array();
        $serviceprovider_types[0] = 'All';
        $serviceprovider_types[1] = 'Coorporate';
        $serviceprovider_types[2] = 'Freelance';
        // debug($Service_Providers);
        // die();


        $this->set("Service_Providers", $Service_Providers);
        $this->set("serviceprovider_types", $serviceprovider_types);

        if (!empty($this->request->data)) {
            $this->loadModel("Service_Provider");
            $this->Service_Provider->unbindModel(array(
                "hasMany" => array("Service_Provider_Category", "Reservation", "Reservation_Details", "Message", "Service_Provider_Complain", "ServiceTracking", "User_Review", "Branch")
            ));
            $Service_Providername = $this->request->data['ServiceProviders']['serviceprovider_name'];
            $Service_Providertype = $this->request->data['ServiceProviders']['service_type_id'];
            if ($Service_Providertype == 0) {
                //$Service_Providers = $this->Service_Provider->find("all", array('conditions' => array('Service_Provider.approval_flag' => '0', 'Service_Provider.service_name_en LIKE' => "%" . $Service_Providername . "%"), 'order' => 'Service_Provider.modified DESC'));
                $this->paginate = array(
                    'conditions' => array('Service_Provider.approval_flag' => '0', 'Service_Provider.service_name_en LIKE' => "%" . $Service_Providername . "%"),
                    'limit' => 10,
                    'order' => array('Service_Provider.modified' => 'desc')
                );

                // we are using the 'User' model
                $Service_Providers = $this->paginate('Service_Provider');
            } else {
                //$Service_Providers = $this->Service_Provider->find("all", array('conditions' => array('Service_Provider.service_type_id' => $Service_Providertype, 'Service_Provider.approval_flag' => '0', 'Service_Provider.service_name_en LIKE' => "%" . $Service_Providername . "%"), 'order' => 'Service_Provider.modified DESC'));
                $this->paginate = array(
                    'conditions' => array('Service_Provider.service_type_id' => $Service_Providertype, 'Service_Provider.approval_flag' => '0', 'Service_Provider.service_name_en LIKE' => "%" . $Service_Providername . "%"),
                    'limit' => 10,
                    'order' => array('Service_Provider.modified' => 'desc')
                );

                // we are using the 'User' model
                $Service_Providers = $this->paginate('Service_Provider');
            }
            $this->set("Service_Providers", $Service_Providers);
        }
    }

    public function showall() {

        $this->loadModel("Service_Provider");
        $this->Service_Provider->unbindModel(array(
            "hasMany" => array("Service_Provider_Category", "Reservation", "Reservation_Details", "Message", "Service_Provider_Complain", "ServiceTracking", "User_Review", "Branch")
        ));
        //$Service_Providers = $this->Service_Provider->find("all", array('order' => 'Service_Provider.modified DESC'));

        $this->paginate = array(
            // 'conditions' => array('Service_Provider.approval_flag' => '0'),
            'limit' => 10,
            'order' => array('Service_Provider.modified' => 'desc')
        );

        // we are using the 'User' model
        $Service_Providers = $this->paginate('Service_Provider');

        $serviceprovider_types = array();
        $serviceprovider_types[0] = 'All';
        $serviceprovider_types[1] = 'Coorporate';
        $serviceprovider_types[2] = 'Freelance';
        // debug($Service_Providers);
        // die();


        $this->set("Service_Providers", $Service_Providers);
        $this->set("serviceprovider_types", $serviceprovider_types);
        if (!empty($this->request->data)) {
            $this->loadModel("Service_Provider");
            $this->Service_Provider->unbindModel(array(
                "hasMany" => array("Service_Provider_Category", "Reservation", "Reservation_Details", "Message", "Service_Provider_Complain", "ServiceTracking", "User_Review", "Branch")
            ));
            $Service_Providername = $this->request->data['ServiceProviders']['serviceprovider_name'];

            $Service_Providertype = $this->request->data['ServiceProviders']['service_type_id'];
            if ($Service_Providertype == 0) {
                //$Service_Providers = $this->Service_Provider->find("all", array('conditions' => array('Service_Provider.service_name_en LIKE' => "%" . $Service_Providername . "%"), 'order' => 'Service_Provider.modified DESC'));
                $this->paginate = array(
                    'conditions' => array('Service_Provider.service_name_en LIKE' => "%" . $Service_Providername . "%"),
                    'limit' => 10,
                    'order' => array('Service_Provider.modified' => 'desc')
                );

                // we are using the 'User' model
                $Service_Providers = $this->paginate('Service_Provider');
            } else {
                //$Service_Providers = $this->Service_Provider->find("all", array('conditions' => array('Service_Provider.service_type_id' => $Service_Providertype, 'Service_Provider.service_name_en LIKE' => "%" . $Service_Providername . "%"), 'order' => 'Service_Provider.modified DESC'));

                $this->paginate = array(
                    'conditions' => array('Service_Provider.service_type_id' => $Service_Providertype, 'Service_Provider.service_name_en LIKE' => "%" . $Service_Providername . "%"),
                    'limit' => 10,
                    'order' => array('Service_Provider.modified' => 'desc')
                );

                // we are using the 'User' model
                $Service_Providers = $this->paginate('Service_Provider');
            }

            $this->set("Service_Providers", $Service_Providers);
        }
    }

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
            $papers_arr[] = '7';
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
            $papers_arr[] = '7';
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
                        $temp['Paper_Transaction_id'] = $Transaction['Paper_Transaction']['id'];
                        $temp['attachment'] = $Transaction['Paper_Transaction']['attachment'];
                        $temp['approval_flag'] = $Transaction['Paper_Transaction']['approval_flag'];
                        $temp['admin_notes'] = $Transaction['Paper_Transaction']['admin_notes'];
                        $temp['old_notes'] = str_replace("'", '', $Transaction['Paper_Transaction']['notes_history']);
                        ;
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

    public function details($Service_Provider_id = null) {
        $this->loadModel("Service_Provider");
        $Service_Provider = $this->Service_Provider->find("first", array("conditions" => array("Service_Provider.id" => $Service_Provider_id)));

        $this->loadModel("Company");
        $Company = $this->Company->find("first", array("conditions" => array("Company.service_provider_id" => $Service_Provider_id)));


        $type = $Service_Provider['Service_Provider']['service_type_id'];
        $userID = $Service_Provider['User']['id'];
        $Required_Paper_arr = array();
        $Required_Paper_arr = $this->papers_check_fun($type, $userID);

        $this->loadModel("Notification");
        $Notifications = $this->Notification->find("all", array("conditions" => array("Notification.user_id" => $userID)));

        $this->loadModel("Area");
        $Areas = $this->Area->find("all");


        $this->loadModel("Service_Provider_Category");
        $Service_Provider_Category = $this->Service_Provider_Category->find("all", array("conditions" => array("Service_Provider_Category.service_provider_id" => $Service_Provider_id)));

        $this->loadModel("User_Review");
        $User_Review = $this->User_Review->find("all", array("conditions" => array("User_Review.service_provider_id" => $Service_Provider_id)));
        $this->loadModel("Reservation");
        $Reservation = $this->Reservation->find("all", array("conditions" => array("Reservation.service_provider_id" => $Service_Provider_id)));


        $action_flag = FALSE;
        $missing_flag = FALSE;
        foreach ($Required_Paper_arr as $key => $value) {
            if ($value["approval_flag"] == '2') {
                $action_flag = TRUE;
            } else if ($value["approval_flag"] == '3') {
                $action_flag = TRUE;
            } else if ($value["approval_flag"] == '4') {
                $missing_flag = TRUE;
            }
        }
        $this->loadModel('Category');
        $Categories_data = $this->Category->find('all', array('recursive' => -1, 'conditions' => array('Category.parent_id' => '0')));

        $this->loadModel('Category');
        $SubCategory = $this->Category->find('all', array('recursive' => -1, 'conditions' => array('Category.parent_id' => $Service_Provider['Service_Provider']['category_id'])));


        $Category_names = array();
        foreach ($Categories_data as $key => $array) {
            $Category_names[$array['Category']['id']] = $array['Category']['name_en'];
        }

        $this->loadModel('Service_Type');
        $Service_Type = $this->Service_Type->find('all', array('recursive' => -1));

        $Service_Type_names = array();
        foreach ($Service_Type as $key => $array) {
            $Service_Type_names[$array['Service_Type']['id']] = $array['Service_Type']['name'];
        }

        $Area_names = array();
        foreach ($Areas as $key => $array) {
            $Area_names[$array['Area']['id']] = $array['Area']['name_ar'];
        }

        $SubCategory_names = array();
        foreach ($SubCategory as $key => $array) {
            $SubCategory_names[$array['Category']['id']] = $array['Category']['name_ar'];
        }
        //debug($Required_Paper_arr);
        // die();
        if (!empty($Service_Provider)) {
            $this->set("Service_Provider", $Service_Provider);
            $this->set("Notifications", $Notifications);
            $this->set("Areas", $Area_names);
            $this->set("Company", $Company);
            $this->set("SubCategory_names", $SubCategory_names);

            $this->set("Required_Paper_arr", $Required_Paper_arr);
            $this->set("Service_Provider_Category", $Service_Provider_Category);
            $this->set("User_Review", $User_Review);
            $this->set("Reservation", $Reservation);
            $this->set("action_flag", $action_flag);
            $this->set("missing_flag", $missing_flag);
            $this->set("Category_names", $Category_names);
            $this->set("Service_Type_names", $Service_Type_names);
        }

        if (!empty($this->request->data)) {

            if ($this->request->data['btn'] == 'Add Service') {


                $filename = null;
                $filenameSaved = null;
                if (!empty($this->data['SubService']['file_panner']['name'])) {
                    $fileName = $this->data['SubService']['file_panner']['name'];
                    $fileContent = ($this->data['SubService']['file_panner']['tmp_name']);

                    $fileCode = '(' . time() . '-' . $this->request->data['SubService']['Service_Provider_id'] . ')';
                    $filename = WWW_ROOT . DS . 'files' . DS . $fileCode . $fileName;
                    $filenameSaved = 'app/webroot/files/' . $fileCode . $fileName;
                    move_uploaded_file($fileContent, $filename);

                    $Service_Provider_Category_arr = array();
                    $Service_Provider_Category_arr['Service_Provider_Category']['category_id'] = $this->request->data['SubService']['subservice_category_id'];
                    $Service_Provider_Category_arr['Service_Provider_Category']['service_provider_id'] = $this->request->data['SubService']['service_provider_id'];
                    $Service_Provider_Category_arr['Service_Provider_Category']['image'] = $filenameSaved;
                    $Service_Provider_Category_arr['Service_Provider_Category']['price'] = $this->request->data['SubService']['price'];
                    $Service_Provider_Category_arr['Service_Provider_Category']['details_en'] = $this->request->data['SubService']['details_en'];
                    $Service_Provider_Category_arr['Service_Provider_Category']['details_ar'] = $this->request->data['SubService']['details_en'];
                    $Service_Provider_Category_arr['Service_Provider_Category']['edited_by'] = $this->Session->read('User.User.id');

                    $this->loadModel("Service_Provider_Category");
                    $this->Service_Provider_Category->create();
                    if ($this->Service_Provider_Category->save($Service_Provider_Category_arr)) {
                        $this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));
                        $this->redirect(array("controller" => "ServiceProviders", "action" => "details/" . $this->request->data['Paper_Transaction']['Service_Provider_id']));
                    } else {
                        $this->Session->setFlash("error in saving,please try again", "default", array("class" => "error-message"));
                        $this->redirect(array("controller" => "ServiceProviders", "action" => "details", $this->request->data['Paper_Transaction']['Service_Provider_id']));
                    }
                } else {
                    $this->Session->setFlash("error in saving,please try again", "default", array("class" => "error-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details", $this->request->data['Paper_Transaction']['Service_Provider_id']));
                }
            } else if ($this->request->data['btn'] == 'Update Company') {
                $this->loadModel("Company");
                if ($this->Company->updateAll(
                                array(
                            'Company.name' => "'" . str_replace("'", "''", $this->request->data['Company']['name']) . "'",
                            'Company.phone' => "'" . $this->request->data['Company']['phone'] . "'",
                            'Company.address' => "'" . str_replace("'", "''", $this->request->data['Company']['address']) . "'",
                            'Company.info' => "'" . str_replace("'", "''", $this->request->data['Company']['info']) . "'",
                            'Company.edited_by' => $this->Session->read('User.User.id')
                                )
                                , array(
                            'Company.user_id' => $this->request->data['Company']['User_id']
                        ))) {
                    $this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details/" . $this->request->data['Paper_Transaction']['Service_Provider_id']));
                } else {
                    $this->Session->setFlash("error in saving,please try again", "default", array("class" => "error-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details", $this->request->data['Paper_Transaction']['Service_Provider_id']));
                }
            } else if ($this->request->data['btn'] == 'Update Account') {
                $this->loadModel("User");
                if ($this->User->updateAll(
                                array(
                            'User.fname' => "'" . str_replace("'", "''", $this->request->data['Paper_Transaction']['fname']) . "'",
                            'User.lname' => "'" . str_replace("'", "''", $this->request->data['Paper_Transaction']['lname']) . "'",
                            'User.email' => "'" . str_replace("'", "''", $this->request->data['Paper_Transaction']['email']) . "'",
                            'User.phone' => "'" . $this->request->data['Paper_Transaction']['phone'] . "'",
                            'User.birthday' => "'" . $this->request->data['Paper_Transaction']['birthday'] . "'",
                            'User.idnumber' => "'" . $this->request->data['Paper_Transaction']['idnumber'] . "'",
                            'User.edited_by' => $this->Session->read('User.User.id')
                                )
                                , array(
                            'User.id' => $this->request->data['Paper_Transaction']['User_id']
                        ))) {
                    $this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details/" . $this->request->data['Paper_Transaction']['Service_Provider_id']));
                } else {
                    $this->Session->setFlash("error in saving,please try again", "default", array("class" => "error-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details", $this->request->data['Paper_Transaction']['Service_Provider_id']));
                }
            } else if ($this->request->data['btn'] == 'Update Provider') {
                $filename = null;
                $filenameSaved = null;
                if (!empty($this->data['Paper_Transaction']['file']['name'])) {
                    $fileName = $this->data['Paper_Transaction']['file']['name'];
                    $fileContent = ($this->data['Paper_Transaction']['file']['tmp_name']);

                    $fileCode = '(' . time() . '-' . $this->request->data['Paper_Transaction']['Service_Provider_id'] . ')';
                    $filename = WWW_ROOT . DS . 'files' . DS . $fileCode . $fileName;
                    $filenameSaved = 'app/webroot/files/' . $fileCode . $fileName;
                    move_uploaded_file($fileContent, $filename);

                    $this->loadModel("Service_Provider");
                    $this->Service_Provider->updateAll(
                            array(
                        'Service_Provider.image' => "'" . $filenameSaved . "'",
                            )
                            , array(
                        'Service_Provider.id' => $this->request->data['Paper_Transaction']['Service_Provider_id']
                    ));
                }
                $this->loadModel("Service_Provider");
                if ($this->Service_Provider->updateAll(
                                array(
                            'Service_Provider.category_id' => $this->request->data['Paper_Transaction']['category_id'],
                            //'Service_Provider.service_type_id' => $this->request->data['Paper_Transaction']['service_type_id'],
                            'Service_Provider.government_id' => $this->request->data['Paper_Transaction']['government_id'],
                            'Service_Provider.address' => "'" . str_replace("'", "''", $this->request->data['Paper_Transaction']['address']) . "'",
                            'Service_Provider.service_name_en' => "'" . str_replace("'", "''", $this->request->data['Paper_Transaction']['service_name_en']) . "'",
                            'Service_Provider.phone' => "'" . $this->request->data['Paper_Transaction']['phone'] . "'",
                            'Service_Provider.service_description_en' => "'" . str_replace("'", "''", $this->request->data['Paper_Transaction']['service_description_en']) . "'",
                            'Service_Provider.edited_by' => $this->Session->read('User.User.id')
                                )
                                , array(
                            'Service_Provider.id' => $this->request->data['Paper_Transaction']['Service_Provider_id']
                        ))) {
                    $this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details/" . $this->request->data['Paper_Transaction']['Service_Provider_id']));
                } else {
                    $this->Session->setFlash("error in saving,please try again", "default", array("class" => "error-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details", $this->request->data['Paper_Transaction']['Service_Provider_id']));
                }
            } else if ($this->request->data['btn'] == 'Activate Account') {
                $this->loadModel("Service_Provider");
                if ($this->Service_Provider->updateAll(
                                array(
                            'Service_Provider.approval_flag' => '1')
                                , array(
                            'Service_Provider.id' => $this->request->data['Paper_Transaction']['Service_Provider_id']
                        ))) {
                    $this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details/" . $this->request->data['Paper_Transaction']['Service_Provider_id']));
                } else {
                    $this->Session->setFlash("error in saving,please try again", "default", array("class" => "error-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details", $this->request->data['Paper_Transaction']['Service_Provider_id']));
                }
            } else if ($this->request->data['btn'] == 'De-activate Account') {
                $this->loadModel("Service_Provider");
                if ($this->Service_Provider->updateAll(
                                array(
                            'Service_Provider.approval_flag' => '0')
                                , array(
                            'Service_Provider.id' => $this->request->data['Paper_Transaction']['Service_Provider_id']
                        ))) {
                    $this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details/" . $this->request->data['Paper_Transaction']['Service_Provider_id']));
                } else {
                    $this->Session->setFlash("error in saving,please try again", "default", array("class" => "error-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details", $this->request->data['Paper_Transaction']['Service_Provider_id']));
                }
            } else {
                $status = '';
                if (str_contains($this->request->data['btn'], 'Reject')) {
                    $status = '3';
                } else if (str_contains($this->request->data['btn'], 'Accept')) {
                    $status = '1';
                }

                $this->loadModel("Paper_Transaction");
                if ($this->Paper_Transaction->updateAll(
                                array(
                            'Paper_Transaction.admin_notes' => "'" . $this->request->data['Paper_Transaction']['admin_notes'] . "'",
                            'Paper_Transaction.approval_flag' => $status,
                            'Paper_Transaction.edited_by' => $this->Session->read('User.User.id'))
                                , array(
                            'Paper_Transaction.id' => $this->request->data['Paper_Transaction']['Paper_Transaction_id']
                        ))) {
                    $this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details/" . $this->request->data['Paper_Transaction']['Service_Provider_id']));
                } else {
                    $this->Session->setFlash("error in saving,please try again", "default", array("class" => "error-message"));
                    $this->redirect(array("controller" => "ServiceProviders", "action" => "details", $this->request->data['Paper_Transaction']['Service_Provider_id']));
                }
            }
        }
    }

    function upload_fun() {
        $service_provider = $_POST['service_provider'];
        $transaction_id = $_POST['transaction_id'];
        $required_paper_id = $_POST['required_paper_id'];

        $fileName = $_FILES['file']['name'];
        $fileType = $_FILES['file']['type'];
        $fileError = $_FILES['file']['error'];
        $fileContent = ($_FILES['file']['tmp_name']);

        $return_array = array();

        $filename = null;
        $filenameSaved = null;
        if (!empty($fileName)) {
            $fileCode = '(' . time() . '-' . $this->Session->read('User.User.id') . ')';
            $filename = WWW_ROOT . DS . 'files' . DS . $fileCode . $fileName;
            $filenameSaved = 'app/webroot/files/' . $fileCode . $fileName;
            move_uploaded_file($fileContent, $filename);

            if (!empty($transaction_id)) {
                $this->loadModel("Paper_Transaction");
                if ($this->Paper_Transaction->updateAll(
                                array(
                            'Paper_Transaction.attachment' => "'" . $filenameSaved . "'",
                            'Paper_Transaction.edited_by' => $this->Session->read('User.User.id'),
                            'Paper_Transaction.approval_flag' => "2")
                                , array(
                            'Paper_Transaction.id' => $transaction_id
                        ))) {

                    $return_array = 'success';
                } else {
                    $return_array = 'failed';
                }
            } else {
                $this->loadModel("Service_Provider");
                $Service_Provider = $this->Service_Provider->find("first", array("conditions" => array("Service_Provider.id" => $service_provider)));



                $paper_arr = array();
                $paper_arr['Paper_Transaction']['user_id'] = $Service_Provider['Service_Provider']['user_id'];
                $paper_arr['Paper_Transaction']['required_paper_id'] = $required_paper_id;
                $paper_arr['Paper_Transaction']['attachment'] = $filenameSaved;
                $paper_arr['Paper_Transaction']['approval_flag'] = '2';
                $paper_arr['Paper_Transaction']['edited_by'] = $this->Session->read('User.User.id');


                $this->loadModel("Paper_Transaction");
                $this->Paper_Transaction->create();
                $this->Paper_Transaction->save($paper_arr);

                $return_array = 'success';
            }
        } else {
            $return_array = 'failed';
        }


        header("Content-Type: application/json", true);
        echo json_encode($return_array);

        exit;
    }

    function accept_fun() {
        $data = $_POST["result"];
        $data = json_decode("$data", true);

        $return_array = array();

        $this->loadModel("Paper_Transaction");
        if ($this->Paper_Transaction->updateAll(
                        array(
                    'Paper_Transaction.admin_notes' => "'" . $data['admin_notes'] . "'",
                    'Paper_Transaction.edited_by' => $this->Session->read('User.User.id'),
                    'Paper_Transaction.approval_flag' => '1')
                        , array(
                    'Paper_Transaction.id' => $data['transaction_id']
                ))) {
            $this->loadModel("Paper_Transaction");
            $Paper_Transaction = $this->Paper_Transaction->find("first", array(
                "conditions" => array('Paper_Transaction.id' => $data['transaction_id'])));
            $this->loadModel("User");
            $User = $this->User->find("first", array(
                "conditions" => array(
                    "User.id" => $Paper_Transaction['Paper_Transaction']['user_id']
            )));
            if (!empty($User['User']['token'])) {
                $this->push_notification_papers($User['User']['token'], '1', $Paper_Transaction['Paper_Transaction']['user_id'] , $Paper_Transaction['Required_Paper']['papername_ar']);
            }

            $return_array = 'success';
        } else {
            $return_array = 'failed';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return_array);

        exit;
    }

    function reject_fun() {
        $data = $_POST["result"];
        $data = json_decode("$data", true);

        $return_array = array();

        $this->loadModel("Paper_Transaction");
        if ($this->Paper_Transaction->updateAll(
                        array(
                    'Paper_Transaction.admin_notes' => "'" . $data['admin_notes'] . "'",
                    'Paper_Transaction.edited_by' => $this->Session->read('User.User.id'),
                    'Paper_Transaction.approval_flag' => '3')
                        , array(
                    'Paper_Transaction.id' => $data['transaction_id']
                ))) {


            $this->loadModel("Paper_Transaction");
            $Paper_Transaction = $this->Paper_Transaction->find("first", array(
                "conditions" => array('Paper_Transaction.id' => $data['transaction_id'])));
            $this->loadModel("User");
            $User = $this->User->find("first", array(
                "conditions" => array(
                    "User.id" => $Paper_Transaction['Paper_Transaction']['user_id']
            )));
            if (!empty($User['User']['token'])) {
                $this->push_notification_papers($User['User']['token'], '3', $Paper_Transaction['Paper_Transaction']['user_id'] ,  $Paper_Transaction['Required_Paper']['papername_ar']);
            }
            $return_array = 'success';
        } else {
            $return_array = 'failed';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return_array);

        exit;
    }

    function sendNotification_fun() {
        $data = $_POST["result"];
        $data = json_decode("$data", true);

        $return_array = array();
        $service_provider_id = $data['service_provider'];
        $text_notification = $data['text_notification'];


        $curl = curl_init();
        //$token = "c84p14PRQlGZUwwcquVCXo:APA91bGe0jQYRV3mjr6yGU4Q7cgZ5SLy754YYecqg7rRc62J6cm7_w30ra0Yb-mxUMo8qK3-KeHhFYfQ2Fn00iAF_zdxeCn7nqwKF2J0epUguw1R6Xt_SPLtDSu5VSOWRqtLSBly_af1";
        $messege = $text_notification;

        $this->loadModel("Service_Provider");
        $Service_Provider = $this->Service_Provider->find("first", array('conditions' => array('Service_Provider.id' => $service_provider_id)));

        $this->loadModel("User");
        $User = $this->User->find("first", array('conditions' => array('User.id' => $Service_Provider['Service_Provider']['user_id'])));

        if (!empty($User['User']['token'])) {
            $post_data = array();
            $post_data["notification"]["body"] = $messege;
            $post_data["data"]["message"] = $messege;
            $post_data["data"]["image"] = "http://api.aiwagroup.org//app/webroot/img/logo0_w.png";
            $post_data["to"] = $User['User']['token'];


            $post_data = json_encode($post_data);

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
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

            $Notification_arr = array();
            $Notification_arr['Notification']['user_id'] = $User['User']['id'];
            $Notification_arr['Notification']['message'] = $messege;
            $Notification_arr['Notification']['token'] = $User['User']['token'];

            $this->loadModel("Notification");
            $this->Notification->create();
            if ($this->Notification->save($Notification_arr)) {
                $return_array = 'success';
            } else {
                $return_array = 'failed';
            }
        } else {
            $return_array = 'failed';
        }
        header("Content-Type: application/json", true);
        echo json_encode($return_array);

        exit;
    }

    function push_notification_papers($token, $status, $user_id , $paper_name) {

        $curl = curl_init();
        //$token = "c84p14PRQlGZUwwcquVCXo:APA91bGe0jQYRV3mjr6yGU4Q7cgZ5SLy754YYecqg7rRc62J6cm7_w30ra0Yb-mxUMo8qK3-KeHhFYfQ2Fn00iAF_zdxeCn7nqwKF2J0epUguw1R6Xt_SPLtDSu5VSOWRqtLSBly_af1";
        $messege = "";
        if ($status == '1')
             $messege ="تم مراجعه "." ".$paper_name." "."   من قبل شركه أيوا و تم الموافقه عليها";
        else if ($status == '3')
             $messege ="تم مراجعه "." ".$paper_name." "."من قبل شركه أيوا و تم رفضها برجاء مراجعه الاوراق و اعادة رفعها ";

        $post_data = array();
        $post_data["notification"]["body"] = $messege;
        $post_data["data"]["message"] = $messege;
        $post_data["data"]["image"] = "http://api.aiwagroup.org//app/webroot/img/logo0_w.png";
        $post_data["to"] = $token;


        $post_data = json_encode($post_data);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
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

        $Notification_arr = array();
        $Notification_arr['Notification']['user_id'] = $user_id;
        $Notification_arr['Notification']['message'] = $messege;
        $Notification_arr['Notification']['token'] = $token;

        $this->loadModel("Notification");
        $this->Notification->create();
        $this->Notification->save($Notification_arr);

        $json = json_decode($response, true);
        return $json['results'][0]['registration_token'];
        //exit;
    }

    function generateRandomString($length = 6) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
