

app.controller('AdminController', function ($scope, $http, $location, myFactory, $rootScope, Facebook, userService,countrylistService) {
//    $scope.countryList={};
//    var countryList = countrylistService;
//    countryList.success(function(data){
//        if(data.status==1){
//            var countryList = data.data;
//        }
//        var tmpcountry =[];
//        angular.forEach(countryList,function(value,key){
//            var obj ={};
//            obj.code = value.currency_code;
//            obj.name = value.currency_name;
//            //obj.currency_flag = value.logo16;
//            
//            tmpcountry.push(obj);
//        },tmpcountry);
//        $scope.currenciesWithNames = tmpcountry;
//        console.log($scope.currenciesWithNames);
//    });
    
    //demo code
    $scope.currencyChangeCount = 0;
            $scope.currencyCodeChangeCount = 0;

            $scope.currencies = [
                {code: 'EUR', symbol: '€'},
                {code: 'USD', symbol: '$'},
                {code: 'GBP', symbol: '£'}
            ];

            $scope.currenciesWithNames = [{
        "name": "Dirham",
        "code": "AED"
    }, {
        "name": "Afghani",
        "code": "AFN"
    }, {
        "name": "Lek",
        "code": "ALL"
    }, {
        "name": "Dram",
        "code": "AMD"
    }, {
        "name": "Netherlands Antilles Guilder",
        "code": "ANG"
    }, {
        "name": "Angolan kwanza",
        "code": "AOA"
    }, {
        "name": "Antarctican dollar",
        "code": "AQD"
    }, {
        "name": "Peso",
        "code": "ARS"
    }, {
        "name": "Australian Dollars",
        "code": "AUD"
    }, {
        "name": "Manat",
        "code": "AZN"
    }, {
        "name": "Bosnia and Herzegovina convertible mark",
        "code": "BAM"
    }, {
        "name": "Barbadian Dollar",
        "code": "BBD"
    }, {
        "name": "Taka",
        "code": "BDT"
    }, {
        "name": "Lev",
        "code": "BGN"
    }, {
        "name": "Bahraini Dinar",
        "code": "BHD"
    }, {
        "name": "Burundi Franc",
        "code": "BIF"
    }, {
        "name": "Bermudian Dollar",
        "code": "BMD"
    }, {
        "name": "Bruneian Dollar",
        "code": "BND"
    }, {
        "name": "Boliviano",
        "code": "BOB"
    }, {
        "name": "Brazil",
        "code": "BRL"
    }, {
        "name": "Bahamian Dollar",
        "code": "BSD"
    }, {
        "name": "Pula",
        "code": "BWP"
    }, {
        "name": "Belarus Ruble",
        "code": "BYR"
    }, {
        "name": "Belizean Dollar",
        "code": "BZD"
    }, {
        "name": "Canadian Dollar",
        "code": "CAD"
    }, {
        "name": "Congolese Frank",
        "code": "CDF"
    }, {
        "name": "Swiss Franc",
        "code": "CHF"
    }, {
        "name": "Chilean Peso",
        "code": "CLP"
    }, {
        "name": "Yuan Renminbi",
        "code": "CNY"
    }, {
        "name": "Peso",
        "code": "COP"
    }, {
        "name": "Costa Rican Colon",
        "code": "CRC"
    }, {
        "name": "Cuban Peso",
        "code": "CUP"
    }, {
        "name": "Escudo",
        "code": "CVE"
    }, {
        "name": "Cypriot Pound",
        "code": "CYP"
    }, {
        "name": "Koruna",
        "code": "CZK"
    }, {
        "name": "Djiboutian Franc",
        "code": "DJF"
    }, {
        "name": "Danish Krone",
        "code": "DKK"
    }, {
        "name": "Dominican Peso",
        "code": "DOP"
    }, {
        "name": "Algerian Dinar",
        "code": "DZD"
    }, {
        "name": "Sucre",
        "code": "ECS"
    }, {
        "name": "Estonian Kroon",
        "code": "EEK"
    }, {
        "name": "Egyptian Pound",
        "code": "EGP"
    }, {
        "name": "Ethiopian Birr",
        "code": "ETB"
    }, {
        "name": "Euros",
        "code": "EUR"
    }, {
        "name": "Fijian Dollar",
        "code": "FJD"
    }, {
        "name": "Falkland Pound",
        "code": "FKP"
    }, {
        "name": "Sterling",
        "code": "GBP"
    }, {
        "name": "Lari",
        "code": "GEL"
    }, {
        "name": "Guernsey pound",
        "code": "GGP"
    }, {
        "name": "Ghana cedi",
        "code": "GHS"
    }, {
        "name": "Gibraltar Pound",
        "code": "GIP"
    }, {
        "name": "Dalasi",
        "code": "GMD"
    }, {
        "name": "Guinean Franc",
        "code": "GNF"
    }, {
        "name": "Quetzal",
        "code": "GTQ"
    }, {
        "name": "Guyanaese Dollar",
        "code": "GYD"
    }, {
        "name": "HKD",
        "code": "HKD"
    }, {
        "name": "Lempira",
        "code": "HNL"
    }, {
        "name": "Croatian Dinar",
        "code": "HRK"
    }, {
        "name": "Gourde",
        "code": "HTG"
    }, {
        "name": "Forint",
        "code": "HUF"
    }, {
        "name": "Indonesian Rupiah",
        "code": "IDR"
    }, {
        "name": "Shekel",
        "code": "ILS"
    }, {
        "name": "Indian Rupee",
        "code": "INR"
    }, {
        "name": "Iraqi Dinar",
        "code": "IQD"
    }, {
        "name": "Iranian Rial",
        "code": "IRR"
    }, {
        "name": "Icelandic Krona",
        "code": "ISK"
    }, {
        "name": "Jamaican Dollar",
        "code": "JMD"
    }, {
        "name": "Jordanian Dinar",
        "code": "JOD"
    }, {
        "name": "Japanese Yen",
        "code": "JPY"
    }, {
        "name": "Kenyan Shilling",
        "code": "KES"
    }, {
        "name": "Som",
        "code": "KGS"
    }, {
        "name": "Riel",
        "code": "KHR"
    }, {
        "name": "Comoran Franc",
        "code": "KMF"
    }, {
        "name": "Won",
        "code": "KPW"
    }, {
        "name": "Won",
        "code": "KRW"
    }, {
        "name": "Kuwaiti Dinar",
        "code": "KWD"
    }, {
        "name": "Caymanian Dollar",
        "code": "KYD"
    }, {
        "name": "Tenge",
        "code": "KZT"
    }, {
        "name": "Kip",
        "code": "LAK"
    }, {
        "name": "Lebanese Pound",
        "code": "LBP"
    }, {
        "name": "Rupee",
        "code": "LKR"
    }, {
        "name": "Liberian Dollar",
        "code": "LRD"
    }, {
        "name": "Loti",
        "code": "LSL"
    }, {
        "name": "Lita",
        "code": "LTL"
    }, {
        "name": "Lat",
        "code": "LVL"
    }, {
        "name": "Libyan Dinar",
        "code": "LYD"
    }, {
        "name": "Dirham",
        "code": "MAD"
    }, {
        "name": "Leu",
        "code": "MDL"
    }, {
        "name": "Malagasy Franc",
        "code": "MGA"
    }, {
        "name": "Denar",
        "code": "MKD"
    }, {
        "name": "Kyat",
        "code": "MMK"
    }, {
        "name": "Tugrik",
        "code": "MNT"
    }, {
        "name": "Pataca",
        "code": "MOP"
    }, {
        "name": "Ouguiya",
        "code": "MRO"
    }, {
        "name": "Maltese Lira",
        "code": "MTL"
    }, {
        "name": "Mauritian Rupee",
        "code": "MUR"
    }, {
        "name": "Rufiyaa",
        "code": "MVR"
    }, {
        "name": "Malawian Kwacha",
        "code": "MWK"
    }, {
        "name": "Peso",
        "code": "MXN"
    }, {
        "name": "Ringgit",
        "code": "MYR"
    }, {
        "name": "Metical",
        "code": "MZN"
    }, {
        "name": "Dollar",
        "code": "NAD"
    }, {
        "name": "Naira",
        "code": "NGN"
    }, {
        "name": "Cordoba Oro",
        "code": "NIO"
    }, {
        "name": "Norwegian Krone",
        "code": "NOK"
    }, {
        "name": "Nepalese Rupee",
        "code": "NPR"
    }, {
        "name": "New Zealand Dollars",
        "code": "NZD"
    }, {
        "name": "Sul Rial",
        "code": "OMR"
    }, {
        "name": "Balboa",
        "code": "PAB"
    }, {
        "name": "Nuevo Sol",
        "code": "PEN"
    }, {
        "name": "Kina",
        "code": "PGK"
    }, {
        "name": "Peso",
        "code": "PHP"
    }, {
        "name": "Rupee",
        "code": "PKR"
    }, {
        "name": "Zloty",
        "code": "PLN"
    }, {
        "name": "Guarani",
        "code": "PYG"
    }, {
        "name": "Rial",
        "code": "QAR"
    }, {
        "name": "Leu",
        "code": "RON"
    }, {
        "name": "Serbian dinar",
        "code": "RSD"
    }, {
        "name": "Ruble",
        "code": "RUB"
    }, {
        "name": "Rwanda Franc",
        "code": "RWF"
    }, {
        "name": "Riyal",
        "code": "SAR"
    }, {
        "name": "Solomon Islands Dollar",
        "code": "SBD"
    }, {
        "name": "Rupee",
        "code": "SCR"
    }, {
        "name": "Dinar",
        "code": "SDG"
    }, {
        "name": "Krona",
        "code": "SEK"
    }, {
        "name": "Dollar",
        "code": "SGD"
    }, {
        "name": "Koruna",
        "code": "SKK"
    }, {
        "name": "Leone",
        "code": "SLL"
    }, {
        "name": "Shilling",
        "code": "SOS"
    }, {
        "name": "Surinamese Guilder",
        "code": "SRD"
    }, {
        "name": "Dobra",
        "code": "STD"
    }, {
        "name": "Salvadoran Colon",
        "code": "SVC"
    }, {
        "name": "Syrian Pound",
        "code": "SYP"
    }, {
        "name": "Lilangeni",
        "code": "SZL"
    }, {
        "name": "Baht",
        "code": "THB"
    }, {
        "name": "Tajikistan Ruble",
        "code": "TJS"
    }, {
        "name": "Manat",
        "code": "TMT"
    }, {
        "name": "Tunisian Dinar",
        "code": "TND"
    }, {
        "name": "Pa\u00d5anga",
        "code": "TOP"
    }, {
        "name": "Lira",
        "code": "TRY"
    }, {
        "name": "Trinidad and Tobago Dollar",
        "code": "TTD"
    }, {
        "name": "Dollar",
        "code": "TWD"
    }, {
        "name": "Shilling",
        "code": "TZS"
    }, {
        "name": "Hryvnia",
        "code": "UAH"
    }, {
        "name": "Shilling",
        "code": "UGX"
    }, {
        "name": "USD",
        "code": "USD"
    }, {
        "name": "Peso",
        "code": "UYU"
    }, {
        "name": "Som",
        "code": "UZS"
    }, {
        "name": "Bolivar",
        "code": "VEF"
    }, {
        "name": "Dong",
        "code": "VND"
    }, {
        "name": "Vatu",
        "code": "VUV"
    }, {
        "name": "CFA Franc BEAC",
        "code": "XAF"
    }, {
        "name": "East Caribbean Dollar",
        "code": "XCD"
    }, {
        "name": "CFA Franc BCEAO",
        "code": "XOF"
    }, {
        "name": "CFP Franc",
        "code": "XPF"
    }, {
        "name": "Rial",
        "code": "YER"
    }, {
        "name": "Rand",
        "code": "ZAR"
    }, {
        "name": "Kwacha",
        "code": "ZMK"
    }, {
        "name": "Zimbabwe Dollar",
        "code": "ZWD"
    }]

    $scope.selectedCurrency9 = {code: 'GBP', symbol: '£'};
     $scope.currencyCodes = [
                'EUR', 'AUD', 'BGN', 'BRL', 'CAD', 'CHF', 'CNY', 'CZK', 'DKK', 'GBP', 'GEL', 'HKD', 'HUF', 'INR', 'MYR',
                'MXN', 'NOK', 'NZD', 'PLN', 'RON', 'SEK', 'SGD', 'THB', 'NGN', 'PKR', 'TRY', 'USD',
                'ZAR', 'JPY', 'PHP', 'MAD', 'COP', 'AED', 'IDR', 'CLP', 'UAH', 'RUB', 'KRW', 'LKR'
            ];

            $scope.someCurrencyCodes = ['EUR', 'AUD', 'BGN', 'BRL'];

            $scope.codeMapper = function(code) {
                return {code: code};
            };

            $scope.codeExtractor = function(currency) {
                return currency.code;
            };

            $scope.changedHandler = function() {
                $scope.currencyChangeCount += 1;
            };

            $scope.changedCodeHandler = function() {
                $scope.currencyCodeChangeCount += 1;
            };

            $scope.otherClicked = function() {
                window.alert("Other clicked");
            };
    
    // demo code over
    
    
    $scope.gotopage = "";
    $scope.fromCur = 'AUD';
    $scope.toCur = 'NGN';
    var url = $rootScope.CurrencyApi;
    $scope.convertDefault = function (url, fromCur, ToCur, defaultfromamount) {
        $scope.DefaultfromAmount = defaultfromamount;
        var DefalutconRes = myFactory.currencyConvert(url, fromCur, ToCur, defaultfromamount);
        DefalutconRes.success(function (data) {
            if (data.status == 1) {
                $scope.DefaulttoAmount = data.converted;
            } else {
                $scope.DefaulttoAmount = '';
            }
        });
    }
    $scope.convertCurFromto = function (fromAmount) {
        
        if (fromAmount != "0") {
            $scope.gotopage = "#/paymentdetails";
        }
        var url = $rootScope.CurrencyApi;
        $scope.convertDefault(url, $scope.fromCur, $scope.toCur, 1);
        var FromconRes = myFactory.currencyConvert(url, $scope.fromCur, $scope.toCur, fromAmount);
        FromconRes.success(function (data) {
            if (data.status == 1) {
                $scope.toAmount = data.converted;
                localStorage.setItem('ToamounT', $scope.toAmount);
            } else {
                $scope.toAmount = '';
            }
        });
        localStorage.setItem('FromamounT', fromAmount);
        localStorage.setItem('FromCUR', $scope.fromCur);
        localStorage.setItem('ToCUR', $scope.toCur);


    }
    $scope.fromAmount = 1000;
    $scope.convertCurFromto($scope.fromAmount);
    $scope.convertCurtoFrom = function (toAmount) {
        if (toAmount != "0") {
            $scope.gotopage = "#/paymentdetails";
        }

        var url = $rootScope.CurrencyApi;
        $scope.convertDefault(url, $scope.fromCur, $scope.toCur, 1);
        var ToconRes = myFactory.currencyConvert(url, $scope.toCur, $scope.fromCur,toAmount);
        ToconRes.success(function (data) {
            if (data.status == 1) {
                $scope.fromAmount = data.converted;
                localStorage.setItem('FromamounT', $scope.fromAmount);
            } else {
                $scope.fromAmount = '';
            }
        });
        localStorage.setItem('ToamounT', $scope.toAmount);
        localStorage.setItem('FromCUR', $scope.fromCur);
        localStorage.setItem('ToCUR', $scope.toCur);
    }
});

