<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 06/03/2017
 * Time: 10:37 AM
 */
class ReportsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post', 'except'=>array(

        )));
        $this->beforeFilter('auth', array('except' => array(

        )));
    }

    public function getClick(){
        $limit = 10;
        $p = Input::get('page',1);
        if($p<=1) $p=1;
        $cp = ($p-1)*$limit;
        $stpage = $p;


        $cond = array(
            'uid' => Auth::user()->_id
        );
        if(!empty(Input::get('start'))){
            $convertStartdate = DateTime::createFromFormat('d/m/Y', Input::get('start'))->format('Y-m-d');
            $cond['datecreate']['$gte'] = (int)strtotime($convertStartdate. ' 00:00:00');
        }
        if(!empty(Input::get('end'))){
            $convertEnddate = DateTime::createFromFormat('d/m/Y', Input::get('end'))->format('Y-m-d');
            $cond['datecreate']['$lte'] = (int)strtotime($convertEnddate. ' 23:59:59');
        }
        $allClick = AffClick::raw()->aggregate(array(
            array('$match' => $cond),
            array('$group' => array('_id'=>'$redirect', 'numclick'=>array('$sum'=>1))),
            array('$sort' => array('numclick'=>-1), '$limit'=>$limit, '$skip'=>$cp)
        ));
        print_r($allClick);die;

        return View::make('report.click', array(
            'allClick' => $allClick['result']
        ));
    }
}