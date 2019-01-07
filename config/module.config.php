<?php

use Zf3Bootstrap4\Form\View;
use Zf3Bootstrap4\Navigation;
use Zf3Bootstrap4\View\Helper;

return [
    'view_helpers' => [
        'aliases'    => [
            'zf3b4navigation'    => Helper\Navigation::class,
            'ztbnavigation'      => Helper\Navigation::class,
            'ztbformelement'     => 'zf3b4formelement',
            'ztbformdescription' => 'zf3b4fordescription',
            'ztbbadge'           => 'zf3b4badge',
            'ztbalert'           => 'zf3b4alert',

        ],
        'factories'  => [
            Helper\Navigation::class => Navigation\View\NavigationHelperFactory::class,
        ],
        'invokables' => [
<<<<<<< Updated upstream
            'zf3b4formelement'      => View\Helper\FormElement::class,
            'zf3b4filterbarelement' => View\Helper\FilterBarElement::class,
            'zf3b4fordescription'   => View\Helper\FormDescription::class,
            'zf3b4badge'            => Helper\Badge::class,
            'zf3b4alert'            => Helper\Alert::class,
=======
            'zf3b4formdescription'   => View\Helper\FormDescription::class,
            'zf3b4forminput'         => View\Helper\FormInput::class,
            'zf3b4formfile'          => View\Helper\FormFile::class,
            'zf3b4formradio'         => View\Helper\FormRadio::class,
            'zf3b4formcheckbox'      => View\Helper\FormCheckbox::class,
            'zf3b4formlabel'         => View\Helper\FormLabel::class,
            'zf3b4formtextarea'      => View\Helper\FormTextarea::class,
            'zf3b4formselect'        => View\Helper\FormSelect::class,
            'zf3b4formmulticheckbox' => View\Helper\FormMultiCheckbox::class,
            'zf3b4alert'             => Helper\Alert::class,
>>>>>>> Stashed changes
        ],
    ],
];
