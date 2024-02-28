<?php

use CustomPhpSettings\Backend\Backend;
use CustomPhpSettings\DI\Container;
use CustomPhpSettings\Plugin\Settings\Settings;

return array(
    Settings::class => function ($c) {
        return new Settings(Backend::SETTINGS_NAME);
    },
    Backend::class => function ($c) {
        return new Backend(
            $c,
            $c->get(Settings::class)
        );
    },
);
