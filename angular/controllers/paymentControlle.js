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
        
    $scope.fromAmount=localStorage.getItem('FromamounT');
    $scope.fromCur=localStorage.getItem('FromCUR');
    $scope.toCur=localStorage.getItem('ToCUR');
    $scope.toAmount=localStorage.getItem('ToamounT');
    
    $scope.convertDefault = function (url, fromCur, ToCur, defaultfromamount) {
        $scope.DefaultfromAmount = defaultfromamount;
        var DefalutconRes = myFactory.currencyConvert(url, fromCur, ToCur, defaultfromamount);
        DefalutconRes.success(function (data) {
            if (data.status == 1) {
                $scope.DefaulttoAmount = data.converted;
            } else {
                $scope.DefaulttoAmount = '';
            }
        });
    }
    $scope.convertCurFromto = function (fromAmount) {
        
        if (fromAmount != "0") {
            $scope.gotopage = "#/paymentdetails";
        }
        var url = $rootScope.CurrencyApi;
        $scope.convertDefault(url, $scope.fromCur, $scope.toCur, 1);
        var FromconRes = myFactory.currencyConvert(url, $scope.fromCur, $scope.toCur, fromAmount);
        FromconRes.success(function (data) {
            if (data.status == 1) {
                $scope.toAmount = data.converted;
                localStorage.setItem('ToamounT', $scope.toAmount);
            } else {
                $scope.toAmount = '';
            }
        });
        localStorage.setItem('FromamounT', fromAmount);
        localStorage.setItem('FromCUR', $scope.fromCur);
        localStorage.setItem('ToCUR', $scope.toCur);


    }
    $scope.convertCurFromto($scope.fromAmount);
    $scope.convertCurtoFrom = function (toAmount) {
        if (toAmount != "0") {
            $scope.gotopage = "#/paymentdetails";
        }

        var url = $rootScope.CurrencyApi;
        $scope.convertDefault(url, $scope.fromCur, $scope.toCur, 1);
        var ToconRes = myFactory.currencyConvert(url, $scope.toCur, $scope.fromCur,toAmount);
        ToconRes.success(function (data) {
            if (data.status == 1) {
                $scope.fromAmount = data.converted;
                localStorage.setItem('FromamounT', $scope.fromAmount);
            } else {
                $scope.fromAmount = '';
            }
        });
        localStorage.setItem('ToamounT', $scope.toAmount);
        localStorage.setItem('FromCUR', $scope.fromCur);
        localStorage.setItem('ToCUR', $scope.toCur);
    }
        $scope.goToSelectBen = function(){
            
            if($scope.toAmount != undefined && $scope.fromAmount != undefined){
                
            $location.path('/paybeneficiary');
            }else{
                return false;
            }
        }
        
    }]);
