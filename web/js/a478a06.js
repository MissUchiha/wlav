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

angular.module('wlav').controller('register', ['$scope', '$http', '$cookies','$q', function($scope, $http, $cookies, $q) {
    $scope.register = function(ev) {
        getForm().then(function(response) {
            var div = document.getElementById('hidden_form');
            div.innerHTML = response;
            var post_data = getInputs.call(div);
            post_data['fos_user_registration_form[email]'] = $scope.input.email;
            post_data['fos_user_registration_form[username]'] = $scope.input.username;
            post_data['fos_user_registration_form[plainPassword][first]'] = $scope.input.password;
            post_data['fos_user_registration_form[plainPassword][second]'] = $scope.input.password_repeat;
            post_data['fos_user_registration_form[firstName]'] = $scope.input.firstname;
            post_data['fos_user_registration_form[lastName]'] = $scope.input.lastname;
            console.log(post_data);
            $http({
                method: "POST",
                url: "/register",
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
            url: '/register'
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
