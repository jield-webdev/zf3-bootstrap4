<?php

namespace Zf3Bootstrap4\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\LabelAwareInterface;
use Zend\Form\View\Helper;
use Zend\I18n\Translator\Translator;
use Zend\View\Helper\EscapeHtml;
use Zend\View\HelperPluginManager;

class FormElement extends Helper\FormElement
{
    protected $typeMap
        = [
            'text'           => 'zf3b4forminput',
            'email'          => 'zf3b4forminput',
            'number'         => 'zf3b4forminput',
            'url'            => 'zf3b4forminput',
            'file'           => 'zf3b4formfile',
            'textarea'       => 'zf3b4formtextarea',
            'radio'          => 'zf3b4formradio',
            'datetime'       => 'zf3b4forminput',
            'date'           => 'zf3b4forminput',
            'select'         => 'zf3b4formselect',
            'multi_checkbox' => 'zf3b4formmulticheckbox',
        ];
    /**
     * @var Helper\FormLabel
     */
    private $formLabel;
    /**
     * @var EscapeHtml
     */
    private $escapeHtml;
    /**
     * @var FormDescription
     */
    private $formDescription;
    /**
     * @var Helper\FormElementErrors
     */
    private $formElementErrors;
    /**
     * @var Translator
     */
    private $translator;
    private $inline = false;

    private $inlineWrapper = '<div class="form-group">%s%s%s%s</div>';
    private $horizonalWrapper = '<div class="form-group row">%s<div class="col-sm-9">%s%s%s</div></div>';
    private $radioWrapper = '<fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-3 pt-0">%s</legend>
                                    <div class="col-sm-9">
                                        %s
                                        %s
                                        %s
                                    </div>
                                </div>
                             </fieldset>';
    private $inlineRadioWrapper = '<div class="form-group">
                                    <strong class="col-form-label">%s</strong>
                                        %s
                                        %s
                                        %s                                
                             </div>';
    private $checkboxWrapper = '<fieldset class="form-group row">
                                    <div class="col-form-label col-sm-3 pt-0">%s</div>
                                    <div class="col-sm-9">
                                        %s
                                        %s
                                        %s
                                    </div>
                             </fieldset>';
    private $inlineCheckboxWrapper = '<div class="form-group">
                                    <strong class="col-form-label">%s</strong>
                                        %s
                                        %s
                                        %s
                                    </div>';

    public function __construct(HelperPluginManager $viewHelperManager, Translator $translator)
    {
        $this->formLabel = $viewHelperManager->get('formlabel');
        $this->escapeHtml = $viewHelperManager->get('escapehtml');
        $this->formDescription = $viewHelperManager->get('zf3b4formdescription');
        $this->formElementErrors = $viewHelperManager->get('formelementerrors');

        $this->translator = $translator;
    }


    public function __invoke(ElementInterface $element = null, bool $inline = false)
    {
        $this->inline = $inline;

        if ($element) {
            return $this->render($element);
        }

        return $this;
    }

    public function render(ElementInterface $element)
    {
        $renderedType = $this->renderType($element);

        if ($renderedType !== null) {
            return $renderedType;
        }

//        var_dump($element->getAttribute('type') . ' cannot be found');

        $element->setValue($this->translator->translate($element->getValue()));

        return parent::render($element);
    }

    protected function renderType(ElementInterface $element): ?string
    {
        $type = $element->getAttribute('type');

        if (isset($this->typeMap[$type])) {
            //Produce the label
            $label = $this->parseLabel($element);
            $renderedElement = $this->renderHelper($this->typeMap[$type], $element);
            $description = $this->parseDescription($element);
            $error = $this->hasFormElementError($element) ? $this->parseFormElementError($element) : null;

            $wrapper = $this->horizonalWrapper;

            if ($this->inline) {
                $wrapper = $this->inlineWrapper;
            }

            switch ($type) {
                case 'radio':
                    $wrapper = $this->radioWrapper;

                    if ($this->inline) {
                        $wrapper = $this->inlineRadioWrapper;
                    }
                    break;
                case 'multi_checkbox':
                    $wrapper = $this->checkboxWrapper;

                    if ($this->inline) {
                        $wrapper = $this->inlineCheckboxWrapper;
                    }
                    break;
                case 'submit':
                case 'button':
                    return $renderedElement;
                default:
                    $label = $this->parseLabel($element, false);
            }

            return \sprintf($wrapper, $label, $renderedElement, $error, $description);
        }

        return null;
    }

    private function parseLabel(ElementInterface $element, bool $inline = true): string
    {
        $label = $element->getLabel();
        if (null !== $element->getAttribute('label')) {
            $label = $element->getAttribute('label');
        }

        $openTagAttributes = ['for' => $element->getName()];

        if (!$inline) {
            $openTagAttributes['class'] = 'col-sm-3 col-form-label';
        }

        $openTag = $this->formLabel->openTag($openTagAttributes);

        if (null !== ($translator = $this->formLabel->getTranslator())) {
            $label = $translator->translate($label);
        }

        if (!$element instanceof LabelAwareInterface || !$element->getLabelOption('disable_html_escape')) {
            $label = $this->escapeHtml->__invoke($label);
        }

        return $openTag . $label . $this->formLabel->closeTag();


        return \sprintf('%s%s', $this->formLabel->openTag(), $this->formLabel->closeTag());
    }

    private function parseDescription(ElementInterface $element): string
    {
        return $this->formDescription->__invoke($element);
    }

    private function hasFormElementError(ElementInterface $element): bool
    {
        return '' !== $this->parseFormElementError($element);
    }

    private function parseFormElementError(ElementInterface $element): string
    {
        $this->formElementErrors->setMessageOpenFormat('<div class="invalid-feedback"><span%s>');
        $this->formElementErrors->setMessageSeparatorString('<br>');
        $this->formElementErrors->setMessageCloseString('</span></div>');

        return $this->formElementErrors->__invoke($element);
    }
}
