
////https://github.com/gsklee/ngStorage
//http://stackoverflow.com/questions/18247130/how-to-store-the-data-to-local-storage
//http://stackoverflow.com/questions/12940974/maintain-model-of-scope-when-changing-between-views-in-angularjs/16559855#16559855
app.factory('userService', ['$rootScope', function ($rootScope) {

    var service = {

        model: {
            name: '',
            email: ''
        },

        SaveState: function () {
            sessionStorage.userService = angular.toJson(service.model);
        },

        RestoreState: function () {
            service.model = angular.fromJson(sessionStorage.userService);
        }
    }

    $rootScope.$on("savestate", service.SaveState);
    $rootScope.$on("restorestate", service.RestoreState);

    return service;
}]);


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