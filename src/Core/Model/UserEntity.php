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

    #[Bindable]
    public string $user_login;

    #[Bindable]
    public string $user_email;

    #[Bindable]
    public string $display_name;

    #[Bindable]
    public string $last_name;

    #[Bindable]
    public string $first_name;

    // public array $roles;
}