<?php
$this->pageTitle = 'Forget Your Password?';

?>


<?php
    Yii::app()->clientScript->registerScript('helloscript',"
        $('#submitButton').click(function() {
  			$('#forgot-password-form').submit();

        	$('#submitButton').attr('disabled', 'true');
			$('#submitButton').val('Please Wait...');
        	$('#submitButton').attr('readonly', 'true');

  			return false;
		});
    ",CClientScript::POS_READY);
?>


<h1>Forgot Password?</h1>

<?php if(Yii::app()->user->hasFlash('forgotpassword')): ?>
	<div class="success">
		<?php echo Yii::app()->user->getFlash('forgotpassword'); ?>
	</div>

<?php else: ?>

	<p>Please fill out the following form with your login credentials:</p>

	<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'forgot-password-form',
	'enableAjaxValidation'=>false,
	)); ?>

	<div class="row">
	<?php echo $form->label($model,'email'); ?><br />
	<?php echo $form->textField($model,'email'); ?><br />
	<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row submit">
			<?php echo CHtml::submitButton('Send me a new password', array('id' => 'submitButton')); ?>
	</div>

	<?php $this->endWidget(); ?>
	</div>
<?php endif; ?>
