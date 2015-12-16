<?php

Yii::import('application.models._base.BaseUser');

class User extends BaseUser
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function checkHash( $password, $hash ) {
		return (crypt($password, $hash) == $hash);
	}
	
	
	public static function userHasAvatar($id){
		return file_exists(YiiBase::getPathOfAlias('webroot').'/images/avatars/' . $id . '.png');
	}
	
	public static function getPathToAvatar($id){
		if(User::userHasAvatar($id))
			return Yii::app()->baseUrl . '/images/avatars/' . $id . '.png';
		else
			return Yii::app()->baseUrl . '/images/avatars/no-image.png';
	}
	
	public function createHash( $password ) {
		$salt = '$2a$08$'.bin2hex(openssl_random_pseudo_bytes(22));
		return crypt($password, $salt);
	}
	
	public function relations() {
		return array(
				'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
		);
	}
	
	public function attributeLabels() {
		return array(
				'id' => Yii::t('app', 'ID'),
				'username' => Yii::t('app', 'Username'),
				'password' => Yii::t('app', 'Password'),
				'email' => Yii::t('app', 'Email'),
				'activationcode' => Yii::t('app', 'Activationcode'),
				'activated' => Yii::t('app', 'Activated'),
				'registration_date' => Yii::t('app', 'Registration Date'),
				'last_login_date' => Yii::t('app', 'Last Login Date'),
				'last_login_ip' => Yii::t('app', 'Last Login Ip'),
				'profile' => null,
		);
	}
	
	
}