<?php declare(strict_types=1);
namespace System\Models;

use System\Core\Cast;
use System\Models\Repository\UserRepositoryTrait;

#[Entity]
class UserModel extends Model
{
    use Cast, UserRepositoryTrait;

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

    public array $roles;
}