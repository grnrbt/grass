<?php

namespace app\components;


abstract class Migration extends \yii\db\Migration
{
    const TYPE_STRUCT = 'struct';
    const TYPE_BASE = 'base';
    const TYPE_TEST = 'test';

    const MAX_FK_NAME_LENGTH = 64;

    /**
     * Return type of migration.
     *
     * @return string One of self::TYPE_* constants.
     */
    public abstract function getType();

    /**
     * Add foreign key with auto generating name.
     *
     * @param string $table
     * @param string $columns
     * @param string $refTable
     * @param string $refColumns
     * @param string $delete
     * @param string $update
     * @param bool $cutName =false If true - name would be cut to {#link static::$maxFkNameLength} chars.
     * @see http://dev.mysql.com/doc/refman/5.5/en/identifiers.html
     * @see \yii\db\Migration::addForeignKey()
     * @throws Exception
     */
    protected function addForeignKeyWithAutoNamed(
        $table,
        $columns,
        $refTable,
        $refColumns,
        $delete = null,
        $update = null,
        $cutName = false
    ) {
        $fkName = $this->generateFkName($table, $columns, $refTable, $refColumns, $cutName);

        $this->addForeignKey(
            $fkName,
            $table,
            $columns,
            $refTable,
            $refColumns,
            $delete,
            $update
        );
    }

    protected function generateFkName($table, $columns, $refTable, $refColumns, $cutName = false)
    {
        if (is_array($columns) || strpos($columns, ',') !== false) {
            throw new Exception(\Yii::t(
                'errors',
                'This method don\'t support multiple $columns. Use \yii\db\Migration::addForeignKey()'
            ));
        }
        if (is_array($refColumns) || strpos($refColumns, ',') !== false) {
            throw new Exception(\Yii::t(
                'errors',
                'This method don\'t support multiple $refColumns. Use \yii\db\Migration::addForeignKey()'
            ));
        }

        $name = $table . '_' . $columns . '_' . $refTable . '_' . $refColumns;
        $length = strlen($name);
        if ($cutName && ($length > self::MAX_FK_NAME_LENGTH)) {
            $name = substr($name, $length - self::MAX_FK_NAME_LENGTH);
        }

        return $name;
    }
}