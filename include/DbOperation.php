<?php

class DbOperation
{
    private $con;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }

    //Method to register a new student
 	public function createVideo($title,$category,$url, $description,$owner){
        if (!$this->isVideoExists($url)) {
            $cdate=date("Y/m/d h:m:s");
            $apikey = $this->generateApiKey();
            $stmt = $this->con->prepare("INSERT INTO uploadvideo(title,category,url, description,owner,createdon,status) values(?, ?, ?, ?,?,?,?)");           
            $status = true; 
            $stmt->bind_param('sssssss',$title,$category,$url, $description,$owner,$cdate,$status);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }
	public function palyList($videoid,$userid){
       // if (!$this->isVideoExists($url)) {
            $cdate=date("Y/m/d h:m:s");
            $apikey = $this->generateApiKey();
            $stmt = $this->con->prepare("INSERT INTO userplaylist(userid,videoid,createdon,status) values(?, ?, ?, ?)");           
            $status = true; 
            $stmt->bind_param('iisi',$userid,$videoid,$cdate,$status);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return 0;
            } else {
                return 1;
            }
       // } else {
       //     return 2;
       // }
    }
    public function createUser($fname,$lname,$age, $username, $password,$gender){
        if (!$this->isUserExists($username)) {
            $password = md5($password);
           $cdate=date("Y/m/d h:m:s");
            $apikey = $this->generateApiKey();
            $stmt = $this->con->prepare("INSERT INTO users(fname,lname,age, username, password,gender, api_key,createdon,status) values(?, ?, ?, ?,?,?,?,?,?)");           
            $status = true;
            $stmt->bind_param('sssssssss',$fname,$lname,$age, $username, $password,$gender, $apikey,$cdate,$status);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }

    //Method to let a student log in
    public function userLogin($username,$pass){
        $password = md5($pass);
        $stmt = $this->con->prepare("SELECT * FROM users WHERE username=? and password=?");
        $stmt->bind_param("ss",$username,$password);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows>0;
    }
 

     

    //Method to create a new assignment
    public function createAssignment($name,$detail,$facultyid,$studentid){
        $stmt = $this->con->prepare("INSERT INTO assignments (name,details,faculties_id,students_id) VALUES (?,?,?,?)");
        $stmt->bind_param("ssii",$name,$detail,$facultyid,$studentid);
        $result = $stmt->execute();
        $stmt->close();
        if($result){
            return true;
        }
        return false;
    }

    //Method to update assignment status
    public function updateAssignment($id){
        $stmt = $this->con->prepare("UPDATE assignments SET completed = 1 WHERE id=?");
        $stmt->bind_param("i",$id);
        $result = $stmt->execute();
        $stmt->close();
        if($result){
            return true;
        }
        return false;
    }

    //Method to get all the assignments of a particular student
    public function getAssignments($studentid){
        $stmt = $this->con->prepare("SELECT * FROM assignments WHERE students_id=?");
        $stmt->bind_param("i",$studentid);
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
//Method to get all the assignments of a particular student
    public function getVideos($vid){
    	if($vid == 'home'){
        	$stmt = $this->con->prepare("SELECT * FROM uploadvideo");
    	}else{
    		 $stmt = $this->con->prepare("SELECT * FROM uploadvideo WHERE category=?");
    		 $stmt->bind_param("i",$vid);
    	} 
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
 	public function myVideos($id){ 
       $stmt = $this->con->prepare("SELECT * FROM uploadvideo WHERE owner=?");
    	$stmt->bind_param("i",$id); 
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
	public function myFavoriteVideos($ids){ 		
		$ids = join(', ', $ids); 
       $stmt = $this->con->prepare("SELECT * FROM uploadvideo WHERE id  IN ($ids)"); 
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
	public function likeVideoIds($id){ 
       $stmt = $this->con->prepare("SELECT * FROM userplaylist WHERE userid=?");
    	$stmt->bind_param("i",$id); 
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
 	public function getCategory(){    	 
        $stmt = $this->con->prepare("SELECT * FROM category");    	 
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }

    //Method to get student details
    public function getUser($username){
        $stmt = $this->con->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
    }
	//Method to get student details
    public function getFavorites($userid){ 
        $stmt = $this->con->prepare("SELECT * FROM userplaylist WHERE userid=?");
        $stmt->bind_param("i",$userid);
        $stmt->execute();
        $user = $stmt->get_result();
        $stmt->close();
        return $user; 
    }

    //Method to fetch all user from database
    public function getAllStudents(){
        $stmt = $this->con->prepare("SELECT * FROM users");
        $stmt->execute();
        $users = $stmt->get_result();
        $stmt->close();
        return $users;
    }   
     
    //Method to check the student username already exist or not
    private function isUserExists($username) {
        $stmt = $this->con->prepare("SELECT id from users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
	 private function isVideoExists($url) {
        $stmt = $this->con->prepare("SELECT id from uploadvideo WHERE url = ?");
        $stmt->bind_param("s", $url);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    } 
    //Checking the student is valid or not by api key
    public function isValidUser($api_key) {
        $stmt = $this->con->prepare("SELECT id from users WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    } 

    //Method to generate a unique api key every time
    private function generateApiKey(){
        return md5(uniqid(rand(), true));
    }
}