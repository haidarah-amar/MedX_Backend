<?php

return array_filter([
    App\Providers\AppServiceProvider::class,
    class_exists('Laravel\\Telescope\\TelescopeApplicationServiceProvider')
        ? App\Providers\TelescopeServiceProvider::class
        : null,
]);
