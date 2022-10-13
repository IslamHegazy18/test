<?php

App::uses('AppController', 'Controller');

class AdvertisingController extends AppController {

    public $uses = array();

    public function showall()
	{
        $this->loadModel("AdvertisingImages");
        $MainImages = $this->AdvertisingImages->find("all", array('recursive' => -1));
        if (!empty($MainImages))
		{
            $this->set("Images", $MainImages);
        } else {
            $this->Session->setFlash("No Record Found", "default", array("class" => "error-message"));
        }
    }

	public function add()
	{
        if (!empty($this->request->data))
		{
            if (!empty($this->request->data['Images']['file']['name']) && !empty($this->request->data['Images']['url']) && !empty($this->request->data['Images']['status']))
			{

                $filename = null;
                $filenameSaved = null;
                if (!empty($this->data['Images']['file']['name']))
				{
                    $fileName = $this->data['Images']['file']['name'];
                    $fileContent = ($this->data['Images']['file']['tmp_name']);

                    $fileCode = '(' . time() . '-';
                    $filename = WWW_ROOT . DS . 'files' . DS . $fileCode . $fileName;
                    $filenameSaved = 'app/webroot/files/' . $fileCode . $fileName;
                    move_uploaded_file($fileContent, $filename);
                }

                $this->loadModel("AdvertisingImages");
                $this->request->data['AdvertisingImages']['image_path'] = $filenameSaved;
				$this->request->data['AdvertisingImages']['url'] 	    = $this->data['Images']['url'];
				$this->request->data['AdvertisingImages']['status']     = $this->data['Images']['status'];

                if ($this->AdvertisingImages->save($this->request->data))
				{
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

    public function edit($image_id = null)
	{
        $this->loadModel("AdvertisingImages");
        $MainImages = $this->AdvertisingImages->find("first", array("conditions" => array("AdvertisingImages.id" => $image_id)));

        if (!empty($MainImages))
		{
            $this->set("image_id", $image_id);
            $this->set("images", $MainImages);

            if (!empty($this->request->data))
			{
                $filename = null;
                $filenameSaved = null;
                if (!empty($this->data['Images']['file']['name']))
				{
                    $fileName = $this->data['Images']['file']['name'];
                    $fileContent = ($this->data['Images']['file']['tmp_name']);

                    $fileCode = '(' . time() . '-' . $image_id . ')';
                    $filename = WWW_ROOT . DS . 'files' . DS . $fileCode . $fileName;
                    $filenameSaved = 'app/webroot/files/' . $fileCode . $fileName;
                    move_uploaded_file($fileContent, $filename);
                }
                if (!empty($filenameSaved))
				{
                    $this->loadModel("AdvertisingImages");
                    if ($this->AdvertisingImages->updateAll(
                                    array(
                                'AdvertisingImages.url' => "'" . $this->request->data['Images']['url'] . "'",
                                'AdvertisingImages.status' => "'" . $this->request->data['Images']['status'] . "'",
                                'AdvertisingImages.image_path'   => "'" . $filenameSaved . "'",
                                    )
                                    , array(
                                'AdvertisingImages.id' => $image_id
                            ))) {

                        $this->Session->setFlash("saved successfully","default", array("class" => "success-message"));
                        $this->redirect(array("action" => "showall"));
                    } else {
                        $this->Session->setFlash("error in saving, please try again");
                    }
                } else {
                    $this->loadModel("AdvertisingImages");
                    if ($this->AdvertisingImages->updateAll(
                                    array(
                                'AdvertisingImages.url' => "'" . $this->request->data['Images']['url'] . "'",
                                'AdvertisingImages.status' => "'" . $this->request->data['Images']['status'] . "'",
                                    )
                                    , array(
                                'AdvertisingImages.id' => $image_id
                            ))) {

                        $this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));
                        $this->redirect(array("action" => "showall"));
                    } else {
                        $this->Session->setFlash("error in saving, please try again");
                    }
                }
            }
        } else {
            $this->Session->setFlash("record not found");
        }
    }

}
