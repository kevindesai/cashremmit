app.controller('AccountSettingController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory',
    function($scope, $http, $rootScope, userService, myFactory) {
        userService.getDataFromSession();
        $scope.userInfo = userService.userInfo;

        $scope.updateValue = function(userInfo) {


            var url = $rootScope.updateApi;
            url = url + "/" + userService.userInfo.id;

            userService.UpdateInfo(userInfo);
            $scope.isupdate = false;

        }

        $scope.isupdate = false;

        $scope.EditClick = function() {
            $scope.isupdate = true;
        }

    }]);