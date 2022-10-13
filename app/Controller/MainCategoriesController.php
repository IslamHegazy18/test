<?php

App::uses('AppController', 'Controller');

class MainCategoriesController extends AppController {

    public $uses = array();

    public function showall() {
        $this->loadModel("MainCategory");
        $MainCategories = $this->MainCategory->find("all", array('recursive' => -1));
        if (!empty($MainCategories)) {
            $this->set("Categories", $MainCategories);
        } else {
            $this->Session->setFlash("No Record Found", "default", array("class" => "error-message"));
        }
    }
    
    public function diable($category_ID = null) {
        $this->autoRender = false;
        $Saved_category = array();

        $this->loadModel("Category");
        $checkCategory = $this->Category->find("first", array('recursive' => -1, "conditions" => array("id" => $category_ID)));

        if ($checkCategory["Category"]["status"] == '0')
            $Saved_category['Category']['status'] = '1';
        else if ($checkCategory["Category"]["status"] == '1')
            $Saved_category['Category']['status'] = '0';

        //$Saved_category['Category']['user_id'] = $this->Session->read('User.User.id');

        $this->Category->id = $category_ID;
        if ($this->Category->save($Saved_category)) {
            $this->Session->setFlash("Disabked successfully", "default", array("class" => "success-message"));
                $this->redirect(array("controller" => "Categories", "action" => "showall"));
        } else {
            $this->Session->setFlash("error in saving,please try again", "default", array("class" => "error-message"));
        }
        // debug($this->request->data);die();

        exit();
    }

    public function edit($category_id = null) {
        $this->loadModel("MainCategory");
        $MainCategories = $this->MainCategory->find("first", array("conditions" => array("MainCategory.id" => $category_id)));

        if (!empty($MainCategories)) {
            $this->set("category_id", $category_id);
            $this->set("Categories", $MainCategories);

            if (!empty($this->request->data)) {
                $filename = null;
                $filenameSaved = null;
                if (!empty($this->data['MainCategory']['file']['name'])) {
                    $fileName = $this->data['MainCategory']['file']['name'];
                    $fileContent = ($this->data['MainCategory']['file']['tmp_name']);

                    $fileCode = '(' . time() . '-' . $category_id . ')';
                    $filename = WWW_ROOT . DS . 'files' . DS . $fileCode . $fileName;
                    $filenameSaved = 'app/webroot/files/' . $fileCode . $fileName;
                    move_uploaded_file($fileContent, $filename);
                }
                if (!empty($filenameSaved)) {
                    $this->loadModel("MainCategory");
                    if ($this->MainCategory->updateAll(
                                    array(
                                'MainCategory.name_en' => "'" . $this->request->data['MainCategory']['name_en'] . "'",
                                'MainCategory.name_ar' => "'" . $this->request->data['MainCategory']['name_ar'] . "'",
                                'MainCategory.image' => "'" . $filenameSaved . "'",
                                'MainCategory.image' => "'" . $filenameSaved . "'",
                                    )
                                    , array(
                                'MainCategory.id' => $category_id
                            ))) {

                        $this->Session->setFlash("saved successfully", array("class" => "success-message"));
                        $this->redirect(array("action" => "showall"));
                    } else {
                        $this->Session->setFlash("error in saving,please try again");
                    }
                } else {
                    $this->loadModel("MainCategory");
                    if ($this->MainCategory->updateAll(
                                    array(
                                'MainCategory.name_en' => "'" . $this->request->data['MainCategory']['name_en'] . "'",
                                'MainCategory.name_ar' => "'" . $this->request->data['MainCategory']['name_ar'] . "'",
                                    )
                                    , array(
                                'MainCategory.id' => $category_id
                            ))) {

                        $this->Session->setFlash("saved successfully", array("class" => "success-message"));
                        $this->redirect(array("action" => "showall"));
                    } else {
                        $this->Session->setFlash("error in saving,please try again");
                    }
                }
            }
        } else {
            $this->Session->setFlash("record not found");
        }
    }

    public function add() {
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['MainCategory']['file']['name']) && !empty($this->request->data['MainCategory']['name_en']) && !empty($this->request->data['MainCategory']['name_ar'])) {

                $filename = null;
                $filenameSaved = null;
                if (!empty($this->data['MainCategory']['file']['name'])) {
                    $fileName = $this->data['MainCategory']['file']['name'];
                    $fileContent = ($this->data['MainCategory']['file']['tmp_name']);

                    $fileCode = '(' . time() . '-';
                    $filename = WWW_ROOT . DS . 'files' . DS . $fileCode . $fileName;
                    $filenameSaved = 'app/webroot/files/' . $fileCode . $fileName;
                    move_uploaded_file($fileContent, $filename);
                }

                $this->loadModel("MainCategory");
                $this->request->data['MainCategory']['image'] = $filenameSaved;
                $this->request->data['MainCategory']['parent_id'] = 0;
                if ($this->MainCategory->save($this->request->data)) {
                    $this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));
                    $this->redirect(array("action" => "showall"));
                } else {
                    $this->Session->setFlash("error in saving,please try again", "default", array("class" => "error-message"));
                }
            } else {
                $this->Session->setFlash("error in saving,please enter all requested fields", "default", array("class" => "error-message"));
            }
        }
    }

}
