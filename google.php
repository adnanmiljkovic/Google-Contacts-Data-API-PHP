<?php 
if (isset($_GET['token'])) {
	$result = curl_init("https://www.google.com/accounts/AuthSubSessionToken");
	curl_setopt($result, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($result, CURLOPT_HTTPHEADER, array("Authorization: AuthSub token=\"".$_GET['token']."\""));
	curl_setopt($result, CURLOPT_VERBOSE, 1);
	curl_setopt ($result, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($result, CURLOPT_TIMEOUT, 120);
	$response_h = curl_exec($result);
	curl_close($result);
	// get the sessiontoken
	$pieces = explode("Token=", $response_h);

	$session = curl_init("http://www.google.com/m8/feeds/contacts/default/full?alt=json");
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($session, CURLOPT_HTTPHEADER, array("Authorization: AuthSub token=\"".$pieces[1]."\""));
	curl_setopt($session, CURLOPT_VERBOSE, 1);
	curl_setopt ($session, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($session, CURLOPT_TIMEOUT, 120);
	$response_session = curl_exec($session);
	curl_close($session);
			
	//get the data to an array			
	$json_a=json_decode($response_session, true);
	foreach($json_a['feed']['entry'] as $contact) {
		echo 'Email: '.$contact['gd$email']['0']['address'].'Name: '.$contact['title']['$t'].'<BR>';
	}
}
?>
<a href="https://www.google.com/accounts/AuthSubRequest?scope=http%3A%2F%2Fwww.google.com%2Fm8%2Ffeeds%2F&session=1&secure=0&next=http://domain.com/google.php">Authorize with GOOGLE<a/>
