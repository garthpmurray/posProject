<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';
	public $layout = '//layouts/login';

	public function redirect($url,$terminate=true,$statusCode=302){
		if(is_array($url)){
			$route=isset($url[0]) ? $url[0] : '';
			$url=$this->createUrl($route,array_splice($url,1));
		}
		Yii::app()->getRequest()->redirect($url,$terminate,$statusCode);
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
	
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
					if (Yii::app()->getBaseUrl()."/index.php" === Yii::app()->user->returnUrl)
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login',array(
			    'model' => $model,
                'form' => new UserRecoveryForm,
            ));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = date('Y-m-d H:i:s');
		$lastVisit->save();
	}

}