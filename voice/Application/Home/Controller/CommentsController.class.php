<?php
namespace Home\Controller;

use Think\Controller;
class CommentsController extends BaseController {

	/**
     * 添加评论接口
     * @return [type] [description]
     */
	public function add_comments(){

		//校验参数
		
        if(!$_POST['message_id']){
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：message_id';
        	$this->ajaxReturn($return_data);
        }

        if(!$_POST['username']){
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '参数不足：username';
            $this->ajaxReturn($return_data);
        }


        
        if(!$_POST['comment']){
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：comment';
        	$this->ajaxReturn($return_data);
        }

        $Comments = M('comments');

        $data = array();
        $data['message_id'] = $_POST['message_id'];
        $data['username'] = $_POST['username'];
        $data['comment'] = $_POST['comment'];

        $result = $Comments->add($data);

        if($result){
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '评论成功';
            $return_data['data']['comment_id'] = $result;
            $return_data['data']['message_id'] = $_POST['message_id'];
            $return_data['data']['username'] = $_POST['username'];
            $return_data['data']['comment'] = $_POST['comment'];
            $this->ajaxReturn($return_data);

        } else {
            $return_data = array();
            $return_data['error_code'] = 2;
            $return_data['msg'] = '评论失败';
            $this->ajaxReturn($return_data);
        }
	}

    /**
     * 获取指定message_id的所有评论接口
     * @return [type] [description]
     */
    public function get_one_message_all_comments(){

        //实例化数据表
        $Comments = M('comments');


        $where['message_id'] = $_POST['message_id'];

        $all_comments = $Comments->where($where)->select();


        if($all_comments){
            $return_data = array();
            $return_data['error_code'] = 0;
            $return_data['msg'] = '获取评论成功';
            $return_data['data'] = $all_comments;
            $this->ajaxReturn($return_data);
        } else {
            $return_data = array();
            $return_data['error_code'] = 1;
            $return_data['msg'] = '获取评论失败';
            $this->ajaxReturn($return_data);
        }
        
    }
}
	