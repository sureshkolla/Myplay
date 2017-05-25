// Application module
var app = angular.module('myplay',['ngStorage']);
app.controller("DbController",['$scope','$http','$localStorage','$location','$timeout', function($scope,$http,$localStorage,$location,$timeout){
  
	$scope.loadCategories =function() {  
		$http.get('v1/getcategory').success(function(data){ 
			$scope.categorydetails = data.allcategories; 
		}); 
	}
	function autoPlayYouTubeModal() {
	    var trigger = $("body").find('[data-toggle="modal"]');
	    trigger.click(function () {
	        var theModal = $(this).data("target"),
	            videoSRC = $(this).attr("data-theVideo"),
	            videoSRCauto = videoSRC + "?autoplay=1";
	        $(theModal + ' iframe').attr('src', videoSRCauto);
	        $(theModal + ' button.close').click(function () {
	            $(theModal + ' iframe').attr('src', videoSRC);
	        });
	    });
	}
	bootstrap_alert = function () {}
	bootstrap_alert.warning = function (message, alert, timeout) {
    $('<div id="floating_alert" class="alert alert-' + alert + ' fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + message + '&nbsp;&nbsp;</div>').appendTo('body');
   
    $timeout(function () {
    	 $("#floating_alert").hide();
    }, timeout);    
}
$scope.sessionid=($localStorage.userId !=undefined)? $localStorage.userId :0;  
$scope.loadVideos =function($id,$name='All'){ 
	$scope.categorytype=$name;
 	$http.get('v1/loadvideos/'+$id).success(function(data){
 		 $scope.videodetails = data.assignments;
 		autoPlayYouTubeModal();
 	}); 
};

$scope.myVideos =function(){ 	
	$id=$scope.sessionid; 
	$http({  
      url: 'v1/myvideos/'+$id,  
      headers: {
       	  'Content-Type': 'application/x-www-form-urlencoded',
       	  'Authorization': $localStorage.Authorization
     	} 
   }).success(function(data){  
	   	   $scope.categorytype="My";
		   $scope.videodetails = data.assignments;
    	   autoPlayYouTubeModal(); 	  
 	}).error(function(data){ 
 		 $(".signin a").click();
 		 bootstrap_alert.warning("Pease login to your account", 'danger', 4000); 		
 	}); 
};
 
$scope.fireEvent=function($event) { 
    var theModal = $event.currentTarget.getAttribute("data-target"),
    videoSRC = $event.currentTarget.getAttribute("data-theVideo"),
    videoSRCauto = videoSRC + "?autoplay=1"; 
	$(theModal + ' iframe').attr('src', 'https://www.youtube.com/embed/'+videoSRCauto); 
} 
 $scope.login = function(info){	
      $http({  
          url: "v1/userlogin",  
          dataType: 'json',  
          method: 'POST',  
          data: $.param(info),
          headers: {'Content-Type': 'application/x-www-form-urlencoded'}
       }).success(function(data){ 
    	   if(!data.error){
		    	 $localStorage.Authorization =data.apikey;
		    	 $localStorage.userId =data.id; 
		    	 window.location.reload();
    	   }else{ 
    		   bootstrap_alert.warning(data.message, 'danger', 4000);
    	   }
 	}).error(function(data){ 
 		  bootstrap_alert.warning(data.message, 'danger', 4000);
 	});
}

$scope.uploadvideo = function(userInfo){    
	 userInfo.owner=$scope.sessionid; 
      $http({  
          url: "v1/createvideo",  
          dataType: 'json',  
          method: 'POST',  
          data: $.param(userInfo),
          headers: {
    	  'Content-Type': 'application/x-www-form-urlencoded',
    	  'Authorization': $localStorage.Authorization
      	} 
       }).success(function(data){
    	 if(!data.error){
    		 	 bootstrap_alert.warning(data.message, 'success', 4000);
		    	 $.magnificPopup.close();
  	   }else{ 
  		   bootstrap_alert.warning(data.message, 'danger', 4000);
  	   }
 	}).error(function(data){
 		 bootstrap_alert.warning(data.message, 'danger', 4000);
 	});
}
$scope.createuser = function(userInfo){   
      $http({  
          url: "v1/createuser",  
          dataType: 'json',  
          method: 'POST',  
          data: $.param(userInfo),
          headers: {'Content-Type': 'application/x-www-form-urlencoded'}
       }).success(function(data){
    	   if(!data.error){
		    	 $.magnificPopup.close();
	   }else{ 
		   bootstrap_alert.warning(data.message, 'danger', 4000);
	   }
 	}).error(function(data){
 		 bootstrap_alert.warning(data.message, 'danger', 4000);
 	});
}
$scope.liked = function($vid){  
	 var user={};
	 user.userid=$scope.sessionid; 
	 user.videoid=$vid;
	 alert(JSON.stringify(user));
     $http({  
         url: "v1/liked",  
         dataType: 'json',  
         method: 'POST',  
         data: $.param(user),
         headers: {
	   	  'Content-Type': 'application/x-www-form-urlencoded',
	   	  'Authorization': $localStorage.Authorization
     	} 
      }).success(function(data){
   	 if(!data.error){
   		 	 bootstrap_alert.warning(data.message, 'success', 4000);
   		 	$("a.likes span").removeClass('glyphicon-thumbs-down');
 	   }else{ 
 		   bootstrap_alert.warning(data.message, 'danger', 4000);
 	   }
	}).error(function(data){
		 bootstrap_alert.warning(data.message, 'danger', 4000);
	});
}
$scope.favorites = function(){  
	 var user={};
	 user.userid=$scope.sessionid;
    $http({  
        url: "v1/favorites",  
        dataType: 'json',  
        method: 'POST',  
        data: $.param(user),
        headers: {
	   	  'Content-Type': 'application/x-www-form-urlencoded',
	   	  'Authorization': $localStorage.Authorization
    	} 
    }).success(function(data){  
	  $scope.videodetails = data.assignments;
 	   autoPlayYouTubeModal(); 
	  
	}).error(function(data){ 
		 $(".signin a").click();
		 bootstrap_alert.warning("Pease login to your account", 'danger', 4000); 		
	});
}
$scope.logout = function(){     
	$localStorage.$reset(); 
	window.location.reload();
}
$scope.deleteInfo = function(info){
	$http.post('databaseFiles/deleteDetails.php',{"del_id":info.emp_id}).success(function(data){
		if (data == true) {
			getInfo();
		}
	});
}
 
$scope.UpdateInfo = function(info){
	$http.post('databaseFiles/updateDetails.php',{"id":info.emp_id,"name":info.emp_name,"email":info.emp_email,"address":info.emp_address,"gender":info.emp_gender}).success(function(data){
		$scope.show_form = true;
			if (data == true) {
				getInfo();
			}
		});
	}
 
}]);
app.controller('LogoutController',function($location, $scope, $window){
    $window.localStorage.clear();
    $location.path('/');
});