app.controller('commonController', ['$scope', '$location', '$http', '$rootScope', 'userService', 'myFactory',
    function ($scope, $location, $http, $rootScope, userService, myFactory) {
        $scope.activeTab = 1;
    $scope.setActiveTab = function(tabToSet) {
        $scope.activeTab = tabToSet;
    };
   // console.log(localStorage.getItem('id'));
        if (localStorage.getItem('id') != undefined || localStorage.getItem('id') != null) {
            ///$scope.isLogin = "true";
            $scope.isLogin = true;
            $rootScope.isLogin = true;
            //console.log(localStorage.getItem('first_name'));
            $scope.globaluserId = localStorage.getItem('id');
            $scope.globalName = localStorage.getItem('first_name');
            $scope.globalLastName = localStorage.getItem('last_name');
        }else{
            $scope.isLogin = false;
            $rootScope.isLogin = false;
        } 
        
        $scope.doLogout = function () {
            localStorage.removeItem('id');
            localStorage.removeItem('email');
            localStorage.removeItem('token');
            localStorage.removeItem('first_name');
            localStorage.removeItem('last_name');
            localStorage.removeItem('building_name');
            localStorage.removeItem('city');
            localStorage.removeItem('country');
            localStorage.removeItem('landline_no');
            localStorage.removeItem('mobile_no');
            localStorage.removeItem('post_code');
            localStorage.removeItem('region');
            localStorage.removeItem('street');
            localStorage.removeItem('unit_no');
            $location.path('/');
        }
    }]);
