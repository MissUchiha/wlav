angular.module('wlav').controller('profile', ['$scope', '$http', '$cookies','$q', function($scope, $http, $cookies, $q) {
    $scope.profile = function(ev) {
        getForm().then(function(response) {
            var div = document.getElementById('hidden_form');
            div.innerHTML = response;
            var post_data = getInputs.call(div);
            post_data['fos_user_registration_form[email]'] = $scope.input.email;
            post_data['fos_user_registration_form[username]'] = $scope.input.username;
            post_data['fos_user_registration_form[firstName]'] = $scope.input.firstname;
            post_data['fos_user_registration_form[lastName]'] = $scope.input.lastname;
            post_data['fos_user_profile_form[current_password]'] = $scope.input.password;
            console.log(post_data);
            $http({
                method: "POST",
                url: "/profile",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                transformRequest: function(obj) {
                    console.log("Udje");
                    var str = [];
                    for(var p in obj) {
                        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                    }
                    return str.join("&");
                },
                data: post_data
            }).success(function(response) {
                // ispisati da je uspesno promenjen pass
                console.log(response);
            }).error(function(response) {
                // ispisati da nije uspesno promenjen pass
                console.log(response);
            });
        });
    };
    function getForm(){
        var promise = $q.defer();
        $http({
            method: 'GET',
            url: '/profile'
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
        console.log(inputs);
        for(i=0;i<inputs.length;i++)
            post_data[inputs[i].name] =inputs[i].value;
        return post_data;
    }
}]);
