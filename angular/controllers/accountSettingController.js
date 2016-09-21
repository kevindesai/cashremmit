app.controller('AccountSettingController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory',
    function($scope, $http, $rootScope, userService, myFactory) {
        userService.getDataFromSession();
        $scope.userInfo = userService.userInfo;
        console.log($scope.userInfo);
        $scope.isupdate = false;
        $scope.getCountry = function () {
            method = "GET";
            url = $rootScope.getCountry;
            methodData = {};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
                if (data.status == 1) {
                    $scope.countryList = data.data;
        
                } else {
                    $scope.countryList = {};
                }

            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.getCountry();

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
            var date = new Date(userData.dob);
            userData.dob = date.toString('dd-MM-yy');
            //console.log(userData);
            delete userData.password;
            //console.log(userData);
            var response = myFactory.httpMethodCall(method, url, userData);
            //console.log(response);
            response.success(function(data) {
                if (data.status == 1) {
                    userService.UpdateInfo(userData);
                } else {
                    //console.log(data);
                }
            });
            response.error(function(error) {
               // console.log(error);
            });
            $scope.isupdate = false;
        }
    }]);