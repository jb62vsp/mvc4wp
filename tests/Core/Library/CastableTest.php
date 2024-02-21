<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(Castable::class)]
class CastableTest extends TestCase
{
    /*
     * -------- is --------
     */

    public function test_is_same(): void
    {
        $this->assertTrue(CastableTestMockUse::is(new CastableTestMockUse()));
        $this->assertTrue((new CastableTestMockUse())::is(new CastableTestMockUse()));
        $this->assertTrue((new CastableTestMockUse())->is(new CastableTestMockUse()));

        $this->assertTrue(CastableTestMockUse::is(CastableTestMockUse::class));
        $this->assertTrue((new CastableTestMockUse())::is(CastableTestMockUse::class));
        $this->assertTrue((new CastableTestMockUse())->is(CastableTestMockUse::class));
    }

    public function test_is_diff(): void
    {
        $this->assertFalse(CastableTestMockUse::is(new stdClass()));
        $this->assertFalse(CastableTestMockUse::is(stdClass::class));
        $this->assertFalse((new CastableTestMockUse())->is(new stdClass()));
        $this->assertFalse((new CastableTestMockUse())->is(stdClass::class));
    }

    public function test_is_parentUseChildUse(): void
    {
        $this->assertTrue(CastableTestMockParentUse::is(new CastableTestMockParentUseChildUse()));
        $this->assertTrue((new CastableTestMockParentUse())::is(new CastableTestMockParentUseChildUse()));
        $this->assertTrue((new CastableTestMockParentUse())->is(new CastableTestMockParentUseChildUse()));

        $this->assertTrue(CastableTestMockParentUse::is(CastableTestMockParentUseChildUse::class));
        $this->assertTrue((new CastableTestMockParentUse())::is(CastableTestMockParentUseChildUse::class));
        $this->assertTrue((new CastableTestMockParentUse())->is(CastableTestMockParentUseChildUse::class));

        $this->assertTrue(CastableTestMockParentUseChildUse::is(new CastableTestMockParentUse()));
        $this->assertTrue((new CastableTestMockParentUseChildUse())::is(new CastableTestMockParentUse()));
        $this->assertTrue((new CastableTestMockParentUseChildUse())->is(new CastableTestMockParentUse()));
    }

    public function test_is_parentUseChildUnuse(): void
    {
        $this->assertTrue(CastableTestMockParentUse::is(new CastableTestMockParentUseChildUnuse()));
        $this->assertTrue((new CastableTestMockParentUse())::is(new CastableTestMockParentUseChildUnuse()));
        $this->assertTrue((new CastableTestMockParentUse())->is(new CastableTestMockParentUseChildUnuse()));

        $this->assertTrue(CastableTestMockParentUse::is(CastableTestMockParentUseChildUnuse::class));
        $this->assertTrue((new CastableTestMockParentUse())::is(CastableTestMockParentUseChildUnuse::class));
        $this->assertTrue((new CastableTestMockParentUse())->is(CastableTestMockParentUseChildUnuse::class));

        $this->assertTrue(CastableTestMockParentUseChildUnuse::is(new CastableTestMockParentUse()));
        $this->assertTrue((new CastableTestMockParentUseChildUnuse())::is(new CastableTestMockParentUse()));
        $this->assertTrue((new CastableTestMockParentUseChildUnuse())->is(new CastableTestMockParentUse()));
    }

    public function test_is_parentUnuseChildUse(): void
    {
        $this->assertTrue(CastableTestMockParentUnuseChildUse::is(new CastableTestMockParentUnuse()));
        $this->assertTrue((new CastableTestMockParentUnuseChildUse())::is(new CastableTestMockParentUnuse()));
        $this->assertTrue((new CastableTestMockParentUnuseChildUse())->is(new CastableTestMockParentUnuse()));

        $this->assertTrue(CastableTestMockParentUnuseChildUse::is(CastableTestMockParentUnuse::class));
        $this->assertTrue((new CastableTestMockParentUnuseChildUse())::is(CastableTestMockParentUnuse::class));
        $this->assertTrue((new CastableTestMockParentUnuseChildUse())->is(CastableTestMockParentUnuse::class));
    }

    /*
     * -------- equals --------
     */

    public function test_equals_same(): void
    {
        $this->assertTrue(CastableTestMockUse::equals(new CastableTestMockUse()));
        $this->assertTrue((new CastableTestMockUse())::equals(new CastableTestMockUse()));
        $this->assertTrue((new CastableTestMockUse())->equals(new CastableTestMockUse()));

        $this->assertTrue(CastableTestMockUse::equals(CastableTestMockUse::class));
        $this->assertTrue((new CastableTestMockUse())::equals(CastableTestMockUse::class));
        $this->assertTrue((new CastableTestMockUse())->equals(CastableTestMockUse::class));
    }

