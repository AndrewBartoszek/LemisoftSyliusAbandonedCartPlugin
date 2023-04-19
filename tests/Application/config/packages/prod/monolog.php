<?php

declare(strict_types=1);

use Symfony\Config\MonologConfig;

return static function (MonologConfig $config): void {
    $config
        ->handler('main')
        ->type('fingers_crossed')
        ->actionLevel('error')
        ->handler('nested');

    $config
        ->handler('nested')
        ->type('stream')
        ->path('%kernel.logs_dir%/%kernel.environment%.log')
        ->level('debug');

    $config->channels(['abandoned_cart']);

    $config
        ->handler('abandoned_cart')
        ->type('stream')
        ->path('%kernel.logs_dir%/%kernel.environment%_abandoned_cart.log')
        ->level('error')
        ->channel('abandoned_cart');
};
