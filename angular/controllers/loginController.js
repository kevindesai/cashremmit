 

app.controller('AdminController', function($scope, $http, $location, myFactory,$rootScope) {
 
    $scope.activeTab = 1;
    $scope.setActiveTab = function(tabToSet) {
        $scope.activeTab = tabToSet;
    };
    $scope.formInfo = {};

    $scope.registerUser = function() {
        console.log($rootScope.RegitrationApi);
        var method = 'POST';
        var url = $rootScope.RegitrationApi;
        var data = $scope.formInfo;
        var response = myFactory.httpMethodCall(method, url, data);
        response.success(function(data) {
            // success callback
            if (data.status == 1) {
                $location.path('/payment');
                console.log(data);
            } else {
                console.log("else");
                console.log(data);
            }
        });
        response.error(function(error) {
            console.log(error);
        });
    };
     
    $scope.loginUser = function() {
       
        var method = 'POST';
        var url = $rootScope.loginApi;
        var data = $scope.loginInfo;
        var response = myFactory.httpMethodCall(method, url, data);
        response.success(function(data) {
            // success callback
            if (data.status == 1) {
//                $localStorage.first_name = data.data.first_name;
//                $localStorage.last_name = data.data.first_name;
                console.log(data);
                $location.path('/payment');
            } else {
                console.log("else");
                console.log(data);
            }
        });
        response.error(function(error) {
            console.log(error);
        });
         
    };
 
}); 