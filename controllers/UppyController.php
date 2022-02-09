<?php

class UppyController
{
    public function actionCreate()
    {
        $model = new $this->modelClass;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $model->save();
            Yii::$app->session->setFlash('success', $this->messageName . " created successfully");
            return $this->redirect(['index']);
        }

        return $this->render(['create'], [
            'model' => $model,
        ]);
    }

    public function actionUpload()
    {
        $model = new $this->modelClass;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) {
            $model->save();
            $this->uploadFiles($model);
        }
    }

    private function uploadFiles($model)
    {
        $files = UploadedFile::getInstancesByName('imageFiles');

        if (!empty($files)) {
            $newsImage = new NewsImage();
            $newsImage->imageFiles = $_FILES['imageFiles'];
            $newsImage->load($this->request->post());
            $this->upload($files, $model->id);
        }
    }

    public function upload($files, $modelID): bool
    {
        foreach ($files as $file) {
            $newsImage = new NewsImage();
            $newsImage->image = uniqid("", true) . '.' . $file->extension;
            $newsImage->news_id = $modelID;
            $file->saveAs(Yii::$app->params['uploadsDirectory'] . $this->folderName . '/' . $newsImage->image);
            $newsImage->save();
        }

        return true;
    }
}