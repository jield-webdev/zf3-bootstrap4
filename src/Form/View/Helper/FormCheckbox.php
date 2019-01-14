<?php

namespace Zf3Bootstrap4\Form\View\Helper;

use Zend\Form\ElementInterface;

final class FormCheckbox extends \Zend\Form\View\Helper\FormCheckbox
{
    public function render(ElementInterface $element)
    {
        $element->setAttribute('class', 'custom-control-input');

        if (\count($element->getMessages()) > 0) {
            $element->setAttribute('class', 'custom-control-input is-invalid');
        }

        $element->setAttribute('id', \md5($element->getName()));

        return parent::render($element);
    }
}
