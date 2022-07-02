<?php

use Psr\Container\ContainerInterface;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnBundle\User\Domain\Services\AuthService3;
use ZnBundle\User\Domain\Subscribers\SymfonyAuthenticationIdentitySubscriber;
use ZnBundle\User\Domain\Entities\IdentityEntity;

return [
    'definitions' => [
//        'ZnCore\Contract\User\Interfaces\Entities\IdentityEntityInterface' => IdentityEntity::class,
        'ZnCore\Contract\User\Interfaces\Entities\IdentityEntityInterface' => IdentityEntity::class,
    ],
    'singletons' => [
        'ZnBundle\User\Domain\Interfaces\Services\IdentityServiceInterface' => 'ZnBundle\User\Domain\Services\IdentityService',
        'ZnBundle\User\Domain\Interfaces\Repositories\IdentityRepositoryInterface' => 'ZnBundle\User\Domain\Repositories\Eloquent\IdentityRepository',

        AuthServiceInterface::class => function (ContainerInterface $container) {
            /** @var AuthService3 $authService */
            $authService = $container->get(AuthService3::class);
            $authService->addSubscriber(SymfonyAuthenticationIdentitySubscriber::class);
            $authService->addSubscriber([
                'class' => \ZnBundle\User\Domain\Subscribers\AuthenticationAttemptSubscriber::class,
                'action' => 'authorization',
                // todo: вынести в настройки
                'attemptCount' => 3,
                'lifeTime' => 10,
//                'lifeTime' => TimeEnum::SECOND_PER_MINUTE * 30,
            ]);
            return $authService;
        },
    ],
    'entities' => [
        'ZnCore\Contract\User\Interfaces\Entities\IdentityEntityInterface' => 'ZnBundle\User\Domain\Interfaces\Repositories\IdentityRepositoryInterface',
//        'ZnCore\Contract\User\Interfaces\Entities\IdentityEntityInterface' => 'ZnBundle\User\Domain\Interfaces\Repositories\IdentityRepositoryInterface',
        'ZnBundle\User\Domain\Entities\IdentityEntity' => 'ZnBundle\User\Domain\Interfaces\Repositories\IdentityRepositoryInterface',
    ],
];
