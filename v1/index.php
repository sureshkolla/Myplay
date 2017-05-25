<?php

//including the required files
require_once '../include/DbOperation.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim;

/* *
 * URL: http://localhost/StudentApp/v1/createstudent
 * Parameters: name, username, password
 * Method: POST
 * */
$app->post('/createvideo','authenticateUser', function () use ($app) { 
    verifyRequiredParams(array('title','category','url', 'description','owner'));
    $response = array();
    $title = $app->request->post('title');
    $category = $app->request->post('category');
    $url = $app->request->post('url');
    $description = $app->request->post('description'); 
    $owner = $app->request->post('owner');  
    $url=youtubeID($url);
    $db = new DbOperation();
    $res = $db->createVideo($title,$category,$url, $description,$owner);
    if ($res == 0) {
        $response["error"] = false;
        $response["message"] = "You are successfully video created";
        echoResponse(201, $response);
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while video created";
        echoResponse(200, $response);
    } else if ($res == 2) {
        $response["error"] = true;
        $response["message"] = "Sorry, this video already existed";
        echoResponse(200, $response);
    }
});
$app->post('/liked','authenticateUser', function () use ($app) { 
    verifyRequiredParams(array('videoid','userid'));
    $response = array();
    $videoid = $app->request->post('videoid');
    $userid = $app->request->post('userid'); 
    $db = new DbOperation();
    $res = $db->palyList($videoid,$userid);
    if ($res == 0) {
        $response["error"] = false;
        $response["message"] = "You are successfully added to playlist";
        echoResponse(201, $response);
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while addining to playlist";
        echoResponse(200, $response);
    } 
});
 
$app->post('/favorites','authenticateUser', function () use ($app) { 
    verifyRequiredParams(array('userid'));
    $response = array(); 
    $userid = $app->request->post('userid'); 
    $db = new DbOperation();  
    $res = $db->likeVideoIds($userid); 
    $resultset = array(); 
    foreach($res as $data) {
    $resultset[] = $data['videoid']; 
    }
    
	 
    $result = $db->myFavoriteVideos($resultset);
    $response = array();
    $response['error'] = false;
    $response['assignments'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id1']=$row['id'];
        $temp['title'] = $row['title'];
        $temp['category'] = $row['category'];
        $temp['url'] = $row['url'];
        $temp['description'] = $row['description'];
        $temp['owner'] = $row['owner'];
        $temp['createdon'] = $row['createdon'];
        $temp['status'] = $row['status'];          
        //$temp['faculty']= $db->getFacultyName($row['faculties_id']);
         array_push($response['assignments'],$temp);
    }
    echoResponse(200,$response);
});
$app->get('/loadvideos/:id', function($vid) use ($app){
    $db = new DbOperation();
    $result = $db->getVideos($vid);
    $response = array();
    $response['error'] = false;
    $response['assignments'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id']=$row['id'];
        $temp['title'] = $row['title'];
        $temp['category'] = $row['category'];
        $temp['url'] = $row['url'];
        $temp['description'] = $row['description'];
        $temp['owner'] = $row['owner'];
        $temp['createdon'] = $row['createdon'];
        $temp['status'] = $row['status'];          
        //$temp['faculty']= $db->getFacultyName($row['faculties_id']);
         array_push($response['assignments'],$temp);
    }
    echoResponse(200,$response);
});
$app->get('/myvideos/:id','authenticateUser', function($id) use ($app){
    $db = new DbOperation();
    $result = $db->myVideos($id);
    $response = array();
    $response['error'] = false;
    $response['assignments'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id']=$row['id'];
        $temp['title'] = $row['title'];
        $temp['category'] = $row['category'];
        $temp['url'] = $row['url'];
        $temp['description'] = $row['description'];
        $temp['owner'] = $row['owner'];
        $temp['createdon'] = $row['createdon'];
        $temp['status'] = $row['status'];          
        //$temp['faculty']= $db->getFacultyName($row['faculties_id']);
         array_push($response['assignments'],$temp);
    }
    echoResponse(200,$response);
});
$app->get('/getcategory', function() use ($app){
    $db = new DbOperation();
    $result = $db->getCategory();
    $response = array();
    $response['error'] = false;
    $response['allcategories'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id']=$row['id'];
        $temp['cetegory_name'] = $row['cetegory_name'];       
        $temp['createdon'] = $row['createdon'];
        $temp['status'] = $row['status'];          
        //$temp['faculty']= $db->getFacultyName($row['faculties_id']);
         array_push($response['allcategories'],$temp);
    }
    echoResponse(200,$response);
});
$app->post('/createuser', function () use ($app) { 
    verifyRequiredParams(array('fname','lname','age', 'username', 'password','gender'));
    $response = array();
    $fname = $app->request->post('fname');
    $lname = $app->request->post('lname');
    $age = $app->request->post('age');
    $username = $app->request->post('username');
    $password = $app->request->post('password');
    $gender = $app->request->post('gender');  
    $db = new DbOperation();
    $res = $db->createUser($fname,$lname,$age, $username, $password,$gender);
    if ($res == 0) {
        $response["error"] = false;
        $response["message"] = "You are successfully registered";
        echoResponse(201, $response);
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
        echoResponse(200, $response);
    } else if ($res == 2) {
        $response["error"] = true;
        $response["message"] = "Sorry, this student  already existed";
        echoResponse(200, $response);
    }
});

