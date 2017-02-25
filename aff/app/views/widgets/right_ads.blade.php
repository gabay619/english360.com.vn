<div class="block">
    <div class="heading2">
        <div class="title_heading2">
            <h2><a title="" href="javascript:void(0)">Follow us on Facebook</a></h2>
        </div>
    </div>
    @if(!Network::is3g() || !Network::is3gmobifone())
    <div class="row_2">
        <div class="fb-page" data-href="{{Constant::FACEBOOK_URL}}" data-width="318" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true">
            <div class="fb-xfbml-parse-ignore">
                <blockquote cite="{{Constant::FACEBOOK_URL}}"><a href="{{Constant::FACEBOOK_URL}}">Facebook</a></blockquote>
            </div>
        </div>
    </div>
    @endif
</div>