<?php
$this->pageTitle = 'Registration';

?>


<?php $this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
	'Register',
);
?>

<?php
    Yii::app()->clientScript->registerScript('helloscript',"
        $('#submitButton').click(function() {
  			$('#registration-form').submit();

        	$('#submitButton').attr('disabled', 'true');
			$('#submitButton').val('Please Wait...');
        	$('#submitButton').attr('readonly', 'true');

  			return false;
		});
    ",CClientScript::POS_READY);
?>



<h1>Register</h1>


<?php if(Yii::app()->user->hasFlash('register')): ?>
<div class="success">


<?php echo Yii::app()->user->getFlash('register'); ?>
</div>

<?php else: ?>

<div class="form small-6 columns">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('form','All fields are required');?></p>

	<div class="">
	<?php echo $form->label($model,'username'); ?><br />
	<?php echo $form->textField($model,'username'); ?><br />
	<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="">
	<?php echo $form->label($model,'password'); ?><br />
	<?php echo $form->passwordField($model,'password'); ?><br />
	<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="">
	<?php echo $form->label($model,'verifyPassword'); ?><br />
	<?php echo $form->passwordField($model,'verifyPassword'); ?><br />
	<?php echo $form->error($model,'verifyPassword'); ?>
	</div>

	<div class="">
	<?php echo $form->label($model,'email'); ?><br />
	<?php echo $form->textField($model,'email'); ?><br />
	<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="">
	<?php echo $form->label($model,'emailNewsLetter'); ?><br />
	<?php echo $form->checkBox($model, 'emailNewsLetter');?><br />
	<?php echo $form->error($model,'emailNewsLetter'); ?>

	</div>

	<div class="">
	<?php echo $form->label($model,'emailUpdates'); ?><br />
	<?php echo $form->checkBox($model, 'emailUpdates');?><br />
	<?php echo $form->error($model,'emailUpdates'); ?>

	</div>

	<div class="">
	<?php echo $form->label($model,'verifyCode'); ?><br />
	<?php $this->widget('CCaptcha', array('buttonOptions' => array('style' => 'display:block'))); ?>
    <?php echo CHtml::activeTextField( $model,'verifyCode', array('class'=>'captcha')); ?><br />
    <?php echo $form->error($model,'verifyCode'); ?>
	</div>

	<div class="">
	<?php echo $form->label($model,'termsAgreed'); ?><br />
	<?php echo $form->checkBox($model, 'termsAgreed');?>
	<?php echo 'I accept the ' . CHtml::link('Terms & Conditions', array('terms'));?>
	<?php echo $form->error($model,'termsAgreed'); ?>

	</div>

	<div class=" submit">
		<?php echo CHtml::submitButton("Register", array('id' => 'submitButton')); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<!-- form -->

<?php endif; ?>
