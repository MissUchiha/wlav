angular.module('symgular').controller('main', ['$scope', '$http', '$cookies', function($scope, $http, $cookies) {
    $scope.login = function(ev) {
        $http.get("/logout").success(function(){
            $http.get("/test?apikey=aaf23bc45f31c72be2ade5ccfff6b31b").success(function(response) {
                document.getElementById('resp').innerHTML = response;
            }).error(function(response) {
                document.getElementById('resp').innerHTML = response;
            });
        })
    };
}]);
