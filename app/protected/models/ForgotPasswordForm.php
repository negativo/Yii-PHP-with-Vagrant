<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ForgotPasswordForm extends CFormModel
{
	public $email;
	

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('email', 'required'),
			array('email', 'email', 'message' => 'That is not a valid email address.'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Email Address',
		);
	}

	
}
