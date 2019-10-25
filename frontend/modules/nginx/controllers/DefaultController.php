<?php

namespace frontend\modules\nginx\controllers;

use yii\web\Controller;

/**
 * Default controller for the `nginx` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
