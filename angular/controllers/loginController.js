app.controller('AdminController', function ($scope, $http, $location, myFactory, $rootScope, Facebook, userService, countrylistService) {
    $scope.currencyList = [];
    var currencyurl = $rootScope.getcurrencylist;
    var method = 'GET';
    var countryList = myFactory.httpMethodCall(method, currencyurl);
    countryList.success(function (data) {
        if (data.status == 1) {
            $scope.currencyList = data.data;
            console.log($scope.currencyList);
            var toindex = $scope.currencyList.map(function (obj) {
                return obj.currency_code;
            }).indexOf('NGN');
            var fromindex = $scope.currencyList.map(function (obj) {
                return obj.currency_code;
            }).indexOf('AUD');
            $scope.toflag = $scope.currencyList[toindex].logo32;
            $scope.fromflag = $scope.currencyList[fromindex].logo32;
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
    $scope.fromCur = 'AUD';
    $scope.toCur = 'NGN';
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
            $scope.gotopage = "#/paymentdetails";
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
                $scope.toAmount = '';
            }
        });
        localStorage.setItem('FromamounT', fromAmount);
        localStorage.setItem('FromCUR', $scope.fromCur);
        localStorage.setItem('ToCUR', $scope.toCur);


    }
    $scope.fromAmount = 1000;
    $scope.convertCurFromto($scope.fromAmount);
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
});

app.controller('LoginController', function ($scope, $http, $location, myFactory, $rootScope, Facebook, userService) {

// tabular
//    $rootScope.isLogin = false;
    $scope.activeTab = 1;
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
                $location.path('/payment');
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
       
        $scope.registrationerrors = false;
        var method = 'POST';
        var url = $rootScope.RegitrationApi;
        var response = myFactory.httpMethodCall(method, url, SocialUserData);
        response.success(function (data) {
            // success callback
            if (data.status == 1) {
//                console.log("Register");
//                console.log(data);
//                console.log("/Register");
//                $rootScope.userData = data.data;
//                userService.saveDataInSession(data.data);
                 //  $scope.suceessregister = true;
                 var loginData = {};
                 loginData.email = SocialUserData.email;
                 loginData.password = SocialUserData.password;
                 $scope.loginMember(loginData);
//                angular.element('#myModal').modal('hide');
//                angular.element('body').removeClass('modal-open');
//                angular.element('.modal-backdrop').remove();
//                
//                
//                $location.path('/payment');
            } else if (data.status == 0) {
                console.log(data.data.email);
                $scope.registrationerrors = true;
                $scope.errormessage = data.data.email[0];
            }
        });
        response.error(function (error) {
            console.log(error);
        });
    }


    $scope.invalidUser = false;
    $scope.hideLoginBtn = false;

    $scope.callforgotPassword = function () {
        //console.log($scope.forgot);
        var arr = {};
        arr.email = $scope.forgot.email;
        arr.birthday = $scope.forgot.bmonth + '/' + $scope.forgot.bday + '/' + $scope.forgot.byear;
        if ($scope.forgot.email != undefined && $scope.forgot.bday != undefined && $scope.forgot.bmonth != undefined && $scope.forgot.byear != undefined) {
            $http({
                method: 'POST',
                url: constant.callforgotPassword,
                data: JSON.stringify(arr),
            }).then(function (response) {
                if (response.status == 200) {
                    $scope.responsemessage = response.data.message;
                }
            }, function errorCallback(response) {
                //console.log(response);
                if (response.status == 401) {
                    $scope.invalidbDate = true;
                    $scope.responsemessage = response.data.message;
                    $scope.$apply;
                }
                if (response.status == 404) {
                    $scope.invalidemail = true;
                    $scope.responsemessage = response.data.message;
                    $scope.$apply;
                }
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
            FB.firstName = response.first_name;
            FB.lastName = response.last_name;
            FB.emailAddress = response.email;
            FB.id = response.id;
            $scope.LoginSocialUsers(FB);
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
        $scope.userDataGoogle = authResult.wc;
        console.log($scope.userDataGoogle);
        var GooData = {};
        GooData.first_name = $scope.userDataGoogle.Za;
        GooData.last_name = $scope.userDataGoogle.Na;
        GooData.email = $scope.userDataGoogle.hg;
        GooData.gmail_token_id = $scope.userDataGoogle.Ka;
        console.log(GooData);
//        return false;
        $scope.addUser(GooData);
    });
    $scope.$on('event:google-plus-signin-failure', function (event, authResult) {
        // User has not authorized the G+ App!
        console.log('Not signed into Google Plus.');
    });


}); 