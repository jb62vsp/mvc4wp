<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model;

use Mvc4Wp\System\Core\Cast;

/**
 * @template TModel of UserEntity
 * @extends Model<TModel>
 */
#[Entity]
abstract class UserEntity extends Model
{
    use Cast;

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