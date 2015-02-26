<?php
namespace app\commands;

use app\components\Migration;

class MigrateController extends \yii\console\controllers\MigrateController
{
    public $removeFromHistoryOnLostFile = true;

    public $data = Migration::TYPE_BASE;

    public $ignoreHistory = false;

    public $templateFile = 'app/views/migration.php';

    public function init()
    {
        parent::init();
        // data=test by default in local, test and stage environment
        if(defined('YII_ENV') && in_array(YII_ENV, ['dev', 'test', 'stage'])){
            $this->data = Migration::TYPE_TEST;
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if($this->data){
                if($this->data == Migration::TYPE_TEST){
                    echo 'Working with test data (structure + base data + test data)';
                } else {
                    echo 'Working with base data (structure + base data)';
                }
            } else {
                echo 'Working without data, only structure';
            }
            echo "\n";

            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function options($actionID)
    {
        return array_merge(
            parent::options($actionID),
            [
                'data',
                'removeFromHistoryOnLostFile',
                'ignoreHistory',
            ]
        );
    }

    /**
     * @inheritdoc
     */
    protected function migrateUp($class)
    {
        if ($class === self::BASE_MIGRATION) {
            return true;
        }

        $migration = $this->createMigration($class);

        if(!$migration){ // skip migration if file not found
            return true;
        }

        if(!$this->data || ($migration->getType() == Migration::TYPE_TEST && $this->data != Migration::TYPE_TEST)){
            $this->addMigrationHistory($class);
            return true;
        }

        parent::migrateUp($class);

        return true;
    }

    /**
     * @inheritdoc
     */
    protected function migrateDown($class)
    {
        if ($class === self::BASE_MIGRATION) {
            return true;
        }

        $migration = $this->createMigration($class);

        if(!$migration){ // skip migration if file not found
            return true;
        }

        if(!$this->data || ($migration->getType() == Migration::TYPE_TEST && $this->data != Migration::TYPE_TEST)){
            $this->removeMigrationHistory($class);
            return true;
        }

        parent::migrateDown($class);

        return true;
    }

    /**
     * @inheritdoc
     */
    protected function createMigration($class)
    {
        $file = $this->migrationPath . DIRECTORY_SEPARATOR . $class . '.php';
        if(file_exists($file)){
            require_once($file);

            return new $class();
        }
        if($this->removeFromHistoryOnLostFile){
            $this->removeMigrationHistory($class);
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    protected function getMigrationHistory($limit)
    {
        if($this->ignoreHistory){
            return [];
        }
        return parent::getMigrationHistory($limit);
    }
} 