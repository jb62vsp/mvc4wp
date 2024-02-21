<?php declare(strict_types=1);
namespace Mvc4Wp\System\Library;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(Cast::class)]
class CastTest extends TestCase
{
    /*
     * -------- is --------
     */

    public function test_is_same(): void
    {
        $this->assertTrue(CastTestMockUse::is(new CastTestMockUse()));
        $this->assertTrue((new CastTestMockUse())::is(new CastTestMockUse()));
        $this->assertTrue((new CastTestMockUse())->is(new CastTestMockUse()));

        $this->assertTrue(CastTestMockUse::is(CastTestMockUse::class));
        $this->assertTrue((new CastTestMockUse())::is(CastTestMockUse::class));
        $this->assertTrue((new CastTestMockUse())->is(CastTestMockUse::class));
    }

    public function test_is_diff(): void
    {
        $this->assertFalse(CastTestMockUse::is(new stdClass()));
        $this->assertFalse(CastTestMockUse::is(stdClass::class));
        $this->assertFalse((new CastTestMockUse())->is(new stdClass()));
        $this->assertFalse((new CastTestMockUse())->is(stdClass::class));
    }

    public function test_is_parentUseChildUse(): void
    {
        $this->assertTrue(CastTestMockParentUse::is(new CastTestMockParentUseChildUse()));
        $this->assertTrue((new CastTestMockParentUse())::is(new CastTestMockParentUseChildUse()));
        $this->assertTrue((new CastTestMockParentUse())->is(new CastTestMockParentUseChildUse()));

        $this->assertTrue(CastTestMockParentUse::is(CastTestMockParentUseChildUse::class));
        $this->assertTrue((new CastTestMockParentUse())::is(CastTestMockParentUseChildUse::class));
        $this->assertTrue((new CastTestMockParentUse())->is(CastTestMockParentUseChildUse::class));

        $this->assertTrue(CastTestMockParentUseChildUse::is(new CastTestMockParentUse()));
        $this->assertTrue((new CastTestMockParentUseChildUse())::is(new CastTestMockParentUse()));
        $this->assertTrue((new CastTestMockParentUseChildUse())->is(new CastTestMockParentUse()));
    }

    public function test_is_parentUseChildUnuse(): void
    {
        $this->assertTrue(CastTestMockParentUse::is(new CastTestMockParentUseChildUnuse()));
        $this->assertTrue((new CastTestMockParentUse())::is(new CastTestMockParentUseChildUnuse()));
        $this->assertTrue((new CastTestMockParentUse())->is(new CastTestMockParentUseChildUnuse()));

        $this->assertTrue(CastTestMockParentUse::is(CastTestMockParentUseChildUnuse::class));
        $this->assertTrue((new CastTestMockParentUse())::is(CastTestMockParentUseChildUnuse::class));
        $this->assertTrue((new CastTestMockParentUse())->is(CastTestMockParentUseChildUnuse::class));

        $this->assertTrue(CastTestMockParentUseChildUnuse::is(new CastTestMockParentUse()));
        $this->assertTrue((new CastTestMockParentUseChildUnuse())::is(new CastTestMockParentUse()));
        $this->assertTrue((new CastTestMockParentUseChildUnuse())->is(new CastTestMockParentUse()));
    }

    public function test_is_parentUnuseChildUse(): void
    {
        $this->assertTrue(CastTestMockParentUnuseChildUse::is(new CastTestMockParentUnuse()));
        $this->assertTrue((new CastTestMockParentUnuseChildUse())::is(new CastTestMockParentUnuse()));
        $this->assertTrue((new CastTestMockParentUnuseChildUse())->is(new CastTestMockParentUnuse()));

        $this->assertTrue(CastTestMockParentUnuseChildUse::is(CastTestMockParentUnuse::class));
        $this->assertTrue((new CastTestMockParentUnuseChildUse())::is(CastTestMockParentUnuse::class));
        $this->assertTrue((new CastTestMockParentUnuseChildUse())->is(CastTestMockParentUnuse::class));
    }

    /*
     * -------- equals --------
     */

    public function test_equals_same(): void
    {
        $this->assertTrue(CastTestMockUse::equals(new CastTestMockUse()));
        $this->assertTrue((new CastTestMockUse())::equals(new CastTestMockUse()));
        $this->assertTrue((new CastTestMockUse())->equals(new CastTestMockUse()));

        $this->assertTrue(CastTestMockUse::equals(CastTestMockUse::class));
        $this->assertTrue((new CastTestMockUse())::equals(CastTestMockUse::class));
        $this->assertTrue((new CastTestMockUse())->equals(CastTestMockUse::class));
    }

