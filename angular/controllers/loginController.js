 

app.controller('AdminController', function($scope, $http, $location, myFactory, constant) {
 
    $scope.activeTab = 1;
    $scope.setActiveTab = function(tabToSet) {
        $scope.activeTab = tabToSet;
    };
    $scope.formInfo = {};

    $scope.registerUser = function() {
        var method = 'POST';
        var url = constant.RegitrationApi;
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
         console.log($scope.loginInfo);
        var method = 'POST';
        var url = constant.loginApi;
        var data = $scope.loginInfo;
        var response = myFactory.httpMethodCall(method, url, data);
        response.success(function(data) {
            // success callback
            if (data.status == 1) {
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