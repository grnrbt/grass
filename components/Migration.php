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
        $fkName = $this->createFkName($table, $columns, $refTable, $refColumns, $cutName);

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
     * @param string|array $columns
     * @param bool $reduceLongName = true
     * @return string
     */
    protected function createIndexName($table, $columns, $reduceLongName = true)
    {
        if (!is_array($columns)) {
            if (strpos($columns, ',') !== false) {
                $columns = explode(',', $columns);
            } else {
                $columns = [$columns];
            }
        }

        $name = $this->db->schema->getRawTableName($table) . '_' . implode('_', $columns);

        if ($reduceLongName) {
            $name = $this->reduceLongConstraintName($name);
        }

        return $name;
    }

    /**
     * @param string $table
     * @param string|array $columns
     * @param string $refTable
     * @param string|array $refColumns
     * @param bool $reduceLongName = true
     * @return string
     * @throws Exception
     */
    protected function createFkName($table, $columns, $refTable, $refColumns, $reduceLongName = true)
    {
        if (!is_array($columns)) {
            if (strpos($columns, ',') !== false) {
                $columns = explode(',', $columns);
            } else {
                $columns = [$columns];
            }
        }
        if (!is_array($refColumns)) {
            if (strpos($refColumns, ',') !== false) {
                $refColumns = explode(',', $refColumns);
            } else {
                $refColumns = [$refColumns];
            }
        }

        $name = $this->db->schema->getRawTableName($table) . '_' . implode('_', $columns) .
            '_' .
            $this->db->schema->getRawTableName($refTable) . '_' . implode('_', $refColumns);

        if ($reduceLongName) {
            $name = $this->reduceLongConstraintName($name);
        }

        return $name;
    }

    /**
     * @param string $table
     * @param string|array $columns
     * @param string $refTable
     * @param string|array $refColumns
     * @param string $delete = null
     * @param string $update = null
     * @param bool $reduceLongName = true
     * @return array [name, table, columns, refTable, refColumns, delete, update]
     */
    protected function createFkData(
        $table,
        $columns,
        $refTable,
        $refColumns,
        $delete = null,
        $update = null,
        $reduceLongName = true
    ) {
        return [
            $this->createFkName($table, $columns, $refTable, $refColumns, $reduceLongName),
            $table,
            $columns,
            $refTable,
            $refColumns,
            $delete,
            $update
        ];
    }

    /**
     * @param string $table
     * @param string|array $columns
     * @param bool $unique = false
     * @param bool $reduceLongName = true
     * @return array [name, table, columns, unique]
     */
    protected function createIndexData($table, $columns, $unique = false, $reduceLongName = true)
    {
        return [
            $this->createIndexName($table, $columns, $reduceLongName),
            $table,
            $columns,
            $unique
        ];
    }

    /**
     * @param string $name
     * @param int $maxLength = self::MAX_FK_NAME_LENGTH  Max length in characters.
     * @return string
     */
    protected function reduceLongConstraintName($name, $maxLength = self::MAX_FK_NAME_LENGTH)
    {
        $length = strlen($name);
        if ($length > $maxLength) {
            $name = substr($name, $length - self::MAX_FK_NAME_LENGTH);
        }

        return $name;
    }
}