    public function test_equals_diff(): void
    {
        $this->assertFalse(CastTestMockUse::equals(new stdClass()));
        $this->assertFalse(CastTestMockUse::equals(stdClass::class));
        $this->assertFalse((new CastTestMockUse())->equals(new stdClass()));
        $this->assertFalse((new CastTestMockUse())->equals(stdClass::class));
    }

    public function test_equals_parentUseChildUse(): void
    {
        $this->assertFalse(CastTestMockParentUse::equals(new CastTestMockParentUseChildUse()));
        $this->assertFalse((new CastTestMockParentUse())::equals(new CastTestMockParentUseChildUse()));
        $this->assertFalse((new CastTestMockParentUse())->equals(new CastTestMockParentUseChildUse()));

        $this->assertFalse(CastTestMockParentUse::equals(CastTestMockParentUseChildUse::class));
        $this->assertFalse((new CastTestMockParentUse())::equals(CastTestMockParentUseChildUse::class));
        $this->assertFalse((new CastTestMockParentUse())->equals(CastTestMockParentUseChildUse::class));

        $this->assertFalse(CastTestMockParentUseChildUse::equals(new CastTestMockParentUse()));
        $this->assertFalse((new CastTestMockParentUseChildUse())::equals(new CastTestMockParentUse()));
        $this->assertFalse((new CastTestMockParentUseChildUse())->equals(new CastTestMockParentUse()));
    }

    public function test_equals_parentUseChildUnuse(): void
    {
        $this->assertFalse(CastTestMockParentUse::equals(new CastTestMockParentUseChildUnuse()));
        $this->assertFalse((new CastTestMockParentUse())::equals(new CastTestMockParentUseChildUnuse()));
        $this->assertFalse((new CastTestMockParentUse())->equals(new CastTestMockParentUseChildUnuse()));

        $this->assertFalse(CastTestMockParentUse::equals(CastTestMockParentUseChildUnuse::class));
        $this->assertFalse((new CastTestMockParentUse())::equals(CastTestMockParentUseChildUnuse::class));
        $this->assertFalse((new CastTestMockParentUse())->equals(CastTestMockParentUseChildUnuse::class));

        $this->assertFalse(CastTestMockParentUseChildUnuse::equals(new CastTestMockParentUse()));
        $this->assertFalse((new CastTestMockParentUseChildUnuse())::equals(new CastTestMockParentUse()));
        $this->assertFalse((new CastTestMockParentUseChildUnuse())->equals(new CastTestMockParentUse()));
    }

    public function test_equals_parentUnuseChildUse(): void
    {
        $this->assertFalse(CastTestMockParentUnuseChildUse::equals(new CastTestMockParentUnuse()));
        $this->assertFalse((new CastTestMockParentUnuseChildUse())::equals(new CastTestMockParentUnuse()));
        $this->assertFalse((new CastTestMockParentUnuseChildUse())->equals(new CastTestMockParentUnuse()));

        $this->assertFalse(CastTestMockParentUnuseChildUse::equals(CastTestMockParentUnuse::class));
        $this->assertFalse((new CastTestMockParentUnuseChildUse())::equals(CastTestMockParentUnuse::class));
        $this->assertFalse((new CastTestMockParentUnuseChildUse())->equals(CastTestMockParentUnuse::class));
    }

    /*
     * -------- extend --------
     */

    public function test_extend_same(): void
    {
        $this->assertFalse(CastTestMockUse::extend(new CastTestMockUse()));
        $this->assertFalse((new CastTestMockUse())::extend(new CastTestMockUse()));
        $this->assertFalse((new CastTestMockUse())->extend(new CastTestMockUse()));

        $this->assertFalse(CastTestMockUse::extend(CastTestMockUse::class));
        $this->assertFalse((new CastTestMockUse())::extend(CastTestMockUse::class));
        $this->assertFalse((new CastTestMockUse())->extend(CastTestMockUse::class));
    }

    public function test_extend_diff(): void
    {
        $this->assertFalse(CastTestMockUse::extend(new stdClass()));
        $this->assertFalse(CastTestMockUse::extend(stdClass::class));
        $this->assertFalse((new CastTestMockUse())->extend(new stdClass()));
        $this->assertFalse((new CastTestMockUse())->extend(stdClass::class));
    }

