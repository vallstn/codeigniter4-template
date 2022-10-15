<?php

	function airtelSmslive($mobile, $dlt_id, $send_message){

		error_reporting(0);
		
		$mobileno     =  $mobile;
		
		$dlt_ct_id  = $dlt_id;
		
		$message = $send_message;
		$finalmessage = string_to_finalmessage(trim($message));
					
		$t = date('Y-m-d H:i:s');
		$data = array(

			"keyword" => "DEMO",
			"timeStamp" => $t,

			"dataSet" =>array('0' => array (
				"UNIQUE_ID" => "43160",
				"MESSAGE" => $finalmessage,
				"OA"=>"AEDCHN",
				"MSISDN" =>  $mobileno,
				"CHANNEL" =>  "SMS",
				"LANG_ID" =>  "2",
				"CAMPAIGN_NAME" => "tnega_u",
				"CIRCLE_NAME" => "DLT_GOVT",
				"USER_NAME" => "tnega_agriengg",
				"DLT_TM_ID" =>"1001096933494158",
				"DLT_CT_ID" => $dlt_ct_id,
				"DLT_PE_ID"=>"1001155816790260075",
				"PASSWORD"=>"tnega@123"
			))

		);
	
		$data_string = json_encode($data);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)");
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, "/temp/cookie");
		curl_setopt($ch, CURLOPT_URL, "http://103.255.217.31:15181/BULK_API/InstantJsonPush");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_PROXY, '');
		echo $result =curl_exec($ch);
		
		if(curl_errno($ch)){
			$result = curl_error($ch);
		} else {$result = 1;}
		
		curl_close($ch);
		
		return $result;

	}


	function string_to_finalmessage($message){

		$finalmessage="";
		$sss = "";

		for($i=0;$i<mb_strlen($message,"UTF-8");$i++) {

			$sss=mb_substr($message,$i,1,"utf-8");

			$a=0;

			$abc="&#". ordutf8($sss,$a).";";

			$finalmessage.=$abc;

		}

		return $finalmessage;

	}

	//function to convet utf8 to html entity

	function ordutf8($string, &$offset){

		$code=ord(substr($string, $offset,1));

		if ($code >= 128)

		{ //otherwise 0xxxxxxx

			if ($code < 224) $bytesnumber = 2;//110xxxxx

			else if ($code < 240) $bytesnumber = 3; //1110xxxx

			else if ($code < 248) $bytesnumber = 4; //11110xxx

			$codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) -

			($bytesnumber > 3 ? 16 : 0);

			for ($i = 2; $i <= $bytesnumber; $i++) {

				$offset ++;
				$code2 = ord(substr($string, $offset, 1)) - 128;//10xxxxxx
				$codetemp = $codetemp*64 + $code2;

			}

		$code = $codetemp;

		}

		return $code;

	}