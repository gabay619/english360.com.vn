<div class="modal fade" id="previewmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" ng-controller="FileCtrl">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closefilemodal" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Thông tin file</h4>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" ng-model="newFileName">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" ng-click="reName()">Rename File</button>
                    </span>
                </div>
                <div ng-repeat="(key, value) in fileInfor">{{key}} : {{value}}</div>
                <div class="input-group input-group-sm" style="margin-bottom: 8px">
                    <input type="text" class="form-control" ng-model="path" readonly="readonly">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" id="copyPathBtn">Copy file path</button>
                    </span>
                </div>
                <textarea class="form-control {{text.visible}}">{{text.content}}</textarea>
                <div id="mediaPlayer_wrapper" class="{{media.visible}}" style="position: relative; width: 640px; height: {{media.height}}">
                    <object width="100%" height="100%" type="application/x-shockwave-flash" data="/asset/js/jwplayer/player.swf" bgcolor="#000000" id="Object1" name="mediaPlayer" tabindex="0">
                        <param name="allowfullscreen" value="true">
                        <param name="allowscriptaccess" value="always">
                        <param name="seamlesstabbing" value="true">
                        <param name="wmode" value="opaque">
                        <param name="flashvars" value=";id=mediaPlayer&amp;file={{media.source}}&amp;screencolor=ffffff&amp;stretching=fill&amp;skin=%2Fasset%2Fjs%2Fjwplayer%2Fskin%2FViet.zip&amp;abouttext=Flash%20Player&amp;aboutlink=http%3A%2F%2Fgoogle.com%2F&amp;controlbar.idlehide=false">
                        <embed id="mediaPlayer" src="{{media.source}}">
                    </object>
                </div>
                <img src="{{image.source}}" class="{{image.visible}}" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary {{text.visible}}" ng-click="saveFile()" style="float: left">Save File</button>
                <button type="button" class="btn btn-danger" ng-click="deleteFile()" style="margin-left: auto; margin-right: auto;">Delete File</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
