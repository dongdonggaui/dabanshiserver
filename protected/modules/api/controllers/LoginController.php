<?php
/**
 * Created by PhpStorm.
 * User: huangluyang
 * Date: 14-2-26
 * Time: 上午10:22
 */

class LoginController extends RestController {

    public function actionIndex() {
        if(Yii::app()->request->isPostRequest) {
            if(isset($_POST['username']) && isset($_POST['password'])) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                // 验证用户
                $exists = User::model()->exists('username=:username', array(':username'=>$username));
                if($exists) {
                    // 获取用户资料
                    $criteria = new CDbCriteria;
                    $criteria->select = array('user_id', 'username', 'password', 'description', 'address');
                    $criteria->condition = 'username=:username';
                    $criteria->params = array(':username'=>$username);
                    $user = User::model()->find($criteria);
                    if($password != $user->password) {
                        $this->_sendError(401, 'password is invalid');
                    }

                    // 验证成功，删除往期 token
                    Token::model()->deleteAll('user_id=:user_id', array(':user_id'=>$user->user_id));

                    // 获取 token
                    $tokenBase = $this->create_password().date('YmdHis').$this->create_password();
                    $token = md5($tokenBase);

                    // 存储 token
                    $tokenObj = new Token;
                    $tokenObj->token = $token;
                    $tokenObj->user_id = $user->user_id;
                    $expire_in = date('YmdHis', time() + 3*30*24*3600);
                    $tokenObj->expire_in = $expire_in;
                    if(!$tokenObj->save()) {
                        $this->_sendError(500, 'token write error');
                    }

                    // 返回响应
                    $response = array(
                        'token'=>$token,
                        'expire_in'=>$expire_in,
                        'user'=>array(
                            'user_id'=>$user->user_id,
                            'username'=>$user->username,
                            'description'=>$user->description,
                            'address'=>$user->address,
                        ),
                    );

                    $this->_sendResponse(200, CJSON::encode($response));
                } else {
                    $this->_sendError(404, 'User not found');
                }
            } else {
                $this->_sendError(400, 'param \'username\' and \'password\' required');
            }
        }
    }
} 