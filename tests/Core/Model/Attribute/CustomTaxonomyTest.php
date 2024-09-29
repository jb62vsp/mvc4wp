<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Attribute;

use Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Mvc4Wp\Core\Exception\ApplicationException;

#[CoversClass(CustomTaxonomy::class)]
#[CoversClass(AttributeTrait::class)]
class CustomTaxonomyTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new CustomTaxonomy('name', 'title', ['target1']);
        $this->assertNotNull($obj);
        $this->assertEquals('name', $obj->name);
        $this->assertEquals('title', $obj->title);
        $this->assertEquals('target1', $obj->targets[0]);
        $this->assertEquals(1, count($obj->targets));
    }

    public function test_construct02(): void
    {
        $obj = new CustomTaxonomy('name', ['en_US' => 'title', 'ja' => 'タイトル'], ['target1']);
        $this->assertNotNull($obj);
        $this->assertEquals('name', $obj->name);
        $this->assertIsArray($obj->title);
        $this->assertCount(2, $obj->title);
        $this->assertArrayHasKey('en_US', $obj->title);
        $this->assertEquals('title', $obj->title['en_US']);
        $this->assertEquals('title', current(array_slice($obj->title, 0, 1, true)));
        $this->assertArrayHasKey('ja', $obj->title);
        $this->assertEquals('target1', $obj->targets[0]);
        $this->assertEquals(1, count($obj->targets));
    }

    public function test_getTitle01(): void
    {
        $obj = new CustomTaxonomy('name', 'title', []);
        $this->assertEquals('title', $obj->getTitle());
    }

    public function test_getTitle02(): void
    {
        $obj = new CustomTaxonomy('name', ['en_US' => 'title', 'ja' => 'タイトル'], []);
        $this->assertEquals('title', $obj->getTitle('en_US'));
    }

    public function test_getTitle03(): void
    {
        $obj = new CustomTaxonomy('name', ['en_US' => 'title', 'ja' => 'タイトル'], []);
        $this->assertEquals('タイトル', $obj->getTitle('ja'));
    }

    public function test_getTitle04(): void
    {
        $obj = new CustomTaxonomy('name', ['en_US' => 'title', 'ja' => 'タイトル'], []);
        $this->assertEquals('title', $obj->getTitle('en_GB'));
    }

    public function test_getTitle05(): void
    {
        $obj = new CustomTaxonomy('name', [], []);
        $this->assertEquals('', $obj->getTitle('en_US'));
    }

    public function test_accessible(): void
    {
        $attr = CustomTaxonomy::getClassAttribute(CustomTaxonomyTestMockA::class);
        $this->assertEquals('mock_a', $attr->name);
        $this->assertEquals('タイトルA', $attr->title);
        $this->assertEquals('post_a', $attr->targets[0]);
        $this->assertEquals(1, count($attr->targets));
    }

    public function test_extends(): void
    {
        $attr = CustomTaxonomy::getClassAttribute(CustomTaxonomyTestMockA::class);
        $this->assertEquals('mock_a', $attr->name);
    }

    public function test_repeatedError(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\CustomTaxonomy" must not be repeated');
        CustomTaxonomy::getClassAttribute(CustomTaxonomyTestMockB::class);
    }

    public function test_illegalParameterError(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Unknown named parameter $hoge');
        CustomTaxonomy::getClassAttribute(CustomTaxonomyTestMockC::class);
    }

    public function test_notSet(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('"Mvc4Wp\Core\Model\Attribute\CustomTaxonomy" is not set to "Mvc4Wp\Core\Model\Attribute\CustomTaxonomyTestMockD"');
        CustomTaxonomy::getClassAttribute(CustomTaxonomyTestMockD::class);
    }
}

#[CustomTaxonomy(name: 'mock_a', title: 'タイトルA', targets: ['post_a'])]
class CustomTaxonomyTestMockA
{
}

#[CustomTaxonomy('a')]
#[CustomTaxonomy('b')]
class CustomTaxonomyTestMockB
{
}

#[CustomTaxonomy(hoge: 'a', fuga: 'b')]
class CustomTaxonomyTestMockC
{
}

class CustomTaxonomyTestMockD
{
}