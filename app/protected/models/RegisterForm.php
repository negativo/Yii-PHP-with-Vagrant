<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegisterForm extends User {
	public $verifyPassword;
	public $verifyCode;
	public $termsAgreed;
	public $emailNewsLetter;
	public $emailUpdates;
	
	public function rules() {
		$rules = array(
			array('username, password, verifyPassword, termsAgreed, email, verifyCode', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => "Incorrect username (length between 3 and 20 characters)."),
			array('password, verifyPassword', 'length', 'max'=>20, 'min' => 4,'message' => "Incorrect password (minimal length 4 symbols)."),
			array('email', 'email'),
			array('verifyCode', 'captcha', 'on'=>'insert', 'message' => 'Incorrect Captcha entered.'),
			array('termsAgreed', 'boolean', 'falseValue'=>'true', 'message' =>'You must read and check "Terms & Conditions"'),
			array('emailNewsLetter', 'boolean'),
			array('emailUpdates', 'boolean'),
			array('username', 'unique', 'message' => "This user's name already exists."),
			array('email', 'unique', 'message' => "This user's email address already exists."),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => "Retype Password is incorrect."),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => "Incorrect symbols (A-z0-9)."),
		);
		
		return $rules;
	}
	
	public function attributeLabels() {
		return array(
				'username' => 'Username',
				'password' => 'Password',
				'emailNewsLetter' => 'Join Email Newsletter',
				'emailUpdates' => 'Receive Email Updates',				
				'verifyPassword' => 'Verify Password',
				'termsAgreed' => 'Terms & Conditions',
				'verifyCode' => 'Captcha',
				'email' => 'Email',
		);
	}
	
}