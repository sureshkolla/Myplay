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
	function YouTubeGetID(url){
		  var ID = '';
		  url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
		  if(url[2] !== undefined) {
		    ID = url[2].split(/[^0-9a-z_\-]/i);
		    ID = ID[0];
		  }
		  else {
		    ID = url;
		  }
		    return ID;
		}
	bootstrap_alert = function () {}
	bootstrap_alert.warning = function (message, alertclass, timeout) {
	$("#floating_alert").remove();
    $('<div id="floating_alert" class="alert alert-' + alertclass + ' fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>' + message + '&nbsp;&nbsp;</div>').appendTo('body');   
    $timeout(function () {
    	 $("#floating_alert").hide();
    }, timeout);    
}
$scope.sessionid=($localStorage.userId !=undefined)? $localStorage.userId :0;
$scope.sessionuser=$localStorage.user; 
$scope.loadVideos =function($id,$cat=''){  
	$scope.activetab=$id;
	if($cat !='')
	$scope.activetab=$cat; 
 	$http.get('v1/loadvideos/'+$id).success(function(data){
 		$scope.videodetails = data;
 		autoPlayYouTubeModal();
 	}); 
}; 
$scope.search =function(info){  
	if($.trim(info.searchbox)!=""){
	 	$http.get('v1/search/'+info.searchbox).success(function(data){
	 		$scope.categorytype="Search "; 
	 		$scope.activetab="Search";
	 		$scope.videodetails = data;
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
		   $scope.videodetails = data;
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
		    	 $localStorage.user =data.username; 
		    	 window.location.reload();
    	   }else{ 
    		   bootstrap_alert.warning(data.message, 'danger', 4000);
    	   }
 	}).error(function(data){ 
 		  bootstrap_alert.warning(data.message, 'danger', 4000);
 	});
} 
 $scope.clearform=function(videoInfo){  
		 $scope.videoInfo.id=''; 
		 $scope.videoInfo.title='';
		 $scope.videoInfo.category='';
		 $scope.videoInfo.url='';
		 $scope.videoInfo.description='';		 
 }
$scope.uploadvideo = function(videoInfo){  
	videoInfo.owner=$scope.sessionid;  
	if(videoInfo.id !=undefined && !(videoInfo.id==isNaN(videoInfo.id))){
		var apiurl="v1/updatevideo";   
	}
	else { 
		var apiurl="v1/createvideo"; 
	}	 
    $http({  
          url: apiurl,  
          dataType: 'json',  
          method: 'POST',  
          data: $.param(videoInfo),
          headers: {
    	  'Content-Type': 'application/x-www-form-urlencoded',
    	  'Authorization': $localStorage.Authorization
      	} 
       }).success(function(data){
    	 if(!data.error){
    		 bootstrap_alert.warning(data.message, 'success', 4000);
    		 $.magnificPopup.close();
    		 /** Update data from javascript**/
    		 if(videoInfo.id !=undefined && !(videoInfo.id==isNaN(videoInfo.id))){    			 
    			 var videourl=YouTubeGetID(videoInfo.url);		 
    			 $('#video'+videoInfo.id).find('.btn-default img').attr('src','https://img.youtube.com/vi/'+videourl+'/1.jpg');
    			 $('#video'+videoInfo.id).find('.title').text(videoInfo.title);
    			 $('#video'+videoInfo.id).find('span.fname').text(videoInfo.fname);
    			 $('#video'+videoInfo.id).find('span.lname').text(videoInfo.lname);
			 }
		     
  	   }else{ 
  		   bootstrap_alert.warning(data.message, 'danger', 4000);
  	   }
 	}).error(function(data){
 		 bootstrap_alert.warning(data.message, 'danger', 4000);
 	});
}
$scope.editvideo = function ($vid) {  
	 var user={};
	 user.userid=$scope.sessionid; 
	 user.videoid=$vid;
 	 $http({  
       url: "v1/editvideo/"+$vid,   
       headers: {
	   	  'Content-Type': 'application/x-www-form-urlencoded',
	   	  'Authorization': $localStorage.Authorization
   	} 
    }).success(function(data){		  
		if(!data.error){ 
 		 	$scope.videoInfo=data;   		 	
 		 	$.magnificPopup.open({
 		 	  items: {
 		 	      src: '#small-dialog5',
 		 	      type: 'inline'
 		 	  }
 		 }); 		 	
	   }else{ 
		   bootstrap_alert.warning(data.message, 'danger', 4000);
	   }
	}).error(function(data){
		 $(".signin a").click();
		 bootstrap_alert.warning("Pease login to your account", 'danger', 4000); 
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
$scope.liked = function($vid,event){  
	 var user={};
	 user.userid=$scope.sessionid; 
	 user.videoid=$vid;  
	 if(angular.element(event.target).hasClass('glyphicon-thumbs-up')){ 
		angular.element(event.target).removeClass('glyphicon-thumbs-up').addClass('glyphicon-thumbs-down');
		 user.favstatus=1;
	 }
	 else{
		 angular.element(event.target).removeClass('glyphicon-thumbs-down').addClass('glyphicon-thumbs-up');
		 user.favstatus=0;
	 }
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
 	   }else{ 
 		   bootstrap_alert.warning(data.message, 'danger', 4000);
 	   }
	}).error(function(data){
		 $(".signin a").click();
		  bootstrap_alert.warning("Pease login to your account", 'danger', 4000); 
	});
} 

$scope.deletevideo = function(event,$vid){  
	 var user={};
	 user.userid=$scope.sessionid; 
	 user.videoid=$vid;
     $http({  
        url: "v1/deletevideo",  
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
  		 	/** Delete data from javascript**/
  		 	 angular.element(event.target).parents('.parent-template').remove();
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
	  $scope.videodetails = data;
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
var timeoutHandle;
$scope.searching =function(info){   
	 $timeout.cancel(timeoutHandle);
	 timeoutHandle =$timeout(function() {  
	    if(info.searchbox.length > 2){ 
	    	$http.get("v1/autocomplete/"+info.searchbox).then(function(response	){ 
	    		$scope.searcharray = response.data;
            }); 
	    }else{	  
	        $scope.searcharray = [];
	    }
	},1000);
} 
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