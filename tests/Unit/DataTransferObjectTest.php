<?php

namespace SchulzeFelix\DTO\Tests\Unit;

use PHPUnit_Framework_TestCase;
use SchulzeFelix\DTO\DataTransferObject;
use stdClass;

class DataTransferObjectTest extends PHPUnit_Framework_TestCase
{
    public function testAttributeManipulation()
    {
        $object = new DataTransferObjectStub;
        $object->name = 'foo';
        $this->assertEquals('foo', $object->name);
        $this->assertTrue(isset($object->name));
        unset($object->name);
        $this->assertFalse(isset($object->name));

        $object->list_items = ['name' => 'taylor'];
        $this->assertEquals(['name' => 'taylor'], $object->list_items);
    }

    public function testFillingJSONAttributes()
    {
        $model = new DataTransferObjectStub;
        $model->fill(['meta->name' => 'foo', 'meta->price' => 'bar', 'meta->size->width' => 'baz']);
        $this->assertEquals(
            ['meta' => json_encode(['name' => 'foo', 'price' => 'bar', 'size' => ['width' => 'baz']])],
            $model->toArray()
        );
        $model = new DataTransferObjectStub(['meta' => json_encode(['name' => 'Taylor'])]);
        $model->fill(['meta->name' => 'foo', 'meta->price' => 'bar', 'meta->size->width' => 'baz']);
        $this->assertEquals(
            ['meta' => json_encode(['name' => 'foo', 'price' => 'bar', 'size' => ['width' => 'baz']])],
            $model->toArray()
        );
    }

    public function testTimestampsAreReturnedAsObjects()
    {
        $object = new DataTransferObjectStub;
        $object->setRawAttributes([
            'created_at' => '2012-12-04',
            'updated_at' => '2012-12-05',
        ]);
        $this->assertInstanceOf('Carbon\Carbon', $object->created_at);
        $this->assertInstanceOf('Carbon\Carbon', $object->updated_at);
    }

    public function testTimestampsAreReturnedAsObjectsFromPlainDatesAndTimestamps()
    {
        $object = new DataTransferObjectStub;
        $object->setRawAttributes([
            'created_at' => '2012-12-04',
            'updated_at' => time(),
        ]);
        $this->assertInstanceOf('Carbon\Carbon', $object->created_at);
        $this->assertInstanceOf('Carbon\Carbon', $object->updated_at);
    }

    public function testModelAttributesAreCastedWhenPresentInCastsArray()
    {
        $object = new EloquentModelCastingStub;
        $object->setDateFormat('Y-m-d H:i:s');
        $object->intAttribute = '3';
        $object->floatAttribute = '4.0';
        $object->stringAttribute = 2.5;
        $object->boolAttribute = 1;
        $object->booleanAttribute = 0;
        $object->objectAttribute = ['foo' => 'bar'];
        $obj = new stdClass;
        $obj->foo = 'bar';
        $object->arrayAttribute = $obj;
        $object->jsonAttribute = ['foo' => 'bar'];
        $object->dateAttribute = '1969-07-20';
        $object->datetimeAttribute = '1969-07-20 22:56:00';
        $object->timestampAttribute = '1969-07-20 22:56:00';
        $this->assertInternalType('int', $object->intAttribute);
        $this->assertInternalType('float', $object->floatAttribute);
        $this->assertInternalType('string', $object->stringAttribute);
        $this->assertInternalType('boolean', $object->boolAttribute);
        $this->assertInternalType('boolean', $object->booleanAttribute);
        $this->assertInternalType('object', $object->objectAttribute);
        $this->assertInternalType('array', $object->arrayAttribute);
        $this->assertInternalType('array', $object->jsonAttribute);
        $this->assertTrue($object->boolAttribute);
        $this->assertFalse($object->booleanAttribute);
        $this->assertEquals($obj, $object->objectAttribute);
        $this->assertEquals(['foo' => 'bar'], $object->arrayAttribute);
        $this->assertEquals(['foo' => 'bar'], $object->jsonAttribute);
        $this->assertEquals('{"foo":"bar"}', $object->jsonAttributeValue());
        $this->assertInstanceOf('Carbon\Carbon', $object->dateAttribute);
        $this->assertInstanceOf('Carbon\Carbon', $object->datetimeAttribute);
        $this->assertEquals('1969-07-20', $object->dateAttribute->toDateString());
        $this->assertEquals('1969-07-20 22:56:00', $object->datetimeAttribute->toDateTimeString());
        $this->assertEquals(-14173440, $object->timestampAttribute);
        $arr = $object->toArray();
        $this->assertInternalType('int', $arr['intAttribute']);
        $this->assertInternalType('float', $arr['floatAttribute']);
        $this->assertInternalType('string', $arr['stringAttribute']);
        $this->assertInternalType('boolean', $arr['boolAttribute']);
        $this->assertInternalType('boolean', $arr['booleanAttribute']);
        $this->assertInternalType('object', $arr['objectAttribute']);
        $this->assertInternalType('array', $arr['arrayAttribute']);
        $this->assertInternalType('array', $arr['jsonAttribute']);
        $this->assertTrue($arr['boolAttribute']);
        $this->assertFalse($arr['booleanAttribute']);
        $this->assertEquals($obj, $arr['objectAttribute']);
        $this->assertEquals(['foo' => 'bar'], $arr['arrayAttribute']);
        $this->assertEquals(['foo' => 'bar'], $arr['jsonAttribute']);
        $this->assertEquals('1969-07-20 00:00:00', $arr['dateAttribute']);
        $this->assertEquals('1969-07-20 22:56:00', $arr['datetimeAttribute']);
        $this->assertEquals(-14173440, $arr['timestampAttribute']);
    }

