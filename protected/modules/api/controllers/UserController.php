<?php
/**
 * Created by PhpStorm.
 * User: huangluyang
 * Date: 14-2-25
 * Time: 下午2:49
 */

class UserController extends RestController {
    // Actions
    public function actionList()
    {
//        $items = User::model()->findAll();

        $criteria = new CDbCriteria;
        $criteria->select = array('user_id', 'username', 'nickname', 'description', 'avator', 'type', 'credit_rate');  // 只选择 'title' 列
//        $criteria->condition='postID=:postID';
//        $criteria->params=array(':postID'=>10);
        $items=User::model()->findAll($criteria); // $params 不需要了

        if(empty($items))
        {
            $this->_sendResponse(200, 'No items');
        }
        else
        {
            $rows = array();
            foreach($items as $item)
                $rows[] = array(
                    'user_id'=>$item->user_id,
                    'username'=>$item->username,
                    'nickname'=>$item->nickname,
                    'description'=>$item->description,
                    'avator'=>$item->avator,
                    'type'=>$item->type,
                    'credit_rate'=>$item->credit_rate,
                );
            $this->_sendResponse(200, CJSON::encode($rows));
        }
    }

    public function actionView()
    {
        if(!isset($_GET['user_id']))
            $this->_sendError(400, 'user_id is missing' );
        $user = User::model()->findByPk($_GET['user_id']);
        if(is_null($user))
            $this->_sendResponse(404, 'No user found');
        else
            $this->_sendResponse(200, CJSON::encode($user));
    }

    public function actionCreate()
    {
        $username = $_POST['username'];
        $user = User::model()->find('username=:username', array(':username'=>$username));
        if(!is_null($user)) {
            $this->_sendError(500, 'The username is already exist.');
        }

        $user = new User;
        foreach($_POST as $var=>$value)
        {
            if($user->hasAttribute($var)) {
                $user->$var = $value;
            }
            else
                $this->_sendError(400, 'parameter require');
        }

        $user_id = $this->create_password().date('YmdHis');
        $user->user_id = $user_id;

        echo "user_id = ".$user->user_id."\n";
        echo "username = ".$user->username."\n";
        echo "password = ".$user->password."\n";
        if($user->save())
            $this->_sendResponse(200, CJSON::encode($user));
        else
            $this->_sendError(500, '');
    }

    public function actionUpdate()
    {
//        //获取 put 方法所带来的 json 数据
//        $json = file_get_contents('php://input');
//        $put_vars = CJSON::decode($json,true);

        $item = User::model()->findByPk($_POST['user_id']);

        if(is_null($item))
            $this->_sendResponse(404, 'No Item found');

        foreach($_POST as $var=>$value)
        {
            if($var == "user_id")
                continue;
            if($item->hasAttribute($var))
                $item->$var = $value;
            else
                $this->_sendError(400, 'Parameter Error');
        }

        if($item->save())
            $this->_sendResponse(200, CJSON::encode($item));
        else
            $this->_sendError(500, 'Could not Update Item');
    }

    public function actionDelete()
    {
    }
} 