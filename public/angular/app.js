var app = angular.module('homeModule', ['ngRoute']);
//.constant('API_URL', 'http://localhost/angulara/publc/api/v1/');

app.config(['$routeProvider', function ($routeProvider) {
        console.log('tetst');
        $routeProvider.
                when('/', {
                    'templateUrl': '/modules/home/home.html',
                    'controller': 'HomeController'
                })

    }]);

        