    public function testModelAttributeCastingPreservesNull()
    {
        $model = new EloquentModelCastingStub;
        $model->intAttribute = null;
        $model->floatAttribute = null;
        $model->stringAttribute = null;
        $model->boolAttribute = null;
        $model->booleanAttribute = null;
        $model->objectAttribute = null;
        $model->arrayAttribute = null;
        $model->jsonAttribute = null;
        $model->dateAttribute = null;
        $model->datetimeAttribute = null;
        $model->timestampAttribute = null;
        $attributes = $model->getAttributes();
        $this->assertNull($attributes['intAttribute']);
        $this->assertNull($attributes['floatAttribute']);
        $this->assertNull($attributes['stringAttribute']);
        $this->assertNull($attributes['boolAttribute']);
        $this->assertNull($attributes['booleanAttribute']);
        $this->assertNull($attributes['objectAttribute']);
        $this->assertNull($attributes['arrayAttribute']);
        $this->assertNull($attributes['jsonAttribute']);
        $this->assertNull($attributes['dateAttribute']);
        $this->assertNull($attributes['datetimeAttribute']);
        $this->assertNull($attributes['timestampAttribute']);
        $this->assertNull($model->intAttribute);
        $this->assertNull($model->floatAttribute);
        $this->assertNull($model->stringAttribute);
        $this->assertNull($model->boolAttribute);
        $this->assertNull($model->booleanAttribute);
        $this->assertNull($model->objectAttribute);
        $this->assertNull($model->arrayAttribute);
        $this->assertNull($model->jsonAttribute);
        $this->assertNull($model->dateAttribute);
        $this->assertNull($model->datetimeAttribute);
        $this->assertNull($model->timestampAttribute);
        $array = $model->toArray();
        $this->assertNull($array['intAttribute']);
        $this->assertNull($array['floatAttribute']);
        $this->assertNull($array['stringAttribute']);
        $this->assertNull($array['boolAttribute']);
        $this->assertNull($array['booleanAttribute']);
        $this->assertNull($array['objectAttribute']);
        $this->assertNull($array['arrayAttribute']);
        $this->assertNull($array['jsonAttribute']);
        $this->assertNull($array['dateAttribute']);
        $this->assertNull($array['datetimeAttribute']);
        $this->assertNull($array['timestampAttribute']);
    }
}

class DataTransferObjectStub extends DataTransferObject
{
}

class EloquentModelCastingStub extends DataTransferObject
{
    protected $casts = [
        'intAttribute' => 'int',
        'floatAttribute' => 'float',
        'stringAttribute' => 'string',
        'boolAttribute' => 'bool',
        'booleanAttribute' => 'boolean',
        'objectAttribute' => 'object',
        'arrayAttribute' => 'array',
        'jsonAttribute' => 'json',
        'dateAttribute' => 'date',
        'datetimeAttribute' => 'datetime',
        'timestampAttribute' => 'timestamp',
    ];


    public function jsonAttributeValue()
    {
        return $this->attributes['jsonAttribute'];
    }
}
