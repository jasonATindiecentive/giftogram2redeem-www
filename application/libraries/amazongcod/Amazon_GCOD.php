<?php


// this class is simply a 'wrapper' than makes the new Amazon_GCOD_V2 compatible with all the
// platform code we already wrote...
//
// ... it does so by simply calling the parent methods then simulating the reply to make it more or less what the old API used to return
//
// JASON: created 4/28/15

include_once dirname(__FILE__) . "/Amazon_GCODv2.php"; // pull in the v2 class


class Amazon_GCOD extends Amazon_GCOD_V2 {
    public function __construct($awsAccessKeyId = NULL, $awsSecretAccessKey = NULL, $partnerId = NULL, $sandbox = false, $displayRequest = false) {
		 parent::__construct($awsAccessKeyId, $awsSecretAccessKey, $partnerId, $sandbox, $displayRequest);
	}
	
	
	/*
	 * HealthCheck
	 *
	 * AGCOD v2 doesn't really have this any more. It's replaced with a simple URL that you hit without using any credentials that returns 'healthy' when succesuful
	 */
	public function HealthCheck() {
		$r = parent::HealthCheck();
		$a = array();
		if ($r === true) {
			$a['STATUS'][0]['STATUSCODE'][0]['VALUE'] = "SUCCESS";
			$a['STATUS'][0]['STATUSMESSAGE'][0]['VALUE'] = "Health Check succesful.";
		} else {
			$a['STATUS'][0]['ERRORCODE'][0]['VALUE'] = "ERROR";
			$a['STATUS'][0]['STATUSMESSAGE'][0]['VALUE'] = $r;
		}
		
		return $a;
	}
	
	public function CreateGiftCard($gcCreationRequestId, $amount, $currencyCode = "USD") {
		$r = parent::CreateGiftCard($gcCreationRequestId, $amount, $currencyCode);
		
		$a = array();
		if ($r->status == "SUCCESS") {
			$creationRequestId = $r->creationRequestId;
			$gcClaimCode = $r->gcClaimCode;
			$gcExpirationDate = $r->gcExpirationDate;
			$gcId = $r->gcId;
			$status = $r->status;
			
			$cardStatus = $r->cardInfo->cardStatus;
			$value = $r->cardInfo->value->amount;
			$currency = $r->cardInfo->value->currencyCode;
			
			$a['STATUS'][0]['STATUSCODE'][0]['VALUE'] = $r->status;
			$a['GCCREATIONRESPONSEID'][0]['VALUE'] = $gcId;
			$a['GCCLAIMCODE'][0]['VALUE'] = $gcClaimCode;
			$a['GCVALUE'][0]['AMOUNT'][0]['VALUE'] = $value;			
			$a['GCVALUE'][0]['CURRENCYCODE'][0]['VALUE'] = $currency;
		} else if (isset($r->errorCode) ){
			$a['STATUS'][0]['STATUSMESSAGE'][0]['VALUE'] = $r->message;
			$a['STATUS'][0]['ERRORCODE'][0]['VALUE'] = $r->errorCode;
		} else {
			$a['STATUS'][0]['STATUSMESSAGE'][0]['VALUE'] = "ERROR";
			$a['STATUS'][0]['ERRORCODE'][0]['VALUE'] = $r->message;
		}
			
		return $a;
	}
	
	public function CancelGiftCard($gcCreationRequestId, $gcCreationResponseId = '') {
				
		$r = parent::CancelGiftCard($gcCreationRequestId, $gcCreationResponseId);
		
		$a = array();
		if ($r->status == "SUCCESS") {
			$a['STATUS'][0]['STATUSCODE'][0]['VALUE'] = $r->status;
			$a['STATUS'][0]['CREATIONREQUESTID'][0]['VALUE'] = $r->creationRequestId;
			$a['STATUS'][0]['GCID'][0]['VALUE'] = $r->gcId;
		} else if (isset($r->errorCode) ){
			$a['STATUS'][0]['STATUSMESSAGE'][0]['VALUE'] = $r->message;
			$a['STATUS'][0]['ERRORCODE'][0]['VALUE'] = $r->errorCode;
		} else {
			$a['STATUS'][0]['STATUSMESSAGE'][0]['VALUE'] = "ERROR";
			$a['STATUS'][0]['ERRORCODE'][0]['VALUE'] = $r->message;
		}
			
		return $a;
	}
	
	
	// v2 doesn't have a 'VoidGiftCardCreation', just call the 'CancelGiftCard' method
	public function VoidGiftCardCreation($gcCreationRequestId, $gcCreationResponseId = '') {
		return $this->	CancelGiftCard($gcCreationRequestId, $gcCreationResponseId);
	}
	
	public function AMZN_log_api_request($url, $request, $reply, $contains_sensitive_data = false) {
		if ($contains_sensitive_data) $reply="(not logged)"; // don't log this reply, it contains sensitive info we don't want to store

		// we'll send this log entry to CloudWatch
		
		use Aws\CloudWatchLogs\CloudWatchLogsClient;

		$client = CloudWatchLogsClient::factory(array(
			'region'  => 'us-east-1'
		));

		$args = array(
			'logGroupName' => "AGCOD GG2.0",
			'logStreamName' => 'Giftogram',
			'logEvents' => array(
				'timestamp' => date(),
				'message' => $message;
			)
		);
	}
	
	
}


?>