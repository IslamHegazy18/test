<?php

App::uses('AppController', 'Controller');
use Cake\ORM\TableRegistry;

class ComplainTitleController extends AppController {

    public $uses = array();

    public function showall()
	{
        $this->loadModel("complain_title");
        $complain_titles = $this->complain_title->find("all", array('order' => array('complain_title.id DESC')));

        if (!empty($complain_titles))
		{
            $this->set("complain_title", $complain_titles);
        } else {
            $this->Session->setFlash("No Record Found", "default", array("class" => "error-message"));
        }
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
public function add()
{

	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['save']))
	{

		if ( !empty($this->request->data['complain_title']['name_en']) && !empty($this->request->data['complain_title']['name_ar']) )
		{

			$this->loadModel("complain_title");
			$this->request->data['complain_title']['name_en'] 		= $this->data['complain_title']['name_en'];
			$this->request->data['complain_title']['name_ar'] 		= $this->data['complain_title']['name_ar'];
			if ($this->complain_title->save($this->request->data))
				{
					$this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));
					$this->redirect(array("action" => "showall"));
				} else {
					$this->Session->setFlash("error in saving, please try again", "default", array("class" => "error-message"));
				}

		} else {
			$this->Session->setFlash("error in saving, please enter all requested fields", "default", array("class" => "error-message"));
		}
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function edit($complain_title_id = null)
	{
        $this->loadModel("complain_title");
        $complain_titles = $this->complain_title->find("first", array("conditions" => array("complain_title.id" => $complain_title_id)));

        if (!empty($complain_titles))
		{
            $this->set("complain_title_id", $complain_title_id);
            $this->set("complain_titles", $complain_titles);

            if (!empty($this->request->data))
			{
				if ($this->complain_title->updateAll(
					array(
						'complain_title.name_en' 	  => "'" . $this->request->data['complain_title']['name_en'] . "'",
						'complain_title.name_ar' => "'" . $this->request->data['complain_title']['name_ar'] . "'",
					), array(
						'complain_title.id' => $complain_title_id
						)))
					{
						$this->Session->setFlash("updated successfully", "default", array("class" => "success-message"));

						$this->redirect(array("action" => "showall"));
					} else {
						$this->Session->setFlash("error in saving, please try again","default", array("class" => "error-message"));
					}
            }
        } else {
            $this->Session->setFlash("record not found");
        }
    }

	public function delete($complain_title_id)
	{
		$this->loadModel("complain_title");

		$this->complain_title->id = $complain_title_id;

		if($this->complain_title->delete())
		{
			$this->Session->setFlash("Record deleted successfully.", "default", array("class" => "success-message"));
			$this->redirect(array("action" => "showall"));
		}else{
			$this->Session->setFlash("error in deleting, please try again","default", array("class" => "error-message"));
		}
	}

}
