<?php

function apiagri_login($url, $username, $password) {
    $curl = curl_init();

	curl_setopt_array($curl, array(
	  //CURLOPT_URL => 'https://tnagrisnet.tn.gov.in/RESTUZHAVAN/api/Auth/login',
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array('username' => $username,'password' => $password),
	  //CURLOPT_HTTPHEADER => array(
		//'Cookie: ci_session=dg9glj8gb8r9r29t8cpt9861oih5ebut'
	  //),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	
	// echo $response; die;
	
    return $response;
}

function apiagri_getdetails($mobile) {
    $curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://10.236.252.116/RESTUZHAVAN/api/Auth/login',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array('username' => 'aed','password' => 'tnagri2021'),
	));

	$response = curl_exec($curl);
	$code = json_decode($response);
	$token = $code->token;

	curl_close($curl);
	
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://10.236.252.116/RESTUZHAVAN/api/aed_api/user/'.$mobile,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	  CURLOPT_HTTPHEADER => array(
		'Authorization: Bearer '. $token,
	  ),
	));

	$details = curl_exec($curl);

	curl_close($curl);
	
    return $details;
}

function perform_http_request($method, $url, $data = false) {
    $curl = curl_init();

    switch ($method) {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			}
			
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
			
            break;
        default:
            if ($data) {
                $url = sprintf("%s?%s", $url, http_build_query($data));
			}
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //If SSL Certificate Not Available, for example, I am calling from http://localhost URL

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}