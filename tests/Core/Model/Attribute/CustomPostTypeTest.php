<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Attribute;

use Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Mvc4Wp\Core\Exception\ApplicationException;

#[CoversClass(CustomPostType::class)]
#[CoversClass(AttributeTrait::class)]
class CustomPostTypeTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new CustomPostType('name', 'title');
        $this->assertNotNull($obj);
        $this->assertEquals('name', $obj->name);
        $this->assertEquals('title', $obj->title);
    }

    public function test_construct02(): void
    {
        $obj = new CustomPostType('name', ['en_US' => 'title', 'ja' => 'タイトル']);
        $this->assertNotNull($obj);
        $this->assertEquals('name', $obj->name);
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
        $obj = new CustomPostType('name', 'title');
        $this->assertEquals('title', $obj->getTitle());
    }

    public function test_getTitle02(): void
    {
        $obj = new CustomPostType('name', ['en_US' => 'title', 'ja' => 'タイトル']);
        $this->assertEquals('title', $obj->getTitle('en_US'));
    }

    public function test_getTitle03(): void
    {
        $obj = new CustomPostType('name', ['en_US' => 'title', 'ja' => 'タイトル']);
        $this->assertEquals('タイトル', $obj->getTitle('ja'));
    }

    public function test_getTitle04(): void
    {
        $obj = new CustomPostType('name', ['en_US' => 'title', 'ja' => 'タイトル']);
        $this->assertEquals('title', $obj->getTitle('en_GB'));
    }

    public function test_getTitle05(): void
    {
        $obj = new CustomPostType('name', []);
        $this->assertEquals('', $obj->getTitle('en_GB'));
    }

    public function test_accessible(): void
    {
        $attr = CustomPostType::getClassAttribute(CustomPostTypeTestMockA::class);
        $this->assertEquals('mock_a', $attr->name);
        $this->assertEquals('タイトルA', $attr->title);
    }

    public function test_extends(): void
    {
        $attr = PostType::getClassAttribute(CustomPostTypeTestMockA::class);
        $this->assertEquals('mock_a', $attr->name);
    }

    public function test_repeatedError(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\CustomPostType" must not be repeated');
        CustomPostType::getClassAttribute(CustomPostTypeTestMockB::class);
    }

    public function test_illegalParameterError(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Unknown named parameter $hoge');
        CustomPostType::getClassAttribute(CustomPostTypeTestMockC::class);
    }

    public function test_notSet(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('"Mvc4Wp\Core\Model\Attribute\CustomPostType" is not set to "Mvc4Wp\Core\Model\Attribute\CustomPostTypeTestMockD"');
        CustomPostType::getClassAttribute(CustomPostTypeTestMockD::class);
    }
}

#[CustomPostType(name: 'mock_a', title: 'タイトルA')]
class CustomPostTypeTestMockA
{
}

#[CustomPostType('a')]
#[CustomPostType('b')]
class CustomPostTypeTestMockB
{
}

#[CustomPostType(hoge: 'a', fuga: 'b')]
class CustomPostTypeTestMockC
{
}

class CustomPostTypeTestMockD
{
}