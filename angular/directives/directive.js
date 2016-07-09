
app.directive("myHeader", function($timeout)
  {
    return {
    	restrict: 'E',
      templateUrl: 'resources/views/templates/common/header.html',
    }
  });	

app.directive("myFooter", function($timeout)
  {
    return {
    	restrict: 'E',
      templateUrl: 'resources/views/templates/common/footer.html',
    }
  });
app.directive("myPopup", function($timeout)
  {
    return {
    	restrict: 'E',
      templateUrl: 'resources/views/templates/login/signUpLoginPopup.html',
    }
  });
app.directive("regForm", function($timeout)
  {
    return {
    	restrict: 'E',
      templateUrl: 'resources/views/templates/login/registerForm.html',
    }
  });
app.directive("loginForm", function($timeout)
  {
    return {
    	restrict: 'E',
      templateUrl: 'resources/views/templates/login/loginForm.html',
    }
  });
app.directive("accountSettingUpdate", function($timeout)
  {
    return {
    	restrict: 'E',
      templateUrl: 'resources/views/templates/account-setting/account-setting-modal.html',
    }
  });
app.directive('lettersOnly', function() {
  return {
    replace: true,
    template: '<input replace="[^a-zA-Z]" with="">'
  };
});  