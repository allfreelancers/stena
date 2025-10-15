<?php

use app\models\Category;
use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
                    'attribute' => 'products',
                'label' => 'Products',
                'value' => function ($model) {
                    $products = Product::find()->where(['category_id' => $model->id])->orderBy(['name' => SORT_ASC])->all();

                    $aNames = [];
                    foreach ($products as $product) {
                        $aNames[] = $product->getName();
                    }

                    return \implode(', ', $aNames);
                },
                'class' => 'yii\grid\DataColumn',
                'sortLinkOptions' => [
                    ['class' => 'text-nowrap'],
                    null,
                ],
                'enableSorting' => true, // Позволяет сортировать по колонке 'name'
//                'class' => 'common\components\grid\CombinedDataColumn',
//                'labelTemplate' => '{0}  /  {1}',
//                'valueTemplate' => '{0}  /  {1}',
//                'labels' => [
//                    'Created At',
//                    '[ Updated At ]',
//                ],
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Category $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
