<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendLessionCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:send-lession';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Gửi thông báo bài học mới qua email.';

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
		$diffTime = 600; //10min
		$time = time() - $diffTime;
		$allType = Common::getAllLessionType();
		foreach($allType as $key=>$val){
			$model = CommonHelpers::getModelFromType($key);
			$newLession = $model::where(array(
				'datecreate' => array('$gte'=>$time)
			))->get();
			$allUser = User::where(array(
				'reg_lession' => $key,
				'email' => array('$ne'=>''),
				'thongbao.email' => '1'
			))->get();
			foreach($newLession as $aLession){
				$related = (array)$model::where('_id', '!=', $aLession->_id)->orderBy('datecreate', 'desc')
					->limit(4)->get();
				foreach($allUser as $aUser){
					$this->_sendMail($aLession->name, $aLession->avatar, $aLession->captions, date('H:i d/m/Y', $aLession->datecreate), 'Bài hát', $related, $aUser->email);
				}
			}
		}
	}

	private function _sendMail($title, $avatar, $description, $time, $cate_name, $related, $to){
		include $_SERVER['DOCUMENT_ROOT'].'/mail/newLession.php';
		$mail = new \helpers\Mail($to,$subject,$body);
		echo $mail->send() ? date('H:i:s d/m/Y', time()).': Thanh cong|'.$cate_name.'|'.$to : date('H:i:s d/m/Y', time()).': That bai|'.$cate_name.'|'.$to;
		echo PHP_EOL;
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
