<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Attribute;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CustomField::class)]
#[CoversClass(AttributeTrait::class)]
class CustomFieldTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new CustomField('title', 'int');
        $this->assertNotNull($obj);
        $this->assertEquals('title', $obj->title);
        $this->assertEquals('int', $obj->type);
    }

    public function test_construct02(): void
    {
        $obj = new CustomField(['en_US' => 'title', 'ja' => 'タイトル']);
        $this->assertNotNull($obj);
        $this->assertIsArray($obj->title);
        $this->assertCount(2, $obj->title);
        $this->assertArrayHasKey('en_US', $obj->title);
        $this->assertEquals('title', $obj->title['en_US']);
        $this->assertEquals('title', current(array_slice($obj->title, 0, 1, true)));
        $this->assertArrayHasKey('ja', $obj->title);
        $this->assertEquals('タイトル', $obj->title['ja']);
        $this->assertEquals('タイトル', current(array_slice($obj->title, 1, 1, true)));
    }

    public function test_getTitle01(): void
    {
        $obj = new CustomField(['en_US' => 'title', 'ja' => 'タイトル']);
        $this->assertEquals('title', $obj->getTitle('en_US'));
    }

    public function test_getTitle02(): void
    {
        $obj = new CustomField(['en_US' => 'title', 'ja' => 'タイトル']);
        $this->assertEquals('タイトル', $obj->getTitle('ja'));
    }

    public function test_getTitle03(): void
    {
        $obj = new CustomField(['en_US' => 'title', 'ja' => 'タイトル']);
        $this->assertEquals('title', $obj->getTitle('en_GB'));
    }

    public function test_getTitle04(): void
    {
        $obj = new CustomField([]);
        $this->assertEquals('', $obj->getTitle('en_US'));
    }
}
