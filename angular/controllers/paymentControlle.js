app.controller('PaymentController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory','$location','$q',
    function ($scope, $http, $rootScope, userService, myFactory,$location,$q) {
        
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
            $scope.discount = localStorage.getItem('discount');

        }else{
            $scope.isLogin = false;
            $rootScope.isLogin = false;
        }
        
        /*
         * update information of user
         */
     $scope.getcharge = function(fromcur,fromamount){
         var deferred = $q.defer();
             userService.getDataFromSession();
            $scope.userInfo = userService.userInfo;
            method = "POST";
            url = $rootScope.getCountryByCurrency;
            Reqdata = {"currency_code":fromcur};
            var response = myFactory.httpMethodCall(method, url,Reqdata);
            
            if($scope.userInfo.country != null && $scope.userInfo.country != ""){
                 $scope.countryName = $scope.userInfo.country;
                 deferred.resolve('request successful');
            }else{
                
            response.success(function (data) {
                console.log(data);
                if (data.status == 1) {
                    $scope.countryName = data.data[0].country_name;
                    
                    deferred.resolve('request successful');
                }else if(data.status == 0){
                    
                    deferred.reject('ERROR');
                }
            });
            response.error(function (error) {
                console.log(error);
                deferred.reject('ERROR');
            });
            }
            response.then(function(resolve){
                 if($scope.countryName != null || $scope.countryName != undefined){
            method = "POST";
            url = $rootScope.gettransferrate;
            reqData = {"country_name":$scope.countryName,"currency_code":fromcur,"amount":fromamount};
            var responseofCharge = myFactory.httpMethodCall(method,url,reqData);
            responseofCharge.success(function(data){
                $scope.transfer_rate = data.transfer_rate;
                localStorage.setItem("transfer_rate",$scope.transfer_rate);
            });
            responseofCharge.error(function(data){
                $scope.transfer_rate = 0;
            });
            }
            },function(reject){
                
            });
            
           
        
    }    
    $scope.fromAmount=localStorage.getItem('FromamounT');
    $scope.fromCur=localStorage.getItem('FromCUR');
    $scope.toCur=localStorage.getItem('ToCUR');
    $scope.toAmount=localStorage.getItem('ToamounT');
    $scope.transfer_rate=localStorage.getItem('transfer_rate');
    
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
        $scope.getcharge($scope.fromCur,fromAmount);
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
                $scope.getcharge($scope.fromCur,$scope.fromAmount);
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
