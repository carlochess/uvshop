<?php

$provider = new League\OAuth2\Client\Provider\Facebook(array(
    'clientId'  =>  '526791157424846',
    'clientSecret'  =>  '9e91996a32f9262e2ac9457b65883efd',
    'redirectUri'   =>  'http://uvshop.co/users/facebook'
));

if ( ! isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    header('Location: '.$provider->getAuthorizationUrl());
    exit;

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // If you are using Eventbrite you will need to add the grant_type parameter (see below)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code'],
        'grant_type' => 'authorization_code'
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $userDetails = $provider->getUserDetails($token);

        // Use these details to create a new profile
        printf('Hello %s!', $userDetails->firstName);

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->accessToken;

    // Use this to get a new access token if the old one expires
    echo $token->refreshToken;

    // Number of seconds until the access token will expire, and need refreshing
    echo $token->expires;
}