    public function test_equals_diff(): void
    {
        $this->assertFalse(CastableTestMockUse::equals(new stdClass()));
        $this->assertFalse(CastableTestMockUse::equals(stdClass::class));
        $this->assertFalse((new CastableTestMockUse())->equals(new stdClass()));
        $this->assertFalse((new CastableTestMockUse())->equals(stdClass::class));
    }

    public function test_equals_parentUseChildUse(): void
    {
        $this->assertFalse(CastableTestMockParentUse::equals(new CastableTestMockParentUseChildUse()));
        $this->assertFalse((new CastableTestMockParentUse())::equals(new CastableTestMockParentUseChildUse()));
        $this->assertFalse((new CastableTestMockParentUse())->equals(new CastableTestMockParentUseChildUse()));

        $this->assertFalse(CastableTestMockParentUse::equals(CastableTestMockParentUseChildUse::class));
        $this->assertFalse((new CastableTestMockParentUse())::equals(CastableTestMockParentUseChildUse::class));
        $this->assertFalse((new CastableTestMockParentUse())->equals(CastableTestMockParentUseChildUse::class));

        $this->assertFalse(CastableTestMockParentUseChildUse::equals(new CastableTestMockParentUse()));
        $this->assertFalse((new CastableTestMockParentUseChildUse())::equals(new CastableTestMockParentUse()));
        $this->assertFalse((new CastableTestMockParentUseChildUse())->equals(new CastableTestMockParentUse()));
    }

    public function test_equals_parentUseChildUnuse(): void
    {
        $this->assertFalse(CastableTestMockParentUse::equals(new CastableTestMockParentUseChildUnuse()));
        $this->assertFalse((new CastableTestMockParentUse())::equals(new CastableTestMockParentUseChildUnuse()));
        $this->assertFalse((new CastableTestMockParentUse())->equals(new CastableTestMockParentUseChildUnuse()));

        $this->assertFalse(CastableTestMockParentUse::equals(CastableTestMockParentUseChildUnuse::class));
        $this->assertFalse((new CastableTestMockParentUse())::equals(CastableTestMockParentUseChildUnuse::class));
        $this->assertFalse((new CastableTestMockParentUse())->equals(CastableTestMockParentUseChildUnuse::class));

        $this->assertFalse(CastableTestMockParentUseChildUnuse::equals(new CastableTestMockParentUse()));
        $this->assertFalse((new CastableTestMockParentUseChildUnuse())::equals(new CastableTestMockParentUse()));
        $this->assertFalse((new CastableTestMockParentUseChildUnuse())->equals(new CastableTestMockParentUse()));
    }

    public function test_equals_parentUnuseChildUse(): void
    {
        $this->assertFalse(CastableTestMockParentUnuseChildUse::equals(new CastableTestMockParentUnuse()));
        $this->assertFalse((new CastableTestMockParentUnuseChildUse())::equals(new CastableTestMockParentUnuse()));
        $this->assertFalse((new CastableTestMockParentUnuseChildUse())->equals(new CastableTestMockParentUnuse()));

        $this->assertFalse(CastableTestMockParentUnuseChildUse::equals(CastableTestMockParentUnuse::class));
        $this->assertFalse((new CastableTestMockParentUnuseChildUse())::equals(CastableTestMockParentUnuse::class));
        $this->assertFalse((new CastableTestMockParentUnuseChildUse())->equals(CastableTestMockParentUnuse::class));
    }

    /*
     * -------- extend --------
     */

    public function test_extend_same(): void
    {
        $this->assertFalse(CastableTestMockUse::extend(new CastableTestMockUse()));
        $this->assertFalse((new CastableTestMockUse())::extend(new CastableTestMockUse()));
        $this->assertFalse((new CastableTestMockUse())->extend(new CastableTestMockUse()));

        $this->assertFalse(CastableTestMockUse::extend(CastableTestMockUse::class));
        $this->assertFalse((new CastableTestMockUse())::extend(CastableTestMockUse::class));
        $this->assertFalse((new CastableTestMockUse())->extend(CastableTestMockUse::class));
    }

    public function test_extend_diff(): void
    {
        $this->assertFalse(CastableTestMockUse::extend(new stdClass()));
        $this->assertFalse(CastableTestMockUse::extend(stdClass::class));
        $this->assertFalse((new CastableTestMockUse())->extend(new stdClass()));
        $this->assertFalse((new CastableTestMockUse())->extend(stdClass::class));
    }

