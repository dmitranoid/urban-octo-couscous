<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $user = json_decode(file_get_contents('php://input'));
    $to      = 'info@etrade-ag.com';
    $subject = 'Callback';
    $message = 'Name: ' . $user->name . PHP_EOL .
                'Phone: ' . $user->phone . PHP_EOL;
    $headers = 'From: webmaster@etrade-ag.com' . PHP_EOL;

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
