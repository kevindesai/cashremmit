app.controller('PaymentController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory',
    function ($scope, $http, $rootScope, userService, myFactory) {
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
        $scope.fromAmount = 1;
        var method = 'POST';
            var url = $rootScope.CurrencyApi;
        var curData={};
        curData.amount = $scope.fromAmount;
            curData.from = $scope.fromCur;
            curData.to = $scope.toCur;
            var response = myFactory.httpMethodCall(method, url, curData);
            response.success(function (data) {
                if (data.status == 1) {
                    $scope.toAmount = data.converted;
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
            var response = myFactory.httpMethodCall(method, url, curData);
            response.success(function (data) {
                if (data.status == 1) {
                    $scope.toAmount = data.converted;
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
            curData.from = $scope.toCur;
            curData.to = $scope.fromCur;
            var response = myFactory.httpMethodCall(method, url, curData);
            response.success(function (data) {
                if (data.status == 1) {
                    $scope.fromAmount = data.converted;
                } else if (data.status == 0) {

                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        
    }]);