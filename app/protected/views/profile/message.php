<?php
$this->pageTitle = 'Message';

?>


<?php
$this->pageTitle=Yii::app()->name . ' - ' . CHtml::encode($title);
?>

<h1><?php echo CHtml::encode($title);?></h1>

<p>
<?php echo CHtml::encode($message); ?>
</p>
