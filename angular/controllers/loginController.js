

app.controller('AdminController', function($scope, $http, $location, myFactory, $rootScope, Facebook, userService) {
    // tabular
    $rootScope.isLogin=false;
    $scope.activeTab = 1;
    $scope.setActiveTab = function(tabToSet) {
        $scope.activeTab = tabToSet;
    };
    $scope.gotopage = "";
    $scope.fromCur='AUD';
    $scope.toCur='NGN';
    
    $scope.DefaultfromAmount = 1;
    localStorage.setItem('FromamounT',$scope.DefaultfromAmount);
    localStorage.setItem('FromCUR',$scope.fromCur);
    localStorage.setItem('ToCUR',$scope.toCur);
    var method = 'POST';
        var url = $rootScope.CurrencyApi;
    var curData = {};
        curData.amount = $scope.DefaultfromAmount;
        curData.from = $scope.fromCur;
        curData.to = $scope.toCur;
        var response = myFactory.httpMethodCall(method, url, curData);
        response.success(function(data) {
            if (data.status == 1) {
                $scope.toAmount = data.converted;
                $scope.DefaulttoAmount = data.converted;
                localStorage.setItem('ToamounT',data.converted);
            } else if(data.status==0) {
                
            }
        });
        response.error(function(error) {
            console.log(error);
        });
    
    $scope.convertCurFromto = function(){
        if($scope.fromAmount != "0"){
            $scope.gotopage = "#/paymentdetails";
        }
        var method = 'POST';
        var url = $rootScope.CurrencyApi;
        var curData = {};
        curData.amount = $scope.fromAmount;
        curData.from = $scope.fromCur;
        curData.to = $scope.toCur;
        localStorage.setItem('FromamounT',$scope.fromAmount);
    localStorage.setItem('FromCUR',$scope.fromCur);
    localStorage.setItem('ToCUR',$scope.toCur);
        var response = myFactory.httpMethodCall(method, url, curData);
        response.success(function(data) {
            if (data.status == 1) {
                $scope.toAmount = data.converted;
                 localStorage.setItem('ToamounT',data.converted);
            } else if(data.status==0) {
                
            }
        });
        response.error(function(error) {
            console.log(error);
        });
    }
    $scope.convertCurtoFrom = function(){
        if($scope.fromAmount != "0"){
            $scope.gotopage = "#/paymentdetails";
        }
        var method = 'POST';
        var url = $rootScope.CurrencyApi;
        var curData = {};
        curData.amount = $scope.toAmount;
        curData.from = $scope.toCur;
        curData.to = $scope.fromCur;
        
    localStorage.setItem('FromCUR',$scope.fromCur);
    localStorage.setItem('ToCUR',$scope.toCur);
    localStorage.setItem('ToamounT',$scope.toAmount);
        var response = myFactory.httpMethodCall(method, url, curData);
        response.success(function(data) {
            if (data.status == 1) {
                $scope.fromAmount = data.converted;
                localStorage.setItem('FromamounT',$scope.fromAmount);
            } else if(data.status==0) {
                
            }
        });
        response.error(function(error) {
            console.log(error);
        });
    }
    

    $scope.formInfo = {};
    /*
     * Normal Registration
     * @returns {undefined}
     */
    $scope.registerUser = function() {
        var data = $scope.formInfo;  
         
        //call addUser Method
        $scope.addUser(data);
    };
    /*
     * Normal Loginn
     * @returns {undefined}
     */
    $scope.loginUser = function() {
        var data = $scope.loginInfo;
        // call loginMember Method 
        
        $scope.loginMember(data);
    };
    /*
     * login functionality
     */
    $scope.loginMember = function(SocialUserData) {
        var method = 'POST';
        var url = $rootScope.loginApi;
         $scope.invalidusername=false;
        var response = myFactory.httpMethodCall(method, url, SocialUserData);
        response.success(function(data) {
            
            if (data.status == 1) {
                
                $rootScope.userData = data.data;
                $rootScope.isLogin=true;
                userService.saveDataInSession(data.data);
                localStorage.setItem('token',data.token);
                //localStorage.getItem('token');
               
                $('#myModal').modal('hide');
                $location.path('/payment');
            } else if(data.status==0) {
                $scope.invalidusername=true;
            }
        });
        response.error(function(error) {
            console.log(error);
        });
    }

    /*
     * New User add 
     * if user exists then it will return negative response
     */
    $scope.addUser = function(SocialUserData) {
        $scope.registrationerrors=false;
        var method = 'POST';
        var url = $rootScope.RegitrationApi;
        var response = myFactory.httpMethodCall(method, url, SocialUserData);
        response.success(function(data) {
            // success callback
            if (data.status == 1) {
                $rootScope.userData = data.data;
                userService.saveDataInSession(data.data);
                $('#myModal').modal('hide');
                $location.path('/payment');
            } else if(data.status==0) {
                console.log(data.data.email);
                $scope.registrationerrors=true;
                $scope.errormessage=data.data.email[0];
            }
        });
        response.error(function(error) {
            console.log(error);
        });
    }


    $scope.invalidUser = false;
    $scope.hideLoginBtn = false;

    $scope.callforgotPassword = function() {
        //console.log($scope.forgot);
        var arr = {};
        arr.email = $scope.forgot.email;
        arr.birthday = $scope.forgot.bmonth + '/' + $scope.forgot.bday + '/' + $scope.forgot.byear;
        if ($scope.forgot.email != undefined && $scope.forgot.bday != undefined && $scope.forgot.bmonth != undefined && $scope.forgot.byear != undefined) {
            $http({
                method: 'POST',
                url: constant.callforgotPassword,
                data: JSON.stringify(arr),
            }).then(function(response) {
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
    $scope.fblogin = function() {

        Facebook.login(function(response) {
            $scope.loginStatus = response.status;
            if ($scope.loginStatus == "connected") {
                $scope.facebookUserData = response;
                // console.log(response);
                $scope.api();


            }
        }, {scope: 'email, public_profile', return_scopes: true});
    };

    $scope.removeAuth = function() {
        Facebook.api({
            method: 'Auth.revokeAuthorization'
        }, function(response) {
            Facebook.getLoginStatus(function(response) {
                $scope.loginStatus = response.status;
            });
        });
    };

    $scope.api = function() {
        Facebook.api('/me', {locale: 'en_US', fields: 'first_name,last_name,email,gender'}, function(response) {
            $scope.user = response;
            var FB = {};
            FB.firstName = response.first_name;
            FB.lastName = response.last_name;
            FB.emailAddress = response.email;
            FB.id = response.id;
            $scope.LoginSocialUsers(FB);
        });
    };

    $scope.$watch(function() {
        return Facebook.isReady();
    }, function(newVal) {
        if (newVal) {
            $scope.facebookIsReady = true;
        }
    });
    $scope.$on('event:google-plus-signin-success', function(event, authResult) {
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
    $scope.$on('event:google-plus-signin-failure', function(event, authResult) {
        // User has not authorized the G+ App!
        console.log('Not signed into Google Plus.');
    });


}); 