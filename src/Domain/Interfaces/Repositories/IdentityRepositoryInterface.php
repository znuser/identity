<?php

namespace ZnUser\Identity\Domain\Interfaces\Repositories;

use ZnCore\Contract\User\Interfaces\Entities\IdentityEntityInterface;
use ZnCore\Repository\Interfaces\CrudRepositoryInterface;
use ZnCore\Query\Entities\Query;

interface IdentityRepositoryInterface extends CrudRepositoryInterface
{

    public function findUserByUsername(string $username, Query $query = null): IdentityEntityInterface;

    //public function findUserBy(array $condition, Query $query = null): IdentityEntity;
}
