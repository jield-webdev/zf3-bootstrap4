<?php

use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Zf3Bootstrap4\Form\View;
use Zf3Bootstrap4\Navigation;
use Zf3Bootstrap4\View\Helper;

return [
    'view_helpers'               => [
        'aliases'    => [
            'zf3b4navigation'     => Helper\Navigation::class,
            'ztbnavigation'       => Helper\Navigation::class,
            'filterbarelement'    => View\Helper\FilterBarElement::class,
            'filtercolumnelement' => View\Helper\FilterColumnElement::class,
            'ztbformelement'      => View\Helper\FormElement::class,
            'ztbformdescription'  => 'zf3b4formdescription',
            'ztbalert'            => 'zf3b4alert',

        ],
        'factories'  => [
            Helper\Navigation::class               => Navigation\View\NavigationHelperFactory::class,
            View\Helper\FormElement::class         => ConfigAbstractFactory::class,
            View\Helper\FilterBarElement::class    => ConfigAbstractFactory::class,
            View\Helper\FilterColumnElement::class => ConfigAbstractFactory::class,
        ],
        'invokables' => [
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
        ],
    ],
    ConfigAbstractFactory::class => [
        View\Helper\FormElement::class         => [
            'ViewHelperManager',
            \Laminas\I18n\Translator\TranslatorInterface::class
        ],
        View\Helper\FilterBarElement::class    => [
            'ViewHelperManager',
            \Laminas\I18n\Translator\TranslatorInterface::class
        ],
        View\Helper\FilterColumnElement::class => [
            'ViewHelperManager',
            \Laminas\I18n\Translator\TranslatorInterface::class
        ]
    ]
];
