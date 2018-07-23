<?php
/* @var $model array */

use yii\helpers\Html;

?>


<a href="<?= Html::encode($model['image_link']) ?>" title="<?= Html::encode($model['description']) ?>" target="_blank">
    <img src="<?= Html::encode($model['image_url']) ?>" alt="<?= Html::encode($model['author_name']) ?>">
</a>