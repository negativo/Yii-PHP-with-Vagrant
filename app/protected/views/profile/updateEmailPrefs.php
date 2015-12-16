<?php
$this->pageTitle = 'Your Email Preferences';

?>


<h2>Email Preferences</h2>

<p>These are the email preferences for the address: <?php echo $email; ?></p>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data',),

)); ?>





	<div class="row">
	<?php echo $form->label($model,'emailNewsLetter'); ?><br />
	<?php echo $form->checkBox($model, 'emailNewsLetter');?><br />
	<?php echo $form->error($model,'emailNewsLetter'); ?>

	</div>

	<div class="row">
	<?php echo $form->label($model,'emailUpdates'); ?><br />
	<?php echo $form->checkBox($model, 'emailUpdates');?><br />
	<?php echo $form->error($model,'emailUpdates'); ?>

	</div>

	<div class="row">
	Receive email updates daily (as opposed to monthly):<br />
	<?php echo $form->checkBox($model, 'daily_emails');?><br />
	<?php echo $form->error($model,'daily_emails'); ?><br />
	Note: This option is irrelevant if you have selected to NOT receive any emails.

	</div>






	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>

<?php $this->endWidget(); ?>
