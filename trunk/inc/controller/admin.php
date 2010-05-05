<?php if (!defined("IN_SYS")) die("Access Denied.");
/*
 * 后台管理控制器
 */

class ctrl_admin extends controller {
	public $form, $user;

	public function  __construct() {
		parent::__construct();
		$this->form =& load_class('form');
		$this->user =& load_class('user');
	}

	//--------------------------------------------------
	//	通用方法定义
	//--------------------------------------------------

	/**
	 * 用于权限检查
	 */
	private function check_power() {
		/*
		if(!$this->user->check_power('admin')) {
			$this->out->set_title('访问出错');
			$this->out->view('system/error', array('error_msg'=>$this->user->msg));
			exit();
		}
		*/
	}

	/**
	 * 后台默认页
	 */
	public function action_index() {
		if($this->user->check_admin()) {
			redirect('admin/main');
		}else{
			redirect('admin/login');
		}
	}

	//--------------------------------------------------
	//	后台基本部分
	//--------------------------------------------------

	/*
	 * 登录后台
	 */
	public function action_login() {
		if($this->form->run()) {
			$admin = $this->in->post('admin');
			$passwd = $this->in->post('passwd');
			$adminpass = $this->in->post('adminpass');
			if($this->user->login_admin($adminpass, $admin, $passwd)) {
				redirect('admin/main');
			}else{
				echo $this->user->msg;
			}
		}else{
			$this->out->view('admin/index/login');
		}
	}

	/*
	 * 后台首页
	 */
	public function action_main() {
		if(!$this->user->check_admin()) {
			$this->out->set_title($this->lang->get('pagetitle'));
			$this->out->view('system/error', array('error_msg'=>'您尚未登录,不能访问管理后台.'));
			return;
		}
		$this->out->view('admin/index/index');
	}

	//--------------------------------------------------
	//	模型管理部分
	//--------------------------------------------------

	/**
	 * 模型列表
	 */
	public function action_module_list() {
		$this->check_power();
		$query = $this->db->get_where('module');
		if($query->num_rows() == 0) {
			$result = NULL;
		}else{
			$result = $query->result_array();
		}
		$this->out->view('admin/module/list', array('modlist' => $result));
	}

	/**
	 * 添加/编辑一个模型
	 */
	public function action_module_modify() {
		$this->check_power();
		//取得要编辑的模块的ID
		$mod_id = $this->in->get('id');
		if(!is_numeric($mod_id)) $mod_id = 0;
		if($this->form->run()) {			//如果表单验证通过,则开始对提交的数据进行处理
			echo 'd';
		}elseif($this->form->is_post()){	//表单验证失败但是POST提交的,返回错误消息
			$msg = array(
				'result' => FALSE,
				'message' => $this->form->error_string(),
			);
			exit(json_encode($msg));
		}else{								//直接访问此控制器的动作, 要显示表单
			if($mod_id != 0) {
				$this->db->where('mod_id', $mod_id);
				$query = $this->db->get('module');
				if($query->num_rows() != 1) {
					exit('要编辑的模型不存在或者已经删除.');
				}else{
					$module = $query->result_array();
				}
			}else{
				$module = array('mod_id' => 0);
			}
			$this->out->view('admin/module/modify', $module[0]);
		}
	}

	/**
	 * 删除一个模型
	 */
	public function action_module_remove() {
		$this->check_power();
	}

	//--------------------------------------------------
	//	频道管理部分
	//--------------------------------------------------

	/**
	 * 频道列表
	 */
	public function action_channel_list() {
		$this->check_power();
	}

	/**
	 * 添加/编辑频道
	 */
	public function action_channel_modify() {
		$this->check_power();
	}

	/**
	 * 删除频道
	 */
	public function action_channel_remove() {
		$this->check_power();
	}

	/**
	 * 频道排序
	 */
	public function action_channel_order() {
		$this->check_power();
	}

	//--------------------------------------------------
	//	分类管理部分
	//--------------------------------------------------

	/**
	 * 分类列表
	 */
	public function action_category_list() {
		$this->check_power();
	}

	/**
	 * 添加/编辑分类
	 */
	public function action_category_modify() {
		$this->check_power();
	}

	/**
	 * 删除分类
	 */
	public function action_category_remove() {
		$this->check_power();
	}

	/**
	 * 排序分类
	 */
	public function action_category_order() {
		$this->check_power();
	}

	//--------------------------------------------------
	//	评论管理部分
	//--------------------------------------------------

	/**
	 * 取得内容列表
	 */
	public function action_content_list() {
		$this->check_power();
	}

	/**
	 * 添加/编辑内容
	 */
	public function action_content_modify() {
		$this->check_power();
	}

	/**
	 * 删除内容
	 */
	public function action_content_remove() {
		$this->check_power();
	}

	/**
	 * 批量更新内容
	 */
	public function action_content_update() {
		$this->check_power();
	}

	//--------------------------------------------------
	//	评论管理部分
	//--------------------------------------------------

	/**
	 * 评论列表
	 */
	public function  action_comment_list() {
		$this->check_power();
	}

	/**
	 * 编辑评论
	 */
	public function action_comment_modify() {
		$this->check_power();
	}

	/**
	 * 删除评论
	 */
	public function action_comment_remove() {
		$this->check_power();
	}

	/**
	 * 更新评论状态
	 */
	public function action_comment_update() {
		$this->check_power();
	}
}
