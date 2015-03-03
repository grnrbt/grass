<?php
namespace app\commands;

use app\components\Migration;
use yii\console\Exception;
use yii\helpers\FileHelper;

class MigrateController extends \yii\console\controllers\MigrateController
{
    public $removeFromHistoryOnLostFile = true;

    public $data = Migration::TYPE_BASE;

    public $ignoreHistory = false;

    public $templateFile = '@app/views/migration.php';

    public $addModules = true;
    private $modulesList;

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

            if($this->addModules){
                $allModules = array_keys(\Yii::$app->modules);
                unset($allModules[array_search('gii', $allModules)]); // drop gii, todo make it smarter, maybe by some param
                array_unshift($allModules, ''); // added empty value for core migrations

                if(is_string($this->addModules)){
                    $this->modulesList = array_intersect($allModules, explode(',', $this->addModules));
                } else {
                    $this->modulesList = $allModules;
                }
            } else {
                $this->modulesList = [''];
            }

            return true;
        } else {
            return false;
        }
    }

    private function switchModule($module, $create = false)
    {
        if($module == ''){ // core
            // todo remove hardcode, use default
            $this->migrationPath = \Yii::getAlias('@app/migrations');
            $this->migrationTable = '{{%migration}}';
        } else {
            // todo get module path from config for duplicate modules
            $path = \Yii::getAlias('@app/modules/'. $module .'/migrations');
            if (!is_dir($path)) {
                if(!$create){
                    throw new Exception('Migration failed. Directory specified in migrationPath doesn\'t exist.');
                }
                FileHelper::createDirectory($path);
            }
            $this->migrationPath = $path;
            $this->migrationTable = '{{%'. $module .'_migration}}';
            echo "\n". $module .":\n";
        }
        return;
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
                'addModules',
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

    /**
     * @inheritdoc
     */
    public function actionUp($limit = 0)
    {
        if(count($this->modulesList) > 1 && !$this->confirm('Apply all ' . count($this->modulesList) . ' modules?')){
            return self::EXIT_CODE_NORMAL;
        }

        foreach ($this->modulesList as $module) {
            $this->switchModule($module);
            parent::actionUp($limit);
        }

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * @inheritdoc
     */
    public function actionDown($limit = 1)
    {
        if ($limit === 'all') {
            $limit = null;
        } else {
            $limit = (int) $limit;
            if ($limit < 1) {
                throw new Exception("The step argument must be greater than 0.");
            }
        }

        if(count($this->modulesList) > 1 && !$this->confirm('Revert all ' . count($this->modulesList) . ' modules?')){
            return self::EXIT_CODE_NORMAL;
        }

        foreach ($this->modulesList as $module) {
            $this->switchModule($module);
            parent::actionDown($limit);
        }

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * @inheritdoc
     */
    public function actionRedo($limit = 1)
    {
        if ($limit === 'all') {
            $limit = null;
        } else {
            $limit = (int) $limit;
            if ($limit < 1) {
                throw new Exception("The step argument must be greater than 0.");
            }
        }

        if(count($this->modulesList) > 1 && !$this->confirm('Redo all ' . count($this->modulesList) . ' modules?')){
            return self::EXIT_CODE_NORMAL;
        }

        foreach ($this->modulesList as $module) {
            $this->switchModule($module);
            parent::actionRedo($limit);
        }

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * @inheritdoc
     */
    public function actionTo($version)
    {
        foreach ($this->modulesList as $module) {
            $this->switchModule($module);
            parent::actionTo($version);
        }
    }

    /**
     * @inheritdoc
     */
    public function actionMark($version)
    {
        foreach ($this->modulesList as $module) {
            $this->switchModule($module);
            parent::actionMark($version);
        }
    }

    /**
     * @inheritdoc
     */
    public function actionHistory($limit = 10)
    {
        if ($limit === 'all') {
            $limit = null;
        } else {
            $limit = (int) $limit;
            if ($limit < 1) {
                throw new Exception("The limit must be greater than 0.");
            }
        }

        foreach ($this->modulesList as $module) {
            $this->switchModule($module);
            parent::actionHistory($limit);
        }
    }

    /**
     * @inheritdoc
     */
    public function actionNew($limit = 10)
    {
        foreach ($this->modulesList as $module) {
            $this->switchModule($module);
            parent::actionNew($limit);
        }
    }

    /**
     * @inheritdoc
     */
    public function actionCreate($name)
    {
        // if modules not set (default), or set to false|0, work by default, add to core
        if(!$this->addModules || $this->addModules === true){
            parent::actionCreate($name);
            return self::EXIT_CODE_NORMAL;
        }

        // set number of modules, throw error
        if(count($this->modulesList) > 1){
            throw new Exception('you must point one module or not point at all for core migrations');
        }

        $this->switchModule(reset($this->modulesList));
        parent::actionCreate($name);
        return self::EXIT_CODE_NORMAL;
    }
} 