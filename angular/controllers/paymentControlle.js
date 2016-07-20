app.controller('PaymentController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory','$location',
    function ($scope, $http, $rootScope, userService, myFactory,$location) {
        userService.getDataFromSession();
        $scope.userInfo = userService.userInfo;
        $scope.isupdate = false;
        $scope.isLogin = $rootScope.isLogin;
        //console.log($scope.userInfo);
        if (localStorage.getItem('id') != undefined || localStorage.getItem('id') != null) {
            ///$scope.isLogin = "true";
            $scope.isLogin = true;
            $rootScope.isLogin = true;
            //console.log(localStorage.getItem('first_name'));
            $scope.globaluserId = localStorage.getItem('id');
            $scope.globalName = localStorage.getItem('first_name');
            $scope.globalLastName = localStorage.getItem('last_name');
        }else{
            $scope.isLogin = false;
            $rootScope.isLogin = false;
        }
        
        /*
         * update information of user
         */
        
        $scope.fromCur = (localStorage.getItem('FromCUR') != null)?localStorage.getItem('FromCUR'):'AUD';
        $scope.toCur = (localStorage.getItem('ToCUR') != null)?localStorage.getItem('ToCUR'):'NGN';
            
        $scope.defaultCurConvert = function(){
            var method = 'POST';
            var url = $rootScope.CurrencyApi;
        var curData={};
            $scope.DefaultfromAmount = 1;
            curData.amount = $scope.DefaultfromAmount;
            curData.from = $scope.fromCur;
            curData.to = $scope.toCur;
            var response = myFactory.httpMethodCall(method, url, curData);
            response.success(function (data) {
                if (data.status == 1) {
                    
                    $scope.DefaulttoAmount = data.converted;
                    console.log($scope.DefaulttoAmount);
                } else if (data.status == 0) {

                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.defaultCurConvert();
        
        $scope.fromAmount=localStorage.getItem('FromamounT');
        $scope.toAmount=localStorage.getItem('ToamounT');
        
        $scope.convertCurFromto = function () {
            var method = 'POST';
            var url = $rootScope.CurrencyApi;
            var curData = {};
            $scope.fromAmount = ($scope.fromAmount == undefined) ? 1 : $scope.fromAmount;
            curData.amount = $scope.fromAmount;
            curData.from = $scope.fromCur;
            curData.to = $scope.toCur;
            localStorage.setItem('FromamounT',$scope.fromAmount);
            localStorage.setItem('FromCUR',$scope.fromCur);
            localStorage.setItem('ToCUR',$scope.toCur);
            var response = myFactory.httpMethodCall(method, url, curData);
            response.success(function (data) {
                if (data.status == 1) {
                    $scope.toAmount = data.converted;
                    localStorage.setItem('ToamounT',data.converted);
                } else if (data.status == 0) {

                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        
        
        $scope.convertCurtoFrom = function () {
            var method = 'POST';
            var url = $rootScope.CurrencyApi;
            var curData = {};
            $scope.toAmount = ($scope.toAmount == undefined) ? 1 : $scope.toAmount;
            curData.amount = $scope.toAmount;
            localStorage.setItem('ToamounT',$scope.toAmount);
            curData.from = $scope.toCur;
            curData.to = $scope.fromCur;
            localStorage.setItem('FromCUR',$scope.fromCur);
            localStorage.setItem('ToCUR',$scope.toCur);
            var response = myFactory.httpMethodCall(method, url, curData);
            response.success(function (data) {
                if (data.status == 1) {
                    $scope.fromAmount = data.converted;
                    localStorage.setItem('FromamounT',data.converted);
                } else if (data.status == 0) {

                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.goToSelectBen = function(){
            
            if($scope.toAmount != undefined && $scope.fromAmount != undefined){
                
            $location.path('/paybeneficiary');
            }else{
                return false;
            }
        }
        
    }]);