app.controller('LoginController', function ($scope, $http, $location, myFactory, $rootScope, Facebook, userService) {

// tabular
//    $rootScope.isLogin = false;
    $scope.activeTab = 1;
    $scope.setActiveTab = function (tabToSet) {
        $scope.activeTab = tabToSet;
    };
    $scope.formInfo = {};
    /*
     * Normal Registration
     * @returns {undefined}
     */
    $scope.registerUser = function () {
        var data = $scope.formInfo;

        //call addUser Method
        $scope.addUser(data);
    };
    /*
     * Normal Loginn
     * @returns {undefined}
     */
    $scope.loginUser = function () {
        var data = $scope.loginInfo;
        // call loginMember Method 

        $scope.loginMember(data);
    };
    /*
     * login functionality
     */
    $scope.loginMember = function (SocialUserData) {
        var method = 'POST';
        var url = $rootScope.loginApi;
        $scope.invalidusername = false;
        var response = myFactory.httpMethodCall(method, url, SocialUserData);
        response.success(function (data) {

            if (data.status == 1) {

                $rootScope.userData = data.data;
                $rootScope.isLogin = true;
                userService.saveDataInSession(data.data);
                localStorage.setItem('token', data.token);
                //localStorage.getItem('token');

                $('#myModal').modal('hide');
                $location.path('/payment');
            } else if (data.status == 0) {
                $scope.invalidusername = true;
            }
        });
        response.error(function (error) {
            console.log(error);
        });
    }

    /*
     * New User add 
     * if user exists then it will return negative response
     */
    $scope.addUser = function (SocialUserData) {
        $scope.registrationerrors = false;
        var method = 'POST';
        var url = $rootScope.RegitrationApi;
        var response = myFactory.httpMethodCall(method, url, SocialUserData);
        response.success(function (data) {
            // success callback
            if (data.status == 1) {
                $rootScope.userData = data.data;
                userService.saveDataInSession(data.data);
                $('#myModal').modal('hide');
                $location.path('/payment');
            } else if (data.status == 0) {
                console.log(data.data.email);
                $scope.registrationerrors = true;
                $scope.errormessage = data.data.email[0];
            }
        });
        response.error(function (error) {
            console.log(error);
        });
    }


    $scope.invalidUser = false;
    $scope.hideLoginBtn = false;

    $scope.callforgotPassword = function () {
        //console.log($scope.forgot);
        var arr = {};
        arr.email = $scope.forgot.email;
        arr.birthday = $scope.forgot.bmonth + '/' + $scope.forgot.bday + '/' + $scope.forgot.byear;
        if ($scope.forgot.email != undefined && $scope.forgot.bday != undefined && $scope.forgot.bmonth != undefined && $scope.forgot.byear != undefined) {
            $http({
                method: 'POST',
                url: constant.callforgotPassword,
                data: JSON.stringify(arr),
            }).then(function (response) {
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
    $scope.fblogin = function () {

        Facebook.login(function (response) {
            $scope.loginStatus = response.status;
            if ($scope.loginStatus == "connected") {
                $scope.facebookUserData = response;
                // console.log(response);
                $scope.api();


            }
        }, {scope: 'email, public_profile', return_scopes: true});
    };

    $scope.removeAuth = function () {
        Facebook.api({
            method: 'Auth.revokeAuthorization'
        }, function (response) {
            Facebook.getLoginStatus(function (response) {
                $scope.loginStatus = response.status;
            });
        });
    };

    $scope.api = function () {
        Facebook.api('/me', {locale: 'en_US', fields: 'first_name,last_name,email,gender'}, function (response) {
            $scope.user = response;
            var FB = {};
            FB.firstName = response.first_name;
            FB.lastName = response.last_name;
            FB.emailAddress = response.email;
            FB.id = response.id;
            $scope.LoginSocialUsers(FB);
        });
    };

    $scope.$watch(function () {
        return Facebook.isReady();
    }, function (newVal) {
        if (newVal) {
            $scope.facebookIsReady = true;
        }
    });
    $scope.$on('event:google-plus-signin-success', function (event, authResult) {
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
    $scope.$on('event:google-plus-signin-failure', function (event, authResult) {
        // User has not authorized the G+ App!
        console.log('Not signed into Google Plus.');
    });


}); 