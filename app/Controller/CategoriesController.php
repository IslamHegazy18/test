<?php

App::uses('AppController', 'Controller');

class CategoriesController extends AppController {

    public $uses = array();

    public function showall() {
        $this->loadModel("Category");
        $this->Category->unbindModel(array(
            "hasMany" => array("Service_Provider")
        ));
        $Categories = $this->Category->find("all", array("conditions" => array("Category.parent_id" => 0)));
        if (!empty($Categories)) {
            $this->set("Categories", $Categories);
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
        $this->loadModel("Category");
        $Categories = $this->Category->find("first", array("conditions" => array("Category.id" => $category_id)));

        if (!empty($Categories)) {
            $this->set("category_id", $category_id);
            $this->set("Categories", $Categories);

            if (!empty($this->request->data)) {
                $filename = null;
                $filenameSaved = null;
                if (!empty($this->data['Category']['file']['name'])) {
                    $fileName = $this->data['Category']['file']['name'];
                    $fileContent = ($this->data['Category']['file']['tmp_name']);

                    $fileCode = '(' . time() . '-' . $category_id . ')';
                    $filename = WWW_ROOT . DS . 'files' . DS . $fileCode . $fileName;
                    $filenameSaved = 'app/webroot/files/' . $fileCode . $fileName;
                    move_uploaded_file($fileContent, $filename);
                }
                if (!empty($filenameSaved)) {
                    $this->loadModel("Category");
                    if ($this->Category->updateAll(
                                    array(
                                'Category.name_en' => "'" . $this->request->data['Category']['name_en'] . "'",
                                'Category.name_ar' => "'" . $this->request->data['Category']['name_ar'] . "'",
                                'Category.image' => "'" . $filenameSaved . "'",
                                'Category.icon' => "'" . $filenameSaved . "'",
                                    )
                                    , array(
                                'Category.id' => $category_id
                            ))) {

                        $this->Session->setFlash("saved successfully", array("class" => "success-message"));
                        $this->redirect(array("action" => "showall"));
                    } else {
                        $this->Session->setFlash("error in saving,please try again");
                    }
                } else {
                    $this->loadModel("Category");
                    if ($this->Category->updateAll(
                                    array(
                                'Category.name_en' => "'" . $this->request->data['Category']['name_en'] . "'",
                                'Category.name_ar' => "'" . $this->request->data['Category']['name_ar'] . "'",
                                    )
                                    , array(
                                'Category.id' => $category_id
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
        $this->loadModel("MainCategory");
        $MainCategories = $this->MainCategory->find("all", array('recursive' => -1));
        $MainCategories_names = array();
        foreach ($MainCategories as $key => $value) {
            $MainCategories_names[$value['MainCategory']['id']] = $value['MainCategory']['name_en'];
        }
        $this->set("parent_names", $MainCategories_names);
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['Category']['file']['name']) && !empty($this->request->data['Category']['name_en']) && !empty($this->request->data['Category']['name_ar'])) {

                $filename = null;
                $filenameSaved = null;
                if (!empty($this->data['Category']['file']['name'])) {
                    $fileName = $this->data['Category']['file']['name'];
                    $fileContent = ($this->data['Category']['file']['tmp_name']);

                    $fileCode = '(' . time() . '-';
                    $filename = WWW_ROOT . DS . 'files' . DS . $fileCode . $fileName;
                    $filenameSaved = 'app/webroot/files/' . $fileCode . $fileName;
                    move_uploaded_file($fileContent, $filename);
                }

                $this->loadModel("Category");
                $this->request->data['Category']['image'] = $filenameSaved;
                $this->request->data['Category']['icon'] = $filenameSaved;
                $this->request->data['Category']['parent_id'] = 0;
                if ($this->Category->save($this->request->data)) {
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
