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
//        $limit = 10;
//        $p = Input::get('page',1);
//        if($p<=1) $p=1;
//        $cp = ($p-1)*$limit;
//        $stpage = $p;
        $cond = array(
            'uid' => Auth::user()->_id
        );
        $start = date('01/m/Y');
        $end = date('d/m/Y');
        if(!empty(Input::get('start'))){
            $start = Input::get('start');
        }
        if(!empty(Input::get('end'))){
            $end = Input::get('end');
        }
        $convertStartdate = DateTime::createFromFormat('d/m/Y', $start)->format('Y-m-d');
        $convertEnddate = DateTime::createFromFormat('d/m/Y', $end)->format('Y-m-d');
        $cond['datecreate'] = array(
            '$gte' => (int)strtotime($convertStartdate. ' 00:00:00'),
            '$lte' => (int)strtotime($convertEnddate. ' 23:59:59')
        );

        $clickByUrl = AffClick::raw()->aggregate(array(
            array('$match' => $cond),
            array('$group' => array('_id'=>'$redirect', 'numclick'=>array('$sum'=>1))),
            array('$sort' => array('numclick'=>-1)),
//            array('$limit' => $limit),
//            array('$skip' => $cp)
        ));
        $clickBySub = AffClick::raw()->aggregate(array(
            array('$match' => $cond),
            array('$group' => array('_id'=>'$sub_id', 'numclick'=>array('$sum'=>1))),
            array('$sort' => array('numclick'=>-1)),
//            array('$limit' => $limit),
//            array('$skip' => $cp)
        ));
//        print_r($allClick);die;

        return View::make('report.click', array(
            'clickByUrl' => $clickByUrl['result'],
            'clickBySub' => $clickBySub['result'],
            'start' => $start,
            'end' => $end
        ));
    }

    public function getUser(){
        $cond = array(
            'aff.uid' => Auth::user()->_id,
            'status' => Constant::STATUS_ENABLE
        );
        $start = date('01/m/Y');
        $end = date('d/m/Y');
        if(!empty(Input::get('start'))){
            $start = Input::get('start');
        }
        if(!empty(Input::get('end'))){
            $end = Input::get('end');
        }
        $convertStartdate = DateTime::createFromFormat('d/m/Y', $start)->format('Y-m-d');
        $convertEnddate = DateTime::createFromFormat('d/m/Y', $end)->format('Y-m-d');
        $cond['aff.datecreate'] = array(
            '$gte' => (int)strtotime($convertStartdate. ' 00:00:00'),
            '$lte' => (int)strtotime($convertEnddate. ' 23:59:59')
        );

        $allUser = User::where($cond)->paginate(20);
        return View::make('report.user',array(
            'allUser'=>$allUser,
            'start' => $start,
            'end' => $end
        ));
    }

    public function getTxn(){
        $cond = array(
            'uid' => Auth::user()->_id,
        );
        $start = date('01/m/Y');
        $end = date('d/m/Y');
        if(!empty(Input::get('start'))){
            $start = Input::get('start');
        }
        if(!empty(Input::get('end'))){
            $end = Input::get('end');
        }
        $convertStartdate = DateTime::createFromFormat('d/m/Y', $start)->format('Y-m-d');
        $convertEnddate = DateTime::createFromFormat('d/m/Y', $end)->format('Y-m-d');
        $cond['datecreate'] = array(
            '$gte' => (int)strtotime($convertStartdate. ' 00:00:00'),
            '$lte' => (int)strtotime($convertEnddate. ' 23:59:59')
        );
        $allTxn = AffTxn::where($cond)->orderBy('datecreate', 'asc')->paginate(20);
        return View::make('report.txn', array(
            'allTxn'=> $allTxn,
            'start' => $start,
            'end' => $end
        ));
    }
}