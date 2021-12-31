<?php
declare(strict_types=1);

namespace SmallUser\Service;

use Laminas\Authentication\Adapter;
use Laminas\Authentication\AuthenticationService;
use RuntimeException;

class UserAuth extends AuthenticationService
{
    public function authenticate(Adapter\AdapterInterface $adapter = null)
    {
        if (! $adapter) {
            if (! $adapter = $this->getAdapter()) {
                throw new RuntimeException(
                    'An adapter must be set or passed prior to calling authenticate()'
                );
            }
        }
        $result = $adapter->authenticate();

        if ($this->hasIdentity()) {
            $this->clearIdentity();
        }

        if ($result->isValid()) {
            $this->getStorage()->write($result->getIdentity()->getId());
        }

        return $result;
    }

}
