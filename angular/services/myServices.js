
////https://github.com/gsklee/ngStorage
//http://stackoverflow.com/questions/18247130/how-to-store-the-data-to-local-storage
//http://stackoverflow.com/questions/12940974/maintain-model-of-scope-when-changing-between-views-in-angularjs/16559855#16559855

app.factory('userService', ['$rootScope', function($rootScope) {
        var userData = {};
        userData.userInfo = {};
        /*
         * set all usrdata in localstorage and
         */
        userData.saveDataInSession = function(userInfo) {
            userData.userInfo = userInfo;
            localStorage.setItem('user_id', userData.userInfo.user_id);
            localStorage.setItem('email', userData.userInfo.email);
            localStorage.setItem('token', userData.userInfo.token);
            localStorage.setItem('first_name', userData.userInfo.first_name);
            localStorage.setItem('last_name', userData.userInfo.last_name);
            localStorage.setItem('building_name', userData.userInfo.building_name);
            localStorage.setItem('city', userData.userInfo.city);
            localStorage.setItem('country', userData.userInfo.country);
            localStorage.setItem('landline_no', userData.userInfo.landline_no);
            localStorage.setItem('mobile_no ', userData.userInfo.mobile_no);
            localStorage.setItem('post_code', userData.userInfo.post_code);
            localStorage.setItem('region', userData.userInfo.region);
            localStorage.setItem('street', userData.userInfo.street);
            localStorage.setItem('unit_no', userData.userInfo.unit_no);
//            console.log(userData.userInfo);
            return userData.userInfo;
        }
        userData.getDataFromSession = function() {
            userData.userInfo.user_id = localStorage.getItem('user_id');
            userData.userInfo.email = localStorage.getItem('email');
            userData.userInfo.token = localStorage.getItem('token');
            userData.userInfo.first_name = localStorage.getItem('first_name');
            userData.userInfo.last_name = localStorage.getItem('last_name');
            userData.userInfo.building_name = localStorage.getItem('building_name');
            userData.userInfo.city = localStorage.getItem('city');
            userData.userInfo.country = localStorage.getItem('country');
            userData.userInfo.landline_no = localStorage.getItem('landline_no');
            userData.userInfo.mobile_no = localStorage.getItem('mobile_no ');
            userData.userInfo.post_code = localStorage.getItem('post_code');
            userData.userInfo.region = localStorage.getItem('region');
            userData.userInfo.street = localStorage.getItem('street');
            userData.userInfo.unit_no = localStorage.getItem('unit_no');

            return userData.userInfo;
        }
        /** 
         * @param {type} key : key which is going to update
         * @param {type} value : value which is set to user
         * @returns {undefined} : return new updated value of that key
         */
        userData.UpdateInfo = function(key, value) { 
            localStorage.setItem(key, value);
            userData.userInfo.key = value;
            return userData.userInfo;
        }

        return userData;

    }]);

//app.factory('userService', ['$rootScope', function ($rootScope) {
//
//    var service = {
//
//        model: {
//            name: '',
//            email: ''
//        },
//
//        SaveState: function () {
//            sessionStorage.userService = angular.toJson(service.model);
//        },
//
//        RestoreState: function () {
//            service.model = angular.fromJson(sessionStorage.userService);
//        }
//    }
//
//    $rootScope.$on("savestate", service.SaveState);
//    $rootScope.$on("restorestate", service.RestoreState);
//
//    return service;
//}]);


app.factory('dataFactory', function($http) {
    var myService = {
        httpRequest: function(url, method, params, dataPost, upload) {
            var passParameters = {};
            passParameters.url = url;

            if (typeof method == 'undefined') {
                passParameters.method = 'GET';
            } else {
                passParameters.method = method;
            }

            if (typeof params != 'undefined') {
                passParameters.params = params;
            }

            if (typeof dataPost != 'undefined') {
                passParameters.data = dataPost;
            }

            if (typeof upload != 'undefined') {
                passParameters.upload = upload;
            }

            var promise = $http(passParameters).then(function(response) {
                if (typeof response.data == 'string' && response.data != 1) {
                    if (response.data.substr('loginMark')) {
                        location.reload();
                        return;
                    }
                    $.gritter.add({
                        title: 'Application',
                        text: response.data
                    });
                    return false;
                }
                if (response.data.jsMessage) {
                    $.gritter.add({
                        title: response.data.jsTitle,
                        text: response.data.jsMessage
                    });
                }
                return response.data;
            }, function() {

                $.gritter.add({
                    title: 'Application',
                    text: 'An error occured while processing your request.'
                });
            });
            return promise;
        }
    };
    return myService;
});

app.directive('validPasswordC', function() {
    return {
        require: 'ngModel',
        scope: {
            reference: '=validPasswordC'

        },
        link: function(scope, elm, attrs, ngModel) {
            ngModel.$validators.compareTo = function(modelValue) {
                return modelValue == scope.otherModelValue;
            };

            scope.$watch("reference", function() {
                ngModel.$validate();
            });
        }
    }
});

app.service('myFactory', ['$http', function($http) {

//    var urlBase = 'http://localhost:2307/Service1.svc';
        var myFactory = {};

        myFactory.httpMethodCall = function(method, url, params, header) {

            var httpData = $http({
                method: method,
                url: url,
                data: params, //forms user object
//          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
            });
            return httpData;
        };
        return myFactory;

    }]);