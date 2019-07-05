<?php

namespace Ayctor\Roles;

use WpCore\Roles\Role;

class Example extends Role
{
    public $name = 'example';

    public $label = 'Role Example';

    public $capabilities = [];
}
