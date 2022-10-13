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
class PaymentservicesController extends AppController {

    public function cashout_callback()
	{
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $postData = array(
            'partnerId' => 5123,
            'programId' => 6001,
            'password' => $json['password'],
            'userIdentifier' => $json['userIdentifier']
        );

        $requestId        = $json['requestId'];
        $fawryRefNumber   = $json['fawryRefNumber'];
        $merchantRefNumber= $json['merchantRefNumber'];
        $customerMobile   = $json['customerMobile'];
        $customerMail     = $json['customerMail'];
        $paymentAmount 	  = $json['paymentAmount'];
        $orderAmount      = $json['orderAmount'];
        $fawryFees        = $json['fawryFees'];
        $paymentMethod    = $json['paymentMethod'];
        $messageSignature = $json['messageSignature'];
        $orderExpiryDate  = $json['orderExpiryDate'];

        $pay_arr = array();
        $pay_arr['FawryPay']['requestId']         = $requestId;
        $pay_arr['FawryPay']['fawryRefNumber']    = $fawryRefNumber;
        $pay_arr['FawryPay']['merchantRefNumber'] = $merchantRefNumber;
        $pay_arr['FawryPay']['customerMobile']    = $customerMobile;
        $pay_arr['FawryPay']['customerMail']      = $customerMail;
        $pay_arr['FawryPay']['paymentAmount']     = $paymentAmount;
        $pay_arr['FawryPay']['orderAmount']       = $orderAmount;
        $pay_arr['FawryPay']['fawryFees']         = $fawryFees;
        $pay_arr['FawryPay']['paymentMethod']     = $paymentMethod;
        $pay_arr['FawryPay']['messageSignature']  = $messageSignature;
        $pay_arr['FawryPay']['orderExpiryDate']   = $orderExpiryDate;

        $err = TRUE;

        $this->loadModel("FawryPay");
        $this->FawryPay->create();

        if ($this->FawryPay->save($pay_arr))
		{
            $err = FALSE;
        } else {
            $err = TRUE;
        }

        if ($err)
		{
            header("Content-Type: application/json", true);
            echo "cURL Error #:" . $err;
        } else {
            header("Content-Type: application/json", true);
            echo json_encode($pay_arr);
        }
        exit;
    }

