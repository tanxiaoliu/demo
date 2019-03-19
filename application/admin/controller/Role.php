<?php
namespace app\admin\controller;

/**
 * 角色管理
 * Role: tanhuaxin
 * Date: 2019/3/13
 * Time: 下午10:54
 */
class Role extends Controller
{
    /**
     * 角色列表
     * @return \think\response\View
     */
    function lists()
    {
        return view();
    }

    /**
     * 获取角色列表数据
     * @return \think\response\Json
     */
    function getList()
    {
        $page = input('page', 0);
        $limit = input('limit', 20);
        $map = array();
        $data = model('Role')->getList($map, $page, $limit);
        $count = model('Role')->countList($map);
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
            $data = model('Role')->find($id);
        }
        $this->assign('data', $data);
        return view();
    }

    /**
     * 角色新增、编辑操作
     * @return \think\response\View
     */
    function save()
    {
        $post = $this->postData('post');
        $id = input('id');
        $map = array();
        if($id) {
            $map['id'] = $id;
        }
        $result = model('Role')->save($post, $map);
        if ($result) {
            return ajax_return(0, '保存成功', 'lists');
        } else {
            return ajax_return(1, '保存失败');
        }
    }

    /**
     * 删除角色
     * @return \think\response\Json
     */
    function delete()
    {
        $id = input('id' );
        $result = model('Role')->deleteById($id);
        if($result) {
            return ajax_return(0, '删除成功');
        } else {
            return ajax_return(1, '删除失败');
        }
    }

}