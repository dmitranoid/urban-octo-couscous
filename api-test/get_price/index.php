<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $user = json_decode(file_get_contents('php://input'));
    $to      = 'info@etrade-ag.com';
    $subject = 'Get a price on request';
    $message = 'Name: ' . $user->name . PHP_EOL .
                'Company: ' . $user->company . PHP_EOL .
                'Email: ' . $user->email . PHP_EOL;
    $headers = 'From: webmaster@etrade-ag.com' . "\r\n";

    if(mail($to, $subject, $message, $headers)){
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['status'=>'success']);
    }
    else{
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['status'=>'error']);

    }

}else{
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['status'=>'error']);
}