/* *
 * URL: http://localhost/StudentApp/v1/studentlogin
 * Parameters: username, password
 * Method: POST
 * */
$app->post('/userlogin', function () use ($app) {
    verifyRequiredParams(array('username', 'password'));
    $username = $app->request->post('username');
    $password = $app->request->post('password');
    $db = new DbOperation();
    $response = array();
    if ($db->userLogin($username, $password)) {
        $user = $db->getUser($username);
        $response['error'] = false;
        $response['id'] = $user['id'];
        $response['fname'] = $user['fname'];
        $response['lname'] = $user['lname'];
        $response['username'] = $user['username'];
        $response['age'] = $user['age'];
        $response['gender'] = $user['gender']; 
        $response['createdon'] = $user['createdon'];
        $response['apikey'] = $user['api_key'];
    } else {
        $response['error'] = true;
        $response['message'] = "Invalid username or password";
    }
    echoResponse(200, $response);
});

 

/* *
 * URL: http://localhost/StudentApp/v1/createassignment
 * Parameters: name, details, facultyid, studentid
 * Method: POST
 * */
$app->post('/createassignment',function() use ($app){
    verifyRequiredParams(array('name','details','facultyid','studentid'));

    $name = $app->request->post('name');
    $details = $app->request->post('details');
    $facultyid = $app->request->post('facultyid');
    $studentid = $app->request->post('studentid');

    $db = new DbOperation();

    $response = array();

    if($db->createAssignment($name,$details,$facultyid,$studentid)){
        $response['error'] = false;
        $response['message'] = "Assignment created successfully";
    }else{
        $response['error'] = true;
        $response['message'] = "Could not create assignment";
    }

    echoResponse(200,$response);

});

/* *
 * URL: http://localhost/StudentApp/v1/assignments/<student_id>
 * Parameters: none
 * Authorization: Put API Key in Request Header
 * Method: GET
 * */
$app->get('/assignments/:id', 'authenticateUser', function($student_id) use ($app){
    $db = new DbOperation();
    $result = $db->getAssignments($student_id);
    $response = array();
    $response['error'] = false;
    $response['assignments'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id']=$row['id'];
        $temp['name'] = $row['name'];
        $temp['details'] = $row['details'];
        $temp['completed'] = $row['completed'];
        $temp['faculty']= $db->getFacultyName($row['faculties_id']);
        array_push($response['assignments'],$temp);
    }
    echoResponse(200,$response);
});


/* *
 * URL: http://localhost/StudentApp/v1/submitassignment/<assignment_id>
 * Parameters: none
 * Authorization: Put API Key in Request Header
 * Method: PUT
 * */

$app->put('/submitassignment/:id', 'authenticateFaculty', function($assignment_id) use ($app){
    $db = new DbOperation();
    $result = $db->updateAssignment($assignment_id);
    $response = array();
    if($result){
        $response['error'] = false;
        $response['message'] = "Assignment submitted successfully";
    }else{
        $response['error'] = true;
        $response['message'] = "Could not submit assignment";
    }
    echoResponse(200,$response);
});

function echoResponse($status_code, $response){
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response);
}

function youtubeID($url){
     $res = explode("v",$url);
     if(isset($res[1])) {
        $res1 = explode('&',$res[1]);
        if(isset($res1[1])){
            $res[1] = $res1[0];
        }
        $res1 = explode('#',$res[1]);
        if(isset($res1[1])){
            $res[1] = $res1[0];
        }
     }
     return substr($res[1],1,12);
     return false;
 }
function verifyRequiredParams($required_fields)
{
    $error = false;
    $error_fields = "";
    $request_params = $_REQUEST;

    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }

    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(400, $response);
        $app->stop();
    }
}

function authenticateUser(\Slim\Route $route)
{
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
	//$headers['Authorization']='a235f51b418125451769a4700af8c4fd';
    if (isset($headers['Authorization'])) {
        $db = new DbOperation();
        $api_key = $headers['Authorization'];
        if (!$db->isValidUser($api_key)) {
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoResponse(401, $response);
            $app->stop();
        }
    } else {
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoResponse(400, $response);
        $app->stop();
    }
}


function authenticateFaculty(\Slim\Route $route)
{
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    if (isset($headers['Authorization'])) {
        $db = new DbOperation();
        $api_key = $headers['Authorization'];
        if (!$db->isValidFaculty($api_key)) {
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoResponse(401, $response);
            $app->stop();
        }
    } else {
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoResponse(400, $response);
        $app->stop();
    }
}

$app->run();