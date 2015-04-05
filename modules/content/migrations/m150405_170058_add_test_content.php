<?php

use app\components\Migration;

class m150405_170058_add_test_content extends Migration
{
    private $bed;
    private $block;

    public function init()
    {
        parent::init();
        $this->bed = \app\modules\content\models\Bed::tableName();
        $this->block = \app\modules\content\models\BedBlock::tableName();
    }

    public function getType()
    {
        return self::TYPE_TEST;
    }

    public function safeUp()
    {
        // default main bed
        $this->insert($this->bed,
            [
                'id' => 1,
                'is_default' => true,
            ]
            );

        $this->insert($this->block, [
            'id' => 1,
            'id_bed' => 1,
            'position' => 0,
            'source' => \app\components\blocks\HtmlParamBlock::class,
            'params' => \yii\helpers\Json::encode(['content' => 'Первый дефолтный блок']),
        ]);

        $this->insert($this->block, [
            'id' => 2,
            'id_bed' => 1,
            'position' => 10,
            'source' => \app\components\blocks\HtmlParamBlock::class,
            'params' => \yii\helpers\Json::encode(['content' => 'Второй дефолтный блок']),
        ]);

        // index main bed
        $this->insert($this->bed,
            [
                'id' => 2,
                'id_proto' => 1,
            ]
        );

        $this->insert($this->block, [
            'id' => 3,
            'id_bed' => 2,
            'position' => 0,
            'source' => \app\components\blocks\HtmlParamBlock::class,
            'params' => \yii\helpers\Json::encode(['content' => 'Главная страница, контент']),
        ]);
    }

    public function safeDown()
    {
        $this->delete($this->bed, ['id' => [1, 2]]);
        $this->delete($this->block, ['id' => [1, 2, 3]]);
    }
}
