

app.directive("myHeader", function($timeout)
  {
    return {
    	restrict: 'E',
      templateUrl: 'resources/views/templates/header.html',
    }
  });	

app.directive("myFooter", function($timeout)
  {
    return {
    	restrict: 'E',
      templateUrl: 'resources/views/templates/footer.html',
    }
  });