    public function vpc_callback()
	{
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $postData = array(
            'partnerId' => 5123,
            'programId' => 6001,
            'password'  => $json['password'],
            'userIdentifier' => $json['userIdentifier']
        );

        $requestId        = $json['requestId'];
        $fawryRefNumber   = $json['fawryRefNumber'];
        $merchantRefNumber= $json['merchantRefNumber'];
        $customerMobile   = $json['customerMobile'];
        $customerMail     = $json['customerMail'];
		$paymentAmount    = $json['paymentAmount'];
        $orderAmount      = $json['orderAmount'];
        $fawryFees        = $json['fawryFees'];
        $paymentMethod    = $json['paymentMethod'];
        $messageSignature = $json['messageSignature'];
        $orderExpiryDate  = $json['orderExpiryDate'];

		$this->loadModel("FawryPay");
		$fawrypay = $this->FawryPay->find('first', array('conditions' => array('FawryPay.fawryRefNumber' => $fawryRefNumber)));
		if(empty($fawrypay))
		{
			$orderAmount = $orderAmount / 1.14;
			$pay_arr = array();
			$pay_arr['FawryPay']['requestId']        = $requestId;
			$pay_arr['FawryPay']['fawryRefNumber']   = $fawryRefNumber;
			$pay_arr['FawryPay']['merchantRefNumber']= $merchantRefNumber;
			$pay_arr['FawryPay']['customerMobile']   = $customerMobile;
			$pay_arr['FawryPay']['customerMail']     = $customerMail;
			$pay_arr['FawryPay']['paymentAmount']    = $paymentAmount;
			$pay_arr['FawryPay']['orderAmount']      = $orderAmount;
			$pay_arr['FawryPay']['fawryFees']        = $fawryFees;
			$pay_arr['FawryPay']['paymentMethod']    = $paymentMethod;
			$pay_arr['FawryPay']['messageSignature'] = $messageSignature;
			$pay_arr['FawryPay']['orderExpiryDate']  = $orderExpiryDate;
			$pay_arr['FawryPay']['14%tax']           = $orderAmount * 0.14;

			$this->loadModel("FawryPay");
			$this->FawryPay->create();
			$this->FawryPay->save($pay_arr);
			header("Content-Type: application/json", true);
            echo json_encode($pay_arr, JSON_PRETTY_PRINT);
			exit;
		}else{

			$merchantCode    	= 'siYxylRjSPxelegvLsOWwA==';
			$merchant_sec_key 	= '381bf4f46def41e78c6d096c8a0a4127';
			$merchantRefNum     = $merchantRefNumber;
			$signature = hash('sha256' , $merchantCode . $merchantRefNum . $merchant_sec_key);

			$ch = curl_init();

			$url = "https://atfawry.com/ECommerceWeb/Fawry/payments/status/v2?merchantCode=$merchantCode&merchantRefNumber=$merchantRefNum&signature=$signature";

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_URL, $url);

			$response = json_decode(curl_exec($ch), true);

			if(curl_error($ch))
			{
				echo 'Request Error:' . curl_error($ch);
			}else
			{
				if($response['orderStatus'] == 'PAID')
				{
					$this->loadModel("FawryPay");
					$this->FawryPay->updateAll(
						array(
							'FawryPay.refnoafterpay' => "'" . $response['paymentRefrenceNumber'] . "'",
							), array(
								'FawryPay.merchantRefNumber' => $response['merchantRefNumber']
					));
					$this->loadModel('Reservation');
					$this->Reservation->updateAll(
                        array('Reservation.status' => '4'),
						array('Reservation.trans_ref' => $response['fawryRefNumber']));
				}
			}
			curl_close($ch);

			$this->loadModel("FawryPay");
			$refnum = $this->FawryPay->find('first', array('conditions' => array('FawryPay.refnoafterpay !=' => null)));
		}
        if (empty($refnum))
		{
            header("Content-Type: application/json", true);
            echo json_encode(['status'=>'fail','result' => 'paymentRefrenceNumber not updated']);
        } else {
            header("Content-Type: application/json", true);
            echo json_encode(['status'=>'success','result' => 'paymentRefrenceNumber is updated successfully']);
        }
        exit();
    }

    public function voucher_callback()
	{
        $this->autoRender = false;
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $postData = array(
            'partnerId' => 5123,
            'programId' => 6001,
            'password' => $json['password'],
            'userIdentifier' => $json['userIdentifier']
        );

        $msgCode    = $json['msgCode'];
        $sender     = $json['sender'];
        $receiver   = $json['receiver'];
        $custLang   = $json['custLang'];
        $clientDt   = $json['clientDt'];
        $isRetry    = $json['isRetry'];
        $rqUID      = $json['rqUID'];
        $asyncRqUID = $json['asyncRqUID'];
        $terminalId = $json['terminalId'];

        //////////////////////
        $customProperties_key   = $json['customProperties'][0]['key'];
        $customProperties_value = $json['customProperties'][0]['value'];
        //////////////////////
        $pmtRec_pmtInfo_billingAcct    = $json['pmtRec'][0]['pmtInfo']['billingAcct'];
        $pmtRec_pmtInfo_pmtType        = $json['pmtRec'][0]['pmtInfo']['pmtType'];
        $pmtRec_pmtInfo_deliveryMethod = $json['pmtRec'][0]['pmtInfo']['deliveryMethod'];
        $pmtRec_pmtInfo_pmtMethod      = $json['pmtRec'][0]['pmtInfo']['pmtMethod'];
        $pmtRec_pmtInfo_pmtStatus      = $json['pmtRec'][0]['pmtInfo']['pmtStatus'];
        $pmtRec_pmtInfo_billTypeCode   = $json['pmtRec'][0]['pmtInfo']['billTypeCode'];
        $pmtRec_pmtInfo_bankId 		   = $json['pmtRec'][0]['pmtInfo']['bankId'];


        //////////////////////////////////////////////////
        $pmtRec_pmtInfo_pmtIds_0_pmtId      = $json['pmtRec'][0]['pmtInfo']['pmtIds'][0]['pmtId'];
        $pmtRec_pmtInfo_pmtIds_0_pmtIdType  = $json['pmtRec'][0]['pmtInfo']['pmtIds'][0]['pmtIdType'];
        $pmtRec_pmtInfo_pmtIds_0_creationDt = $json['pmtRec'][0]['pmtInfo']['pmtIds'][0]['creationDt'];
        //////////////////////////////////////////////////
        $pmtRec_pmtInfo_pmtIds_1_pmtId      = $json['pmtRec'][0]['pmtInfo']['pmtIds'][1]['pmtId'];
        $pmtRec_pmtInfo_pmtIds_1_pmtIdType  = $json['pmtRec'][0]['pmtInfo']['pmtIds'][1]['pmtIdType'];
        $pmtRec_pmtInfo_pmtIds_1_creationDt = $json['pmtRec'][0]['pmtInfo']['pmtIds'][1]['creationDt'];
        //////////////////////////////////////////////////
        $pmtRec_pmtInfo_pmtIds_2_pmtId      = $json['pmtRec'][0]['pmtInfo']['pmtIds'][2]['pmtId'];
        $pmtRec_pmtInfo_pmtIds_2_pmtIdType  = $json['pmtRec'][0]['pmtInfo']['pmtIds'][2]['pmtIdType'];
        $pmtRec_pmtInfo_pmtIds_2_creationDt = $json['pmtRec'][0]['pmtInfo']['pmtIds'][2]['creationDt'];
        //////////////////////////////////////////////////
        $pmtRec_pmtInfo_pmtIds_3_pmtId      = $json['pmtRec'][0]['pmtInfo']['pmtIds'][3]['pmtId'];
        $pmtRec_pmtInfo_pmtIds_3_pmtIdType  = $json['pmtRec'][0]['pmtInfo']['pmtIds'][3]['pmtIdType'];
        $pmtRec_pmtInfo_pmtIds_3_creationDt = $json['pmtRec'][0]['pmtInfo']['pmtIds'][3]['creationDt'];
        ////////////////////////////////////////////
        $voucherInfo_vouchSN = $json['pmtRec'][0]['pmtInfo']['extraBillingAccts'][0]['value'];


        //////////////////////////////////////////////////
        $pmtRec_pmtInfo_pmtIds_pmtAmt_amt     = $json['pmtRec'][0]['pmtInfo']['pmtAmt']['amt'];
        $pmtRec_pmtInfo_pmtIds_pmtAmt_curCode = $json['pmtRec'][0]['pmtInfo']['pmtAmt']['curCode'];

        //////////////////////////////////////////////////
        $pmtRec_pmtInfo_pmtIds_billRefNumber = $json['pmtRec'][0]['pmtInfo']['billRefNumber'];



        $response_arr = array();

        if (!empty($msgCode))
		{
            ////////////////////////////////////////
            $response_arr['msgCode']             = $msgCode;
            $response_arr['serverDt']            = $clientDt;
            $response_arr['rqUID']               = $rqUID;
            $response_arr['asyncRqUID']          = $asyncRqUID;
            $response_arr['terminalId']          = $terminalId;
            $response_arr['clientTerminalSeqId'] = '16101816493400010014';
            ///////////////////////////////////////
            $response_arr['customProperties'][0]['key']   = $customProperties_key;
            $response_arr['customProperties'][0]['value'] = $customProperties_value;
            ///////////////////////////////////////
            $response_arr['pmtStatusRec'][0]['status']['statusCode']  = '200';
            $response_arr['pmtStatusRec'][0]['status']['description'] = 'Success';
            ///////////////////////////////////////
            if (!empty($pmtRec_pmtInfo_pmtIds_0_pmtId))
			{
                $response_arr['pmtStatusRec'][0]['pmtIds'][0]['pmtId']      = $pmtRec_pmtInfo_pmtIds_0_pmtId;
                $response_arr['pmtStatusRec'][0]['pmtIds'][0]['pmtIdType']  = $pmtRec_pmtInfo_pmtIds_0_pmtIdType;
                $response_arr['pmtStatusRec'][0]['pmtIds'][0]['creationDt'] = $pmtRec_pmtInfo_pmtIds_0_creationDt;
            }
            ///////////////////////////////////////
            if (!empty($pmtRec_pmtInfo_pmtIds_1_pmtId))
			{
                $response_arr['pmtStatusRec'][0]['pmtIds'][1]['pmtId']      = $pmtRec_pmtInfo_pmtIds_1_pmtId;
                $response_arr['pmtStatusRec'][0]['pmtIds'][1]['pmtIdType']  = $pmtRec_pmtInfo_pmtIds_1_pmtIdType;
                $response_arr['pmtStatusRec'][0]['pmtIds'][1]['creationDt'] = $pmtRec_pmtInfo_pmtIds_1_creationDt;
            }
            ///////////////////////////////////////
            if (!empty($pmtRec_pmtInfo_pmtIds_2_pmtId))
			{
                $response_arr['pmtStatusRec'][0]['pmtIds'][2]['pmtId']      = $pmtRec_pmtInfo_pmtIds_2_pmtId;
                $response_arr['pmtStatusRec'][0]['pmtIds'][2]['pmtIdType']  = $pmtRec_pmtInfo_pmtIds_2_pmtIdType;
                $response_arr['pmtStatusRec'][0]['pmtIds'][2]['creationDt'] = $pmtRec_pmtInfo_pmtIds_2_creationDt;
            }
            ///////////////////////////////////////
            if (!empty($pmtRec_pmtInfo_pmtIds_3_pmtId))
			{
                $response_arr['pmtStatusRec'][0]['pmtIds'][3]['pmtId']      = $pmtRec_pmtInfo_pmtIds_3_pmtId;
                $response_arr['pmtStatusRec'][0]['pmtIds'][3]['pmtIdType']  = $pmtRec_pmtInfo_pmtIds_3_pmtIdType;
                $response_arr['pmtStatusRec'][0]['pmtIds'][3]['creationDt'] = $pmtRec_pmtInfo_pmtIds_3_creationDt;
            }
            if (!empty($voucherInfo_vouchSN))
			{
                $response_arr['pmtStatusRec'][0]['pmtInfo']['extraBillingAccts'][0]['value'] = $voucherInfo_vouchSN;
                $response_arr['pmtStatusRec'][0]['pmtInfo']['extraBillingAccts'][0]['key']   = 'key1';
            }
            ///////////////////////////////////////
            $response_arr['pmtStatusRec'][0]['balanceAmt']['amt']     = $pmtRec_pmtInfo_pmtIds_pmtAmt_amt;
            $response_arr['pmtStatusRec'][0]['balanceAmt']['curCode'] = $pmtRec_pmtInfo_pmtIds_pmtAmt_curCode;

            $FawryVouchers_arr = array();
            $FawryVouchers_arr['FawryVouchers']['billingAcct']    = $pmtRec_pmtInfo_billingAcct;
            $FawryVouchers_arr['FawryVouchers']['pmtType']        = $pmtRec_pmtInfo_pmtType;
            $FawryVouchers_arr['FawryVouchers']['deliveryMethod'] = $pmtRec_pmtInfo_deliveryMethod;
            $FawryVouchers_arr['FawryVouchers']['pmtMethod']      = $pmtRec_pmtInfo_pmtMethod;
            $FawryVouchers_arr['FawryVouchers']['pmtStatus']      = $pmtRec_pmtInfo_pmtStatus;
            $FawryVouchers_arr['FawryVouchers']['billTypeCode']   = $pmtRec_pmtInfo_billTypeCode;
            $FawryVouchers_arr['FawryVouchers']['bankId']         = $pmtRec_pmtInfo_bankId;

            $FawryVouchers_arr['FawryVouchers']['vouchSN']    = $voucherInfo_vouchSN;
            $FawryVouchers_arr['FawryVouchers']['vouchPIN']   = '';
            $FawryVouchers_arr['FawryVouchers']['vouchExpDt'] = '';
            $FawryVouchers_arr['FawryVouchers']['vouchDesc']  = '';

            $FawryVouchers_arr['FawryVouchers']['amt']           = $pmtRec_pmtInfo_pmtIds_pmtAmt_amt;
            $FawryVouchers_arr['FawryVouchers']['billRefNumber'] = $pmtRec_pmtInfo_pmtIds_billRefNumber;
            $FawryVouchers_arr['FawryVouchers']['receiver']      = $receiver;

			$amt = $pmtRec_pmtInfo_pmtIds_pmtAmt_amt;
			$FawryVouchers_arr['FawryVouchers']['aiwafees10%']   = $amt * 0.1;
			$FawryVouchers_arr['FawryVouchers']['fawryfees2,5%'] = $amt * 0.025;
			$FawryVouchers_arr['FawryVouchers']['14%from2,5%']   = ($amt * 0.025) * 0.14;
			$FawryVouchers_arr['FawryVouchers']['14%from10%']    = ($amt * 0.1) * 0.14;
			$FawryVouchers_arr['FawryVouchers']['ordertot']      = $amt-($amt * 0.1)-($amt * 0.025)-(($amt * 0.025) * 0.14)-(($amt * 0.1) * 0.14);
			$FawryVouchers_arr['FawryVouchers']['voucherrefno']  = 'null';


            $amount      = $pmtRec_pmtInfo_pmtIds_pmtAmt_amt;
            $mobile      = $pmtRec_pmtInfo_billingAcct;
            $Voucher_OTP = $voucherInfo_vouchSN;

            $this->loadModel('Voucher');
            $Voucher_check = $this->Voucher->find('first', array('recursive' => '-1', 'conditions' => array('Voucher.amount' => $amount, 'Voucher.mobile' => $mobile, 'Voucher.Voucher_OTP' => $Voucher_OTP)));

            if (!empty($Voucher_check))
			{
                if ($Voucher_check['Voucher']['status'] == '0')
				{
                    $this->loadModel('Voucher');
                    if ($this->Voucher->updateAll(
                                    array(
                                'Voucher.status' => '1',
                                    ), array(
                                'Voucher.id' => $Voucher_check['Voucher']['id']
                            ))) {
                        $response_arr['status']['statusCode'] = '200';
                        $response_arr['status']['description'] = 'Success';
                        $this->loadModel("FawryVouchers");
                        $this->FawryVouchers->create();
                        $this->FawryVouchers->save($FawryVouchers_arr);
                    }
                } else {
                    $response_arr['status']['statusCode']  = '24012';
                    $response_arr['status']['description'] = 'Voucher Used Before';
                }
            } else {
                $response_arr['status']['statusCode']  = '24012';
                $response_arr['status']['description'] = 'No Voucher Found';
            }
        } else {
            $response_arr['status']['description'] = 'Failed';
        }
        header("Content-Type: application/json", true);
        echo json_encode($response_arr);

        exit();
    }

}
