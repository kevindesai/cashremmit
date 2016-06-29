var app = angular.module('main-App', ['ngRoute', 'angularUtils.directives.dirPagination']);
//$location.protocol() + "://" + $location.host();
app.run(function($rootScope, $location) {
    console.log($location.absUrl());
    $rootScope.baseurl = $location.absUrl();
    $rootScope.apiUrl = $rootScope.baseurl.replace("/#","");
    console.log($rootScope.apiUrl);
    $rootScope.RegitrationApi = $rootScope.apiUrl + 'public/api/v1/users';
    $rootScope.loginApi = $rootScope.apiUrl + 'public/api/v1/users/login';
});
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
                when('/payment2', {
                    templateUrl: 'resources/views/templates/payment_transfar-2.html',
                    controller: 'PaymentController'
                }).
                when('/report', {
                    templateUrl: 'resources/views/templates/report.html',
                    controller: 'ReportController'
                }).
                when('/success', {
                    templateUrl: 'resources/views/templates/success.html',
                    controller: 'SuccessController'
                }).
                when('/transfarDetail', {
                    templateUrl: 'resources/views/templates/transfar-detail.html',
                    controller: 'TransfarDetailController'
                }).
                when('/accountSetting', {
                    templateUrl: 'resources/views/templates/account-setting.html',
                    controller: 'AccountSettingController'
                }).
                when('/beneficiaries', {
                    templateUrl: 'resources/views/templates/Beneficiaries.html',
                    controller: 'BeneficiariesController'
                }).
                otherwise({
                    redirectTo: '/'
                });
    }]);

