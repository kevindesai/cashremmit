app.controller('AdminController', function ($scope, $http, $location, myFactory, $rootScope, Facebook, userService, countrylistService,$routeParams) {
   // $rootScope.stateIsLoading = true;
    $scope.currencyList = [];
    var currencyurl = $rootScope.getcurrencylist;
    var method = 'GET';
    var countryList = myFactory.httpMethodCall(method, currencyurl);
    countryList.success(function (data) {
        if (data.status == 1) {
            $scope.currencyList = data.data;
            console.log($scope.currencyList);

            $scope.toflag = $scope.currencyList[1].logo32;
            $scope.fromflag = $scope.currencyList[0].logo32;
            $scope.fromCur = $scope.currencyList[0].currency_code;
            $scope.toCur = $scope.currencyList[1].currency_code;
            $scope.fromAmount = 1000;
            $scope.convertCurFromto($scope.fromAmount);
        }
    });
    $scope.selectcur = function (cur, logo, direction) {
        $scope.filterfromcur="";
        $scope.filtertocur="";
        if (direction == "to") {
            $scope.toCur = cur;
            $scope.toflag = logo;
        } else {
            $scope.fromCur = cur;
            $scope.fromflag = logo;
        }
        $scope.convertCurFromto($scope.fromAmount);
        
    };

    $scope.gotopage = "";
    
    var url = $rootScope.CurrencyApi;
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
        angular.element(".loaderbox").show();
        if (fromAmount != "0") {
            $scope.gotopage = "#/payment";
        }
        var url = $rootScope.CurrencyApi;
        $scope.convertDefault(url, $scope.fromCur, $scope.toCur, 1);
        var FromconRes = myFactory.currencyConvert(url, $scope.fromCur, $scope.toCur, fromAmount);
        FromconRes.success(function (data) {
            if (data.status == 1) {
                $scope.toAmount = data.converted;
                localStorage.setItem('ToamounT', $scope.toAmount);
                angular.element(".loaderbox").hide();
                 
            } else {
                angular.element(".loaderbox").hide();
                $scope.toAmount = '';
                
            }
        });
        localStorage.setItem('FromamounT', fromAmount);
        localStorage.setItem('FromCUR', $scope.fromCur);
        localStorage.setItem('ToCUR', $scope.toCur);


    }
    
    $scope.convertCurtoFrom = function (toAmount) {
        angular.element(".loaderbox").show();
        if (toAmount != "0") {
            $scope.gotopage = "#/paymentdetails";
        }

        var url = $rootScope.CurrencyApi;
        $scope.convertDefault(url, $scope.fromCur, $scope.toCur, 1);
        var ToconRes = myFactory.currencyConvert(url, $scope.toCur, $scope.fromCur, toAmount);
        ToconRes.success(function (data) {
            if (data.status == 1) {
                $scope.fromAmount = data.converted;
                localStorage.setItem('FromamounT', $scope.fromAmount);
                angular.element(".loaderbox").hide();
            } else {
                $scope.fromAmount = '';
            }
        });
        localStorage.setItem('ToamounT', $scope.toAmount);
        localStorage.setItem('FromCUR', $scope.fromCur);
        localStorage.setItem('ToCUR', $scope.toCur);
    }
    if($routeParams.pwdresettoken !=undefined){
        $scope.resetToken = $routeParams.pwdresettoken;
        angular.element("#myModalResetPwd").modal('show');
        //console.log(resetToken);
    }
    $scope.callResetPassword = function(){
        if($scope.reset.password == $scope.reset.confpassword){
            if($scope.resetToken != undefined || $scope.resetToken !=""){
                var arr ={};
                arr.token = $scope.resetToken;
                arr.password = $scope.reset.password;
                var method = 'POST';
                var url = $rootScope.ResetPwdApi;
                var response = myFactory.httpMethodCall(method, url, arr);
                response.success(function(data){
                    if(data.status=="1"){
                        $scope.successMsg = true;
                        
                    }else{
                        $scope.somethingwentWrong= true;
                    }
                });
                response.error(function(data){
                    console.log(data);
                });
            }else{
                $scope.somethingwentWrong=true;
                return false;
            }
        }else{
            $scope.sameerrMsg = true;
            return false;
        }

    }
    $scope.closeResetModal = function(){
        angular.element('#myModalResetPwd').modal('hide');
                angular.element('body').removeClass('modal-open');
                angular.element('.modal-backdrop').remove();
                $timeout(function(){
                    angular.element('body').css('padding-right',"0px");
                },500);
    }
});

