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
	 * 显示后台操作消息
	 * @param string $msg 错误消息
	 * @param mixed $go_url 显示后前往的URL
	 * @param int $autogo 自动转跳时间
	 */
	private function show_message($type = 'error', $msg = NULL, $go_url = NULL, $autogo = NULL) {
		if(is_array($go_url)) {
			array_walk($go_url, 'site_url');
		}else{
			$go_url = array('返回前页' => site_url($go_url));
		}
		if($autogo != NULL) {
			$redirect = current($go_url);
			$this->out->html_header("<meta http-equiv=\"refresh\"  content=\"{$autogo};url={$redirect}\" />");
		}
		$pdata = array(
			'golist' => $go_url,
			'msgtype' => $type,
			'msgstr' => $msg
		);
		$this->out->view('admin/other/message', $pdata);
		exit();
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
				redirect('admin/index');
			}else{
				echo $this->user->msg;
			}
		}else{
			$this->out->view('admin/index/login');
		}
	}

	/**
	 * 后台首页
	 */
	public function action_index() {
		if($this->user->check_admin()) {
			$this->out->view('admin/index/index');
		}else{
			redirect('admin/login');
		}
	}

	/*
	 * 后台欢迎页
	 */
	public function action_main() {
		$this->check_power();
		$this->out->view('admin/index/main');
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
		$this->out->view('admin/module/list', array('list' => $result));
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
			$data = array(
				'mod_name'		=> $this->in->post('name'),
				'mod_desc'		=> $this->in->post('desc'),
				'mod_class'		=> $this->in->post('class'),
				'mod_plugin'	=> $this->in->post('plugin'),
				'mod_manage'	=> $this->in->post('manage')
			);
			$this->db->set($data);
			if($mod_id == 0) {
				$this->db->insert('module');
			}else{
				$this->db->where('mod_id', $mod_id);
				$this->db->update('module');
			}
			$this->show_message('succeed', '保存成功!', 'admin/module_list', 3);
		}else{								//验证失败则显示表单
			if($mod_id != 0) {
				$this->db->where('mod_id', $mod_id);
				$query = $this->db->get('module');
				if($query->num_rows() != 1) {
					exit('要编辑的模型不存在或者已经删除.');
				}else{
					$module = $query->row_array();
				}
			}else{
				$module = array('mod_id' => 0);
			}
			$this->out->view('admin/module/modify', $module);
		}
	}

	/**
	 * 删除一个模型
	 */
	public function action_module_remove() {
		$this->check_power();
		$id = $this->in->get('id');
		$this->db->select('mod_is_system');
		$this->db->where('mod_id', $id);
		$query = $this->db->get('module');
		if($query->num_rows() != 1) {
			$this->show_message('error', '要删除的模型不存在或者已被删除.', 'admin/module_list', 3);
		}
		$result = $query->row();
		if(!empty($result->mod_is_system)) {
			$this->show_message('error', '您不能删除一个系统模型.', 'admin/module_list', 3);
		}
		$this->db->where('ch_modid', $id);
		if($this->db->count_all_results('channel') > 0) {
			$this->show_message('error', '系统中存在引用此模型的频道, 要删除此模型您必须先删除关联频道.', 'admin/module_list', 3);
		}
		$this->db->where('mod_id', $id);
		$this->db->delete('module');
		$this->show_message('succeed', '删除成功!', 'admin/module_list', 3);
	}

	//--------------------------------------------------
	//	频道管理部分
	//--------------------------------------------------

	/**
	 * 频道列表
	 */
	public function action_channel_list() {
		$this->check_power();
		$this->db->join('module', 'ch_modid = mod_id');
		$query = $this->db->get('channel');
		if($query->num_rows() == 0) {
			$result = NULL;
		}else{
			$result = $query->result_array();
		}
		$this->out->view('admin/channel/list', array('list' => $result));
	}

	/**
	 * 添加/编辑频道
	 */
	public function action_channel_modify() {
		$this->check_power();
		$chid = $this->in->get('id');
		if(empty($chid)) $chid = 0;
		if($this->form->run()) {

		}else{
			
		}
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
