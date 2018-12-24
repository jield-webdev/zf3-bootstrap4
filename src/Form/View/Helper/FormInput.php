<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zf3Bootstrap4\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper;

class FormInput extends Helper\FormInput
{
    private $inlineWrapper = '<div class="form-group"><label for="%s">%s</label>%s</div>';
    private $horizonalWrapper = '<div class="form-group row"><label class="col-sm-3 col-form-label" for="%s">%s</label><div class="col-sm-9">%s</div></div>';

    public function render(ElementInterface $element)
    {
        //Generate an id
        $id = \md5($element->getName());

        $element->setAttribute('class', 'form-control');
        $element->setAttribute('id', $id);

        $label = $element->getLabel();

        $renderedElement = parent::render($element);

        return \sprintf($this->horizonalWrapper, $id, $label, $renderedElement);
    }

}
