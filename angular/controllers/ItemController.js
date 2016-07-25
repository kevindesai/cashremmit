app.controller('commonController', ['$scope', '$location', '$http', '$rootScope', 'userService', 'myFactory','$window',
    function ($scope, $location, $http, $rootScope, userService, myFactory,$window) {
        $scope.activeTab = 1;
    $scope.setActiveTab = function(tabToSet) {
        $scope.activeTab = tabToSet;
    };
   // console.log(localStorage.getItem('id'));
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
        
        $scope.doLogout = function () {
            localStorage.removeItem('id');
            localStorage.removeItem('email');
            localStorage.removeItem('token');
            localStorage.removeItem('first_name');
            localStorage.removeItem('last_name');
            localStorage.removeItem('building_name');
            localStorage.removeItem('city');
            localStorage.removeItem('country');
            localStorage.removeItem('landline_no');
            localStorage.removeItem('mobile_no');
            localStorage.removeItem('post_code');
            localStorage.removeItem('region');
            localStorage.removeItem('street');
            localStorage.removeItem('unit_no');
            localStorage.removeItem('FromamounT');
            localStorage.removeItem('FromCUR');
            localStorage.removeItem('ToCUR');
            localStorage.removeItem('ToamounT');
            $location.path('/');
        }
    }]);
