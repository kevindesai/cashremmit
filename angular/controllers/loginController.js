

app.controller('AdminController', function($scope, $http, $location, myFactory, $rootScope,Facebook) {

    $scope.activeTab = 1;
    $scope.setActiveTab = function(tabToSet) {
        $scope.activeTab = tabToSet;
    };
    $scope.formInfo = {};
    /*
     * Normal Registration
     * @returns {undefined}
     */
    $scope.registerUser = function() {
        console.log($rootScope.RegitrationApi); 
        var data = $scope.formInfo;
        console.log($scope.formInfo);
//        return false;
         $scope.addUser(data);
    };
    /*
     * Normal Loginn
     * @returns {undefined}
     */
    $scope.loginUser = function() { 
        var data = $scope.loginInfo;
        $scope.loginMember(data); 
    };
    /*
     * if user is new then it will be called
     * Add user
     */
    $scope.loginMember = function(SocialUserData) {
        var method = 'POST';
        var url = $rootScope.loginApi;
            var response = myFactory.httpMethodCall(method, url, SocialUserData);
        response.success(function(data) {
            // success callback
            if (data.status == 1) {
                $scope.loginData = data.data;
                localStorage.setItem('user_id', $scope.loginData.user_id);
                localStorage.setItem('user_email', $scope.loginData.email);
                localStorage.setItem('user_token', $scope.loginData.token);
                localStorage.setItem('first_name', $scope.loginData.first_name);
                localStorage.setItem('last_name', $scope.loginData.last_name); 
                console.log($scope.loginData);
                $location.path('/payment');
            } else {
                console.log("else");
                console.log(data);
            }
        });
        response.error(function(error) {
            console.log(error);
        });
    }
    
    /*
     * login user
     * if user exists then it will call
     */
    $scope.addUser = function(SocialUserData) {
        var method = 'POST';
        var url = $rootScope.RegitrationApi;
        var response = myFactory.httpMethodCall(method, url, SocialUserData);
        response.success(function(data) {
            // success callback
            if (data.status == 1) {
                $scope.loginData = data.data;
                    localStorage.setItem('user_id', $scope.loginData.user_id);
                localStorage.setItem('user_email', $scope.loginData.email);
                localStorage.setItem('user_token', $scope.loginData.token);
                localStorage.setItem('first_name', $scope.loginData.first_name);
                localStorage.setItem('last_name', $scope.loginData.last_name); 
                console.log($scope.loginData);
                $location.path('/payment');
            } else {
                console.log("else");
                console.log(data);
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
        GooData.gmail_token_id = $scope.userDataGoogle.Ka   ;
        console.log(GooData);
//        return false;
        $scope.addUser(GooData);
    });
    $scope.$on('event:google-plus-signin-failure', function(event, authResult) {
        // User has not authorized the G+ App!
        console.log('Not signed into Google Plus.');
    });
     
    

}); 