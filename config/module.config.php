<?php

use Zf3Bootstrap4\Form\View;
use Zf3Bootstrap4\Navigation;
use Zf3Bootstrap4\View\Helper;

return [
    'view_helpers' => [
        'aliases'    => [
            'zf3b4navigation'    => Helper\Navigation::class,
            'ztbnavigation'       => Helper\Navigation::class,
            'ztbformelement'     => 'zf3b4formelement',
            'ztbformdescription' => 'zf3b4fordescription',
            'ztbbadge'           => 'zf3b4badge',
            'ztbalert'           => 'zf3b4alert',

        ],
        'factories'  => [
            Helper\Navigation::class => Navigation\View\NavigationHelperFactory::class,
        ],
        'invokables' => [
            'zf3b4formelement'    => View\Helper\FormElement::class,
            'zf3b4fordescription' => View\Helper\FormDescription::class,
            'zf3b4badge'          => Helper\Badge::class,
            'zf3b4alert'          => Helper\Alert::class,
        ],
    ],
];
