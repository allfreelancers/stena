<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Category::find()
            ->joinWith('products')
            //->select(['categories.*', 'products.*'])
            ->groupBy('id')
        ;

        //$query->joinWith(['products' => function($query) { $query->from(['product' => 'users']); }]);

        $sort = new Sort([
            'defaultOrder' => [
                'id' => SORT_DESC,
            ],
//            'attributes' => [
//                'constituency',
////                'count' => [
////                    'asc' => 'products.name ASC',
////                    'desc' => 'products.name DESC',
////                ],
//            ],
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50
            ],
            //'sort' => $sort
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
                'attributes' => [
                    //'name',
                    //'products'
//                    'products' => [ // Example of a custom field not directly mapped to a column
////                        'asc' => 'products.name ASC',
////                        'desc' => 'products.name DESC',
//                    ],
                ]
            ]
        ]);

        $dataProvider->sort->attributes['products'] = [
            'asc' => [
                //new \yii\db\Expression("FIELD(login, 'finance', 'admin') DESC"),
                new \yii\db\Expression("products.name ASC"),
                //'id' => SORT_ASC,
            ],
            'desc' => [
                new \yii\db\Expression("products.name DESC"),
                //'id' => SORT_DESC,
            ],
            'label' => 'ID', // $searchModel->getAttributeLabel('id')
        ];

        $dataProvider->sort->defaultOrder = ['id' => SORT_ASC];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
