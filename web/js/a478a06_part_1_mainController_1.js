angular.module('wlav').controller('main', ['$scope', '$http', '$cookies','$q', function($scope, $http, $cookies, $q) {
    $scope.login = function(ev) {
        getForm().then(function(response) {
            var div = document.getElementById('hidden_form');
            div.innerHTML = response;
            var post_data = getInputs.call(div);
            post_data['fos_user_change_password_form[current_password]'] = "id";
            post_data['fos_user_change_password_form[plainPassword][first]'] = "idid";
            post_data['fos_user_change_password_form[plainPassword][second]'] = "idid";
            console.log(post_data);
            $http({
                method: "POST",
                url: "/profile/password",
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
                document.getElementById('resp').innerHTML = response;
            }).error(function(response) {
                document.getElementById('resp').innerHTML = response;
            });
        });
    };
    function getForm(){
        var promenljiva = $q.defer();
        $http({
            method: 'GET',
            url: '/profile/password'
        }).success(function(response) {
            promenljiva.resolve(response);
        }).error(function(response) {
            promenljiva.reject(response);
        });
        return promenljiva.promise;
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
