<?php

class UserController extends GxController
{


    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id, 'User'),
        ));
    }


		public function actionIndex() {
				$dataProvider = new CActiveDataProvider('User');
				$this->render('index', array(
						'dataProvider' => $dataProvider,
				));
		}


	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{

		if(Yii::app()->user->isGuest){
			Yii::app()->language = 'it';
			$model=new LoginForm;

			// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}

			// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
					$this->redirect(array('/site/index'));
			}

			// display the login form
			$this->render('login',array('model'=>$model));
		}else{
			$this->redirect(array('site/index'));
		}
	}

	/**
	 * Displays the forgot password page
	 */
	public function actionForgotPassword()
	{

		$model=new ForgotPasswordForm;

		// collect user input data

		if(isset($_POST['ForgotPasswordForm']))
		{

			$model->attributes=$_POST['ForgotPasswordForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate()){

				$user = User::model()->find('email = "' . $model->email . '"');
				if($user === null)
					$this->render('message', array('title' => 'Error', 'message' => 'There is no account with that email address.'));


				else{
					$password = $this->createRandomPassword();
					$user->password = $user->createHash($password);
					$user->save();
					if($this->emailNewPassword($password, $user))
						$this->render('message', array('title' => 'New Password Sent', 'message' => 'We have changed your password and emailed it to you.'));
					else
						$this->render('message', array('title' => 'Password Reset Error', 'message' => 'An error has occurred while resetting your password'));
				}
			}
			else
				$this->render('forgotpassword', array('model' => $model));



		}
		else
			$this->render('forgotpassword', array('model' => $model));
	}

	private function createRandomPassword() {

		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$pass = '' ;

		while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}

		return $pass;
	}

	/**
	 * Displays the login page
	 */
	public function actionRegister()
	{
		$model=new RegisterForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='register-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['RegisterForm']))
		{
			$model->attributes=$_POST['RegisterForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate()){
				$user = new User;
				$user->username = $model->username;
				$user->password = $user->createHash($model->password);

				$user->email = $model->email;

				//generate activation code
				$activationcode = $user->createHash($this->createRandomPassword());
				$user->activationcode = $activationcode;
				$user->activated = 0;
				$user->registration_date = new CDbExpression('NOW()');
				$user->last_login_date = new CDbExpression('NOW()');
				$user->last_login_ip = 'asdsa';//CHttpRequest::getUserHostAddress();
				if($user->save()){



					$profile = new Profile;
					$profile->user_id = $user->id;
					$profile->emailNewsLetter = $model->emailNewsLetter;
					$profile->emailUpdates = $model->emailUpdates;
					$profile->last_emailed = new CDbExpression('FROM_UNIXTIME(' . time() . ')');
					$profile->save();


					if(!$this->sendRegistrationEmail($user))
						$this->render('message', array('title' => 'Registration Error', 'message' => 'There was a problem during registration.'));
					else
						$this->render('message', array('title' => 'Account Registered', 'message' => 'You have successfully registered. You have been emailed an activation code. Sometimes it gets caught by the spam filter. I am working on that. If you dont see it, please check your junk/spam email box. I appreciate your patience.'));
				}
				else{
					$this->render('message', array('title' => 'Registration Error', 'message' => 'There was a problem during registration.'));
				}

			}
			else{
				$this->render('register',array('model'=>$model));
			}

			return null;

		}
		// display the login form
		$this->render('register',array('model'=>$model));
	}



	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionTerms(){
		$this->render('terms');

	}

	public function actionPrivacy(){
		$this->render('privacy');

	}

	public function actions()
	{
		return array(
				// captcha action renders the CAPTCHA image displayed on the contact page
				'captcha'=>array(
						'class'=>'CCaptchaAction',
						'backColor'=>0xFFFFFF,
				),
		);
	}

	public function emailNewPassword($password, $user){
		//message set up
		$toAddress = $user->email;
		$message = 	'
				<h1>Password Reset</h1>

				<p>Thank you for using .</p>
				<p>You have requested that your password be sent to you. Because even
				we can not see your password, it has been reset and is included here. </p>

				<p>New Password: ' . $password . '</p>

				<p>Please change your password to something private as soon as possible.</p>

				<p>Thank you very much for your cooperation. If you have any questions or concerns. Please email support@site.com</p>
				';
		$subject = 'Password Reset';
		$encryptedId = $user->activationcode;

		Util::sendTransactionalEmail($toAddress, $subject, $message, $encryptedId);
		return true;
	}

	public function sendRegistrationEmail($user){
		//message set up

		$linkstring = 'http://www.clearmindapp.com/user/activate?code=' . $user->activationcode;
		$toAddress = $user->email;
		$message = 	'
				<h1>Password Reset</h1>

				<p>Thank you for registering an account with .</p>

				<p>To verify that you are a real person, and not a computer program, we
					require that you click the link below to activate your account:</p>

				<p><a href="' . $linkstring . '">Activate Account</a></p>

				<p>Thank you very much for your cooperation. If you have any questions or concerns. Please email info@site.com</p>
				';
		$subject = 'Account Activation';
		$encryptedId = null;

		Util::sendTransactionalEmail($toAddress, $subject, $message, $encryptedId);
		return true;
	}



	public function actionActivate(){
		//validate input
		$user = User::model()->find('activationcode = "' . $_GET['code'] . '"');
		if($user === null)
			$this->render('message', array('title' => 'Error', 'message' => 'The emailed link is wrong. Please contact info@site.com'));
		else if($user->activated)
			$this->render('message', array('title' => 'Account Already Activated', 'message' => 'That account is already activated. You can log-in now.'));
		else if(strcmp($user->activationcode, $_GET['code']) == 0){

			//activate user
			$user->activated = true;
			$user->save();

			//inform user
			$this->render('message', array('title' => 'Account Activated', 'message' => 'Your account has been successfully activated.'));
		}
		else{
			$this->render('message', array('title' => 'Activation Error', 'message' => 'There was a problem activating your account.'));
		}


	}



}
