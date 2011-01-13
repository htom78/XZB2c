<?php

class DefaultController extends DashController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}