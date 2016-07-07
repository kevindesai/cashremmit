app.controller('commonController', ['$scope','$location' ,'$http', '$rootScope', 'userService', 'myFactory',
    function($scope,$location, $http, $rootScope, userService, myFactory){
     if(localStorage.getItem('id') !=undefined){
         $scope.isLogin=true;
         //console.log(localStorage.getItem('first_name'));
         $scope.globaluserId = localStorage.getItem('id');
         $scope.globalName = localStorage.getItem('first_name');
            $scope.globalLastName = localStorage.getItem('last_name');
     }else{
         $location.path('/');
     }   
    $scope.doLogout = function(){
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
app.controller('ReportController', function($scope, $http) {
    console.log("ReportController");

});
app.controller('SuccessController', function($scope, $http) {
    console.log("SuccessController");

});
app.controller('TransfarDetailController', function($scope, $http) {
    console.log("TransfarDetailController");

});
//app.controller('AccountSettingController', function($scope, $http, $rootScope) {
//    console.log($rootScope.userData);
//    console.log("account-setting");
//
//});
app.controller('BeneficiariesController', function($scope, $http) {
    console.log("BeneficiariesController");

});
app.directive('modalDialog', function() {
    return {
        restrict: 'E',
        scope: {
            show: '='
        },
        replace: true, // Replace with the template below
        transclude: true, // we want to insert custom content inside the directive
        link: function(scope, element, attrs) {
            scope.dialogStyle = {};
            if (attrs.width)
                scope.dialogStyle.width = attrs.width;
            if (attrs.height)
                scope.dialogStyle.height = attrs.height;
            scope.hideModal = function() {
                scope.show = false;
            };
        },
        templateUrl: 'resources/views/templates/signUpLoginPopup.html',
//    template: ""
    };
});
app.controller('ItemController', function(dataFactory, $scope, $http) {

    $scope.data = [];
    $scope.libraryTemp = {};
    $scope.totalItemsTemp = {};

    $scope.totalItems = 0;
    $scope.pageChanged = function(newPage) {
        getResultsPage(newPage);
    };

    getResultsPage(1);
    function getResultsPage(pageNumber) {
        if (!$.isEmptyObject($scope.libraryTemp)) {
            dataFactory.httpRequest('/items?search=' + $scope.searchText + '&page=' + pageNumber).then(function(data) {
                $scope.data = data.data;
                $scope.totalItems = data.total;
            });
        } else {
            dataFactory.httpRequest('/items?page=' + pageNumber).then(function(data) {
                $scope.data = data.data;
                $scope.totalItems = data.total;
            });
        }
    }

    $scope.searchDB = function() {
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

    $scope.saveAdd = function() {
        dataFactory.httpRequest('items', 'POST', {}, $scope.form).then(function(data) {
            $scope.data.push(data);
            $(".modal").modal("hide");
        });
    }

    $scope.edit = function(id) {
        dataFactory.httpRequest('items/' + id + '/edit').then(function(data) {
            console.log(data);
            $scope.form = data;
        });
    }

    $scope.saveEdit = function() {
        dataFactory.httpRequest('items/' + $scope.form.id, 'PUT', {}, $scope.form).then(function(data) {
            $(".modal").modal("hide");
            $scope.data = apiModifyTable($scope.data, data.id, data);
        });
    }

    $scope.remove = function(item, index) {
        var result = confirm("Are you sure delete this item?");
        if (result) {
            dataFactory.httpRequest('items/' + item.id, 'DELETE').then(function(data) {
                $scope.data.splice(index, 1);
            });
        }
    }

});