    public function test_extend_parentUseChildUse(): void
    {
        $this->assertFalse(CastableTestMockParentUse::extend(new CastableTestMockParentUseChildUse()));
        $this->assertFalse((new CastableTestMockParentUse())::extend(new CastableTestMockParentUseChildUse()));
        $this->assertFalse((new CastableTestMockParentUse())->extend(new CastableTestMockParentUseChildUse()));

        $this->assertFalse(CastableTestMockParentUse::extend(CastableTestMockParentUseChildUse::class));
        $this->assertFalse((new CastableTestMockParentUse())::extend(CastableTestMockParentUseChildUse::class));
        $this->assertFalse((new CastableTestMockParentUse())->extend(CastableTestMockParentUseChildUse::class));

        $this->assertTrue(CastableTestMockParentUseChildUse::extend(new CastableTestMockParentUse()));
        $this->assertTrue((new CastableTestMockParentUseChildUse())::extend(new CastableTestMockParentUse()));
        $this->assertTrue((new CastableTestMockParentUseChildUse())->extend(new CastableTestMockParentUse()));
    }

    public function test_extend_parentUseChildUnuse(): void
    {
        $this->assertFalse(CastableTestMockParentUse::extend(new CastableTestMockParentUseChildUnuse()));
        $this->assertFalse((new CastableTestMockParentUse())::extend(new CastableTestMockParentUseChildUnuse()));
        $this->assertFalse((new CastableTestMockParentUse())->extend(new CastableTestMockParentUseChildUnuse()));

        $this->assertFalse(CastableTestMockParentUse::extend(CastableTestMockParentUseChildUnuse::class));
        $this->assertFalse((new CastableTestMockParentUse())::extend(CastableTestMockParentUseChildUnuse::class));
        $this->assertFalse((new CastableTestMockParentUse())->extend(CastableTestMockParentUseChildUnuse::class));

        $this->assertTrue(CastableTestMockParentUseChildUnuse::extend(new CastableTestMockParentUse()));
        $this->assertTrue((new CastableTestMockParentUseChildUnuse())::extend(new CastableTestMockParentUse()));
        $this->assertTrue((new CastableTestMockParentUseChildUnuse())->extend(new CastableTestMockParentUse()));
    }

    public function test_extend_parentUnuseChildUse(): void
    {
        $this->assertTrue(CastableTestMockParentUnuseChildUse::extend(new CastableTestMockParentUnuse()));
        $this->assertTrue((new CastableTestMockParentUnuseChildUse())::extend(new CastableTestMockParentUnuse()));
        $this->assertTrue((new CastableTestMockParentUnuseChildUse())->extend(new CastableTestMockParentUnuse()));

        $this->assertTrue(CastableTestMockParentUnuseChildUse::extend(CastableTestMockParentUnuse::class));
        $this->assertTrue((new CastableTestMockParentUnuseChildUse())::extend(CastableTestMockParentUnuse::class));
        $this->assertTrue((new CastableTestMockParentUnuseChildUse())->extend(CastableTestMockParentUnuse::class));
    }

    /*
     * -------- extended --------
     */

    public function test_extended_same(): void
    {
        $this->assertFalse(CastableTestMockUse::extended(new CastableTestMockUse()));
        $this->assertFalse((new CastableTestMockUse())::extended(new CastableTestMockUse()));
        $this->assertFalse((new CastableTestMockUse())->extended(new CastableTestMockUse()));

        $this->assertFalse(CastableTestMockUse::extended(CastableTestMockUse::class));
        $this->assertFalse((new CastableTestMockUse())::extended(CastableTestMockUse::class));
        $this->assertFalse((new CastableTestMockUse())->extended(CastableTestMockUse::class));
    }

    public function test_extended_diff(): void
    {
        $this->assertFalse(CastableTestMockUse::extended(new stdClass()));
        $this->assertFalse(CastableTestMockUse::extended(stdClass::class));
        $this->assertFalse((new CastableTestMockUse())->extended(new stdClass()));
        $this->assertFalse((new CastableTestMockUse())->extended(stdClass::class));
    }

    public function test_extended_parentUseChildUse(): void
    {
        $this->assertTrue(CastableTestMockParentUse::extended(new CastableTestMockParentUseChildUse()));
        $this->assertTrue((new CastableTestMockParentUse())::extended(new CastableTestMockParentUseChildUse()));
        $this->assertTrue((new CastableTestMockParentUse())->extended(new CastableTestMockParentUseChildUse()));

        $this->assertTrue(CastableTestMockParentUse::extended(CastableTestMockParentUseChildUse::class));
        $this->assertTrue((new CastableTestMockParentUse())::extended(CastableTestMockParentUseChildUse::class));
        $this->assertTrue((new CastableTestMockParentUse())->extended(CastableTestMockParentUseChildUse::class));

        $this->assertFalse(CastableTestMockParentUseChildUse::extended(new CastableTestMockParentUse()));
        $this->assertFalse((new CastableTestMockParentUseChildUse())::extended(new CastableTestMockParentUse()));
        $this->assertFalse((new CastableTestMockParentUseChildUse())->extended(new CastableTestMockParentUse()));
    }

