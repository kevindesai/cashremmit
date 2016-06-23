var app = angular.module('main-App', ['ngRoute', 'angularUtils.directives.dirPagination']);

app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
                when('/', {
                    templateUrl: 'resources/views/templates/home.html',
                    controller: 'AdminController'
                }).
                when('/payment', {
                    templateUrl: 'resources/views/templates/payment_transfar.html',
                    controller: 'PaymentController'
                }).
                when('/payment1', {
                    templateUrl: 'resources/views/templates/payment_transfar-1.html',
                    controller: 'PaymentController'
                }).
                otherwise({
                    redirectTo: '/'
                });
    }]);
