app.controller('ExplorerCtrl4', function ($controller, $scope, $http, $templateCache, $compile, $location, $routeParams, $rootScope, IntentService, transformRequestAsFormPost) {
    $controller('ExplorerCtrl3', { $scope: $scope });
    // All out code here!
    $scope.fileinfo = function (obj) {
        $rootScope.$broadcast('fileInfor', obj);
    }

    var imagetypes = ["png", "jpg", "jpeg", "gif"];

    $scope.$on('renameFile', function (event, changedfile, newname, newpath, newwebpath) {
        //var id = $scope.listfile.indexOf(changedfile);
        //if (id > -1) {
        //var file = $scope.listfile[id];
        var file = changedfile;
        file.filename = newname;
        file.path = file.src = newpath;
        file.type = newname.split(".").pop();
        file.webpath = newwebpath;
        if (imagetypes.indexOf(file.type) > -1) {
            file.image = file.webpath;
        }
        else {
            file.image = file.image.substring(0, file.image.indexOf(":") + 1) + file.type;
            alert(file.image);
            $scope.$apply();
            setTimeout(function () {
                Holder.run({ images: ".holderimg" });
            }, 1);
        }
        //}
    });

    $scope.loadMoreFile = function () {
        if ($scope.isLoadFolder == false) {
            //$scope.loadfolder($scope.currlocation);
            $scope.isLoadFolder = true;
            var path = $scope.currlocation.src;
            var ltime = $scope.lasttime;
            var keyword = $("#keyword").val();
            console.log(keyword);
            if (keyword == '')
                var data = { method: 'GET', url: 'incoming.php?act=listfolder&path=' + path + '&firstload=' + IntentService.getFirstLoad() + '&ltime=' + ltime };
            else
                var data = { method: 'GET', url: 'incoming.php?act=searchfile&path=' + path + '&firstload=' + IntentService.getFirstLoad() + '&keyword=' + keyword + '&ltime=' + ltime };

            angular.element('#btnLoadMore').hide();
            $http(data).
                 success(function (data, status, headers, config) {
                     if ((data.file !== null) || (data.folder !== null)) $scope.isLoadFolder = false;
                     if ((data.keyword == $("#keyword").val()) || $("#keyword").val() == '') {
                         if (data.file !== null) {
                             data.file.forEach(function (elem) {
                                 $scope.listfile.push(elem);
                             });
                         }
                         if ($scope.listfile.length == 0) $scope.isEmptyfile = true;
                         else $scope.isEmptyfile = false;

                         $scope.lasttime = data.lasttime;
                     }
                     setTimeout(function () {
                         Holder.run({ images: ".holderimg" });
                     }, 50);
                     $scope.isLoadMore = false;
                     if (data.file || data.folder) angular.element('#btnLoadMore').show();
                 });
        }
    }

    var t = 400; var thread;

    $scope.searchFile = function () {
        clearTimeout(thread);
        thread = setTimeout(function () {
            connectserver();
        }, t)
    };
    function connectserver() {
        $scope.lasttime = 999999999999999;
        $scope.listfile.length = 0;
        $scope.listfolder.length = 0;
        $scope.isLoadFolder = false;
        $scope.loadMoreFile();
    }

});





