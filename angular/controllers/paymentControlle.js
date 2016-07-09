app.controller('PaymentController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory','$location',
    function ($scope, $http, $rootScope, userService, myFactory,$location) {
        userService.getDataFromSession();
        $scope.userInfo = userService.userInfo;
        $scope.isupdate = false;
        $scope.isLogin = $rootScope.isLogin;
        console.log($rootScope.isLogin);
        /*
         * update information of user
         */
        $scope.fromCur = 'AUD';
        $scope.toCur = 'NGN';
        $scope.DefaultfromAmount = 1;
        $scope.fromAmount = 1;
        localStorage.setItem('FromamounT',$scope.DefaultfromAmount);
            localStorage.setItem('FromCUR',$scope.fromCur);
            localStorage.setItem('ToCUR',$scope.toCur);
            
        var method = 'POST';
            var url = $rootScope.CurrencyApi;
        var curData={};
        curData.amount = $scope.DefaultfromAmount;
            curData.from = $scope.fromCur;
            curData.to = $scope.toCur;
            var response = myFactory.httpMethodCall(method, url, curData);
            response.success(function (data) {
                if (data.status == 1) {
                    $scope.DefaulttoAmount = data.converted;
                    $scope.toAmount = data.converted;
                    localStorage.setItem('ToamounT',data.converted);
                } else if (data.status == 0) {

                }
            });
            response.error(function (error) {
                console.log(error);
            });
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
            $location.path('/paybeneficiary');
        }
        
    }]);
