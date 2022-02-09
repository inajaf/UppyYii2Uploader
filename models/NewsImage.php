<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class NewsImage extends ActiveRecord
{
    public $imageFile;
    public $imageFiles;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'news_image';
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