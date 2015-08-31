<?php

namespace app\components;

use yii\base\Exception;

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
    abstract public function getType();

    /**
     * @inheritdoc
     */
    public function addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete = null, $update = null)
    {
        $name = $this->clearConstraintName($name);
        parent::addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete, $update);
    }

    /**
     * @inheritdoc
     */
    public function dropForeignKey($name, $table)
    {
        $name = $this->clearConstraintName($name);
        parent::dropForeignKey($name, $table);
    }

    /**
     * @inheritdoc
     */
    public function createIndex($name, $table, $columns, $unique = false)
    {
        $name = $this->clearConstraintName($name);
        parent::createIndex($name, $table, $columns, $unique);
    }

    /**
     * @inheritdoc
     */
    public function dropIndex($name, $table)
    {
        $name = $this->clearConstraintName($name);
        parent::dropIndex($name, $table);
    }

    /**
     * @inheritdoc
     */
    public function addPrimaryKey($name, $table, $columns)
    {
        $name = $this->clearConstraintName($name);
        parent::addPrimaryKey($name, $table, $columns);
    }

    /**
     * @inheritdoc
     */
    public function dropPrimaryKey($name, $table)
    {
        $name = $this->clearConstraintName($name);
        parent:: dropPrimaryKey($name, $table);
    }

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
     * @deprecated
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

    /**
     * @param string $table
     * @param string $columns
     * @param string $refTable
     * @param string $refColumns
     * @param bool $cutLongName = true
     * @return string
     * @throws Exception
     */
    protected function generateFkName($table, $columns, $refTable, $refColumns, $cutLongName = true)
    {
        // TODO: add support of multiple columns.
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

        $name = $this->db->schema->getRawTableName($table) . '_' . $columns . '_' .
            $this->db->schema->getRawTableName($refTable) . '_' . $refColumns;
        $length = strlen($name);
        if ($cutLongName && ($length > self::MAX_FK_NAME_LENGTH)) {
            $name = substr($name, $length - self::MAX_FK_NAME_LENGTH);
        }

        return $name;
    }

    /**
     * Removes from name tablePrefix markers.
     *
     * @param string $name
     * @return string
     */
    private function clearConstraintName($name)
    {
        return str_replace(["{{%", "}}"], "", $name);
    }
}