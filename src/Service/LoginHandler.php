<?php
declare(strict_types=1);

namespace SmallUser\Service;

use SmallUser\Entity\UserInterface;

class LoginHandler
{
    public function isValidLogin(UserInterface $user)
    {
        return true;
    }
}