app.controller('ExplorerCtrl2', function ($scope, $http, $templateCache, $compile, $location, $controller, $routeParams, IntentService, transformRequestAsFormPost) {
    $controller('ExplorerCtrl', {$scope: $scope});
    // Folder Region 
    $scope.foldername = "";
    $scope.createfolder = function () {

        var path = $('#realpath').val();
        var name = $scope.foldername;
        var permission = $scope.permissions;
        $.post(
            "incoming.php?act=createfolder",
            { path: path, name: name, permission: permission },
            function(data, status, headers, config) {
                if (data.status == 200) {
                    $("#btn_close").click();
                    data.folder.indexfolder = ($scope.listfolder==null)?0: $scope.listfolder.length;
                    if ($scope.isEmptyfolder == true) {
                        $scope.listfolder = [data.folder];
                        $scope.isEmptyfolder = false;
                    } else {
                        if($scope.listfolder==null) $scope.listfolder = [];
                        $scope.listfolder.push(data.folder);
                    }
                } else {
                    alert(data.mss);
                }
            }
        );
    };
    $scope.delFolder = function (obj) {
        var path = obj.src;
        if (confirm('Bạn có chắc chắn muốn xóa folder này không?')) {
            $.post(
                "incoming.php?act=delfolder",
                { path: path },
                function(data, status, headers, config) {
                    if (data.status == 200) {
                        $scope.listfolder.splice(obj.indexfolder, 1);
                        if ($scope.listfolder.length == 0) {
                            $scope.isEmptyfolder = true;
                        }
                    } else {
                        alert(data.mss);
                    }
                }
            );
        }
    };
    $scope.saveFolder = function (obj) {
        if (obj.keyCode == 13) {
            $scope.createfolder();
        }
    };
    // Permmissions Region
    $scope.oread = '4';
    $scope.owrite = '2';
    $scope.oexecute = '1';

    $scope.gread = '4';
    $scope.gwrite = '2';
    $scope.gexecute = '1';

    $scope.pread = '4';
    $scope.pwrite = '2';
    $scope.pexecute = '1';


    $scope.setPermissions = function () {
        $scope.totalowner = parseInt($scope.oread) + parseInt($scope.owrite) + parseInt($scope.oexecute);
        $scope.totalgroup = parseInt($scope.gread) + parseInt($scope.gwrite) + parseInt($scope.gexecute);
        $scope.totalpublic = parseInt($scope.pread) + parseInt($scope.pwrite) + parseInt($scope.pexecute);

        $scope.totalowner = $scope.totalowner > 0 ? $scope.totalowner : '';
        if ($scope.totalowner == '' && $scope.totalgroup == 0 && $scope.totalpublic == 0) {
            $scope.permissions = 0;
        } else {
            $scope.permissions = $scope.totalowner.toString() + $scope.totalgroup.toString() + $scope.totalpublic.toString();
        }
    };

    $scope.getPermissions = function () {
        $scope.permissions = $scope.permissions.replace(" ", "");
        if ($scope.permissions == 0 || $scope.permissions.lenght == 0) {
            $scope.oread = '0';
            $scope.owrite = '0';
            $scope.oexecute = '0';

            $scope.gread = '0';
            $scope.gwrite = '0';
            $scope.gexecute = '0';

            $scope.pread = '0';
            $scope.pwrite = '0';
            $scope.pexecute = '0';
        } else if ($scope.permissions.length == 2) {
            $scope.oread = '0';
            $scope.owrite = '0';
            $scope.oexecute = '0';

            var str = $scope.permissions.split('');
            $scope.calPermission(str[0], 2);
            $scope.calPermission(str[1], 3);
        } else {
            var str = $scope.permissions.split('');
            $scope.calPermission(str[0], 1);
            $scope.calPermission(str[1], 2);
            $scope.calPermission(str[2], 3);
        }
    };

    $scope.calPermission = function (point, type) {
        var obj = IntentService.calPermission(point);
        switch (type) {
            case 1:
                $scope.oread = obj.read;
                $scope.owrite = obj.write;
                $scope.oexecute = obj.execute;
                break;
            case 2:
                $scope.gread = obj.read;
                $scope.gwrite = obj.write;
                $scope.gexecute = obj.execute;
                break;
            case 3:
                $scope.pread = obj.read;
                $scope.pwrite = obj.write;
                $scope.pexecute = obj.execute;
                break;
        }

    }
    $scope.permissions = $scope.setPermissions;
    // Zip File Region 
    $scope.chosefile = '';
    $scope.zipfile = function () {
        var path = $('#realpath').val();
        var listfile = $scope.chosefile;
        $.post(
            "incoming.php?act=zipfile",
            { path: path, list_file: listfile },
            function(data, status, headers, config) {
                if (data.status == 200) {
                    $scope.listfile.push(data.file);
                } else {
                    alert(data.mss);
                }
            }
        );
    };
    $scope.previewList = new Array();
    var imagetypes = ["jpg", "gif", "png", "jpeg"];
    $scope.chosing = function () {
        $.each($scope.listfile, function (index, value) {
            if (value.chose) {
                if ($scope.chosefile.indexOf(value.filename) == -1)
                    $scope.chosefile += value.filename + ",";
                if (imagetypes.indexOf(value.type) > -1) {
                    var id = $scope.previewList.indexOf(value.src);
                    if (id == -1)
                        $scope.previewList.push(value.src);
                }
            } else {
                var id = $scope.previewList.indexOf(value.src);
                if (id > -1)
                    $scope.previewList.splice(id, 1);
            }
        });
        
    };
    // Del File Region
    $scope.delfile = function (fileName) {
        if (confirm('Bạn chắc chắn muốn xóa file này không?')) {
            var path = $('#realpath').val();
            if (!fileName) {
                var listfile = $scope.chosefile;
            } else {
                listfile = fileName;
                $scope.listfile.forEach(function (elem) {
                    if (elem.filename == fileName) {
                        elem.chose = true;
                    }
                });
            }
            $.post(
                "incoming.php?act=delfile",
                { path: path, list_file: listfile },
                function(data, status, headers, config) {
                    if (data.status == 200) {
                        var list_index = [];
                        $.each($scope.listfile, function (index, value) {
                            if (value.chose)
                                list_index.push(index);
                        });
                        list_index.sort(function (a, b) { return b - a });
                        $.each(list_index, function (index, value) {
                            $scope.listfile.splice(value, 1);
                        });
                        if ($scope.listfile.length == 0) {
                            $scope.isEmptyfile = true;
                        }
                    } else {
                        alert(data.mss);
                    }
                }
            );
        }
    };

    $scope.$on('deleteFile', function (event, obj) {
        $scope.delfile(obj);
    });

    $scope.selectPrv = function () {
        $("#prlistimage.img").trigger('select');
    }
    // Upload Region
    $scope.overwrite = false;
    $scope.uploadinpage = function () {
        $("#notify_upload").html('');
        var path = $scope.realpath;
        var overwrite =  ($('#allowoverwrite').is(":checked"))?true:false;
            $('#file_upload').uploadify({
                'formData': {
                    'path': path,
                    'overwrite': overwrite,
                    'create_folder_type': false,
                    'token': $("#token").val(),
                    '<?php echo session_name();?>': '<?php echo session_id();?>'
                },
                'auto': false,
                'width': 120,
                'height': 30,
                'multi': true,
                'queueID': 'queuex010',
                'removeCompleted': false,
                'swf': 'plugin/uploadify/uploadify.swf',
                'uploader': 'incoming.php?act=uploadfile',
                'onSelect' : function(file) {
                    $('#uploadifybtn_start').removeClass().addClass('show');
                },
                'onUploadSuccess': function (file, data, response) {
                    var obj = JSON.parse(data);
                    if (obj.status == 200) {
                        if ($scope.isEmptyfile == true) {
                            $scope.listfile = [obj.file];
                            $scope.isEmptyfile = false;
                        } else {
                            if (obj.newfile==true) $scope.listfile.push(obj.file);
                        }
                        $scope.$apply();
                        $("#notify_upload").html('<p style="color:green">' + obj.mss + '</p>');
                    } else {
                        $("#notify_upload").html('<p style="color:red">' + obj.mss + '</p>');
                    }
                    
                }
            });

    }

    $scope.checkAllFile = function () {
        $scope.listfile.forEach(function (elem) {
            elem.chose = !$scope.checkall;
        });
        $scope.chosing();
    }
});