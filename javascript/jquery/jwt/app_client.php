<?php
/**
 * This file processes the login request and sends back a token response
 * if successful.
 */


$requestMethod = $_SERVER['REQUEST_METHOD'];

$action = $_REQUEST["action"];


if ($action == "login" ) {

    $username = '';
    $password = '';

    if (isset($_REQUEST['user'])) {$username = $_REQUEST['user'];}
    if (isset($_REQUEST['pwd'])) {$password = $_REQUEST['pwd'];}


    if (($username == 'luiz') && ($password == '123456')) {
        require_once('jwt.php');
        /** 
         * Create some payload data with user data we would normally retrieve from a
         * database with users credentials. Then when the client sends back the token,
         * this payload data is available for us to use to retrieve other data 
         * if necessary.
         */
        $userId = 'USER123456';
        /**
         * Uncomment the following line and add an appropriate date to enable the 
         * "not before" feature.
         */
        // $nbf = strtotime('2021-01-01 00:00:01');
        /**
         * Uncomment the following line and add an appropriate date and time to enable the 
         * "expire" feature.
         */
        // $exp = strtotime('2021-01-01 00:00:01');
        // Get our server-side secret key from a secure location.
        $serverKey = '5f2b5cdbe5194f10b3241568fe4e2b24';
        // create a token
        $payloadArray = array();
        $payloadArray['userId'] = $userId;
        if (isset($nbf)) {$payloadArray['nbf'] = $nbf;}
        if (isset($exp)) {$payloadArray['exp'] = $exp;}
        $token = JWT::encode($payloadArray, $serverKey);
        // return to caller
        $returnArray = array('token' => $token);
        $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
        header('Content-type: application/json');
        echo $jsonEncodedReturnArray;
    } 
    else {
        http_response_code(400);
        $returnArray = array('error' => 'Invalid user ID or password.');
        $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
        header('Content-type: application/json');
        echo $jsonEncodedReturnArray;
    }


} else if ($action == "users" ) {


        $token = null;
        
        if (isset($_REQUEST['token'])) {
            
            $token = $_REQUEST['token'];
        
        } else {
            if (isset($_SERVER['HTTP_X_ACCESS_TOKEN'])) { 
               $token = $_SERVER['HTTP_X_ACCESS_TOKEN'];
            }
        }



        if (!is_null($token)) {
            require_once('jwt.php');
            // Get our server-side secret key from a secure location.
            $serverKey = '5f2b5cdbe5194f10b3241568fe4e2b24';
            try {
                $payload = JWT::decode($token, $serverKey, array('HS256'));
                
                //$returnArray = array('userId' => $payload->userId);
                $returnArray = array(
                    array('id' => 1, "username" => "joao", "name" => "João da Silva"),
                    array('id' => 2, "username" => "maria", "name" => "Maria Menezes"),
                    array('id' => 2, "username" => "pedro", "name" => "Pedro Azambuja")
                );


                if (isset($payload->exp)) {
                    $returnArray['exp'] = date(DateTime::ISO8601, $payload->exp);;
                }
            }
            catch(Exception $e) {
                http_response_code(500);
                $returnArray = array('error' => $e->getMessage());
            }
        } 
        else {
            http_response_code(403);
            $returnArray = array('error' => 'You are not logged in with a valid token.');
        }
        
        // return to caller
        $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
        header('Content-type: application/json');
        echo $jsonEncodedReturnArray;
    
} else if ($action == "logout" ) {
    http_response_code(200);
    $returnArray = array('message' => 'You are not logged anymore.');
    $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
    header('Content-type: application/json');
    echo $jsonEncodedReturnArray;
} else {
        http_response_code(400);
        $returnArray = array('error' => 'You have requested an invalid method.');
        $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);
        header('Content-type: application/json');
        echo $jsonEncodedReturnArray;
}