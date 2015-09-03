<?php

namespace app\modules\content\controllers;

use app\components\AdminController;
use app\modules\content\models\Content;
use yii\web\NotFoundHttpException;

class PageAdminController extends AdminController
{
    /**
     * {post} string slug
     * {post} bool is_active
     * {post} bool is_hidden
     * {post} int|null id_parent
     * {post} string menu_title
     * {post} int position
     * {post} int position
     *
     * @return Content|array
     */
    public function actionCreate()
    {
        $data = \Yii::$app->getRequest()->post();
        $page = new Content($data);
        return $page->save() ? $page : $page->getErrors();
    }

    /**
     * {post} string slug
     * {post} bool is_active
     * {post} bool is_hidden
     * {post} int|null id_parent
     * {post} string menu_title
     * {post} int position
     * {post} int position
     *
     * @param int $idPage
     * @return Content|array
     */
    public function actionUpdate($idPage)
    {
        $data = \Yii::$app->getRequest()->post();
        $page = $this->findPage($idPage);

        if ($page->load($data) && $page->save()) {
            return $page;
        } else {
            return $page->getErrors();
        }
    }

    /**
     * @param int $idPage
     * @return bool
     */
    public function actionDelete($idPage)
    {
        $page = $this->findPage($idPage);
        return $page->remove();
    }

    /**
     * @param $id
     * @return Content
     * @throws NotFoundHttpException
     */
    private function findPage($id)
    {
        $page = Content::find()->byId($id)->one();
        if (!$page) {
            throw new NotFoundHttpException;
        }
        return $page;
    }
}