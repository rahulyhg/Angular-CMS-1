


var app = angular.module('myApp', []);

// http://stackoverflow.com/questions/12864887/angularjs-integrating-with-server-side-validation

app.directive('uniqueUsername', ['$http', function($http) {
  return {
    require: 'ngModel',
    link: function(scope, elem, attrs, ctrl) {
      scope.busy = false;
      scope.$watch(attrs.ngModel, function(value) {
        
        // hide old error messages
        ctrl.$setValidity('isTaken', true);
        ctrl.$setValidity('invalidChars', true);
        
        if (!value) {
          // don't send undefined to the server during dirty check
          // empty username is caught by required directive
          return;
        }
      
        scope.busy = true;
        $http.post('index/validate', {'username' : value})
          .success(function(data) {
            // everything is fine -> do nothing
            scope.busy = false;
            if (data.invalidChars) {
              ctrl.$setValidity('invalidChars', false);
            }
          })          
      })
    }
  }
}]);

//Form submitting

app.controller('FormCtrl', function ($scope, $http) {

	operations({'ID':1},"admin/session_check",$http,$scope);
  $scope.submitForm = function() {
    var formData = { 'username' : $scope.username,
                'password' : $scope.password};
      $http({
        url: "index/formsubmit",
        data: formData,
        method: 'POST'
      }).success(function(data){

        console.log(data)
        if(data == 1)
        {
         // $scope.$watch(attrs.ngModel, function(data) {
          $scope.error="Invalid Username/password";
           // alert('sadf')
         // })
        }
        if(data == 2)
        {
          window.location.href = '/admin#/home';
        }

      }).error(function(err){"ERR", console.log(err)})
  };

});

function operations(data,url,$http,$scope)
{
	$http({
		url: url,
		data: data,
		method: 'POST'
	      }).success(function(res){			
			if(url == "admin/session_check")
			{
				if(res == 1)
				{
					 window.location.href = '/admin#/home';
				}
			}
		});
	return 1;
}



