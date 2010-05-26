<?php if(!defined('BASEPATH')) die('Access Denied');
/*-------------------------------------------------
 * FreeWMS - A Free Website Management System
 * Ver:0.1.0	Update: 2010-05-16
 * Home: http://code.google.com/p/freewms
 * Copyright 2010, FreeWMS Team, SOVO, Neusoft
 * Released under the New BSD Licenses
 *-------------------------------------------------*/
/**
 * 邮件组件
 */

class Email {

	//配置信息
	private $email_lib = 'socket';
	private $email_account = NULL;
	private $smtp_host = NULL;
	private $smtp_port = NULL;
	private $smtp_user = NULL;
	private $smtp_pass = NULL;
	private $email_format = "html";//邮件格式,html或者text
	private $email_charset = "utf-8"; //邮件字符集

	//邮件信息
	private $to = NULL; //收件人列表
	private $cc = NULL; //抄送列表
	private $from = NULL; //发件人
	private $subject = NULL;//邮件主题
	private $content = NULL;//邮件内容

	//返回消息
	public $msg = NULL;

	public function  __construct($param = NULL) {
		if($param == NULL) {
			$this->email_lib = Config::get('mail_lib');
			$this->email_account = Config::get('mail_account');
			$this->smtp_host = Config::get('mail_smtp_host');
			$this->smtp_port = Config::get('mail_smtp_port');
			$this->smtp_user = Config::get('mail_smtp_user');
			$this->smtp_pass = Config::get('mail_smtp_pass');
		}else{
			$this->email_lib = empty($param['lib']) ? 'socket' : $param['lib'];
			$this->email_account = $param['account'];
			$this->smtp_host = $param['smtp_host'];
			$this->smtp_port = $param['smtp_port'];
			$this->smtp_user = $param['smtp_user'];
			$this->smtp_pass = $param['smtp_pass'];
		}
		$this->email_format = empty($param['format']) ? 'html' : $param['format'];
		$this->email_charset = empty($param['charset']) ? 'utf-8' : $param['charset'];
		$this->from = $this->email_account;
	}

	/**
	 * 设置收件人
	 * @param mixed $addr 收件人地址或列表
	 * @param string $name 收件人名字
	 */
	public function set_to($addr, $name){
		$this->to = array(
			'email' => $addr,
			'name' => $name
		);
	}

	/**
	 * 设置抄送人列表
	 * @param mixed $addr
	 * @param string $name
	 */
	public function set_cc($addr) {
		if(is_array($addr)) {
			foreach($addr as $name => $email) {
				if(!$this->check_email($email)) continue;
				if(preg_match('/^[0-9]+$/i', $name)) {
					$this->set_cc($email);
				}
			}
		}else{
			$this->cc[] = $addr;
		}
	}

	/**
	 * 设置邮件标题
	 * @param string $str
	 */
	public function set_subject($str = NULL) {
		$this->subject = $str;
	}

	/**
	 * 设置发件人
	 * @param string $str
	 */
	public function set_from($str) {
		$this->from = $str;
	}

	/**
	 * 设置邮件内容
	 * @param string $str
	 */
	public function set_content($str) {
		$this->content = $str;
	}

	/**
	 * 发送邮件
	 * @return bool
	 */
	public function send() {
		if ($this->to == NULL) return FALSE;
		$header = "MIME-Version: 1.0\r\n";
		if ($this->email_format == "text") {
			$header .= "Content-Type: text/plain; charset=\"{$this->email_charset}\"\r\nContent-Transfer-Encoding: base64\r\n";
		}else{
			$header .= "Content-Type: text/html; charset=\"{$this->email_charset}\"\r\nContent-Transfer-Encoding: base64\r\n";
		}
		$header .= "To: \"{$this->to['name']}\"<{$this->to['email']}>\r\n";
		if ($this->cc != NULL)  $header .= "Cc: ".implode(',', $this->cc)."\r\n";
		$header .= "From: {$this->from}\r\n";
		if ($this->email_lib == "socket")  $header .= "Subject: ".$this->encodeheader($this->subject)."\r\n";
		$header .= "Date: ".date("r")."\r\n";
		$header .= "Message-ID: <".md5(SAFETY_STRING.date("r")).">\r\n";
		$header .= "X-Mailer:By FreeWMS (PHP/".phpversion().")";
		if ($this->email_lib == "socket") {
			if ($this->content) {
				$this->content = preg_replace('/^\./',"..",explode("\r\n",$this->content));
			}
			$arr_header = explode("\r\n", $header);
			$arr_smtp = array(
				array("EHLO {$this->smtp_host}\r\n","220,250","HELO error: "),
				array("AUTH LOGIN\r\n","334","AUTH error:"),
				array(base64_encode($this->smtp_user)."\r\n","334","AUTHENTIFICATION error : "),
				array(base64_encode($this->smtp_pass)."\r\n","235","AUTHENTIFICATION error : "),
				array("MAIL FROM: <{$this->from}>\r\n","250","MAIL FROM error: "),
				array("RCPT TO: <{$this->to['email']}>\r\n","250","RCPT TO error: "),
				array("DATA\r\n","354","DATA error: ")
			);
			foreach($arr_header as $header) {
				$arr_smtp[] = array($header."\r\n","","");
			}
			$arr_smtp[] = array("\r\n","","");
			if ($this->content) {
				foreach($this->content as $content) {
					$arr_smtp[] = array(base64_encode($content."\r\n")."\r\n","","");
				}
			}
			$arr_smtp[] = array(".\r\n","250","DATA(end)error: ");
			$arr_smtp[] = array("QUIT\r\n","221","QUIT error: ");
			$this->msg = NULL;
			$fsock = @fsockopen($this->smtp_host, $this->smtp_port);
			if (!$fsock) {
				$this->msg = "Cannot conect to smtp server.";
				return FALSE;
			}
			while ($result = @fgets($fsock, 1024)){
				if(substr($result,3,1) == " ") {
					break;
				}
			}
			foreach($arr_smtp as $request){
				@fputs($fsock, $request[0]);
				if($request[1]){
					while($result = @fgets($fsock, 1024)) {
						if(substr($result,3,1) == " ") {
							break;
						}

					};
					if (!strstr($request[1],substr($result,0,3))) {
						$this->msg .= $request[2].$result."\n";
					}
				}
			}
			@fclose($fsock);
			if ($this->msg == NULL) {
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return mail($this->to, $this->subject, base64_encode($this->content), $header);
		}
	}

	/**
	 * 检查email是否合法
	 * @param string $str
	 * @return bool
	 */
	private function check_email($str) {
		return (bool)preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str);
	}

	/**
	 * 编码头信息
	 * @param string $str
	 * @return string
	 */
	private function encodeheader($str) {
		return "=?" . $this->email_charset . "?B?" . base64_encode($str) . "?=";
	}
}

/* End of this file */