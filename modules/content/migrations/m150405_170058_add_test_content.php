<?php

use app\components\blocks\HtmlParamBlock;
use app\components\Migration;
use app\modules\content\models\beds\BedBlock;
use app\modules\content\models\beds\Bed;
use app\modules\content\models\Content;
use yii\helpers\Json;

class m150405_170058_add_test_content extends Migration
{
    private $bed;
    private $block;
    private $content;

    public function init()
    {
        parent::init();
        $this->bed = Bed::tableName();
        $this->block = BedBlock::tableName();
        $this->content = Content::tableName();
    }

    public function getType()
    {
        return self::TYPE_TEST;
    }

    public function safeUp()
    {
        // default main bed
        $this->insert($this->bed,            [
                'id' => 1,
                'is_default' => true,
            ]            );

        $this->insert($this->block, [
            'id' => 1,
            'id_bed' => 1,
            'position' => 0,
            'source' => HtmlParamBlock::class,
            'params' => Json::encode(['content' => 'Первый дефолтный блок']),
        ]);

        $this->insert($this->block, [
            'id' => 2,
            'id_bed' => 1,
            'position' => 10,
            'source' => HtmlParamBlock::class,
            'params' => Json::encode(['content' => 'Второй дефолтный блок']),
        ]);

        // index main bed
        $this->insert($this->bed,            [
                'id' => 2,
                'id_proto' => 1,
            ]        );

        $this->insert($this->block, [
            'id' => 3,
            'id_bed' => 2,
            'position' => 0,
            'source' => HtmlParamBlock::class,
            'params' => Json::encode(['content' => 'Главная страница, контент']),
        ]);

        $this->insert($this->content, [
            'id' => 1,
            'slug' => '',
            'ids_bed' => Json::encode(['main' => 2]),
            'menu_title' => '',
        ]);
    }

    public function safeDown()
    {
        $this->delete($this->bed, ['id' => [1, 2]]);
        $this->delete($this->block, ['id' => [1, 2, 3]]);
        $this->delete($this->content, ['id' => 1]);
    }
}
