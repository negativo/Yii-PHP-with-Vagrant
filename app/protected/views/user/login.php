
<div class="row">


<div class="large-10 columns large-offset-1 loginBox centered">
	<div class="  large-12 columns">
		<h1 class="f-white">login</h1>

	</div>
	<div class="  large-12 columns ">
	<div class="row">
		<p><?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'login-form',
			'enableAjaxValidation'=>false,
		)); ?>
		<div class="large-12 columns">
			<label><?php echo $form->label($model,'username'); ?></label>
			<?php echo $form->textField($model,'username'); ?>
			<?php echo $form->error($model,'username'); ?>
		</div>

		<div class="large-12 columns">
			<label><?php echo $form->label($model,'password'); ?></label>
			<?php echo $form->passwordField($model,'password'); ?>
			<?php echo $form->error($model,'password'); ?>
		</div>

		<div class="large-12 columns rememberMe" >
			<label class="left"><?php echo $form->checkBox($model,'rememberMe'); ?></label>
			<span class="left"><?php echo $form->label($model,'rememberMe'); ?></span>
			<?php echo $form->error($model,'rememberMe'); ?>
		</div>

		<div class="large-12 columns">
			<?php echo CHtml::link('Forgot Password?', array('/user/forgotPassword'));?>
		</div>

		<div class="large-9 columns centered ">
			<?php echo CHtml::submitButton('Login',array('class'=>'button loginButton ') ); ?>
		</div>

	<?php $this->endWidget(); ?></p>
	</div></div><!-- form -->
</div></div>
<br/><br/><br/><br/><br/><br/><br/>