    public function test_extended_parentUseChildUnuse(): void
    {
        $this->assertTrue(CastableTestMockParentUse::extended(new CastableTestMockParentUseChildUnuse()));
        $this->assertTrue((new CastableTestMockParentUse())::extended(new CastableTestMockParentUseChildUnuse()));
        $this->assertTrue((new CastableTestMockParentUse())->extended(new CastableTestMockParentUseChildUnuse()));

        $this->assertTrue(CastableTestMockParentUse::extended(CastableTestMockParentUseChildUnuse::class));
        $this->assertTrue((new CastableTestMockParentUse())::extended(CastableTestMockParentUseChildUnuse::class));
        $this->assertTrue((new CastableTestMockParentUse())->extended(CastableTestMockParentUseChildUnuse::class));

        $this->assertFalse(CastableTestMockParentUseChildUnuse::extended(new CastableTestMockParentUse()));
        $this->assertFalse((new CastableTestMockParentUseChildUnuse())::extended(new CastableTestMockParentUse()));
        $this->assertFalse((new CastableTestMockParentUseChildUnuse())->extended(new CastableTestMockParentUse()));
    }

    public function test_extended_parentUnuseChildUse(): void
    {
        $this->assertFalse(CastableTestMockParentUnuseChildUse::extended(new CastableTestMockParentUnuse()));
        $this->assertFalse((new CastableTestMockParentUnuseChildUse())::extended(new CastableTestMockParentUnuse()));
        $this->assertFalse((new CastableTestMockParentUnuseChildUse())->extended(new CastableTestMockParentUnuse()));

        $this->assertFalse(CastableTestMockParentUnuseChildUse::extended(CastableTestMockParentUnuse::class));
        $this->assertFalse((new CastableTestMockParentUnuseChildUse())::extended(CastableTestMockParentUnuse::class));
        $this->assertFalse((new CastableTestMockParentUnuseChildUse())->extended(CastableTestMockParentUnuse::class));
    }

    /*
     * -------- cast --------
     */

    public function test_cast_same(): void
    {
        $this->assertEquals(CastableTestMockUse::class, get_class(CastableTestMockUse::cast(new CastableTestMockUse())));
    }

    public function test_cast_diff(): void
    {
        $this->assertNotEquals(stdClass::class, get_class(CastableTestMockUse::cast(new CastableTestMockUse())));
    }

    public function test_cast_parentUseChildUse(): void
    {
        $this->assertEquals(CastableTestMockParentUseChildUse::class, get_class(CastableTestMockParentUse::cast(new CastableTestMockParentUseChildUse())));
        $this->assertEquals(CastableTestMockParentUseChildUse::class, get_class(CastableTestMockParentUseChildUse::cast(new CastableTestMockParentUseChildUse())));
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage(''); // TODO:
        CastableTestMockParentUseChildUse::cast(new CastableTestMockParentUse());
    }

    public function test_cast_parentUseChildUnuse(): void
    {
        $this->assertEquals(CastableTestMockParentUseChildUnuse::class, get_class(CastableTestMockParentUse::cast(new CastableTestMockParentUseChildUnuse())));
        $this->assertEquals(CastableTestMockParentUseChildUnuse::class, get_class(CastableTestMockParentUseChildUnuse::cast(new CastableTestMockParentUseChildUnuse())));
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage(''); // TODO:
        CastableTestMockParentUseChildUnuse::cast(new CastableTestMockParentUse());
    }

    public function test_cast_parentUnuseChildUse(): void
    {
        $this->assertEquals(CastableTestMockParentUnuseChildUse::class, get_class(CastableTestMockParentUnuseChildUse::cast(new CastableTestMockParentUnuseChildUse())));
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage(''); // TODO:
        $this->assertEquals(CastableTestMockParentUnuseChildUse::class, get_class(CastableTestMockParentUnuseChildUse::cast(new CastableTestMockParentUnuse())));
    }

    /*
     * -------- cast_null --------
     */

    public function test_cast_null(): void
    {
        $this->assertNotNull(CastableTestMockUse::cast_null(new CastableTestMockUse()));
        $this->assertNull(CastableTestMockUse::cast_null(null));
    }
}

class CastableTestMockUse
{
    use Castable;
}

class CastableTestMockUnuse
{
}

class CastableTestMockParentUse
{
    use Castable;
}

class CastableTestMockParentUnuse
{
}

class CastableTestMockParentUseChildUse extends CastableTestMockParentUse
{
    use Castable;
}

class CastableTestMockParentUseChildUnuse extends CastableTestMockParentUse
{
}

class CastableTestMockParentUnuseChildUse extends CastableTestMockParentUnuse
{
    use Castable;
}