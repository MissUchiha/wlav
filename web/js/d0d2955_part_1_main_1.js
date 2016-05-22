var wlav = angular.module('wlav', ['ngCookies', 'ngRoute']);

wlav.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
        when('/', {
            templateUrl: '/partials/login.html',
            controller: 'main'
        }).
        when('/nla', {
            templateUrl: '/partials/nla.html',
            controller: 'nla'
        });
    }
]);