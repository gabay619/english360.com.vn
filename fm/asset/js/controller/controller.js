var app = angular.module("filemanager", ['ngRoute']);

app.config(function ($locationProvider, $routeProvider, $provide) {
    //$locationProvider.html5Mode(true).hashPrefix('!');
    $routeProvider.
      when('/upload', {
          templateUrl: 'templates/view_upload.php',
          controller: 'UploadCtrl'
      }).
      when('/explorer/:path*', {
          templateUrl: 'templates/view_explorer.html',
          controller: 'ExplorerCtrl'
      }).
      when('/explorer/', {
          templateUrl: 'templates/view_explorer.html',
          controller: 'ExplorerCtrl'
      }).
      when('/fm/logout.php', {
          redirectTo: 'logout.php'
      }).
      otherwise({
          redirectTo: '/explorer'
      });
});

var first = 0;

app.factory('IntentService', function ($rootScope, $http) {
    var number = 1;
    var arrPer = ['read', 'write', 'execute'];
    var arrNumb = [4, 2, 1];
    var firstload = true;
    function getNumber() {
        return number;
    }
    function setNumber(newNumber) {
        number = newNumber;
    }

    function getFirstLoad() {
        return firstload;
    }
    function setFirstLoad(val) {
        firstload = val;
    }

    function calPermission(point) {
        var obj = { 'read': '0', 'write': '0', 'execute': '0' };
        cal(obj, point, 0);
        return obj;
    }

    function cal(obj, point, tmp) {
        var sub = point - arrNumb[tmp];
        if (sub >= 0) {
            obj[arrPer[tmp]] = arrNumb[tmp] + "";
            cal(obj, sub, tmp + 1);
        } else if (sub < 0) {
            cal(obj, point, tmp + 1);
        }
    }

    return {
        getNumber: getNumber,
        setNumber: setNumber,
        getFirstLoad: getFirstLoad,
        setFirstLoad: setFirstLoad,
        calPermission: calPermission
    }
});

app.factory("transformRequestAsFormPost", function () {
    function transformRequest(data, getHeaders) {
        var headers = getHeaders();
        headers["Content-type"] = "application/x-www-form-urlencoded; charset=utf-8";
        return (serializeData(data));
    }
    return (transformRequest);
    function serializeData(data) {
        // If this is not an object, defer to native stringification.
        if (!angular.isObject(data)) {
            return ((data == null) ? "" : data.toString());
        }
        var buffer = [];
        // Serialize each key in the object.
        for (var name in data) {
            if (!data.hasOwnProperty(name)) {
                continue;
            }
            var value = data[name];
            buffer.push(
                encodeURIComponent(name) +
                "=" +
                encodeURIComponent((value == null) ? "" : value)
            );
        }
        // Serialize the buffer and clean it up for transportation.
        var source = buffer.join("&").replace(/%20/g, "+");
        return (source);
    }
});

app.controller("ExplorerCtrl", function ($scope, $http, $templateCache, $compile, $location, $routeParams, IntentService, transformRequestAsFormPost) {
    $scope.getRandomSpan = function () {
        return Math.floor((Math.random() * 999999) + 1);
    };
    $scope.listfile = [];
    $scope.listfolder = [];
    $scope.breadcrums = [];
    $scope.isLoadFolder = false;
    $scope.isEmptyfolder = false;
    $scope.isEmptyfile = false;
    $scope.isLoadMore = false;
    $scope.realpath = "";
    $scope.currlocation = null;
    $scope.lasttime = 999999999999999;
    $scope.isLoadFolderTemplate = false;
    $scope.loadfolder = function (obj) {
        var path = "";
        if ($routeParams.path != undefined && $routeParams.path.length > 0) path = $routeParams.path;
        if (obj != null) {
            path = obj.src;
            if (obj != $scope.currlocation) {
                $scope.currlocation = obj;
                $scope.lasttime = 999999999999999;
                $scope.listfile.length = 0;
                $scope.listfolder.length = 0;
            }
        }
        var ltime = $scope.lasttime;
        $scope.breadcrums.length = 0;
        $scope.isLoadFolder = true;
        $scope.isLoadMore = true;
        $("#keyword").val('');
        angular.element('#btnLoadMore').hide();
        $http({ method: 'GET', url: 'incoming.php?act=listfolder&path=' + path + '&firstload=' + IntentService.getFirstLoad() + '&ltime=' + ltime }).
                success(function (data, status, headers, config) {
                    var id = 1; //if (obj != undefined) id = obj.index;  e.log(obj);
                    if ((data.file !== null) || (data.folder !== null)) $scope.isLoadFolder = false;
                    if (data.file !== null) {
                        data.file.forEach(function (elem) {
                            $scope.listfile.push(elem);
                        });
                    }
                    if ($scope.listfile.length == 0) $scope.isEmptyfile = true;
                    else $scope.isEmptyfile = false;
                    if (data.folder !== null) {
                        data.folder.forEach(function (elem) {
                            $scope.listfolder.push(elem);
                        });
                    }
                    if ($scope.listfolder.length == 0) $scope.isEmptyfolder = true;
                    else $scope.isEmptyfolder = false;
                    $scope.breadcrums = data.inpath;
                    $scope.realpath = data.realpath;
                    $scope.lasttime = data.lasttime;
                    if ($scope.isLoadFolderTemplate == false) {
                        $http.get('templates/folder.html', {
                            cache: $templateCache
                        }).then(function (template) {
                            var e = angular.element(template.data);
                            var l = $compile(e)($scope);
                            if (id != 1) angular.element('#folder_' + id).parent().append(e);
                            else angular.element('#folder_' + id).append(e);
                        });
                        $scope.isLoadFolderTemplate = true;
                    }
                    setTimeout(function () {
                        Holder.run({ images: ".holderimg" });
                    }, 50);
                    IntentService.setFirstLoad(false);
                    if ($scope.currlocation == null) { $scope.currlocation = { src: data.realpath } }
                    $scope.isLoadMore = false;
                    if (data.file) angular.element('#btnLoadMore').show();
                });
    };


    
});


app.controller("UploadCtrl", function ($scope, $http, $templateCache, $compile) {
});

function setPermissions() {
    console.log(this);
}
