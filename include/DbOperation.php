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
  //Method to register a new student
 	public function updateVideo($title,$category,$url,$description,$owner,$vid){ 
 	  if (!$this->isVideoExists($url,$vid)) {
 	   $stmt = $this->con->prepare("UPDATE uploadvideo SET title = '".$title."' ,category='".$category."' ,url='".$url."',description='".$description."' WHERE owner=$owner and id=$vid"); 	     
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
    public function views($videoid){  
        $stmt = $this->con->prepare("UPDATE uploadvideo SET views = views+1 WHERE id=$videoid");
        $result = $stmt->execute();
        $stmt->close();
       	 if ($result){
                return 0;
            } else {
                return 1;
            }
        
    } 
	public function palyList($videoid,$userid,$favstatus){  
       if (!$this->isLiked($videoid,$userid)) {
            $cdate=date("Y/m/d h:m:s");
            $apikey = $this->generateApiKey();
            $status = true; 
            $stmt = $this->con->prepare("INSERT INTO userplaylist(userid,videoid,createdon,status) values(?, ?, ?, ?)");          
            $stmt->bind_param('iisi',$userid,$videoid,$cdate,$status);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return 0;
            } else {
                return 1;
            }
        } else {
            $stmt = $this->con->prepare("UPDATE userplaylist SET status = ? WHERE userid=? and videoid=?");
	        $stmt->bind_param("iii",$favstatus,$userid,$videoid);
	        $result = $stmt->execute();
	        $stmt->close();
       		 if ($result){
                return 10;
            } else {
                return 11;
            }
        }
    } 
	public function deletevideo($videoid,$userid){ 
            $stmt = $this->con->prepare("DELETE FROM uploadvideo WHERE id = ? and owner=?"); 
            $stmt->bind_param('ii',$videoid,$userid);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return 0;
            } else {
                return 1;
            } 
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
    public function getVideos($catid){
    	if($catid == 'all'){
        	$stmt = $this->con->prepare("SELECT uploadvideo.id as id, uploadvideo.title,uploadvideo.views, uploadvideo.category, uploadvideo.url, uploadvideo.description,uploadvideo.owner, uploadvideo.status,uploadvideo.createdon, users.id as userid,users.fname,users.lname FROM uploadvideo LEFT JOIN users on uploadvideo.owner = users.id");
    	}else{
    		 $stmt = $this->con->prepare("SELECT uploadvideo.id as id, uploadvideo.title,uploadvideo.views, uploadvideo.category, uploadvideo.url, uploadvideo.description,uploadvideo.owner, uploadvideo.status,uploadvideo.createdon, users.id as userid,users.fname,users.lname FROM uploadvideo LEFT JOIN users on uploadvideo.owner = users.id WHERE uploadvideo.category=?");
    		 $stmt->bind_param("i",$catid);
    	} 
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
	 
	public function getSearch($search){		
		$stmt = $this->con->prepare("SELECT uploadvideo.id as id, uploadvideo.title,uploadvideo.views, uploadvideo.category, uploadvideo.url, uploadvideo.description,uploadvideo.owner, uploadvideo.status,uploadvideo.createdon, users.id as userid,users.fname,users.lname FROM uploadvideo LEFT JOIN users on uploadvideo.owner = users.id  WHERE uploadvideo.title like '$search%' or uploadvideo.description like '%$search%' or users.fname like '%$search%' or users.lname like '%$search%' ");		 	
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
	public function autoComplete($inputvalue){
		$stmt = $this->con->prepare("SELECT uploadvideo.id as id, uploadvideo.title,uploadvideo.views, uploadvideo.category, uploadvideo.url, uploadvideo.description,uploadvideo.owner, uploadvideo.status,uploadvideo.createdon, users.id as userid,users.fname,users.lname FROM uploadvideo LEFT JOIN users on uploadvideo.owner = users.id  WHERE uploadvideo.title like '$inputvalue%' or uploadvideo.description like '%$inputvalue%' or users.fname like '%$inputvalue%' or users.lname like '%$inputvalue%'");	 
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close(); 
        return $assignments;
    }
 	public function myVideos($id){  
        $stmt = $this->con->prepare("SELECT uploadvideo.id as id, uploadvideo.title,uploadvideo.views, uploadvideo.category, uploadvideo.url, uploadvideo.description,uploadvideo.owner, uploadvideo.status,uploadvideo.createdon, users.id as userid,users.fname,users.lname FROM uploadvideo LEFT JOIN users on uploadvideo.owner = users.id WHERE uploadvideo.owner=?");
        $stmt->bind_param("i",$id);    	 
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
	public function interestedBy($ids){ 	 
		if($ids!='') 
      	$stmt = $this->con->prepare("SELECT * FROM userplaylist WHERE  status=1 and videoid  IN ($ids)"); 
      	else 
      	$stmt = $this->con->prepare("SELECT * FROM userplaylist where id='' and status=1");
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    } 
	public function myFavoriteVideos($ids){ 		
		$ids = join(', ', $ids);  
		if($ids!='')
       	 $stmt = $this->con->prepare("SELECT uploadvideo.id as id, uploadvideo.title,uploadvideo.views, uploadvideo.category, uploadvideo.url, uploadvideo.description,uploadvideo.owner, uploadvideo.status,uploadvideo.createdon, users.id as userid,users.fname,users.lname FROM uploadvideo LEFT JOIN users on uploadvideo.owner = users.id WHERE uploadvideo.id IN ($ids)"); 
        else
        $stmt = $this->con->prepare("SELECT uploadvideo.id as id, uploadvideo.title,uploadvideo.views, uploadvideo.category, uploadvideo.url, uploadvideo.description,uploadvideo.owner, uploadvideo.status,uploadvideo.createdon, users.id as userid,users.fname,users.lname FROM uploadvideo LEFT JOIN users on uploadvideo.owner = users.id WHERE uploadvideo.id=''"); 
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
	public function interestedByuser($uid){ 			 
      	$stmt = $this->con->prepare("SELECT * FROM userplaylist where userid=$uid and status=1");
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
	//	Method to get student details
    public function getFavorites($userid){ 
        $stmt = $this->con->prepare("SELECT * FROM userplaylist WHERE userid=? and status=1");
        $stmt->bind_param("i",$userid);
        $stmt->execute();
        $user = $stmt->get_result();
        $stmt->close();
        return $user; 
    }
	public function likeVideoIds($id){ 
       $stmt = $this->con->prepare("SELECT * FROM userplaylist WHERE userid=? and status=1");
    	$stmt->bind_param("i",$id); 
        $stmt->execute();
        $assignments = $stmt->get_result();
        $stmt->close();
        return $assignments;
    }
	public function editVideos($id){ 
        $stmt = $this->con->prepare("SELECT * FROM uploadvideo WHERE id=?");
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
	 private function isVideoExists($url,$vid='') {
	 	if($vid=='')
        $stmt = $this->con->prepare("SELECT id from uploadvideo WHERE url = ?");
        else 
        $stmt = $this->con->prepare("SELECT id from uploadvideo WHERE url = ? and id!=$vid");
        $stmt->bind_param("s", $url);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    } 
	private function isLiked($videoid,$userid) {
        $stmt = $this->con->prepare("SELECT * from userplaylist WHERE videoid = ? and userid=?");
        $stmt->bind_param("ii",$videoid,$userid);
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