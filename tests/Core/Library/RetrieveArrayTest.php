<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RetrieveArray::class)]
class RetrieveArrayTest extends TestCase
{
    public function test_get_emptyArray(): void
    {
        $actual = RetrieveArray::get([], ['hoge']);
        $this->assertNull($actual);
    }

    public function test_get_emptyKey(): void
    {
        $actual = RetrieveArray::get(['hoge' => 'HOGE'], []);
        $this->assertNull($actual);
    }

    public function test_get_singleArraySingleKey(): void
    {
        $actual = RetrieveArray::get([
            'hoge' => 'HOGE',
        ], [
            'hoge',
        ]);
        $this->assertEquals('HOGE', $actual);
    }

    public function test_get_nextedArrayMultiKeys(): void
    {
        $actual = RetrieveArray::get([
            'hoge' => [
                'fuga' => [
                    'piyo' => 'PIYO',
                ],
            ],
        ], [
            'hoge',
            'fuga',
            'piyo',
        ]);
        $this->assertEquals('PIYO', $actual);
    }

    public function test_get_noEdgeKey(): void
    {
        $actual = RetrieveArray::get([
            'hoge' => [
                'fuga' => [
                    'piyo' => 'PIYO',
                ],
            ],
        ], [
            'hoge',
            'fuga',
            'buz',
        ]);
        $this->assertNull($actual);
    }

    public function test_get_noBranchKey(): void
    {
        $actual = RetrieveArray::get([
            'hoge' => [
                'fuga' => [
                    'piyo' => 'PIYO',
                ],
            ],
        ], [
            'hoge',
            'bar',
            'buz',
        ]);
        $this->assertNull($actual);
    }

    public function test_set_emptyArray(): void
    {
        $actual = RetrieveArray::set([], ['hoge'], 'Hoge');
        $this->assertNull($actual);
    }

    public function test_set_emptyKey(): void
    {
        $actual = RetrieveArray::set(['hoge' => 'HOGE'], [], 'Hoge');
        $this->assertNull($actual);
    }

    public function test_set_singleArraySingleKey(): void
    {
        $actual = RetrieveArray::set([
            'hoge' => 'HOGE',
        ], [
            'hoge',
        ], 'Hoge');
        $this->assertEquals([
            'hoge' => 'Hoge',
        ], $actual);
    }

    public function test_set_nextedArrayMultiKeys(): void
    {
        $actual = RetrieveArray::set([
            'hoge' => [
                'fuga' => [
                    'piyo' => 'PIYO',
                ],
            ],
        ], [
            'hoge',
            'fuga',
            'piyo',
        ], 'Piyo');
        $this->assertEquals([
            'hoge' => [
                'fuga' => [
                    'piyo' => 'Piyo',
                ],
            ],
        ], $actual);
    }

    public function test_set_noEdgeKey(): void
    {
        $actual = RetrieveArray::set([
            'hoge' => [
                'fuga' => [
                    'piyo' => 'PIYO',
                ],
            ],
        ], [
            'hoge',
            'fuga',
            'buz',
        ], 'Buz');
        $this->assertEquals([
            'hoge' => [
                'fuga' => [
                    'piyo' => 'PIYO',
                    'buz' => 'Buz',
                ],
            ],
        ], $actual);
    }

    public function test_gset_noBranchKey(): void
    {
        $actual = RetrieveArray::set([
            'hoge' => [
                'fuga' => [
                    'piyo' => 'PIYO',
                ],
            ],
        ], [
            'hoge',
            'bar',
            'buz',
        ], 'Buz');
        $this->assertEquals([
            'hoge' => [
                'fuga' => [
                    'piyo' => 'PIYO',
                ],
                'bar' => [
                    'buz' => 'Buz',
                ],
            ],
        ], $actual);
    }
}