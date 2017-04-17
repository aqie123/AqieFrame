<?php

/**
 * ajax聊天室
 * Class ChatController
 */
class ChatController extends Controller {
    // 显示聊天室首页
    public function indexAction(){
        // 获取成员数据，并在首页显示

        // 从session 中读取用户名
//        $username = isset($_SESSION['user']['user_name']) ? $_SESSION['user']['user_name']: '游客'; 这个会出bug

         if (isset($_SESSION['user']['user_name'])){
             $username = $_SESSION['user']['user_name'];
        };
        //获取数据库中所有用户
        $userModel =  new HomeModel('user');
        $users = $userModel->showAll();
        include CUR_VIEW_PATH ."chatroom.html";
    }

    // 从数据库获取聊天信息
    public function getmsgAction(){
        $maxId = $_GET['maxId'];
        $messagemodel = new MessageModel('message');
        $res = $messagemodel->showAll("id>'{$maxId}'",PDO::FETCH_ASSOC);
        // 将二维数组信息，通过json格式提供
       // $res = json_encode($res);
//        这里放弃使用message函数
        if($res){
             //var_dump($res);die;
            echo json_encode($res);
        }

    }

    /**
     * 将提交的信息存进数据库
     */
    public function savemsgAction(){

//        var_dump($_POST);
//        die;

        // 实例化模型
        $messageModel = new MessageModel('message');
        // 没有接收者默认所有人
        $_POST['receiver'] = empty($_POST['receiver']) ? '所有人': $_POST['receiver'];
        // 发送内容为空
        if(!$_POST['msg']){
            $this->message(array('message'=>'请输入信息','status'=>0));
            return;
        }
        // 载入辅助函数
        $this->helper('input');
        // 批量实体转移
        $data = deepspecialchars($_POST);
        // 批量单引号转译
        $data = deepslashes($data);
        $data['add_time'] = date('Y-m-d H:i:s',time());
        if($messageModel->insert($data)){
            $this->message(array('message'=>'','status'=>1));
            die;
        }else{
            $this->message(array('message'=>'数据插入失败失败','status'=>0));
            die;
        }
    }
}