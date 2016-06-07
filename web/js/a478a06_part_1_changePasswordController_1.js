angular.module('wlav').controller('changePassword', ['$scope', '$http', '$cookies','$q', function($scope, $http, $cookies, $q) {
    $scope.change = function(ev) {
        getForm().then(function(response) {
            var div = document.getElementById('hidden_form');
            div.innerHTML = response;
            var post_data = getInputs.call(div);
            post_data['fos_user_change_password_form[current_password]'] = $scope.input.current_password;
            post_data['fos_user_change_password_form[plainPassword][first]'] = $scope.input.new_password;
            post_data['fos_user_change_password_form[plainPassword][second]'] = $scope.input.new_password_repeat;
            $http({
                method: "POST",
                url: "/profile/password",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                transformRequest: function(obj) {
                    var str = [];
                    for(var p in obj) {
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    }
                    return str.join("&");
                },
                data: post_data
            }).success(function(response) {
                // ispisati da je uspesno promenjen pass
                console.log('success',response);
            }).error(function(response) {
                // ispisati da nije uspesno promenjen pass
                console.log('error ',response);
            });
        });
    };
    function getForm(){
        var promise = $q.defer();
        $http({
            method: 'GET',
            url: '/profile/password'
        }).success(function(response) {
            promise.resolve(response);
        }).error(function(response) {
            promise.reject(response);
        });
        return promise.promise;
    }
    function getInputs(){
        var post_data = {};
        var inputs = this.querySelectorAll('input');
        for(i=0;i<inputs.length;i++)
            post_data[inputs[i].name] =inputs[i].value;
        return post_data;
    }
}]);
