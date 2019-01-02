<?php

namespace Zf3Bootstrap4\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper;

final class FormSelect extends Helper\FormSelect
{
    public function render(ElementInterface $element)
    {
        $element->setAttribute('class', 'form-control');

        if (\count($element->getMessages()) > 0) {
            $element->setAttribute('class', 'form-control is-invalid');
        }

        $element->setAttribute('id', $element->getName());

        return parent::render($element);
    }
}
