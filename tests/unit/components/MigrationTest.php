<?php

namespace app\tests\unit\components;

use app\components\Migration;
use app\tests\unit\TestCase;

class MigrationTest extends TestCase
{
    public function testCreateIndexName()
    {
        $obj = new FakeMigration();
        $this->assertEquals($obj->createIndexName("tbl", "col"), "tbl_col");
        $this->assertEquals($obj->createIndexName("tbl", "col1,col2"), "tbl_col1_col2");
        $this->assertEquals($obj->createIndexName("tbl", ["col1", "col2"]), "tbl_col1_col2");

        $tbl = "tbl_1234567890_123456789_01234567890";
        $col1 = "col_1234567890_1234567890_1234567890";
        $col2 = "col_1234567890_1234567890_1234567890";
        $name = $obj->createIndexName($tbl, [$col1, $col2]);
        $this->assertLessThanOrEqual(strlen($name), Migration::MAX_FK_NAME_LENGTH);
    }

    public function createFkName()
    {
        $obj = new FakeMigration();

        $name = $obj->createFkName("tbl1", "col1", "tbl2", "col2");
        $this->assertEquals($name, "tbl1_col1__tbl2_col2");

        $name = $obj->createFkName("tbl1", "col1,col2", "tbl2", "col3,col4");
        $this->assertEquals($name, "tbl1_col1_col2__tbl2_col3_col4");

        $name = $obj->createFkName("tbl1", ["col1", "col2"], "tbl2", ["col3", "col4"]);
        $this->assertEquals($name, "tbl1_col1_col2__tbl2_col3_col4");

        $tbl = "tbl_1234567890_123456789_01234567890";
        $col1 = "col_1234567890_1234567890_1234567890";
        $tbl2 = "tbl_1234567890_123456789_01234567890";
        $col2 = "col_1234567890_1234567890_1234567890";
        $name = $obj->createFkName($tbl, $col1, $tbl2, $col2);
        $this->assertLessThanOrEqual(strlen($name), Migration::MAX_FK_NAME_LENGTH);
    }
}

class FakeMigration extends Migration
{
    public function createIndexName(...$args)
    {
        return parent::createIndexName(...$args);
    }

    public function createFkName(...$args)
    {
        return parent::createFkName(...$args);
    }

    public function getType()
    {
        return self::TYPE_STRUCT;
    }
}