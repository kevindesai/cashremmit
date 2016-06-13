var app =  angular.module('main-App',['ngRoute','angularUtils.directives.dirPagination']);

app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/', {
                templateUrl: '../resources/views/templates/home.html',
                controller: 'AdminController'
            }).
            when('/items', {
                templateUrl: '../resources/views/templates/items.html',
                controller: 'ItemController'
            });
}]);