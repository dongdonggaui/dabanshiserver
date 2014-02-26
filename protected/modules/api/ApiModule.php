<?php

class ApiModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'api.models.*',
			'api.components.*',
		));

        // 这里设置访问有错误信息时的页面，返回的是 JSON 数据
        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'api/default/error',
            )
        ));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
