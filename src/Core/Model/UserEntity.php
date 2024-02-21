<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Library\Castable;

/**
 * @template TModel of UserEntity
 * @extends Model<TModel>
 */
#[Entity]
abstract class UserEntity extends Model
{
    use Castable;

    #[Field]
    public string $user_login;

    #[Field]
    public string $user_email;

    #[Field]
    public string $display_name;

    #[Field]
    public string $last_name;

    #[Field]
    public string $first_name;

    // public array $roles;
}