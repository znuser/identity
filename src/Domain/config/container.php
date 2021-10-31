<?php

use Psr\Container\ContainerInterface;
use ZnBundle\User\Domain\Interfaces\Services\AuthServiceInterface;
use ZnBundle\User\Domain\Services\AuthService3;
use ZnBundle\User\Domain\Subscribers\SymfonyAuthenticationIdentitySubscriber;

return [
    'definitions' => [

    ],
    'singletons' => [
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
];
