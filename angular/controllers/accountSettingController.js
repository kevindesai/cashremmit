app.controller('AccountSettingController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory',
    function($scope, $http, $rootScope, userService, myFactory) {
        $scope.days= 31;
        $scope.getNumber = function(num) {
          return new Array(num);   
        }
         $scope.totalyears = 150;
        $scope.years = [];
        var currentYear = new Date().getFullYear();
        for (var i = currentYear; i > currentYear - $scope.totalyears; i--) {
            $scope.years.push(i - 1);
        }
        userService.getDataFromSession();
        $scope.userInfo = userService.userInfo;
        var dobarray = $scope.userInfo.dob.split('-');
        //console.log(dobarray);
        $scope.userInfo.DayOfBirth = dobarray[2];
        $scope.userInfo.MonthOfBirth = dobarray[1];
        $scope.userInfo.YearOfBirth = dobarray[0];
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
            userData.dob = userData.YearOfBirth+"-"+userData.MonthOfBirth+"-"+userData.DayOfBirth;
            console.log(userData);
            //return false;
            delete userData.DayOfBirth;
            delete userData.MonthOfBirth;
            delete userData.YearOfBirth;
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