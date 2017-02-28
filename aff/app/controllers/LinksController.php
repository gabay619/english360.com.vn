<?php

class LinksController extends \BaseController {

    public function getNew(){
        return View::make('link.new');
    }
}