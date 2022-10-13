<?php

App::uses('AppController', 'Controller');

class SubServicesController extends AppController {

    public $uses = array();

    public function showall() {
        $this->loadModel("Category");
        $Categories = $this->Category->find("all", array('recursive' => -1, "conditions" => array("Category.parent_id <>" => 0)));
        foreach ($Categories as $key => $value) {
            $Parent = $this->Category->find("first", array('recursive' => -1, "conditions" => array("Category.id" => $value['Category']['parent_id'])));
            $Categories[$key]['Parent'] = $Parent;
        }
        if (!empty($Categories)) {
            $this->set("Categories", $Categories);
        } else {
            $this->Session->setFlash("No Record Found", "default", array("class" => "error-message"));
        }
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
        $this->loadModel("Category");
        $Categories = $this->Category->find("all", array('recursive' => -1, "conditions" => array("Category.parent_id" => 0)));
        $parent_names = array();
        foreach ($Categories as $key => $value) {
            $parent_names[$value['Category']['id']] = $value['Category']['name_en'];
        }
        $this->set("parent_names", $parent_names);
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
