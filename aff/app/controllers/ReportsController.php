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

    public function getClick($type='url'){
        $limit = 20;
        $p = Input::get('page',1);
        if($p<=1) $p=1;
        $cp = ($p-1)*$limit;
        $stpage = $p;
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
        if($type=='url'){
            $clickByUrl = AffClick::raw()->aggregate(array(
                array('$match' => $cond),
                array('$group' => array('_id'=>'$redirect', 'numclick'=>array('$sum'=>1))),
                array('$sort' => array('numclick'=>-1)),
                array('$group' => array('_id'=>null,'total'=>array('$sum'=>1),'data'=>array('$push'=>'$$ROOT'))),
                array('$project' => array('total' => 1, 'data'=>array('$slice'=>array('$data',$cp,$limit))  )),
            ));
            return View::make('report.click_url', array(
                'clickByUrl' => isset($clickByUrl['result'][0]['data']) ? $clickByUrl['result'][0]['data'] : array(),
                'rowcount' => isset($clickByUrl['result'][0]['total']) ? $clickByUrl['result'][0]['total'] : 0,
                'stpage' => $stpage,
                'limit' => $limit,
                'start' => $start,
                'end' => $end
            ));
        }

        $clickBySub = AffClick::raw()->aggregate(array(
            array('$match' => $cond),
            array('$group' => array('_id'=>'$sub_id', 'numclick'=>array('$sum'=>1))),
            array('$sort' => array('numclick'=>-1)),
            array('$group' => array('_id'=>null,'total'=>array('$sum'=>1),'data'=>array('$push'=>'$$ROOT'))),
            array('$project' => array('total' => 1, 'data'=>array('$slice'=>array('$data',$cp,$limit))  )),
        ));

        return View::make('report.click_sub', array(
            'clickBySub' => isset($clickBySub['result'][0]['data']) ? $clickBySub['result'][0]['data'] : array(),
            'rowcount' => isset($clickBySub['result'][0]['total']) ? $clickBySub['result'][0]['total'] : 0,
            'stpage' => $stpage,
            'limit' => $limit,
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
        $allTxn = AffTxn::where($cond)->orderBy('datecreate', 'desc')->paginate(20);
        return View::make('report.txn', array(
            'allTxn'=> $allTxn,
            'start' => $start,
            'end' => $end
        ));
    }

    public function getHistory($uid){
        $user = User::where('_id',$uid)->first();
        if(!$user){
            return Redirect::to('/thong-bao.html')->with('error', 'User không tồn tại');
        }
        if(!isset($user->aff['uid']) || $user->aff['uid'] != Auth::user()->_id){
            return Redirect::to('/thong-bao.html')->with('error', 'Bạn không có quyền xem lịch sử sử dụng của user này');
//            return 'Bạn không có quyền xem lịch sử sử dụng của user này';
        }

        $cond = array(
            'uid' => $uid
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

        $allLog = HisLog::where($cond)->orderBy('datecreate','desc')->paginate(20);
        return View::make('report.history', array(
            'allLog'=> $allLog,
            'start' => $start,
            'end' => $end,
            'user' => $user
        ));
    }
}