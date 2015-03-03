<?php

namespace app\components;

class PhpMessageSource extends \yii\i18n\PhpMessageSource
{
    const MODULE_DELIMITER = '.';

    public $basePath = 'i18n';

    /**
     * @inheritdoc
     * Category mast be {module}.{dictionary} view.
     */
    protected function getMessageFilePath($category, $language)
    {
        $path = explode(self::MODULE_DELIMITER, $category);

        if (count($path) == 2) {
            $filePath = \Yii::getAlias("@app/modules/{$path[0]}/{$this->basePath}/{$language}/");
            $dictionary = $path[1];
        } else {
            $filePath = \Yii::getAlias("@app/{$this->basePath}/{$language}/");
            $dictionary = $path[0];
        }

        if (isset($this->fileMap[$dictionary])) {
            $filePath .= $this->fileMap[$dictionary];
        } else {
            $filePath .= str_replace('\\', '/', $dictionary) . '.php';
        }

        return $filePath;
    }
}