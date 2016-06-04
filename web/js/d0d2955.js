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
        }).
        when('/changePassword', {
            templateUrl: '/partials/changePassword.html',
            controller: 'changePassword'
        }).
        when('/register', {
            templateUrl: '/partials/register.html',
            controller: 'register'
        });
    }
]);