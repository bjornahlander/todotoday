<?php
	require_once "variables.php";
	//If you do not use composer it will be a different autoload.php that you must require. See facebook docs.
	require_once "vendor/autoload.php";
	require_once "ListUSers.php";

	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\FacebookResponse;
	use Facebook\FacebookSDKException;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookAuthorizationException;
	use Facebook\GraphObject;
	use Facebook\Entities\AccessToken;
	use Facebook\HttpClients\FacebookCurlHttpClient;
	use Facebook\HttpClients\FacebookHttpable;
	// init app with app id and secret
	FacebookSession::setDefaultApplication($appId , $appSecret );

	// login helper with redirect_uri
	$helper = new FacebookRedirectLoginHelper($redirectUrl);

	try {
	  $session = $helper->getSessionFromRedirect();
	} catch( FacebookRequestException $ex ) {
	  echo $ex->getMessage();
	} catch( Exception $ex ) {
	  // When validation fails or other local issues
		echo $ex->getMessage()."\n";
	}

	// see if we have a session
	if ( isset( $session ) ) {
	  // graph api request for user data
	  $request = new FacebookRequest( $session, 'GET', '/me' );
	  $response = $request->execute();
	  $graphObject = $response->getGraphObject();

	  //Save the user to the database
	  $id = $graphObject->getProperty('id');
	  $firstname = $graphObject->getProperty('first_name');
	  $lastname = $graphObject->getProperty('last_name');
	  $_SESSION["user"] = $id;
	  $_SESSION['u_firstname'] = $firstname;
	  $_SESSION['u_lastname'] = $lastname;
	  $users = new ListUsers($db);
	  $user = $users->createAccount($id,$firstname,$lastname);
	  //echo '<p>'.$user.'</p>';
	 // echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';
	  echo '<a href="' . $helper->getLogoutUrl($session, $redirectUrl).'">Logout</a>';
	} else {
	  // show login url
	  echo '<a href="' . $helper->getLoginUrl( array( 'scope' => $scope)) . '">Login with Facebook</a>';
	}

?>