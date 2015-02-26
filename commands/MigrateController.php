<?php
namespace app\commands;

class MigrateController extends \yii\console\controllers\MigrateController
{
    public $removeFromHistoryOnLostFile = true;

    public $data = 'base';

    public $ignoreHistory = false;

    public function init()
    {
        parent::init();
        // data=test by default in local, test and stage environment
        if(defined('YII_ENV') && in_array(YII_ENV, ['dev', 'test', 'stage'])){
            $this->data = 'test';
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if($this->data){
                if($this->data == 'test'){
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

        // if migration has "data" property, apply migration only if parameter "data" not false (0)
        if($migration->hasProperty('data')){
            if (!$this->data) { // structure migrations only
                $this->addMigrationHistory($class);
                return true;
            }

            if($migration->data == 'test' && $this->data != 'test'){ // --data=base, default
                $this->addMigrationHistory($class);
                return true;
            }
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

        // if migration has "data" property, apply migration only if parameter "data" not false (0)
        if($migration->hasProperty('data')){
            if (!$this->data) { // structure migrations only
                $this->removeMigrationHistory($class);
                return true;
            }

            if($migration->data == 'test' && $this->data != 'test'){ // --data=base, default
                $this->removeMigrationHistory($class);
                return true;
            }
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