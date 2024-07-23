<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Attribute;

use Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Mvc4Wp\Core\Exception\ApplicationException;

#[CoversClass(Entry::class)]
#[CoversClass(AttributeTrait::class)]
class EntryTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new Entry('name');
        $this->assertNotNull($obj);
        $this->assertEquals('name', $obj->name);
    }

    public function test_getName01(): void
    {
        $obj = new EntryTestMockA();
        $this->assertEquals('mock_a', Entry::getName(EntryTestMockA::class));
    }

    public function test_accessible(): void
    {
        $attr = Entry::getClassAttribute(EntryTestMockA::class);
        $this->assertEquals('mock_a', $attr->name);
    }

    public function test_extends(): void
    {
        $attr = Entry::getClassAttribute(EntryTestMockA::class);
        $this->assertEquals('mock_a', $attr->name);
    }

    public function test_repeatedError(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\Entry" must not be repeated');
        Entry::getClassAttribute(EntryTestMockB::class);
    }

    public function test_illegalParameterError(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Unknown named parameter $hoge');
        Entry::getClassAttribute(EntryTestMockC::class);
    }

    public function test_notSet(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('"Mvc4Wp\Core\Model\Attribute\Entry" is not set to "Mvc4Wp\Core\Model\Attribute\EntryTestMockD"');
        Entry::getClassAttribute(EntryTestMockD::class);
    }
}

#[Entry(name: 'mock_a')]
class EntryTestMockA
{
}

#[Entry('a')]
#[Entry('b')]
class EntryTestMockB
{
}

#[Entry(hoge: 'a', fuga: 'b')]
class EntryTestMockC
{
}

class EntryTestMockD
{
}