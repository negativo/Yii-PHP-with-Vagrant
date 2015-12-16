<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class ChangePasswordForm extends User {
	public $verifyPassword;
	
	public function rules() {
		$rules = array(
			array('password, verifyPassword', 'required'),
			
			array('password', 'length', 'max'=>60, 'min' => 4,'message' => "Incorrect password (minimal length 4 symbols)."),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => "Retype Password is incorrect."),
		);
		
		return $rules;
	}
	
}