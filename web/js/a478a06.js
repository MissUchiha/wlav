angular.module('wlav').controller('main', ['$scope', '$http', '$cookies', function($scope, $http, $cookies) {
    $scope.login = function(ev) {
        $http({
            method: "POST",
            url: "/login_check",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            transformRequest: function(obj) {
                var str = [];
                for(var p in obj) {
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                }
                return str.join("&");
            },
            data: {
                '_username': $scope.input.username,
                '_password': $scope.input.password
            }
        }).success(function(response) {
            document.getElementById('resp').innerHTML = response;
        }).error(function(response) {
            document.getElementById('resp').innerHTML = response;
        });
    };
}]);

angular.module('wlav').controller('nla', ['$scope', '$http', function($scope, $http) {
    $scope.username = 'Pera';
    $scope.lastname = 'asd';

    $http.post();



}]);