    public function test_extend_parentUseChildUse(): void
    {
        $this->assertFalse(CastTestMockParentUse::extend(new CastTestMockParentUseChildUse()));
        $this->assertFalse((new CastTestMockParentUse())::extend(new CastTestMockParentUseChildUse()));
        $this->assertFalse((new CastTestMockParentUse())->extend(new CastTestMockParentUseChildUse()));

        $this->assertFalse(CastTestMockParentUse::extend(CastTestMockParentUseChildUse::class));
        $this->assertFalse((new CastTestMockParentUse())::extend(CastTestMockParentUseChildUse::class));
        $this->assertFalse((new CastTestMockParentUse())->extend(CastTestMockParentUseChildUse::class));

        $this->assertTrue(CastTestMockParentUseChildUse::extend(new CastTestMockParentUse()));
        $this->assertTrue((new CastTestMockParentUseChildUse())::extend(new CastTestMockParentUse()));
        $this->assertTrue((new CastTestMockParentUseChildUse())->extend(new CastTestMockParentUse()));
    }

    public function test_extend_parentUseChildUnuse(): void
    {
        $this->assertFalse(CastTestMockParentUse::extend(new CastTestMockParentUseChildUnuse()));
        $this->assertFalse((new CastTestMockParentUse())::extend(new CastTestMockParentUseChildUnuse()));
        $this->assertFalse((new CastTestMockParentUse())->extend(new CastTestMockParentUseChildUnuse()));

        $this->assertFalse(CastTestMockParentUse::extend(CastTestMockParentUseChildUnuse::class));
        $this->assertFalse((new CastTestMockParentUse())::extend(CastTestMockParentUseChildUnuse::class));
        $this->assertFalse((new CastTestMockParentUse())->extend(CastTestMockParentUseChildUnuse::class));

        $this->assertTrue(CastTestMockParentUseChildUnuse::extend(new CastTestMockParentUse()));
        $this->assertTrue((new CastTestMockParentUseChildUnuse())::extend(new CastTestMockParentUse()));
        $this->assertTrue((new CastTestMockParentUseChildUnuse())->extend(new CastTestMockParentUse()));
    }

    public function test_extend_parentUnuseChildUse(): void
    {
        $this->assertTrue(CastTestMockParentUnuseChildUse::extend(new CastTestMockParentUnuse()));
        $this->assertTrue((new CastTestMockParentUnuseChildUse())::extend(new CastTestMockParentUnuse()));
        $this->assertTrue((new CastTestMockParentUnuseChildUse())->extend(new CastTestMockParentUnuse()));

        $this->assertTrue(CastTestMockParentUnuseChildUse::extend(CastTestMockParentUnuse::class));
        $this->assertTrue((new CastTestMockParentUnuseChildUse())::extend(CastTestMockParentUnuse::class));
        $this->assertTrue((new CastTestMockParentUnuseChildUse())->extend(CastTestMockParentUnuse::class));
    }

    /*
     * -------- extended --------
     */

    public function test_extended_same(): void
    {
        $this->assertFalse(CastTestMockUse::extended(new CastTestMockUse()));
        $this->assertFalse((new CastTestMockUse())::extended(new CastTestMockUse()));
        $this->assertFalse((new CastTestMockUse())->extended(new CastTestMockUse()));

        $this->assertFalse(CastTestMockUse::extended(CastTestMockUse::class));
        $this->assertFalse((new CastTestMockUse())::extended(CastTestMockUse::class));
        $this->assertFalse((new CastTestMockUse())->extended(CastTestMockUse::class));
    }

    public function test_extended_diff(): void
    {
        $this->assertFalse(CastTestMockUse::extended(new stdClass()));
        $this->assertFalse(CastTestMockUse::extended(stdClass::class));
        $this->assertFalse((new CastTestMockUse())->extended(new stdClass()));
        $this->assertFalse((new CastTestMockUse())->extended(stdClass::class));
    }

    public function test_extended_parentUseChildUse(): void
    {
        $this->assertTrue(CastTestMockParentUse::extended(new CastTestMockParentUseChildUse()));
        $this->assertTrue((new CastTestMockParentUse())::extended(new CastTestMockParentUseChildUse()));
        $this->assertTrue((new CastTestMockParentUse())->extended(new CastTestMockParentUseChildUse()));

        $this->assertTrue(CastTestMockParentUse::extended(CastTestMockParentUseChildUse::class));
        $this->assertTrue((new CastTestMockParentUse())::extended(CastTestMockParentUseChildUse::class));
        $this->assertTrue((new CastTestMockParentUse())->extended(CastTestMockParentUseChildUse::class));

        $this->assertFalse(CastTestMockParentUseChildUse::extended(new CastTestMockParentUse()));
        $this->assertFalse((new CastTestMockParentUseChildUse())::extended(new CastTestMockParentUse()));
        $this->assertFalse((new CastTestMockParentUseChildUse())->extended(new CastTestMockParentUse()));
    }

