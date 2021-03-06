<?php

class ApiModule extends CWebModule {
	public function init() {
		$this->setImport(array(
			'api.components.*',
		));
		// $this->setViewPath(Yii::getPathOfAlias('application.views.api'));
		Yii::app()->errorHandler->errorAction = 'api/default/error';
	}

	public function beforeControllerAction($controller, $action) {
		$controller->setIsAjaxRequest(true);
		if (parent::beforeControllerAction($controller, $action)) {
			return true;
		} else {
			return false;
		}
	}
}
