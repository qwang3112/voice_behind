<?php
namespace Home\Controller;

use Think\Controller;
class MessageController extends BaseController {

	/**
     * 发布新树洞接口
     * @return [type] [description]
     */
	public function publish_new_message(){

		//校验参数
		if(!$_POST['user_id']){
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：user_id';
        	$this->ajaxReturn($return_data);
        }

        if(!$_POST['username']){
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：username';
        	$this->ajaxReturn($return_data);
        }

        
        if(!$_POST['face_url']){
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：face_url';
        	$this->ajaxReturn($return_data);
        }

        if(!$_POST['content']){
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：content';
        	$this->ajaxReturn($return_data);
        }

        $Message = M('message');

        $data = array();
        $data['user_id'] = $_POST['user_id'];
        $data['username'] = $_POST['username'];
        $data['face_url'] = $_POST['face_url'];
        $data['content'] = $_POST['content'];
        $data['total_like'] = 0;
        $data['send_timestamp'] = time();

        $result = $Message->add($data);

        if($result){
        	$return_data = array();
        	$return_data['error_code'] = 0;
        	$return_data['msg'] = '发布树洞成功';
        	$this->ajaxReturn($return_data);
        } else {
        	$return_data = array();
        	$return_data['error_code'] = 2;
        	$return_data['msg'] = '发布树洞失败';
        	$this->ajaxReturn($return_data);
        }
	}

	/**
     * 获取所有树洞接口
     * @return [type] [description]
     */
	public function get_all_messages(){

		//实例化数据表
		$Message = M('message');

		//按时间倒序获取所有树洞
		$all_messages = $Message->order('id desc')->select();

		foreach ($all_messages as $key => $message) {
			$all_messages[$key]['send_timestamp'] = date('Y-m-d H:i:s', $message['send_timestamp']);
		}

		$return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '树洞获取成功';
        $return_data['data'] = $all_messages;
        $this->ajaxReturn($return_data);
	}

	/**
     * 获取指定用户树洞接口
     * @return [type] [description]
     */

	public function get_one_user_all_messages(){

		//校验参数
		if(!$_POST['user_id']){
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：user_id';
        	$this->ajaxReturn($return_data);
        }

        //实例化数据表
		$Message = M('message');

		$where = array();
		$where['user_id'] = $_POST['user_id'];

		//按时间倒序获取所有树洞
		$all_messages = $Message->order('id desc')->where($where)->select();

		foreach ($all_messages as $key => $message) {
			$all_messages[$key]['send_timestamp'] = date('Y-m-d H:i:s', $message['send_timestamp']);
		}

		$return_data = array();
        $return_data['error_code'] = 0;
        $return_data['msg'] = '树洞获取成功';
        $return_data['data'] = $all_messages;
        $this->ajaxReturn($return_data);
	}

	/**
     * 点赞接口
     * @return [type] [description]
     */

	public function do_like(){
		//校验参数
		if(!$_POST['message_id']){
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：message_id';
        	$this->ajaxReturn($return_data);
        }

        if(!$_POST['user_id']){
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：user_id';
        	$this->ajaxReturn($return_data);
        }

        //查看指定树洞是否存在

        $Message = M('message');
        $where = array();
        $where['id'] = $_POST['message_id'];

        $message = $Message->where($where)->find();

        if(!$message){
        	$return_data = array();
        	$return_data['error_code'] = 2;
        	$return_data['msg'] = '指定的数据查询不存在';
        	$this->ajaxReturn($return_data);
        } 

        $data = array();
        $data['total_like'] = $message['total_like'] + 1;

        $where = array();
        $where['id'] = $_POST['message_id'];

        $result = $Message->where($where)->save($data);

        if($result){
        	$return_data = array();
        	$return_data['error_code'] = 0;
        	$return_data['msg'] = '数据保存成功';
        	$return_data['data']['message_id'] = $_POST['message_id'];
        	$return_data['data']['total_like'] = $data['total_like'];
        	$this->ajaxReturn($return_data);
        } else {
        	$return_data = array();
        	$return_data['error_code'] = 3;
        	$return_data['msg'] = '数据保存失败';
        	$this->ajaxReturn($return_data);
        }
	}

	/**
     * 删除指定树洞接口
     * @return [type] [description]
     */
	public function delete_message(){
		//校验参数
		if(!$_POST['message_id']){
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：message_id';
        	$this->ajaxReturn($return_data);
        }

        if(!$_POST['user_id']){
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：user_id';
        	$this->ajaxReturn($return_data);
        }

        //查看指定树洞是否存在

        $Message = M('message');
        $where = array();
        $where['id'] = $_POST['message_id'];

        $message = $Message->where($where)->find();

        if(!$message){
        	$return_data = array();
        	$return_data['error_code'] = 2;
        	$return_data['msg'] = '指定的数据查询不存在';
        	$this->ajaxReturn($return_data);
        } 

        //删除树洞

        $result = $Message->where($where)->delete();

        if($result){
        	$return_data = array();
        	$return_data['error_code'] = 0;
        	$return_data['msg'] = '数据删除成功';
        	$return_data['data']['message_id'] = $_POST['message_id'];
        	$this->ajaxReturn($return_data);
        } else {
        	$return_data = array();
        	$return_data['error_code'] = 3;
        	$return_data['msg'] = '数据删除失败';
        	$this->ajaxReturn($return_data);
        }
	}
}
	