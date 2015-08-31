<?php
/**
 * This view is used by console/controllers/MigrateController.php
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name */

echo "<?php\n";
?>

use app\components\Migration;

class <?= $className ?> extends Migration
{
    /**
    * @inheritdoc
    */
    public function getType()
    {
        return self::TYPE_STRUCT;
    }

    /**
    * @inheritdoc
    */
    public function safeUp()
    {

    }

    /**
    * @inheritdoc
    */
    public function safeDown()
    {
        echo "<?= $className ?> cannot be reverted.\n";

        return false;
    }
}
