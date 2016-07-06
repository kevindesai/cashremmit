app.controller('AccountSettingController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory',
    function($scope, $http, $rootScope, userService, myFactory) {
        userService.getDataFromSession();
        $scope.userInfo = userService.userInfo;
        $scope.isupdate = false;

        $scope.EditClick = function() {
            $scope.isupdate = true;
        }
        /*
         * update information of user
         */
        $scope.updateValue = function(userData) {
            var method = "PUT";
            userData._method = "PUT";
            var url = $rootScope.updateApi;
            url = url + "/" + userService.userInfo.id;
            
            var response = myFactory.httpMethodCall(method, url, userData);
            console.log(response);
            response.success(function(data) {
                if (data.status == 1) {
                    console.log("test");
                    userService.UpdateInfo(userData);
                } else {
                    console.log("else");
                    console.log(data);
                }
            });
            response.error(function(error) {
                console.log(error);
            });
            $scope.isupdate = false;
        }
    }]);