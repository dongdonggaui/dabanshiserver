<?php

class DefaultController extends RestController
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            $this->_sendError($error['code'],$error['message']);
        }
    }
}