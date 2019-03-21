<?php
namespace app\admin\controller;

use think\Validate;

/**
 * 用户管理
 * User: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:54
 */
class User extends Controller
{
    /**
     * 用户列表
     * @return \think\response\View
     */
    function lists()
    {
        return view();
    }

    /**
     * 获取用户列表数据
     * @return \think\response\Json
     */
    function getList()
    {
        $page = input('page', 0);
        $limit = input('limit', 20);
        $map = array();
        $data = model('User')->getList($map, $page, $limit);
        $count = model('User')->countList($map);
        return ajax_list( $count,  $data);
    }

    /**
     * 添加、编辑页面
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function add()
    {
        $id = input('id');
        $data = array();
        if ($id) {
            $id = input('id');
            $data = model('User')->find($id);
        }
        $this->assign('data', $data);
        return view();
    }

    /**
     * 用户新增、编辑操作
     * @return \think\response\View
     */
    function save()
    {
        $rule = [
            ['user_name','require|max:25','用户名不能为空|用户名最多不能超过25个字符'],
            ['phone','regex:/^1[34578]{1}[0-9]{9}$/','手机格式错误'],
            ['email','email','邮箱格式错误']
        ];
        $validate = new Validate($rule);
        $post = $this->postData('post');
        if(!$validate->check($post)){
            return ajax_return(1, $validate->getError());
        }
        $id = input('id');
        $map = array();
        if($id) {
            $map['id'] = $id;
        }
        $result = model('User')->save($post, $map);
        if ($result) {
            return ajax_return(0, '保存成功', 'lists');
        } else {
            return ajax_return(1, '保存失败');
        }
    }

    /**
     * 删除用户
     * @return \think\response\Json
     */
    function delete()
    {
        $id = input('id' );
        $result = model('User')->deleteById($id);
        if($result) {
            return ajax_return(0, '删除成功');
        } else {
            return ajax_return(1, '删除失败');
        }
    }

}