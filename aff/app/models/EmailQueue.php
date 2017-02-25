<?php
use Jenssegers\Mongodb\Model as Eloquent;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 31/10/2016
 * Time: 10:18 AM
 */
class EmailQueue extends Eloquent {
    protected $collection = 'email_queue';
}