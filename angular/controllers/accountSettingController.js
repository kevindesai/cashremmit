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
        console.log($scope.userInfo);
        var dobarray = $scope.userInfo.dob.split('-');
        //console.log(dobarray);
        $scope.userInfo.DayOfBirth = dobarray[2];
        $scope.userInfo.MonthOfBirth = dobarray[1];
        $scope.userInfo.YearOfBirth = dobarray[0];
        $scope.userInfo.password='';
//        console.log($scope.userInfo);
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
//            return false;
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
        
        /**
         * Update Password
         * @param {type} userData
         * @returns {undefined}
         */
        
         $scope.updatePassword = function(userData) {
            var method = "PUT";
            userData._method = "PUT";
            var url = $rootScope.updateApi;
            url = url + "/" + userService.userInfo.id;
//            console.log(userData);
            if(userData.password !=""){
            var response = myFactory.httpMethodCall(method, url, userData);
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
            }
        };
        $scope.uploadFile = function(files){
           //var file = $scope.myFile;
            $scope.userInfo = userService.userInfo;
               var uploadUrl = $rootScope.updateProfilePic;
               var fd = new FormData();
               fd.append('file', files[0]);
               fd.append('token',$scope.userInfo.token);
               $http.post(uploadUrl, fd, {
                  transformRequest: angular.identity,
                  headers: {'Content-Type': undefined}
               })
               .success(function(data){
                   if(data.status=='1'){
                       var imageNmae = data.data;
                       $scope.userInfo.proile = data.data;
                       localStorage.setItem("profile",data.data);
                   }
               })
               .error(function(data){
                   alert("Please try again");
               });
        };
    }]);