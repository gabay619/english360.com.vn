var firstplaymedia = 0;
app.controller("FileCtrl", function ($scope, $http, $rootScope, IntentService, transformRequestAsFormPost) {
    hideContentTag($scope);
    $scope.$on('fileInfor', function (event, file) {
        var path = ""; if (file != null) $scope.path = file.path;
        $scope.file = file;
        $scope.webpath = file.webpath;
        $http({ method: 'GET', url: 'incoming.php?act=fileinfo&path=' + $scope.path })
        .success(function (res, status, headers, config) {
            if (res.status == 200) {
                if (first == 0) {
                    $('#fileModal').on('hidden.bs.modal', function () {
                        hideContentTag($scope)
                    });
                }
                var data = res.data;
                $scope.fileInfor = res.fileinfor;
                $scope.newFileName = res.name;
                $scope.oldFileName = res.name;
                if (data !== null) {
                    if (data.text) {
                        $scope.text = { content: data.text, visible: 'visiblecont' };
                    }
                    else if (data.media) {
                        $scope.media.visible = 'visiblecont';
                        $scope.media.source = encodeURI(data.media);
                        if (data.type == 'audio') {
                            $scope.media.height = "25px";
                        }
                        else if (data.type == 'video') {
                            $scope.media.height = "320px";
                        }
                    }
                    else if (data.image) {
                        $scope.image = { source: data.image, visible: 'visiblecont' };
                    }
                } else {
                    alert('Khong co du lieu ve file');
                }
            }
        });
    });

    $scope.reName = function () {
        $.post(
            "incoming.php?act=renamefile",
            { path: $scope.path, newname: $scope.newFileName },
            function (res, status, headers, config) {
                if (res.status == 200) {
                    $scope.path = res.newpath;
                    $scope.oldFileName = $scope.newFileName = res.newname;
                    $scope.webpath = res.newwebpath;
                    alert(' Ðổi tên file thành công');
                    $rootScope.$broadcast('renameFile', $scope.file, $scope.oldFileName, $scope.path, $scope.webpath);
                } else {
                    alert(res.mess);
                    $scope.newFileName = $scope.oldFileName;
                }
            }
        );
    }

    $scope.deleteFile = function () {
        $rootScope.$broadcast('deleteFile', $scope.oldFileName);
        $('#fileModal').modal('hide');

    }

    $scope.saveFile = function () {
        $.post(
            "incoming.php?act=savefile",
            { path: $scope.path, content: $scope.text.content  },
            function (res, status, headers, config) {
                if (res.status == 200) {
                    alert('File đã lưu thành công');
                } else {
                    alert(res.mess);
                }
            }
        );
    };
});


function hideContentTag($scope) {
    $(".modal-dialog").css({ 'width': '720px' });
    $scope.text = { content: "", visible: 'invisiblecont' };
    $scope.media = { source: "", visible: 'invisiblecont' };
    $scope.image = { source: "", visible: 'invisiblecont' };
}
