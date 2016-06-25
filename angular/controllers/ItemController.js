//app.controller('AdminController', function($scope,$http){
// 
//  $scope.pools = [];
//   
//});

app.controller('AdminController', function($scope, $http, $location, myFactory, constant, $log) {

//    $log.info($location.absUrl());
//$log.info($location.protocol() + "://" + $location.host() + ":" + $location.port());
    // tabluar for the angular with bootstrap
    $scope.activeTab = 1;
    $scope.setActiveTab = function(tabToSet) {
        $scope.activeTab = tabToSet;
    };
    $scope.formInfo = {};

    $scope.registerUser = function() {
        var method = 'POST';
        var url = constant.RegitrationApi;
        var data = $scope.formInfo;
        var response = myFactory.httpMethodCall(method, url, data);
        response.success(function(data) {
            // success callback
            if (data.status == 1) {
                $location.path('/payment');
                console.log(data);
            } else {
                console.log("else");
                console.log(data);
            }
        });
        response.error(function(error) {
            console.log(error);
        });
    };
    $scope.reference = function() {


        console.log("test");
        console.log($scope.formInfo);
        $http({
            method: 'POST',
            url: 'http://localhost/ang-test/public/api/v1/users',
            data: $scope.formInfo, //forms user object
//            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .then(
                        function(response) {
                            // success callback
                            if (response.status == 1) {
                                console.log(response);
                            } else {
                                console.log("else");
                                console.log(response);
                            }
                        },
                        function(response) {
                            // failure callback
                        }
                );
//                .success(function(response) {
//                    if (response.status == 1) {
//                        console.log(response);
//                    } else {
//                        console.log("else");
//                        console.log(response);
//                    }
//                })
//                .error(function(data) {
//                    return data;
//                });
    };
    $scope.loginUser = function() {
        console.log($scope.formInfo);
        $http({
            method: 'POST',
            url: 'http://localhost/ang-test/public/api/v1/users',
            data: $scope.formInfo, //forms user object
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        })
                .success(function(data) {
                    console.log(data);
                    if (data.errors) {
                        // Showing errors.
                        $scope.errorName = data.errors.name;
                        $scope.errorUserName = data.errors.username;
                        $scope.errorEmail = data.errors.email;
                    } else {
                        $scope.message = data.message;
                    }
                })
                .error(function(data) {
                    return data;
                });
    };

    ////     myFactory.testMethod();
    //      // create a blank object to handle form data.
    //        $scope.user = {};
    //        
    //       
    //      // calling our submit function.
    //        $scope.submitForm = function() {
    //        // Posting data to php file
    //        $http({
    //          method  : 'POST',
    //          url     : 'clone.php',
    //          data    : $scope.user, //forms user object
    //          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
    //         })
    //          .success(function(data) {
    //            if (data.errors) {
    //              // Showing errors.
    //              $scope.errorName = data.errors.name;
    //              $scope.errorUserName = data.errors.username;
    //              $scope.errorEmail = data.errors.email;
    //            } else {
    //              $scope.message = data.message;
    //            }
    //          })
    //          .error(function(data){
    //              return data;
    //          });
    //        };
});
//app.controller('AdminController', ['$scope', function($scope) {
//  $scope.modalShown = false;
//  $scope.toggleModal = function() {
//      console.log("here");
//    $scope.modalShown = !$scope.modalShown;
//  };
//}]);
app.controller('PaymentController', function($scope, $http) {
    console.log("test");

});
app.controller('ReportController', function($scope, $http) {
    console.log("ReportController");

});
app.controller('SuccessController', function($scope, $http) {
    console.log("SuccessController");

});
app.controller('TransfarDetailController', function($scope, $http) {
    console.log("TransfarDetailController");

});
app.controller('AccountSettingController', function($scope, $http) {
    console.log("account-setting");

});
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