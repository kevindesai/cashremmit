var app = angular.module('main-App', ['ngRoute', 'angularUtils.directives.dirPagination',
    'facebook','directive.g+signin','tw-currency-select'
]);
//$location.protocol() + "://" + $location.host();
app.run(function($rootScope, $location,$route,$http,myFactory) {
    
    
    $rootScope.baseurl = $location.absUrl();
//    $rootScope.apiUrl = $rootScope.baseurl.replace("/#","");
    $rootScope.apiUrl = $rootScope.baseurl.split("#")[0];
//    if(!localStorage.getItem('user_email')){
//        $rootScope.userData = {};
//    } 
    $rootScope.RegitrationApi = $rootScope.apiUrl + 'api/v1/users';
    $rootScope.loginApi = $rootScope.apiUrl + 'api/v1/users/login';
    $rootScope.updateApi = $rootScope.apiUrl + 'api/v1/users';
    $rootScope.CurrencyApi = $rootScope.apiUrl +'api/v1/currency/convert';
    $rootScope.addBenefiery = $rootScope.apiUrl +'api/v1/recipient';
    $rootScope.getBenefiery = $rootScope.apiUrl +'api/v1/recipient';
    $rootScope.deleteBenefiery = $rootScope.apiUrl +'api/v1/recipient';
    $rootScope.getCountry = $rootScope.apiUrl+'api/v1/country';
    $rootScope.getBanks = $rootScope.apiUrl+'api/v1/banks';
    $rootScope.getbankdetail = $rootScope.apiUrl+'api/v1/bankdetail';
    $rootScope.getCountryByCurrency = $rootScope.apiUrl+'api/v1/getcountrybycurrency';
    $rootScope.gettransferrate = $rootScope.apiUrl+'api/v1/transferrate';
    $rootScope.checkPromocode = $rootScope.apiUrl+'api/v1/checkpromossion';    
    $rootScope.initpoli = $rootScope.apiUrl+'api/v1/poliinit';
    $rootScope.getTxn = $rootScope.apiUrl+'api/v1/transactions';
    $rootScope.checkToken = $rootScope.apiUrl+'api/v1/checkToken';
    $rootScope.getcurrencylist = $rootScope.apiUrl+'api/v1/getcurrencylist';
    $rootScope.getpaymentInfo = $rootScope.apiUrl+'api/v1/transactions/get';
    $rootScope.getDocumentFields = $rootScope.apiUrl+'api/v1/documentfield';
    $rootScope.verifyDriverLicence = $rootScope.apiUrl+'api/v1/verifyDriverLicence';
    $rootScope.verifyPassPort = $rootScope.apiUrl+'api/v1/verifyPassport';
    
    $rootScope.$on('$locationChangeStart', function(ev, next, current) {
    var token = localStorage.getItem("token"); 
    if(token != undefined || token != null){
        var method = 'POST';
        var url = $rootScope.checkToken;
        var UserToken = {"token":token};
        var response = myFactory.httpMethodCall(method, url, UserToken);
        response.success(function(data){
            if(data.status == -1){
                
                $rootScope.doLogout();
            }
        });
        response.error(function(data){
            $rootScope.doLogout();
        });
    }
        
        
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
                when('/selectpayment1', {
                    templateUrl: 'resources/views/templates/payment/creditCardPay.html',
                    controller: 'SelectPaymentController',
                    auth: true
                }).
                when('/polisuccess/:politoken', {
                    templateUrl: 'resources/views/templates/payment/polisuccess.html',
                    controller: 'PoliPaymentController',
                    auth: true
                }).
                when('/polifailure/:politoken', {
                    templateUrl: 'resources/views/templates/payment/polifailure.html',
                    controller: 'PoliPaymentController',
                    auth: true
                }).
                when('/policancelled/:politoken', {
                    templateUrl: 'resources/views/templates/payment/policancelled.html',
                    controller: 'PoliPaymentController',
                    auth: true
                }).
                when('/polinudge/:politoken', {
                    templateUrl: 'resources/views/templates/payment/polinudge.html',
                    controller: 'PoliPaymentController',
                    auth: true
                }).
				when('/successbutnotverified/:politoken', {
                    templateUrl: 'resources/views/templates/payment/documentverify.html',
                    controller: 'DocumentVerifyController',
                    auth: true
                }).
                otherwise({
                    redirectTo: '/'
                });
    }]);

