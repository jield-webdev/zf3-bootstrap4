<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zf3Bootstrap4\Form\View\Helper;

use Zend\Form\Element\MultiCheckbox as MultiCheckboxElement;
use Zend\Form\ElementInterface;
use Zend\Form\LabelAwareInterface;
use Zend\Form\View\Helper;

class FormMultiCheckbox extends Helper\FormMultiCheckbox
{
    private $template = '<div class="form-check">%s%s%s%s</div>';

    public function render(ElementInterface $element)
    {
        $name = static::getName($element);

        $options = $element->getValueOptions();

        $attributes = $element->getAttributes();
        $attributes['name'] = $name;
        $attributes['type'] = $this->getInputType();
        $selectedOptions = (array)$element->getValue();

        $rendered = $this->renderOptions($element, $options, $selectedOptions, $attributes);

        // Render hidden element
        $useHiddenElement = \method_exists($element, 'useHiddenElement') && $element->useHiddenElement()
            ? $element->useHiddenElement()
            : $this->useHiddenElement;

        if ($useHiddenElement) {
            $rendered = $this->renderHiddenElement($element, $attributes) . $rendered;
        }

        return $rendered;
    }

    protected function renderOptions(
        MultiCheckboxElement $element,
        array $options,
        array $selectedOptions,
        array $attributes
    ) {
        $escapeHtmlHelper = $this->getEscapeHtmlHelper();
        $labelHelper = $this->getLabelHelper();
        $labelClose = $labelHelper->closeTag();
        $labelPosition = $this->getLabelPosition();
        $globalLabelAttributes = [];
        $closingBracket = $this->getInlineClosingBracket();

        if ($element instanceof LabelAwareInterface) {
            $globalLabelAttributes = $element->getLabelAttributes();
        }

        if (empty($globalLabelAttributes)) {
            $globalLabelAttributes = $this->labelAttributes;
        }

        $combinedMarkup = [];
        $count = 0;

        foreach ($options as $key => $optionSpec) {
            $count++;
            if ($count > 1 && \array_key_exists('id', $attributes)) {
                unset($attributes['id']);
            }

            $value = '';
            $label = '';
            $inputAttributes = $attributes;
            $labelAttributes = $globalLabelAttributes;
            $selected = (isset($inputAttributes['selected'])
                && $inputAttributes['type'] != 'radio'
                && $inputAttributes['selected']);
            $disabled = (isset($inputAttributes['disabled']) && $inputAttributes['disabled']);

            if (\is_scalar($optionSpec)) {
                $optionSpec = [
                    'label' => $optionSpec,
                    'value' => $key
                ];
            }

            if (isset($optionSpec['value'])) {
                $value = $optionSpec['value'];
            }
            if (isset($optionSpec['label'])) {
                $label = $optionSpec['label'];
            }
            if (isset($optionSpec['selected'])) {
                $selected = $optionSpec['selected'];
            }
            if (isset($optionSpec['disabled'])) {
                $disabled = $optionSpec['disabled'];
            }
            if (isset($optionSpec['label_attributes'])) {
                $labelAttributes = \array_merge($labelAttributes, $optionSpec['label_attributes']);
            }
            if (isset($optionSpec['attributes'])) {
                $inputAttributes = \array_merge($inputAttributes, $optionSpec['attributes']);
            }

            if (\in_array($value, $selectedOptions)) {
                $selected = true;
            }

            $elementId = \md5($element->getName() . $label);
            $inputAttributes['class'] = 'form-check-input';

            if (\count($element->getMessages()) > 0) {
                $inputAttributes['class'] = 'form-check-input is-invalid';
            }

            $inputAttributes['id'] = $elementId;

            $inputAttributes['value'] = $value;
            $inputAttributes['checked'] = $selected;
            $inputAttributes['disabled'] = $disabled;

            $input = sprintf(
                '<input %s%s',
                $this->createAttributesString($inputAttributes),
                $closingBracket
            );

            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate(
                    $label,
                    $this->getTranslatorTextDomain()
                );
            }

            if (!$element instanceof LabelAwareInterface || !$element->getLabelOption('disable_html_escape')) {
                $label = $escapeHtmlHelper($label);
            }

            $labelAttributes['for'] = $elementId;
            $labelAttributes['class'] = 'form-check-label';

            $labelOpen = $labelHelper->openTag($labelAttributes);

            switch ($labelPosition) {
                case self::LABEL_PREPEND:
                    $markup = sprintf($this->template, $label, $labelOpen, $input, $labelClose);
                    break;
                case self::LABEL_APPEND:
                default:
                    $markup = sprintf($this->template, $input, $labelOpen, $label, $labelClose);
                    break;
            }

            $combinedMarkup[] = $markup;
        }

        return \implode($this->getSeparator(), $combinedMarkup);
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }
}
