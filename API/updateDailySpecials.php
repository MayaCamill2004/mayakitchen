<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include_once('../core/initialize.php');
$dailySpecials = new DailySpecials($db);


// JSON request data
$data = json_decode(file_get_contents('php://input'));

// Check if user_id is provided and valid
if (!empty($data->user_id) && is_numeric($data->user_id)) {
    // Instantiate the ServeOrderFeedback class
    $serveOrderFeedback = new ServeOrderFeedback($db);
    $serveOrderFeedback->user_id = $data->user_id;

    // Get the user feedback
    $feedback = $serveOrderFeedback->getUserFeedback();

    // Respond with feedback data
    echo json_encode($feedback);
} else {
    // Respond with error message if user_id is not provided
    http_response_code(400); // Bad Request
    echo json_encode(array('message' => 'Incomplete data. Please provide a valid user_id.'));
}

?>
