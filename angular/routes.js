var app = angular.module('main-App', ['ngRoute', 'angularUtils.directives.dirPagination',
    'facebook','directive.g+signin'
]);
//$location.protocol() + "://" + $location.host();
app.run(function($rootScope, $location,$route) { 
    $rootScope.baseurl = $location.absUrl();
//    $rootScope.apiUrl = $rootScope.baseurl.replace("/#","");
    $rootScope.apiUrl = $rootScope.baseurl.split("#")[0];
//    if(!localStorage.getItem('user_email')){
//        $rootScope.userData = {};
//    } 
    $rootScope.RegitrationApi = $rootScope.apiUrl + 'public/api/v1/users';
    $rootScope.loginApi = $rootScope.apiUrl + 'public/api/v1/users/login';
    $rootScope.updateApi = $rootScope.apiUrl + 'public/api/v1/users';
    $rootScope.CurrencyApi = $rootScope.apiUrl +'public/api/v1/currency/convert';
    $rootScope.addBenefiery = $rootScope.apiUrl +'public/api/v1/recipient';
    $rootScope.getBenefiery = $rootScope.apiUrl +'public/api/v1/recipient';
    $rootScope.deleteBenefiery = $rootScope.apiUrl +'public/api/v1/recipient';
    $rootScope.getCountry = $rootScope.apiUrl+'api/v1/country';
    $rootScope.getBanks = $rootScope.apiUrl+'api/v1/banks';
    $rootScope.getbankdetail = $rootScope.apiUrl+'api/v1/bankdetail';
    $rootScope.getCountryByCurrency = $rootScope.apiUrl+'api/v1/getcountrybycurrency'
    $rootScope.gettransferrate = $rootScope.apiUrl+'api/v1/transferrate'
    
    $rootScope.$on('$locationChangeStart', function(ev, next, current) {
    var nextPath = $location.path(),
      nextRoute = $route.routes[nextPath];
    //$log.info(nextRoute);
    if (nextRoute && nextRoute.auth && localStorage.getItem("id") == null) {
      $location.path("/");
    }
  });
});

app.config(function(FacebookProvider){//205637772980180
        FacebookProvider.init('1022256307853175');
    });
app.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
                when('/', {
                    templateUrl: 'resources/views/templates/home.html',
                    controller: 'AdminController',
                    auth: false
                    
                }).
                when('/payment', {
                    templateUrl: 'resources/views/templates/payment/payment_transfar.html',
                    controller: 'PaymentController',
                    auth: false
                }).
                when('/payment2', {
                    templateUrl: 'resources/views/templates/payment/payment_transfar-1.html',
                    controller: 'PaymentController',
                    auth: false
                }).
                when('/paymentdetails', {
                    templateUrl: 'resources/views/templates/payment/payment_transfar-2.html',
                    controller: 'PaymentDetailsController',
                    auth: false
                }).
                when('/paybeneficiary', {
                    templateUrl: 'resources/views/templates/report.html',
                    controller: 'ReportController',
                    auth: true
                }).
                when('/success', {
                    templateUrl: 'resources/views/templates/success.html',
                    controller: 'SuccessController',
                    auth: true
                    
                }).
                when('/transfarDetail', {
                    templateUrl: 'resources/views/templates/transfar-detail.html',
                    controller: 'TransfarDetailController',
                    auth: true
                }).
                when('/accountSetting', {
                    templateUrl: 'resources/views/templates/account-setting/account-setting.html',
                    controller: 'AccountSettingController',
                    auth: true
                }).
                when('/beneficiaries', {
                    templateUrl: 'resources/views/templates/Beneficiaries.html',
                    controller: 'BeneficiariesController',
                    auth: true
                }).
                when('/selectpayment', {
                    templateUrl: 'resources/views/templates/payment/choosePayment.html',
                    controller: 'SelectPaymentController',
                    auth: true
                }).
                otherwise({
                    redirectTo: '/'
                });
    }]);