    public function test_extended_parentUseChildUnuse(): void
    {
        $this->assertTrue(CastTestMockParentUse::extended(new CastTestMockParentUseChildUnuse()));
        $this->assertTrue((new CastTestMockParentUse())::extended(new CastTestMockParentUseChildUnuse()));
        $this->assertTrue((new CastTestMockParentUse())->extended(new CastTestMockParentUseChildUnuse()));

        $this->assertTrue(CastTestMockParentUse::extended(CastTestMockParentUseChildUnuse::class));
        $this->assertTrue((new CastTestMockParentUse())::extended(CastTestMockParentUseChildUnuse::class));
        $this->assertTrue((new CastTestMockParentUse())->extended(CastTestMockParentUseChildUnuse::class));

        $this->assertFalse(CastTestMockParentUseChildUnuse::extended(new CastTestMockParentUse()));
        $this->assertFalse((new CastTestMockParentUseChildUnuse())::extended(new CastTestMockParentUse()));
        $this->assertFalse((new CastTestMockParentUseChildUnuse())->extended(new CastTestMockParentUse()));
    }

    public function test_extended_parentUnuseChildUse(): void
    {
        $this->assertFalse(CastTestMockParentUnuseChildUse::extended(new CastTestMockParentUnuse()));
        $this->assertFalse((new CastTestMockParentUnuseChildUse())::extended(new CastTestMockParentUnuse()));
        $this->assertFalse((new CastTestMockParentUnuseChildUse())->extended(new CastTestMockParentUnuse()));

        $this->assertFalse(CastTestMockParentUnuseChildUse::extended(CastTestMockParentUnuse::class));
        $this->assertFalse((new CastTestMockParentUnuseChildUse())::extended(CastTestMockParentUnuse::class));
        $this->assertFalse((new CastTestMockParentUnuseChildUse())->extended(CastTestMockParentUnuse::class));
    }

    /*
     * -------- cast --------
     */

    public function test_cast_same(): void
    {
        $this->assertEquals(CastTestMockUse::class, get_class(CastTestMockUse::cast(new CastTestMockUse())));
    }

    public function test_cast_diff(): void
    {
        $this->assertNotEquals(stdClass::class, get_class(CastTestMockUse::cast(new CastTestMockUse())));
    }

    public function test_cast_parentUseChildUse(): void
    {
        $this->assertEquals(CastTestMockParentUseChildUse::class, get_class(CastTestMockParentUse::cast(new CastTestMockParentUseChildUse())));
        $this->assertEquals(CastTestMockParentUseChildUse::class, get_class(CastTestMockParentUseChildUse::cast(new CastTestMockParentUseChildUse())));
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage(''); // TODO:
        CastTestMockParentUseChildUse::cast(new CastTestMockParentUse());
    }

    public function test_cast_parentUseChildUnuse(): void
    {
        $this->assertEquals(CastTestMockParentUseChildUnuse::class, get_class(CastTestMockParentUse::cast(new CastTestMockParentUseChildUnuse())));
        $this->assertEquals(CastTestMockParentUseChildUnuse::class, get_class(CastTestMockParentUseChildUnuse::cast(new CastTestMockParentUseChildUnuse())));
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage(''); // TODO:
        CastTestMockParentUseChildUnuse::cast(new CastTestMockParentUse());
    }

    public function test_cast_parentUnuseChildUse(): void
    {
        $this->assertEquals(CastTestMockParentUnuseChildUse::class, get_class(CastTestMockParentUnuseChildUse::cast(new CastTestMockParentUnuseChildUse())));
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage(''); // TODO:
        $this->assertEquals(CastTestMockParentUnuseChildUse::class, get_class(CastTestMockParentUnuseChildUse::cast(new CastTestMockParentUnuse())));
    }

    /*
     * -------- cast_null --------
     */

    public function test_cast_null(): void
    {
        $this->assertNotNull(CastTestMockUse::cast_null(new CastTestMockUse()));
        $this->assertNull(CastTestMockUse::cast_null(null));
    }
}

class CastTestMockUse
{
    use Cast;
}

class CastTestMockUnuse
{
}

class CastTestMockParentUse
{
    use Cast;
}

class CastTestMockParentUnuse
{
}

class CastTestMockParentUseChildUse extends CastTestMockParentUse
{
    use Cast;
}

class CastTestMockParentUseChildUnuse extends CastTestMockParentUse
{
}

class CastTestMockParentUnuseChildUse extends CastTestMockParentUnuse
{
    use Cast;
}