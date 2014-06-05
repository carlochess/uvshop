<?php

$provider = new League\OAuth2\Client\Provider\Google(array(
    'clientId'  =>  '206140480642.apps.googleusercontent.com',
    'clientSecret'  =>  'AIzaSyCXXTzDOwT-IoVygSvdBB47jN4Rxsye2pU',
    'redirectUri'   =>  'http://uvshop.co/users/gmail'
));

if ( ! isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    header('Location: '.$provider->getAuthorizationUrl());
    exit;

} else {
    //echo "Codigo: ".$_GET['code'].'<br/>';
    try{
    $token = $provider->getAccessToken('AuthorizationCode', [
        'code' => $_GET['code']
    ]);
}catch(Exception $e)
{
        echo "Error: ".$e;
}

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $userDetails = $provider->getUserDetails($token);

        // Use these details to create a new profile
        printf('Hola %s!', $userDetails->firstName);

    } catch (Exception $e) {
    
    }

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $userDetails = $provider->getUserDetails($token);

        // Use these details to create a new profile
        printf('Hola %s!', $userDetails->firstName);

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh Dios...');
    }

    // Use this to interact with an API on the users behalf
    //echo $token->accessToken;

    // Use this to get a new access token if the old one expires
    //echo $token->refreshToken;

    // Number of seconds until the access token will expire, and need refreshing
    //echo $token->expires;
}