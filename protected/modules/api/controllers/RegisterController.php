<?php
/**
 * Created by PhpStorm.
 * User: huangluyang
 * Date: 14-2-25
 * Time: 下午6:22
 */

class RegisterController extends RestController {

    public function actionTest()
    {
        $this->_sendResponse(200, 'test');
    }

    public function actionIndex()
    {
        if(Yii::app()->request->isPostRequest) {

            if(isset($_POST['username'])) {
                $username = $_POST['username'];
                $exists = User::model()->exists('username=:username', array(':username'=>$username));
                if($exists) {
                    $this->_sendError(400, 'The username is already exist.');
                }
            } else {
                $this->_sendError(400, 'require param \"username\"!');
            }

            if(isset($_POST['email'])) {
                $email = $_POST['email'];
                if(!$this->isEmail($email)) {
                    $this->_sendError(400, 'email is invalid');
                }
                $exists = User::model()->exists('email=:email', array(':email'=>$email));
                if($exists) {
                    $this->_sendError(400, 'The email is already exist.');
                }
            }

            if(isset($_POST['phone'])) {
                $phoneNum = $_POST['phone'];
                if(strlen($phoneNum) != 11) {
                    $this->_sendError(400, 'phone number invalid');
                }
                $exists = User::model()->exists('phone=:phone', array(':phone'=>$phone));
                if($exists) {
                    $this->_sendError(400, 'The phone number is already exist.');
                }
            }

            if(!isset($_POST['password'])) {
                $this->_sendError(400,'require param \"password\"!');
            }

            if(!isset($_POST['email']) && !isset($_POST['phone'])) {
                $this->_sendError(400,'require param \"email\" or \"phone\"!');
            }

            $user = new User;
            foreach($_POST as $var=>$value)
            {
                if($user->hasAttribute($var)) {
                    $user->$var = $value;
                }
                else
                    $this->_sendError(400, 'parameter required');
            }

            if(is_null($user->nickname)) {
                $user->nickname = $user->username;
            }

            $user_id = $this->create_password().date('YmdHis');
            $user->user_id = $user_id;

            if($user->save()) {
                $this->_sendResponse(200, CJSON::encode($user));
            }
            else
                $this->_sendError(500, '');
        }
    }

    private  function isEmail($email){
        if(preg_match("/^[0-9a-zA-Z]+@(([0-9a-zA-Z]+)[.])+[a-z]{2,4}$/i",$email )) {
            return true;
        } else {
            return false;
        }
    }
} 