app.controller('ReportController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory', '$location','$document',
    function ($scope, $http, $rootScope, userService, myFactory, $location,$document) {
        userService.getDataFromSession();
        $scope.userInfo = userService.userInfo;
        $scope.ToAmount = localStorage.getItem('ToamounT')
        $scope.ToCur = localStorage.getItem('ToCUR')
        $scope.globalName = localStorage.getItem('first_name');
        $scope.globalLastName = localStorage.getItem('last_name');
        $scope.setActiveBenif = function (activeData, indexes) {
            $scope.isActive = indexes;
            $scope.benifData = activeData;
        }
        $scope.refreshbeif = function () {
            $scope.isActive = 0;
            $scope.NoBenif=0;
            $scope.user_id = localStorage.getItem('id');
            method = "GET";
            url = $rootScope.getBenefiery + '/' + $scope.user_id+"?token="+$scope.userInfo.token;
            var methodData = {"_method": "GET",'token':$scope.userInfo.token};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
                console.log(data);
                if (data.status == 1 && data.message == "data found") {
                    $scope.userBefif = data.data;
                    $scope.benifData = data.data[0];
                }else{
                    $scope.NoBenif = 1;
                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.refreshbeif();
        $scope.getCountry = function (){
           method = "GET";
            url = $rootScope.getCountry;
            methodData ={};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
                if(data.status==1){
                    $scope.countryList = data.data;
                    
                }else{
                    $scope.countryList ={};
                }
                
            });
            response.error(function (error) {
                console.log(error);
            }); 
        }
        $scope.getCountry();
        $scope.getBanks = function(countryIdName){
            var dataArr = countryIdName.split("_");
            $scope.CountryId = dataArr[0];
            $scope.country_name = dataArr[1];
            method = "GET";
            url = $rootScope.getBanks+"/"+$scope.CountryId;
            methodData ={};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
                if(data.status==1){
               $scope.Banks = data.data;     
                    
                }else{
                    $scope.Banks ={};
                }
                
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.getBankDetails=function(bankselect){
            var dataArr = bankselect.split("_");
            $scope.BankId = dataArr[0];
            $scope.bank_name = dataArr[1];
            method = "GET";
            url = $rootScope.getbankdetail+"/"+$scope.BankId;
            methodData ={};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
                console.log(data)
                if(data.status==1){
               $scope.BankDetails = data.data;     
                    
                }else{
                    $scope.BankDetails ={};
                }
                
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.addbenif = function (benifdata) {
        	$scope.benifData = $scope.benif;
            $scope.benifData.user_id = $scope.userInfo.id;
            $scope.benifData.token = $scope.userInfo.token;
            $scope.benifData.attributes = JSON.stringify($scope.benifData.attributes);
            var dataArr = $scope.benifData.bank_name.split("_");
            $scope.BankId = dataArr[0];
            $scope.benifData.bank_name = dataArr[1];
            method = "POST";
            url = $rootScope.addBenefiery;
            var response = myFactory.httpMethodCall(method, url, $scope.benifData);
            response.success(function (data) {
                console.log(data);
                if (data.status == 1) {
                    $scope.refreshbeif();
                    $('#myModal').modal('hide');
                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        

    }]);
app.controller('SuccessController', function ($scope, $http) {
    console.log("SuccessController");

});
app.controller('TransfarDetailController', function ($scope, $http) {
    console.log("TransfarDetailController");

});
app.controller('SelectPaymentController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory', '$location',
    function ($scope, $http, $rootScope, userService, myFactory, $location) {
    console.log("TransfarDetailController");
    $scope.ToAmount = localStorage.getItem('ToamounT')
        $scope.ToCur = localStorage.getItem('ToCUR')
        $scope.globalName = localStorage.getItem('first_name');
        $scope.globalLastName = localStorage.getItem('last_name');


}]);
app.controller('PaymentDetailsController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory', '$location',
    function ($scope, $http, $rootScope, userService, myFactory, $location) {
    $scope.userId = localStorage.getItem('id');
    $scope.isLogin=true;
    if($scope.userId == null || $scope.userId == undefined){
        $scope.isLogin = false;
    }
    $scope.fromAmount=localStorage.getItem('FromamounT');
    $scope.fromCur=localStorage.getItem('FromCUR');
    $scope.toCur=localStorage.getItem('ToCUR');
    $scope.toAmount=localStorage.getItem('ToamounT');
    $scope.defaultCurConvert = function(){
            var method = 'POST';
            var url = $rootScope.CurrencyApi;
            var curData={};
            $scope.DefaultfromAmount = 1;
            curData.amount = $scope.DefaultfromAmount;
            curData.from = $scope.fromCur;
            curData.to = $scope.toCur;
            var response = myFactory.httpMethodCall(method, url, curData);
            response.success(function (data) {
                if (data.status == 1) {
                    
                    $scope.DefaulttoAmount = data.converted;
                    console.log($scope.DefaulttoAmount);
                } else if (data.status == 0) {

                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.defaultCurConvert();
     $scope.convertCurFromto = function () {
            var method = 'POST';
            var url = $rootScope.CurrencyApi;
            var curData = {};
            $scope.fromAmount = ($scope.fromAmount == undefined) ? 1 : $scope.fromAmount;
            curData.amount = $scope.fromAmount;
            curData.from = $scope.fromCur;
            curData.to = $scope.toCur;
            localStorage.setItem('FromamounT',$scope.fromAmount);
            localStorage.setItem('FromCUR',$scope.fromCur);
            localStorage.setItem('ToCUR',$scope.toCur);
            var response = myFactory.httpMethodCall(method, url, curData);
            response.success(function (data) {
                if (data.status == 1) {
                    $scope.toAmount = data.converted;
                    localStorage.setItem('ToamounT',data.converted);
                } else if (data.status == 0) {

                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.convertCurtoFrom = function () {
            var method = 'POST';
            var url = $rootScope.CurrencyApi;
            var curData = {};
            $scope.toAmount = ($scope.toAmount == undefined) ? 1 : $scope.toAmount;
            curData.amount = $scope.toAmount;
            localStorage.setItem('ToamounT',$scope.toAmount);
            curData.from = $scope.toCur;
            curData.to = $scope.fromCur;
            localStorage.setItem('FromCUR',$scope.fromCur);
            localStorage.setItem('ToCUR',$scope.toCur);
            var response = myFactory.httpMethodCall(method, url, curData);
            response.success(function (data) {
                if (data.status == 1) {
                    $scope.fromAmount = data.converted;
                    localStorage.setItem('FromamounT',data.converted);
                } else if (data.status == 0) {

                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }

}]);
app.controller('BeneficiariesController', ['$scope', '$http', '$rootScope', 'userService', 'myFactory', '$location',
    function ($scope, $http, $rootScope, userService, myFactory, $location) {
        userService.getDataFromSession();
        $scope.userInfo = userService.userInfo;
        $scope.refreshbeif = function () {
            $scope.isActive = 0;
            $scope.user_id = localStorage.getItem('id');
            method = "GET";
            url = $rootScope.getBenefiery + '/' + $scope.user_id+'?token='+$scope.userInfo.token;
            var methodData = {"_method": "GET"};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
                console.log(data);
                if (data.status == 1 && data.message == "data found") {
                    $scope.userBefif = data.data;
                    $scope.benifData = data.data[0];
                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
        $scope.refreshbeif();
        $scope.deleteBenif = function (id) {
            $scope.user_id = localStorage.getItem('id');
            method = "POST";
            url = $rootScope.deleteBenefiery + '/' + id+'?token='+$scope.userInfo.token;
            var methodData = {"_method": "DELETE"};
            var response = myFactory.httpMethodCall(method, url, methodData);
            response.success(function (data) {
                console.log(data);
                if (data.status == 1) {
                    $scope.refreshbeif();
                }
            });
            response.error(function (error) {
                console.log(error);
            });
        }
    }]);
app.directive('modalDialog', function () {
    return {
        restrict: 'E',
        scope: {
            show: '='
        },
        replace: true, // Replace with the template below
        transclude: true, // we want to insert custom content inside the directive
        link: function (scope, element, attrs) {
            scope.dialogStyle = {};
            if (attrs.width)
                scope.dialogStyle.width = attrs.width;
            if (attrs.height)
                scope.dialogStyle.height = attrs.height;
            scope.hideModal = function () {
                scope.show = false;
            };
        },
        templateUrl: 'resources/views/templates/signUpLoginPopup.html',
//    template: ""
    };
});
app.controller('ItemController', function (dataFactory, $scope, $http) {

    $scope.data = [];
    $scope.libraryTemp = {};
    $scope.totalItemsTemp = {};

    $scope.totalItems = 0;
    $scope.pageChanged = function (newPage) {
        getResultsPage(newPage);
    };

    getResultsPage(1);
    function getResultsPage(pageNumber) {
        if (!$.isEmptyObject($scope.libraryTemp)) {
            dataFactory.httpRequest('/items?search=' + $scope.searchText + '&page=' + pageNumber).then(function (data) {
                $scope.data = data.data;
                $scope.totalItems = data.total;
            });
        } else {
            dataFactory.httpRequest('/items?page=' + pageNumber).then(function (data) {
                $scope.data = data.data;
                $scope.totalItems = data.total;
            });
        }
    }

    $scope.searchDB = function () {
        if ($scope.searchText.length >= 3) {
            if ($.isEmptyObject($scope.libraryTemp)) {
                $scope.libraryTemp = $scope.data;
                $scope.totalItemsTemp = $scope.totalItems;
                $scope.data = {};
            }
            getResultsPage(1);
        } else {
            if (!$.isEmptyObject($scope.libraryTemp)) {
                $scope.data = $scope.libraryTemp;
                $scope.totalItems = $scope.totalItemsTemp;
                $scope.libraryTemp = {};
            }
        }
    }

    $scope.saveAdd = function () {
        dataFactory.httpRequest('items', 'POST', {}, $scope.form).then(function (data) {
            $scope.data.push(data);
            $(".modal").modal("hide");
        });
    }

    $scope.edit = function (id) {
        dataFactory.httpRequest('items/' + id + '/edit').then(function (data) {
            console.log(data);
            $scope.form = data;
        });
    }

    $scope.saveEdit = function () {
        dataFactory.httpRequest('items/' + $scope.form.id, 'PUT', {}, $scope.form).then(function (data) {
            $(".modal").modal("hide");
            $scope.data = apiModifyTable($scope.data, data.id, data);
        });
    }

    $scope.remove = function (item, index) {
        var result = confirm("Are you sure delete this item?");
        if (result) {
            dataFactory.httpRequest('items/' + item.id, 'DELETE').then(function (data) {
                $scope.data.splice(index, 1);
            });
        }
    }

});