<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 23/11/2016
 * Time: 11:54 AM
 */
class FreeLessionController
{
    public function index(){
        $item = Show::where('type', 'free_lession')->first();
        $list = $item->lession;
        $listLession = array();
        foreach($list as $aLession){
            $model = CommonHelpers::getModelFromType($aLession['type']);
            $lession = $model::where('_id', $aLession['id'])->first();
            if($lession){
                $cate = Common::getcategorytype($aLession['type']);
                $listLession[] = array(
                    'name' => $lession->name,
                    'url' => $lession->getDetailUrl($aLession['type']),
                    'avatar' => $lession->avatar,
                    'cate' => $cate['name']
                );
            }
        }

        $slide = array();
        $slide[] = isset($listLession[0]) ? $listLession[0] : null;
        $slide[] = isset($listLession[1]) ? $listLession[1] : null;
        $slide[] = isset($listLession[2]) ? $listLession[2] : null;
        unset($listLession[0],$listLession[1],$listLession[2]);

        return View::make('freelession.index', array(
            'firstLession' => $firstLession,
            'listLession' => $listLession
        ));
    }
}