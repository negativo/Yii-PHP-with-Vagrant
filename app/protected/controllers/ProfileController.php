<?php

class ProfileController extends Controller
{

	public function init()
	{
		$uri = Yii::app()->baseUrl . '/css/profile.css';
		Yii::app()->clientScript->registerCssFile($uri, 'screen, projection');
		return parent::init();
	}

	public function filters()
	{
		return array( 'accessControl' ); // perform access control for CRUD operations
	}

	public function accessRules()
	{
		return array(
				array('allow', // allow authenticated users to access all actions
						'users'=>array('@'),
				),

				array('allow',
						'actions'=>array('emailPreferences'),
						'users'=>array('*'),
				),
				array('deny'),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionIndex()
	{
		$user = User::model()->with('profile')->findByPk(Yii::app()->user->id);

		$this->render('index',array('model'=>$user));
	}



	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{

		$model=User::model()->findByPk(Yii::app()->user->id);
		$profile = $model->profile;

		if(isset($_POST['User']) && isset($_POST['Profile']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes = $_POST['Profile'];

			if($_FILES['avatar']['name'] != ""){
				$newImage = $this->resizeAndConvertImage($_FILES['avatar']['tmp_name']);
				imagepng($newImage, YiiBase::getPathOfAlias('webroot') . '/images/avatars/' . $model->id . '.png');
			}
			elseif($_POST['clear'] == 'true')
				$this->clearAvatar();

			if($model->validate() && $profile->validate()){
				$model->save();
				$profile->save();
				$this->redirect(array('index','id'=>$model->id));
			}
			else{
				$this->render('update',array(
						'model'=>$model, 'profile' => $profile
				));
			}

		}

		$this->render('update',array(
				'model'=>$model, 'profile' => $profile
		));
	}

	function resizeAndConvertImage($srcFile, $maxSize = 100) {
		list($width_orig, $height_orig, $type) = getimagesize($srcFile);

		// Get the aspect ratio
		$ratio_orig = $width_orig / $height_orig;

		$width  = $maxSize;
		$height = $maxSize;

		// resize to height (orig is portrait)
		if ($ratio_orig < 1) {
			$width = $height * $ratio_orig;
		}
		// resize to width (orig is landscape)
		else {
			$height = $width / $ratio_orig;
		}

		return Util::imageToPNG($srcFile, $type);

	}

	public function actionChangePassword()
	{
	    $model = new ChangePasswordForm;

	    if(isset($_POST['ChangePasswordForm']))
	    {

	        $model->attributes=$_POST['ChangePasswordForm'];
	        if($model->validate())
	        {
	        	//change password
	        	$user = User::model()->findByPk(Yii::app()->user->id);
	        	$user->password = $user->createHash($model->password);
	            $user->save();

	            //inform user
	            $this->render('message', array('title' => 'Password Changed', 'message' => 'You have successfully changed your password.'));

	            return;
	        }
	    }
	    $this->render('changePassword',array('model'=>$model));
	}

	public function actionEmailPreferences($cd){


	$user = User::model()->find('activationcode = \'' . $cd . '\'');
	$profile= $user->profile;

	if(isset($_POST['Profile'])){

		$profile->emailNewsLetter = $_POST['Profile']['emailNewsLetter'];
		$profile->emailUpdates = $_POST['Profile']['emailUpdates'];
		$profile->daily_emails = $_POST['Profile']['daily_emails'];

		$profile->save();
		$this->render('message', array('title' => 'Email Preferences Changed', 'message' => 'You have successfully changed your email preferences.'));
		return;
	}



	$this->render('updateEmailPrefs', array('model' =>$profile, 'email' => $user->email));

	}


}