app.controller('ReportController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory', '$location','$document',
    function ($scope, $http, $rootScope, userService, myFactory, $location,$document) {
        userService.getDataFromSession();
        $scope.userInfo = userService.userInfo;
        $scope.ToAmount = localStorage.getItem('ToamounT')
        $scope.ToCur = localStorage.getItem('ToCUR')
        $scope.globalName = localStorage.getItem('first_name');
        $scope.globalLastName = localStorage.getItem('last_name');
        $scope.setActiveBenif = function (activeData, indexes) {
            $scope.isActive = indexes;
            $scope.benifData = activeData;
        }
        $scope.refreshbeif = function () {
            $scope.isActive = 0;
            $scope.NoBenif=0;
            $scope.user_id = localStorage.getItem('id');
            method = "GET";
            url = $rootScope.getBenefiery + '/' + $scope.user_id+"?token="+$scope.userInfo.token;
            var methodData = {"_method": "GET",'token':$scope.userInfo.token};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
                console.log(data);
                if (data.status == 1 && data.message == "data found") {
                    $scope.userBefif = data.data;
                    $scope.benifData = data.data[0];
                }else if(data.status == -1){
                    
                    $scope.doLogout();
                }
                else{
                    $scope.NoBenif = 1;
                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.refreshbeif();
        $scope.getCountry = function (){
           method = "GET";
            url = $rootScope.getCountry;
            methodData ={};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
                if(data.status==1){
                    $scope.countryList = data.data;
                    
                }else{
                    $scope.countryList ={};
                }
                
            });
            response.error(function (error) {
                console.log(error);
            }); 
        }
        $scope.getCountry();
        $scope.getBanks = function(countryIdName){
            var dataArr = countryIdName.split("_");
            $scope.CountryId = dataArr[0];
            $scope.country_name = dataArr[1];
            method = "GET";
            url = $rootScope.getBanks+"/"+$scope.CountryId;
            methodData ={};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
                if(data.status==1){
               $scope.Banks = data.data;     
                    
                }else{
                    $scope.Banks ={};
                }
                
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.getBankDetails=function(bankselect){
            var dataArr = bankselect.split("_");
            $scope.BankId = dataArr[0];
            $scope.bank_name = dataArr[1];
            method = "GET";
            url = $rootScope.getbankdetail+"/"+$scope.BankId;
            methodData ={};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
                console.log(data)
                if(data.status==1){
               $scope.BankDetails = data.data;     
                    
                }else{
                    $scope.BankDetails ={};
                }
                
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.addbenif = function (benifdata) {
        	$scope.benifData = $scope.benif;
            $scope.benifData.user_id = $scope.userInfo.id;
            $scope.benifData.token = $scope.userInfo.token;
            $scope.benifData.attributes = JSON.stringify($scope.benifData.attributes);
            var dataArr = $scope.benifData.bank_name.split("_");
            $scope.BankId = dataArr[0];
            $scope.benifData.bank_name = dataArr[1];
            method = "POST";
            url = $rootScope.addBenefiery;
            var response = myFactory.httpMethodCall(method, url, $scope.benifData);
            response.success(function (data) {
                
                if (data.status == 1) {
                    $scope.refreshbeif();
                    $('#myModal').modal('hide');
                }else if(data.status == -1){
                    
                    $scope.doLogout();
                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        

    }]);
app.controller('SuccessController', function ($scope, $http) {
    console.log("SuccessController");

});
app.controller('TransfarDetailController', function ($scope, $http) {
    console.log("TransfarDetailController");

});
app.controller('SelectPaymentController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory', '$location',
    function ($scope, $http, $rootScope, userService, myFactory, $location) {
    userService.getDataFromSession();
    $scope.userInfo = userService.userInfo;    
    
    $scope.ToAmount = localStorage.getItem('ToamounT')
        $scope.ToCur = localStorage.getItem('ToCUR')
        $scope.globalName = localStorage.getItem('first_name');
        $scope.globalLastName = localStorage.getItem('last_name');


}]);
app.controller('PaymentDetailsController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory', '$location','$q',
    function ($scope, $http, $rootScope, userService, myFactory, $location,$q) {
    $scope.userId = localStorage.getItem('id');
    $scope.isLogin=true;
    if($scope.userId == null || $scope.userId == undefined){
        $scope.isLogin = false;
    }
    $scope.fromAmount=localStorage.getItem('FromamounT');
    $scope.fromCur=localStorage.getItem('FromCUR');
    $scope.toCur=localStorage.getItem('ToCUR');
    $scope.toAmount=localStorage.getItem('ToamounT');
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
                $scope.getcharge($scope.fromCur,$scope.fromAmount);
                localStorage.setItem('FromamounT', $scope.fromAmount);
            } else {
                $scope.fromAmount = '';
            }
        });
        localStorage.setItem('ToamounT', $scope.toAmount);
        localStorage.setItem('FromCUR', $scope.fromCur);
        localStorage.setItem('ToCUR', $scope.toCur);
    }
    
    
    
    //$scope.getcharge($scope.fromCur,$scope.fromAmount);


}]);
app.controller('BeneficiariesController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory', '$location',
    function ($scope, $http, $rootScope, userService, myFactory, $location) {
        userService.getDataFromSession();
        $scope.userInfo = userService.userInfo;
        $scope.refreshbeif = function () {
            $scope.isActive = 0;
            $scope.user_id = localStorage.getItem('id');
            method = "GET";
            url = $rootScope.getBenefiery + '/' + $scope.user_id+'?token='+$scope.userInfo.token;
            var methodData = {"_method": "GET"};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
                console.log(data);
                if (data.status == 1 && data.message == "data found") {
                    $scope.userBefif = data.data;
                    $scope.benifData = data.data[0];
                }else if(data.status == -1){
                    
                    $scope.doLogout();
                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.refreshbeif();
        $scope.deleteBenif = function (id) {
            $scope.user_id = localStorage.getItem('id');
            method = "POST";
            url = $rootScope.deleteBenefiery + '/' + id+'?token='+$scope.userInfo.token;
            var methodData = {"_method": "DELETE"};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
               
                if (data.status == 1) {
                    $scope.refreshbeif();
                }else if(data.status == -1){
                    
                    $scope.doLogout();
                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
    }]);
app.directive('modalDialog', function () {
    return {
        restrict: 'E',
        scope: {
            show: '='
        },
        replace: true, // Replace with the template below
        transclude: true, // we want to insert custom content inside the directive
        link: function (scope, element, attrs) {
            scope.dialogStyle = {};
            if (attrs.width)
                scope.dialogStyle.width = attrs.width;
            if (attrs.height)
                scope.dialogStyle.height = attrs.height;
            scope.hideModal = function () {
                scope.show = false;
            };
        },
        templateUrl: 'resources/views/templates/signUpLoginPopup.html',
//    template: ""
    };
});
