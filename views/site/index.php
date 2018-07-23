<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = 'My Yii Application';
?>

<div class="site-index">

    <?= \yii\widgets\ListView::widget([
        'id' => 'masonry_item_container',
        'dataProvider' => $dataProvider,
        'itemView' => 'index_item',
        'layout' => "{items}\n{pager}",
        'emptyText' => '',
        'options' => [
            'class' => 'item_container',
        ],
        'itemOptions' => [
            'class' => 'item',
        ],
    ]) ?>

</div>


<?php
if (!Yii::$app->request->get('keyword')) {
    return true;
}


$siteIndexCss = <<< CSS
.item_container {
  box-sizing: border-box;
}

.item_container:after {
  content: '';
  display: block;
  clear: both;
}

.item {
  width: 22%;
  /*padding: 10px;  */
  margin: 6px auto;
  float: left;
  background: #e4e4e4;
  border-radius: 5px;
}

.item img {
    max-width: 100%;
}
CSS;


$currentUrl = \yii\helpers\Url::current();

$siteIndexJs = <<< JS
var item_container = $(".item_container").masonry({
    // options
    itemSelector: ".item",
    //columnWidth: ".sizer",
    percentPosition: true,
    gutter: 10
});

// get Masonry instance
var msnry = item_container.data("masonry");

// init Infinite Scroll
item_container.infiniteScroll({
  path: function() {
    return "$currentUrl&page=" + ( this.loadCount + 2 );
  },
  append: ".item",
  outlayer: msnry,
  prefgill: false
});

// item_container.on( 'request.infiniteScroll', function( event, path ) {
//   console.log( 'Loading page: ' + path );
// });

JS;

$this->registerCss($siteIndexCss);
$this->registerJs($siteIndexJs);
$this->registerJsFile('https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js', ['depends' => \yii\bootstrap\BootstrapAsset::className()]);
$this->registerJsFile('https://unpkg.com/infinite-scroll@3/dist/infinite-scroll.pkgd.min.js', ['depends' => \yii\bootstrap\BootstrapAsset::className()]);
