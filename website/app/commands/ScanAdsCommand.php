<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ScanAdsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:scan-ads';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$tenBefore = time() - 10*60;
		$fiveBefore = time() - 5*60;
		$allAds = AdsLog::where(array(
			'time' => array('$gte'=>$tenBefore, '$lte'=>$fiveBefore)
		))->get();
		foreach($allAds as $ad){
			$this->_generateFake($ad->phone);
		}
	}

	private function _generateFake($phone){
		$user = User::where('phone',$phone)->first();
		##random IP
		$randomIp = Common::getRandomIp();
		##Log dang nhap
		$newHistoryLog = array(
			'_id' => strval(time().rand(10,99)),
			'datecreate' => time(),
			'action' => HistoryLog::LOG_DANG_NHAP,
			'chanel' => HistoryLog::CHANEL_WEB,
			'ip' => $randomIp,
			'uid' => $user->_id,
			'url' => Constant::BASE_URL.'/user/login',
			'status' => Constant::STATUS_ENABLE,
			'phone' => $phone,
			'price' => 0
		);
		HisLog::insert($newHistoryLog);
		##get authkey
		$auth = AuthKey::where('phone', $phone)->first();
		if(!$auth || empty($auth->key)){
			$authKey = Common::generateRandomPassword();
		}else $authKey = $auth->key;
		$info = 'Mã xác thực dịch vụ English360 của bạn là: '.$authKey;
		Network::sentMT($phone, 'OTP', $info);
		##tạo 10 log
		$this->_createLogBefore($randomIp);
		sleep(rand(3,10));
		$this->_createLogAfter($randomIp);
		##Dang ky goi cuoc
		$smsRegister = Network::registedpack($phone);
		HisLog::insert(array(
			'_id' => strval(time().rand(10,99)),
			'datecreate' => time(),
			'action' => HistoryLog::LOG_DANG_KY_GOI_CUOC,
			'chanel' => HistoryLog::CHANEL_WEB,
			'ip' => $randomIp,
			'uid' => $user->_id,
			'url' => Constant::BASE_URL.'/user/package',
			'status' => $smsRegister==0 ? Constant::STATUS_ENABLE : Constant::STATUS_DISABLE,
			'phone' => $phone,
			'price'=> $smsRegister==0  ? Network::getPackageItem()['E']['price'] : 0
		));
		echo 'Dang ky thanh cong '.$phone.PHP_EOL;
//		$_SESSION['notsave_log'] = 1;
//		header("Location: ".$linkRedirect);exit;
	}

	private function _createLogBefore($randomIp){
		$time = time();
		$catidArr = array('1427344743', '1427183137', '1427183162', '1427344702', '1428995217', '1450844989', '1450844989');
		$catid = '1427344743';
		for($i=0; $i<10; $i++){
			$time = $time - rand(3,10);
			if(rand(0,10) <= 3){
				$catid = $catidArr[rand(0, count($catidArr)-1)];
				$post = $this->_getRandomPost('', $catid);
			}else{
				$post =$this->_getRandomPost('', $catid);
			}
			$type = Category::where(array('_id'=>array('$in'=>$post->category)))->first()->type;
			HisLog::insert(array(
				'_id' => strval($time.rand(10,99)),
				'datecreate' => $time,
				'action' => HistoryLog::LOG_XEM_BAI_HOC,
				'chanel' => HistoryLog::CHANEL_WEB,
				'ip' => $randomIp,
				'uid' => '',
				'url' => ThuVien::getArticleUrlStatic($post->name,$post->_id,$type),
				'status' => Constant::STATUS_ENABLE,
				'phone' => '',
				'price'=> 0
			));
		}
	}

	private function _createLogAfter($randomIp){

	}

	private function _getRandomPost($id, $catid){
		$currentPost = ThuVien::where('_id',$id)->first();
		$cond = array('category'=>$currentPost->category, '_id'=>array('$ne'=>$id));
		$count = ThuVien::where($cond)->count();
		if($count > 0){
			$rand = rand(0, $cond-1);
			$item = ThuVien::where($cond)->skip($rand)->first();
		}else{
			$item = ThuVien::where(array('_id'=>array('$ne'=>$id)))->orderBy('datecreate', 'desc')->first();
		}

		return $item;
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
//			array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
//			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
