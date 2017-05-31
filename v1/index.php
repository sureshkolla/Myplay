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
$app->post('/updatevideo','authenticateUser', function () use ($app) { 
    verifyRequiredParams(array('id','title','category','url', 'description','owner'));
    $response = array(); 
    $vid = $app->request->post('id');
    $title = $app->request->post('title');
    $category = $app->request->post('category');
    $url = $app->request->post('url');
    $description = $app->request->post('description'); 
    $owner = $app->request->post('owner');     
    $url=youtubeID($url);
    $db = new DbOperation();
    $res = $db->updateVideo($title,$category,$url, $description,$owner,$vid);
    if ($res == 0) {
        $response["error"] = false;
        $response["message"] = "You are successfully video updated";
        echoResponse(201, $response);
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while video created";
        echoResponse(200, $response);
    }  else if ($res == 2) {
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
    }  else if ($res == 2) {
        $response["error"] = true;
        $response["message"] = "This video you already liked";
        echoResponse(200, $response);
    }
});
$app->post('/deletevideo','authenticateUser', function () use ($app) { 
    verifyRequiredParams(array('videoid','userid'));
    $response = array();
    $videoid = $app->request->post('videoid');
    $userid = $app->request->post('userid'); 
    $db = new DbOperation();
    $res = $db->deletevideo($videoid,$userid);
    if ($res == 0) {
        $response["error"] = false;
        $response["message"] = "You are successfully deleted";
        echoResponse(201, $response);
    } else if ($res == 1) {
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while deleting te video";
        echoResponse(200, $response);
    }  
});
$app->get('/editvideo/:id','authenticateUser', function ($id) use ($app) {  
    $response = array(); 
    $db = new DbOperation();  
    $res = $db->editVideos($id);   
    $resultset = array(); 
    foreach($res as $data) {
		$resultset['id'] = $data['id'];
		$resultset['title'] = $data['title']; 
		$cat=$data['category'];
		$resultset['category'] = "$cat"; 
		$resultset['url'] = "https://www.youtube.com/watch?v=".$data['url']; 
		$resultset['description'] = $data['description']; 
    }   
     
   echoResponse(200,$resultset);
});
 $app->get('/myvideos/:id','authenticateUser', function($id) use ($app){
    $db = new DbOperation();
    $result = $db->myVideos($id);
    $response = array();
    $response['error'] = false;
    $response['assignments'] = array();
    $interestedby= array();
    $response['interestedby']= array();
   
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
         $temp['firstname'] = $row['fname'];
         $temp['lastname'] = $row['lname'];        
        array_push( $interestedby,$row['id']); 
        array_push($response['assignments'],$temp);
    }
    //$strusers = implode (", ",  $interestedby);   
    $result = $db->interestedByuser($id);  
    while($row = $result->fetch_assoc()){ 
     	$temp1 = array();  
        $temp1['userid'] = $row['userid'];
        $temp1['videoid'] = $row['videoid']; 
        array_push( $response['interestedby'],$temp1); 
    } 
    echoResponse(200,$response);
});
$app->get('/favorites/:id','authenticateUser', function ($id) use ($app) {  
   	$response = array();   
    $db = new DbOperation();  
    $res = $db->likeVideoIds($id); 
    $resultset = array(); 
    foreach($res as $data) {
		$resultset[] = $data['videoid']; 
    } 	 
    $result = $db->myFavoriteVideos($resultset);
    $response = array();
    $response['error'] = false;
    $response['assignments'] = array();
    $interestedby= array();
    $response['interestedby']= array();
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
         $temp['firstname'] = $row['fname'];
         $temp['lastname'] = $row['lname'];          
        array_push( $interestedby,$row['id']); 
        array_push($response['assignments'],$temp);
    }
   // $strusers = implode (", ",  $interestedby);  
   $result = $db->interestedByuser($id);       
    while($row = $result->fetch_assoc()){ 
     	$temp1 = array();  
        $temp1['userid'] = $row['userid'];
        $temp1['videoid'] = $row['videoid']; 
        array_push( $response['interestedby'],$temp1); 
    } 
    echoResponse(200,$response);
});
$app->get('/loadvideos/:id', function($catid) use ($app){
    $db = new DbOperation();
    $result = $db->getVideos($catid);
    $response = array();
    $response['error'] = false;
    $response['assignments'] = array();
    $interestedby= array();
    $response['interestedby']= array();
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
         $temp['firstname'] = $row['fname'];
         $temp['lastname'] = $row['lname'];           
         array_push( $interestedby,$row['id']); 
         array_push($response['assignments'],$temp);
    }
    $strusers = implode (", ",  $interestedby);   
    $result = $db->interestedBy($strusers);  
    while($row = $result->fetch_assoc()){ 
     	$temp1 = array();  
        $temp1['userid'] = $row['userid'];
        $temp1['videoid'] = $row['videoid']; 
        array_push( $response['interestedby'],$temp1); 
    }    
    echoResponse(200,$response);
});
$app->get('/search/:id', function($search) use ($app){
    $db = new DbOperation(); 
    $search=utf8_decode(urldecode($search));  
    $result = $db->getSearch($search);
    $response = array();
    $response['error'] = false;
    $response['assignments'] = array();
    $interestedby= array();
    $response['interestedby']= array();
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
         $temp['firstname'] = $row['fname'];
         $temp['lastname'] = $row['lname'];     
        array_push( $interestedby,$row['id']);    
        array_push($response['assignments'],$temp);
    }        
    $strusers = implode (", ",  $interestedby);   
    $result = $db->interestedBy($strusers);  
    while($row = $result->fetch_assoc()){ 
     	$temp1 = array();  
        $temp1['userid'] = $row['userid'];
        $temp1['videoid'] = $row['videoid']; 
        array_push( $response['interestedby'],$temp1); 
    }    
    echoResponse(200,$response);
});
$app->get('/autocomplete/:id', function($inputvalue) use ($app){
    $db = new DbOperation(); 
    $inputvalue=utf8_decode(urldecode($inputvalue));  
    $result = $db->autoComplete($inputvalue);
    $response = array(); 
    $temp = array();  
    while($row = $result->fetch_assoc()){ 
        $temp['title'] = $row['title'];
        $temp['description'] = $row['description']; 
        $temp['firstname'] = $row['fname'];
        $temp['lastname'] = $row['lname'];
        array_push( $response,$temp);
    }   
    $response1=returnResponse(200,$response);
    $implode = array();
	$multiple = json_decode($response1, true);
	foreach($multiple as $single)
    $implode[] = implode('", "', $single); 
	$jsonstring= '["'.implode('", "', $implode).'"]';   //this will output abaneel, 23, john, 32, Dev, 22	
	$array = json_decode( $jsonstring, TRUE ); 
	$array = array_values( array_unique( $array, SORT_REGULAR ) );
	// Make a JSON string from the array.
	echo json_encode( $array ); exit;
 
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
        $response["message"] = "Sorry, this user already existed";
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
function returnResponse($status_code, $response){
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json');
    return  json_encode($response);
}
 
function youtubeID($url){ 
    # https://www.youtube.com/watch?v=nn5hCEMyE-E
    preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
    
     
    return $matches[1]; 
     
 }
function verifyRequiredParams($required_fields){
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