<?php

App::uses('AppController', 'Controller');

class TermsController extends AppController {

    public $uses = array();

    public function showall()
	{
		$this->loadModel("TermsConditions");

        $keys = $this->TermsConditions->find("all", array("conditions" => array("TermsConditions.parent_id" => 0)));
		$keys_names = array();
        foreach ($keys as $key => $value)
		{
            $keys_names[$value['TermsConditions']['id']] = $value['TermsConditions']['data_en'];
        }

        $this->set("keys_names", $keys_names);

        if (!empty($this->request->data))
		{

            $keys_index = $this->request->data['Terms']['parent_id'];

            if (!empty($keys_index))
			{
				$this->loadModel("TermsConditions");
				$keys_data = $this->TermsConditions->find("all", array("conditions" => array("TermsConditions.parent_id" => $keys_index)));

				$this->set("keys_data", $keys_data);

            }
        }
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
public function add()
{
	if (!empty($this->request->data))
	{
		if (!empty($this->request->data['Terms']['term_en']) && !empty($this->request->data['Terms']['term_ar']))
		{

			$this->loadModel("TermsConditions");
			$this->request->data['TermsConditions']['data_en']   = $this->data['Terms']['term_en'];
			$this->request->data['TermsConditions']['data_ar']   = $this->data['Terms']['term_ar'];

			if ($this->TermsConditions->save($this->request->data))
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

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function edit($terms_id = null)
	{
        $this->loadModel("TermsConditions");
        $terms = $this->TermsConditions->find("first", array("conditions" => array("TermsConditions.id" => $terms_id)));

        if (!empty($terms))
		{
            $this->set("terms_id", $terms_id);
            $this->set("terms", $terms);

            if (!empty($this->request->data))
			{
                if (!empty($this->request->data['Terms']['data_en']) && !empty($this->request->data['Terms']['data_ar']))
				{
                    $this->loadModel("TermsConditions");
                    if ($this->TermsConditions->updateAll(
                                    array(
                                'TermsConditions.data_en' => "'" . $this->request->data['Terms']['data_en'] . "'",
                                'TermsConditions.data_ar' => "'" . $this->request->data['Terms']['data_ar'] . "'",
                                    )
                                    , array(
                                'TermsConditions.id' => $terms_id
                            ))) {

                        $this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));
                        $this->redirect(array("action" => "showall"));
                    } else {
                        $this->Session->setFlash("error in saving,please try again");
                    }
                } else {
                        $this->Session->setFlash("error in saving,please try again");
                    }

            }
        } else {
            $this->Session->setFlash("record not found");
        }
    }

	public function en_to_ar()
	{
		$this->loadModel("TermsConditions");

        $keys = $this->TermsConditions->find("all", array("conditions" => array("TermsConditions.parent_id" => 0)));
		$keys_names = array();
        foreach ($keys as $key => $value)
		{
            $keys_names[$value['TermsConditions']['id']] = $value['TermsConditions']['data_ar'];
        }

        $this->set("keys_names", $keys_names);

        if (!empty($this->request->data))
		{

            $keys_index = $this->request->data['Terms']['parent_id'];

            if (!empty($keys_index))
			{
				$this->loadModel("TermsConditions");
				$keys_data = $this->TermsConditions->find("all", array("conditions" => array("TermsConditions.parent_id" => $keys_index)));

				$this->set("keys_data", $keys_data);

            }
        }
	}

}