app.controller('LoginController', function ($scope, $http, $location, myFactory, $rootScope, Facebook, userService,$timeout) {
//angular.element(".loaderbox").show();
// tabular
//    $rootScope.isLogin = false;
    $scope.activeTab = 1;
    $scope.showForgot = false;
    $scope.setActiveTab = function (tabToSet) {
        $scope.activeTab = tabToSet;
    };
    $scope.formInfo = {};
    /*
     * Normal Registration
     * @returns {undefined}
     */
    $scope.registerUser = function () {
        var data = $scope.formInfo;
        data.from="register";
        //call addUser Method
        $scope.addUser(data);
    };
    /*
     * Normal Loginn
     * @returns {undefined}
     */
    $scope.loginUser = function () {
        var data = $scope.loginInfo;
        // call loginMember Method 

        $scope.loginMember(data);
    };
    /*
     * login functionality
     */
    $scope.loginMember = function (SocialUserData) {
	
        var method = 'POST';
        var url = $rootScope.loginApi;
        var from = SocialUserData.from;
        delete SocialUserData.from;
        
        $scope.invalidusername = false;
        var response = myFactory.httpMethodCall(method, url, SocialUserData);
        response.success(function (data) {

            if (data.status == 1) {

                $rootScope.userData = data.data;
                $rootScope.isLogin = true;
                userService.saveDataInSession(data.data);
                localStorage.setItem('token', data.token);
                //localStorage.getItem('token');

                angular.element('#myModal').modal('hide');
                angular.element('body').removeClass('modal-open');
                angular.element('.modal-backdrop').remove();
                angular.element('body').css('padding-right',0);
                if(from=='register'){
                    $location.path('/accountSetting');
                }else{
                    $location.path('/payment');
                }
            } else if (data.status == 0) {
                $scope.invalidusername = true;
                $scope.invalidMsg = data.message;
            }
        });
        response.error(function (error) {
            console.log(error);
        });
    }

    /*
     * New User add 
     * if user exists then it will return negative response
     */
    $scope.addUser = function (SocialUserData) {
       angular.element(".regloaderbox").show();
        $scope.registrationerrors = false;
        var method = 'POST';
        var url = $rootScope.RegitrationApi;
        var response = myFactory.httpMethodCall(method, url, SocialUserData);
        response.success(function (data) {
            angular.element(".regloaderbox").hide();
            // success callback
            if (data.status == 1) {
                 var loginData = {};
                 loginData.email = SocialUserData.email;
                 loginData.password = SocialUserData.password;
                 loginData.from='register';
                 $scope.loginMember(loginData);

            } else if (data.status == 0) {
               // console.log(data.data.email);
                $scope.registrationerrors = true;
                $scope.errormessage = data.data.email[0];
            } else if(data.status == 2){
                var loginData = {};
                loginData.email = data.data.email;
                 loginData.password = '123456';
                 loginData.from='register';
                 $scope.loginMember(loginData);
            }
        });
        response.error(function (error) {
            console.log(error);
        });
    }


    $scope.invalidUser = false;
    $scope.hideLoginBtn = false;
    $scope.hideLoginPopup = function(){
        angular.element('#myModal').modal('hide');
    }
    $scope.closeforgotModal =function(){
       
                angular.element('#myModalForgot').modal('hide');
                angular.element('body').removeClass('modal-open');
                angular.element('.modal-backdrop').remove();
                $timeout(function(){
                    angular.element('body').css('padding-right',"0px");
                },500);
                
    }
    $scope.callforgotPassword = function () {
        console.log($scope.forgot);
       
        var arr = {};
        arr.email = $scope.forgot.email;
         if ($scope.forgot.email != undefined || $scope.forgot.email != "") {
             var method = 'POST';
        var url = $rootScope.ForgotPwdApi;
        var response = myFactory.httpMethodCall(method, url, arr);
        response.success(function(data){
            if(data.status==1){
                $scope.successMsg = true;
            }else{
                $scope.errorMsg=true;
            }
        });
        response.error(function(data){
            console.log(data);
        });
        }
    }
    $scope.loginStatus = 'disconnected';
    $scope.facebookIsReady = false;
    $scope.user = null;
    $scope.fblogin = function () {

        Facebook.login(function (response) {
            $scope.loginStatus = response.status;
            if ($scope.loginStatus == "connected") {
                $scope.facebookUserData = response;
                // console.log(response);
                $scope.api();


            }
        }, {scope: 'email, public_profile', return_scopes: true});
    };

    $scope.removeAuth = function () {
        Facebook.api({
            method: 'Auth.revokeAuthorization'
        }, function (response) {
            Facebook.getLoginStatus(function (response) {
                $scope.loginStatus = response.status;
            });
        });
    };

    $scope.api = function () {
        Facebook.api('/me', {locale: 'en_US', fields: 'first_name,last_name,email,gender'}, function (response) {
            $scope.user = response;
            var FB = {};
            FB.first_name = response.first_name;
            FB.last_name = response.last_name;
            FB.email = response.email;
            FB.social_id = response.id;
            FB.from = "facebook";
            $scope.addUser(FB);
        });
    };

    $scope.$watch(function () {
        return Facebook.isReady();
    }, function (newVal) {
        if (newVal) {
            $scope.facebookIsReady = true;
        }
    });
    $scope.$on('event:google-plus-signin-success', function (event, authResult) {
        // User successfully authorized the G+ App!
       // console.log(authResult);
        $scope.userDataGoogle = authResult.w3;
        //console.log($scope.userDataGoogle);
        var GooData = {};
        GooData.first_name = $scope.userDataGoogle.ofa;
        GooData.last_name = $scope.userDataGoogle.wea;
        GooData.email = $scope.userDataGoogle.U3;
        GooData.social_id = $scope.userDataGoogle.Eea;
        GooData.from="google";
       // console.log(GooData);
//        return false;
        $scope.addUser(GooData);
    });
    $scope.$on('event:google-plus-signin-failure', function (event, authResult) {
        // User has not authorized the G+ App!
        console.log('Not signed into Google Plus.');
    });


}); 