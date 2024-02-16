<?php declare(strict_types=1);
namespace System\Models;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use System\Exception\ApplicationException;

#[CoversClass(Bindable::class)]
class BindableTest extends TestCase
{
    public function test_construct01(): void
    {
        $obj = new Bindable();
        $this->assertNotNull($obj);
    }

    public function test_getBindableFields01(): void
    {
        $fields = Bindable::getBindableFields(BindableTestMockA::class);
        $this->assertCount(1, $fields);
    }

    public function test_getBindableFieldNames01(): void
    {
        $names = Bindable::getBindableFieldNames(BindableTestMockA::class);
        $this->assertCount(1, $names);
        $this->assertEquals('field_a', $names[0]);
    }
}

class BindableTestMockA
{
    #[Bindable]
    public string $field_a;

    public string $field_b;

    #[Bindable]
    private string $field_c;

    #[Bindable]
    protected string $field_d;
}

class BindableTestMockB
{
    #[Bindable]
    #[Bindable]
    public string $field_a;

    #[Bindable(hoge: 'hoge', fuga: 'fuga')]
    public string $field_b;
}