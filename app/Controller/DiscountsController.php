<?php

App::uses('AppController', 'Controller');
use Cake\ORM\TableRegistry;

class DiscountsController extends AppController {

    public $uses = array();

    public function showall()
	{
        $this->loadModel("Discount");
        $Discounts = $this->Discount->find("all", array('order' => array('Discount.id DESC')));

        if (!empty($Discounts))
		{
            $this->set("Discounts", $Discounts);
        } else {
            $this->Session->setFlash("No Record Found", "default", array("class" => "error-message"));
        }
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
public function add()
{

	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['save']))
	{

		if (!empty($_POST['discount_key']) && !empty($this->request->data['Discount']['due_date']) && ($_POST['select'] == 'v' || $_POST['select'] == 'p'))
		{

			$this->loadModel("Discount");
			$this->request->data['Discount']['key']   		= $_POST['discount_key'];
			$this->request->data['Discount']['value'] 		= $this->data['Discount']['discount_value'];
			$this->request->data['Discount']['percentage'] 	= $this->data['Discount']['discount_percentage'];
			$this->request->data['Discount']['due_date'] 	= $this->data['Discount']['due_date'];

			if ($this->data['Discount']['due_date'] >=  date("Y-m-d"))
			{
				if ($this->Discount->save($this->request->data))
				{
					$this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));
					$this->redirect(array("action" => "showall"));
				} else {
					$this->Session->setFlash("error in saving, please try again", "default", array("class" => "error-message"));
				}
			}else {
				$this->Session->setFlash("error in saving date, please try again", "default", array("class" => "error-message"));
			}

		} else {
			$this->Session->setFlash("error in saving, please enter all requested fields", "default", array("class" => "error-message"));
		}
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function edit($discount_id = null)
	{
        $this->loadModel("Discount");
        $dicounts = $this->Discount->find("first", array("conditions" => array("Discount.id" => $discount_id)));

        if (!empty($dicounts))
		{
            $this->set("discount_id", $discount_id);
            $this->set("dicounts", $dicounts);

            if (!empty($this->request->data))
			{

                if (!empty($_POST['discount_key']) && (!empty($this->request->data['Discount']['discount_value']) || !empty($this->request->data['Discount']['discount_percentage'])))
				{

                    $this->loadModel("Discount");
                    if ($this->Discount->updateAll(
                                    array(
										'Discount.key' 	      => "'" . $_POST['discount_key'] . "'",
										'Discount.value' 	  => "'" . $this->request->data['Discount']['discount_value'] . "'",
										'Discount.percentage' => "'" . $this->request->data['Discount']['discount_percentage'] . "'",
										'Discount.due_date'   => "'" . $this->request->data['Discount']['due_date'] . "'"
                                    ), array(
										'Discount.id' => $discount_id
										)))
									{
										$this->Session->setFlash("saved successfully", "default", array("class" => "success-message"));

										$this->redirect(array("action" => "showall"));
									} else {
										$this->Session->setFlash("error in saving, please try again","default", array("class" => "error-message"));
									}
                } else {
					$this->Session->setFlash("error in saving, please try again","default", array("class" => "error-message"));
                    }

            }
        } else {
            $this->Session->setFlash("record not found");
        }
    }

	// public function delete($discount_id)
	// {
	// 	$this->loadModel("Discount");

	// 	$this->Discount->id = $discount_id;

	// 	if($this->Discount->delete())
	// 	{
	// 		$this->Session->setFlash("Record deleted successfully.", "default", array("class" => "success-message"));
	// 		$this->redirect(array("action" => "showall"));
	// 	}else{
	// 		$this->Session->setFlash("error in deleting, please try again","default", array("class" => "error-message"));
	// 	}
	// }

}
