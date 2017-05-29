// Application module
var app = angular.module('myplay',['ngStorage']);
// Factory
app.factory('Searchfactory', function($http, $cacheFactory) {
    return {
        get: function(payload, successCallback){
            var key = 'search_' + payload.q;
            if($cacheFactory.get(key) == undefined || $cacheFactory.get(key) == ''){
                //$http.get('gistfile2.json', {params: payload}).then(function(data){
            	 $http.get("v1/autosearch/"+payload).then(function(data){
                    $cacheFactory(key).put('result', data.data);
                    successCallback(data.data);
                });
            }else{
                successCallback($cacheFactory.get(key).get('result'));
            }
        }
    }
});
app.controller("DbController",['$scope','$http','$localStorage','$location','$timeout','Searchfactory', function($scope,$http,$localStorage,$location,$timeout,Searchfactory){  
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
	bootstrap_alert.warning = function (message, alertclass, timeout) {
    $('<div id="floating_alert" class="alert alert-' + alertclass + ' fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' + message + '&nbsp;&nbsp;</div>').appendTo('body');
   
    $timeout(function () {
    	 $("#floating_alert").hide();
    }, timeout);    
}
$scope.sessionid=($localStorage.userId !=undefined)? $localStorage.userId :0;  	
$scope.loadVideos =function($id,$cat=''){  
	$scope.activetab=$id;
	if($cat !='')
	$scope.activetab=$cat; 
 	$http.get('v1/loadvideos/'+$id).success(function(data){
 		$scope.videodetails = data.assignments;
 		autoPlayYouTubeModal();
 	}); 
}; 
$scope.search =function(info){  
	if($.trim(info.searchbox)!=""){
	 	$http.get('v1/search/'+info.searchbox).success(function(data){
	 		$scope.categorytype="Search "; 
	 		$scope.activetab="Search";
	 		$scope.videodetails = data.assignments;
	 		autoPlayYouTubeModal();
	 	});
	}
};
$scope.myVideos =function(){ 	
	$id=$scope.sessionid; 
	$scope.activetab="My"; 
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
		 $(".signin a").click();
			bootstrap_alert.warning("Pease login to your account", 'danger', 4000); 
	});
}
$scope.favorites = function(){  
	$uid=$scope.sessionid;
	$scope.activetab="Favorite";  
    $http({  
        url: "v1/favorites/"+$uid,   
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
$scope.searcharray = {};
$scope.$watch('info.searchbox', function (val) {
	$timeout(function() { 
	    var payload = val; 
	    $scope.selectedstatus=false;
	    if( val.length > 2){
	    	Searchfactory.get(payload, function(data){ 	    		
	            $scope.searcharray = data;  
	        });
	    }else{	    	 
	        $scope.searcharray = [];
	    }
	},1000);
});
$scope.clicked = function(val){
	$scope.info.searchbox=val;
	$timeout(function() { 
		$scope.searcharray=[];
	},100);
} 
}]); 	 
app.controller('LogoutController',function($location, $scope, $window){
    $window.localStorage.clear();
    $location.path('/');
});