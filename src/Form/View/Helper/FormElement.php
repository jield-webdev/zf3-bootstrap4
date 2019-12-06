<?php

namespace Zf3Bootstrap4\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\LabelAwareInterface;
use Zend\Form\View\Helper;
use Zend\I18n\Translator\TranslatorInterface;
use Zend\View\Helper\EscapeHtml;
use Zend\View\HelperPluginManager;
use function md5;
use function sprintf;

class FormElement extends Helper\FormElement
{
    protected $typeMap
        = [
            'text'           => 'zf3b4forminput',
            'email'          => 'zf3b4forminput',
            'number'         => 'zf3b4forminput',
            'color'          => 'zf3b4forminput',
            'password'       => 'zf3b4forminput',
            'url'            => 'zf3b4forminput',
            'checkbox'       => 'zf3b4formcheckbox',
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
     * @var TranslatorInterface
     */
    protected $translator;
    protected $inline = false;

    private $inlineWrapper = '<div class="form-group">%s%s%s%s</div>';
    private $horizontalWrapper = '<div class="form-group row">%s<div class="col-sm-9">%s%s%s</div></div>';
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
    private $checkboxWrapper = '<div class="form-group row">
                                    <div class="col-form-label col-sm-3 pt-0">%s</div>
                                    <div class="col-sm-9">
                                        %s
                                        %s
                                        %s
                                    </div>
                             </div>';
    private $inlineCheckboxWrapper = '<div class="form-group">
                                    <strong class="col-form-label">%s</strong>
                                        %s
                                        %s
                                        %s
                                    </div>';
    private $singleCheckboxWrapper = '<div class="form-group row">
                                                <div class="col-sm-9 offset-sm-3">
                                                    <div class="custom-control custom-switch">
                                                        %s
                                                        %s
                                                    </div>
                                                </div>    
                                            </div>';
    private $inlineSingleCheckboxWrapper = '<div class="custom-control custom-checkbox">
                                        %s
                                        %s
                                    </div>';

    public function __construct(HelperPluginManager $viewHelperManager, TranslatorInterface $translator)
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

        $element->setValue($this->translator->translate($element->getValue()));

        return parent::render($element);
    }

    protected function renderType(ElementInterface $element): ?string
    {
        $type = $element->getAttribute('type');

        if (isset($this->typeMap[$type])) {
            //Produce the label
            $label = $this->findLabel($element);
            $renderedElement = $this->renderHelper($this->typeMap[$type], $element);
            $description = $this->parseDescription($element);
            $error = $this->hasFormElementError($element) ? $this->parseFormElementError($element) : null;

            $wrapper = $this->horizontalWrapper;

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
                case 'checkbox':
                    $wrapper = $this->singleCheckboxWrapper;

                    if ($this->inline) {
                        $wrapper = $this->inlineSingleCheckboxWrapper;
                    }

                    $label = '<label class="custom-control-label" for="' . md5($element->getName()) . '">' . $label
                        . '</label>';
                    return sprintf($wrapper, $renderedElement, $label, $error, $description);

                    break;
                case 'submit':
                case 'button':
                    return $renderedElement;
                default:
                    $label = $this->parseLabel($element);
            }

            return sprintf($wrapper, $label, $renderedElement, $error, $description);
        }

        return null;
    }

    private function findLabel(ElementInterface $element): ?string
    {
        $label = $element->getLabel();
        if (null !== $element->getAttribute('label')) {
            $label = $element->getAttribute('label');
        }

        if (null !== ($translator = $this->formLabel->getTranslator())) {
            $label = $translator->translate($label);
        }

        return $label;
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

    protected function parseLabel(ElementInterface $element): string
    {
        $label = $this->findLabel($element);

        if (null === $label) {
            return '';
        }

        $openTagAttributes = ['for' => $element->getName()];

        if (!$this->inline) {
            $openTagAttributes['class'] = 'col-sm-3 col-form-label';
        }

        $openTag = $this->formLabel->openTag($openTagAttributes);


        if (!$element instanceof LabelAwareInterface || !$element->getLabelOption('disable_html_escape')) {
            $label = $this->escapeHtml->__invoke($label);
        }

        return $openTag . $label . $this->formLabel->closeTag();
    }
}
