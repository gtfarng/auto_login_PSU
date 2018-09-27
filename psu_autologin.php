<?php
 /**
 * phpAutoLoginPSUInternet
 *
 * The PHP AutoLogin Script for PSU Internet
 *
 * @package		phpAutoLoginPSUInternet
 * @category	Script
 * @author		Mr.Weerayut Hongsa
 */
// Login Parameter Setting
$loginUrl = 'https://cp-xml.psu.ac.th:6082/php/uid.php'; // PSU Authenticate URL
$chkLoginUrl = 'http://www.speedtest.net'; // URL For Check Authenticate
$PSU_Username = ''; // PSU Passport Username for Authenticate
$PSU_Password = ''; // PSU Passport Password for Authenticate
// Set Date-Time Zone
date_default_timezone_set('Asia/Bangkok');
// Login Checker
while (true) 
{
	$chkLoginContent = get_headers($chkLoginUrl,1);
	// Not Login
	if ($chkLoginContent[0] == 'HTTP/1.0 302 Moved Temporarily')
	{
		// Init Parameter
		$postData = http_build_query(
			array(
				'username' => $PSU_Username,
				'password' => $PSU_Password,
				'login' => 'Login'
				)
			);
		// Execute Command
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$loginUrl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		curl_close($ch);
		$chkLoginContentAfterLogin = get_headers($chkLoginUrl,1);
		if ($chkLoginContentAfterLogin[0] == 'HTTP/1.0 302 Moved Temporarily')
		{
			echo "[" . date('Y-m-d [G:i:s]') . "] Incorrect Username or Password to Login to PSU Internet\n";
		}
		else
		{
			echo "[" . date('Y-m-d [G:i:s]') . "] Login to PSU Internet Successful.\n";
		}
		
	}
	// Already Logged in
	else
	{
		echo "[" . date('Y-m-d [G:i:s]') . "] Your Already Login PSU Internet.\n";
	}
	sleep(300);
}
?>