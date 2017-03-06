<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 04/03/2017
 * Time: 11:26 AM
 */
use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: CHINHNC
 * Date: 11/18/2015
 * Time: 5:17 PM
 */
class Aff extends Eloquent
{
    protected $collection = 'aff';

    public function user(){
        return User::where('_id', $this->uid)->first();
    }
}
