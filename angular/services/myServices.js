
////https://github.com/gsklee/ngStorage
//http://stackoverflow.com/questions/18247130/how-to-store-the-data-to-local-storage
//http://stackoverflow.com/questions/12940974/maintain-model-of-scope-when-changing-between-views-in-angularjs/16559855#16559855

app.factory('userService', ['$rootScope', function($rootScope) {
        var userData = {};
        userData.userInfo = {};
        /*
         * set all usrdata in localstorage and
         */
        userData.saveDataInSession = function(userInfo) {
            userData.userInfo = userInfo;
            for (var x in userData.userInfo) {
                localStorage.setItem(x, userData.userInfo[x]);
            }
            return userData.userInfo;
        }
        /*
         * get all data from session
         */
        userData.getDataFromSession = function() {
            userData.userInfo.id = localStorage.getItem('id');
            userData.userInfo.email = localStorage.getItem('email');
            userData.userInfo.token = localStorage.getItem('token');
            userData.userInfo.first_name = localStorage.getItem('first_name');
            userData.userInfo.last_name = localStorage.getItem('last_name');
            userData.userInfo.building_name = localStorage.getItem('building_name');
            userData.userInfo.city = localStorage.getItem('city');
            userData.userInfo.country = localStorage.getItem('country');
            userData.userInfo.country_id = localStorage.getItem('country_id');
            userData.userInfo.country_code = localStorage.getItem('country_code');
            userData.userInfo.country_name = localStorage.getItem('country_name');
            userData.userInfo.dob = localStorage.getItem('dob');
            userData.userInfo.landline_no = localStorage.getItem('landline_no');
            userData.userInfo.mobile_no = localStorage.getItem('mobile_no');
            userData.userInfo.post_code = localStorage.getItem('post_code');
            userData.userInfo.region = localStorage.getItem('region');
            userData.userInfo.street = localStorage.getItem('street');
            userData.userInfo.unit_no = localStorage.getItem('unit_no');
            userData.userInfo.is_active = localStorage.getItem('is_active');
            userData.userInfo.proile = localStorage.getItem("profile");

            return userData.userInfo;
        }
        /** 
         * @param {type} key : key which is going to update
         * @param {type} value : value which is set to user
         * @returns {undefined} : return new updated value of that key
         */
        /*
         * update info of user in localstorage
         */
        userData.UpdateInfo = function(updatedInformation) {
//            var keys = Object.keys(updatedInformation);
            var arr = [];
            for (var x in updatedInformation) {
                localStorage.setItem(x, updatedInformation[x]);
                userData.userInfo.x = updatedInformation[x];
                arr[x] = updatedInformation[x];
            }
            return arr;
        }

        return userData;

    }]); 
app.directive('validPasswordC', function() {
    return {
        require: 'ngModel',
        scope: {
            reference: '=validPasswordC'

        },
        link: function(scope, elm, attrs, ngModel) {
            ngModel.$validators.compareTo = function(modelValue) {
                return modelValue == scope.otherModelValue;
            };

            scope.$watch("reference", function() {
                ngModel.$validate();
            });
        }
    }
});

app.service('myFactory', ['$http', function($http) {

//    var urlBase = 'http://localhost:2307/Service1.svc';
        var myFactory = {};

        myFactory.httpMethodCall = function(method, url, params, header) {

            var httpData = $http({
                method: method,
                url: url,
                data: params, //forms user object
//          headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
            });
            return httpData;
        };
        myFactory.currencyConvert = function(url,fromcur,tocur,fromamount){
            var curData = {};
            curData.amount = fromamount;
            curData.from = fromcur;
            curData.to = tocur;
            var httpData = $http({
                method:"POST",
                url:url,
                data:curData
            });
            return httpData;
        } 
        
        return myFactory;

    }]);
app.factory('countrylistService',['$rootScope','$http',function($rootScope,$http){
        var countryData ={};
        var httpData = $http({
                method:"GET",
                url:$rootScope.getCountry,
                
            });
        return httpData;
        //console.log(countryData);
        
        
}]);
app.filter('toDate', function() {
    return function(stringDate) {
        return new Date(stringDate);
    };
});
app.filter('minLength', function(){
  return function(input, len, pad){
    input = input.toString(); 
    if(input.length >= len) return input;
    else{
      pad = (pad || 0).toString(); 
      return new Array(1 + len - input.length).join(pad) + input;
    }
  };
});