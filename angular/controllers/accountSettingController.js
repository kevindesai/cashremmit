app.controller('AccountSettingController', function($scope, $http,$rootScope,userService) { 
    console.log("account-setting"); 
    userService.getDataFromSession();
    console.log(userService.userInfo);
    $scope.userInfo = userService.userInfo;
    
    $scope.updateValue = function(key,value){
        console.log(key+"=="+value);
        userService.UpdateInfo(key,value);
    }

});