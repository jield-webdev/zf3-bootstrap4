<?php
/**
 * Zf3Bootstrap4
 */

namespace Zf3Bootstrap4\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormElement as ZendFormElement;
use Zend\Form\View\Helper\FormElementErrors;
use Zend\Form\View\Helper\FormLabel;
use Zend\View\Helper\EscapeHtml;

/**
 * Form Element
 */
class FormElement extends ZendFormElement
{
<<<<<<< Updated upstream
=======
    protected $typeMap
        = [
            'text'           => 'zf3b4forminput',
            'email'          => 'zf3b4forminput',
            'number'         => 'zf3b4forminput',
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
>>>>>>> Stashed changes
    /**
     * @var \Zend\Form\View\Helper\FormLabel
     */
    protected $labelHelper;

    /**
     * @var ZendFormElement
     */
    protected $elementHelper;

    /**
     * @var \Zend\View\Helper\EscapeHtml
     */
<<<<<<< Updated upstream
    protected $escapeHelper;
=======
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
                                                <div class="col-sm-3 offset-sm-3">
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

    private $test = '<div class="form-group row">
    <div class="col-sm-2">Checkbox</div>
    <div class="col-sm-10">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="gridCheck1">
        <label class="form-check-label" for="gridCheck1">
          Example checkbox
        </label>
      </div>
    </div>
  </div>';

    public function __construct(HelperPluginManager $viewHelperManager, Translator $translator)
    {
        $this->formLabel = $viewHelperManager->get('formlabel');
        $this->escapeHtml = $viewHelperManager->get('escapehtml');
        $this->formDescription = $viewHelperManager->get('zf3b4formdescription');
        $this->formElementErrors = $viewHelperManager->get('formelementerrors');
>>>>>>> Stashed changes

    /**
     * @var \Zend\Form\View\Helper\FormElementErrors
     */
    protected $elementErrorHelper;

    /**
     * @var FormDescription
     */
    protected $descriptionHelper;
    /**
     * @var string
     */
    protected $groupWrapper = '<div class="form-group %s" id="control-group-%s">%s</div>';

    /**
     * @var string
     */
    protected $controlWrapper = '<div class="col-sm-9">%s%s%s</div>';
    /**
     * @var bool
     */
    protected $inline = false;

    public function __invoke(ElementInterface $element = null, $groupWrapper = null, $controlWrapper = null) {
        if ($element) {
            return $this->render($element, $groupWrapper, $controlWrapper);
        }

        return $this;
    }

    public function render(ElementInterface $element, $groupWrapper = null, $controlWrapper = null,
        bool $dropdown = false
    ) {
        $labelHelper = $this->getLabelHelper();
        $escapeHelper = $this->getEscapeHtmlHelper();
        $elementHelper = $this->getElementHelper();
        $elementErrorHelper = $this->getElementErrorHelper();
        $descriptionHelper = $this->getDescriptionHelper();
        $groupWrapper = $groupWrapper ?: $this->groupWrapper;
        $controlWrapper = $controlWrapper ?: $this->controlWrapper;

        $hiddenElementForCheckbox = '';
        if (method_exists($element, 'useHiddenElement') && $element->useHiddenElement()) {
            // If we have hidden input with checkbox's unchecked value, render that separately so it can be prepended later, and unset it in the element
            $withHidden = $elementHelper->render($element);
            $withoutHidden = $elementHelper->render($element->setUseHiddenElement(false));
            $hiddenElementForCheckbox = str_ireplace($withoutHidden, '', $withHidden);
        }

        $id = $element->getAttribute('id') ?: $element->getAttribute('name');

        $classes = [$element->getAttribute('class')];

        //Different form elements require different classes
        switch (true) {
            case $element instanceof \Zend\Form\Element\Radio:
            case $element instanceof \Zend\Form\Element\Checkbox:
                $classes[] = 'form-check-input';
                break;
            case $element instanceof \Zend\Form\Element\Hidden:
            case $element instanceof \Zend\Form\Element\Button:
            case $element instanceof \Zend\Form\Element\Submit:
                break;
            default:
                $classes[] = 'form-control';
                break;
        }

        //Add the is-invalid when no suited option is given
        if (!empty($element->getMessages())) {
            $classes[] = 'is-invalid';
        }

        $element->setAttribute('class', implode(' ', $classes));

        //Dedicated control-wrapper for inline form elemens
        if ($element->getOption('inline')) {
            $controlWrapper = '%s%s%s';
        }


        $controlLabel = '';
        $label = $element->getLabel();
        if (strlen($label) === 0) {
            $label = $element->getOption('label') ?: $element->getAttribute('label');
        }

        if ($label && !$element->getOption('skipLabel')) {

            $labelClasses = [];

            if (!$element->getOption('wrapCheckboxInLabel')) {
                $labelClasses[] .= 'col-form-label';
            }

            if (!$element->getOption('inline')) {
                $labelClasses[] .= 'col-sm-3';
            }

            //Wrap the checkboxes in special form-check-elements
            if ($element instanceof \Zend\Form\Element\Checkbox) {
                $labelClasses[] .= 'col-form-label pt-0';
            }

            $controlLabel .= $labelHelper->openTag(
                [
                    'class' => implode(' ', $labelClasses),
                ] + ($element->hasAttribute('id') ? ['for' => $id] : [])
            );

            if (null !== ($translator = $labelHelper->getTranslator())) {
                $label = $translator->translate(
                    $label,
                    $labelHelper->getTranslatorTextDomain()
                );
            }
            if ($element->getOption('wrapCheckboxInLabel')) {
                $controlLabel .= $elementHelper->render($element) . ' ';
            }
            if ($element->getOption('skipLabelEscape')) {
                $controlLabel .= $label;
            } else {
                $controlLabel .= $escapeHelper($label);
            }
            $controlLabel .= $labelHelper->closeTag();
        }

<<<<<<< Updated upstream
        if ($element->getOption('wrapCheckboxInLabel')) {
            $controls = $controlLabel;
            $controlLabel = '';
        } else {
            $controls = $elementHelper->render($element);
        }
=======
        if (isset($this->typeMap[$type])) {
            //Produce the label
            $label = $this->findLabel($element);
            $renderedElement = $this->renderHelper($this->typeMap[$type], $element);
            $description = $this->parseDescription($element);
            $error = $this->hasFormElementError($element) ? $this->parseFormElementError($element) : null;
>>>>>>> Stashed changes


        //Wrap the checkboxes in special form-check-elements
        if (!$dropdown) {
            if ($element instanceof \Zend\Form\Element\Checkbox) {
                $controls = str_replace(
                    ['<label', '</label>'],
                    ['<div class="form-check"><label class="form-check-label"', '</label></div>'],
                    $controls
                );
            }
        }

<<<<<<< Updated upstream
        if ($dropdown) {

            if ($element instanceof \Zend\Form\Element\Checkbox) {
                $controls = str_replace(
                    ['<label>', '</label>'],
                    ['<a class="dropdown-item">', '</a>'],
                    $controls
                );
=======
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

                    $label = '<label class="custom-control-label" for="' . \md5($element->getName()) . '">' . $label
                        . '</label>';
                    return \sprintf($wrapper, $renderedElement, $label, $error, $description);

                    break;
                case 'submit':
                case 'button':
                    return $renderedElement;
                default:
                    $label = $this->parseLabel($element);
>>>>>>> Stashed changes
            }

            $html = sprintf(
                "%s%s",
                $controls,
                $descriptionHelper->render($element)

            );

            return \sprintf($groupWrapper, $html);
        }


        if ($element instanceof \Zend\Form\Element\Hidden
            || $element instanceof \Zend\Form\Element\Submit
            || $element instanceof \Zend\Form\Element\Button
        ) {
            return $controls . $elementErrorHelper->render($element);
        }


        //As of Bootstrap 4 the error element is wrapped in a div
        $errorElement = $elementErrorHelper->render($element);
        if (!empty($errorElement)) {
            $errorElement = sprintf('<div class="invalid-feedback">%s</div>', $errorElement);
        }

        $html = $hiddenElementForCheckbox . $controlLabel . sprintf(
                $controlWrapper,
                $controls,
                $errorElement,
                $descriptionHelper->render($element)

            );

        return sprintf($groupWrapper, (!$element->getOption('inline') ? 'row' : ''), $id, $html);
    }

<<<<<<< Updated upstream
    /**
     * Get Label Helper
     *
     * @return \Zend\Form\View\Helper\FormLabel
     */
    public function getLabelHelper()
=======
    private function findLabel(ElementInterface $element): ?string
>>>>>>> Stashed changes
    {
        if (!$this->labelHelper) {
            $this->setLabelHelper($this->view->plugin('formlabel'));
        }

<<<<<<< Updated upstream
        return $this->labelHelper;
    }

    /**
     * Set Label Helper
     *
     * @param  \Zend\Form\View\Helper\FormLabel $labelHelper
     *
     * @return self
     */
    public function setLabelHelper(FormLabel $labelHelper): FormElement
    {
        $labelHelper->setView($this->getView());
        $this->labelHelper = $labelHelper;

        return $this;
    }

    /**
     * Get EscapeHtml Helper
     *
     * @return \Zend\View\Helper\EscapeHtml
     */
    public function getEscapeHtmlHelper()
    {
        if (!$this->escapeHelper) {
            $this->setEscapeHtmlHelper($this->view->plugin('escapehtml'));
        }

        return $this->escapeHelper;
    }

    /**
     * Set EscapeHtml Helper
     *
     * @param  \Zend\View\Helper\EscapeHtml $escapeHelper
     *
     * @return self
     */
    public function setEscapeHtmlHelper(EscapeHtml $escapeHelper)
    {
        $escapeHelper->setView($this->getView());
        $this->escapeHelper = $escapeHelper;

        return $this;
    }

    /**
     * Get Element Helper
     *
     * @return \Zend\Form\View\Helper\FormElement
     */
    public function getElementHelper(): \Zend\Form\View\Helper\FormElement
    {
        if (!$this->elementHelper) {
            $this->setElementHelper($this->view->plugin('formelement'));
        }

        return $this->elementHelper;
    }

    /**
     * Set Element Helper
     *
     * @param  \Zend\Form\View\Helper\FormElement $elementHelper
     *
     * @return self
     */
    public function setElementHelper(ZendFormElement $elementHelper): self
    {
        $elementHelper->setView($this->getView());
        $this->elementHelper = $elementHelper;

        return $this;
    }

    /**
     * Get Element Error Helper
     *
     * @return \Zend\Form\View\Helper\FormElementErrors
     */
    public function getElementErrorHelper(): FormElementErrors
    {
        if (!$this->elementErrorHelper) {
            $this->setElementErrorHelper($this->view->plugin('formelementerrors'));
        }

        return $this->elementErrorHelper;
    }

    /**
     * Set Element Error Helper
     *
     * @param  \Zend\Form\View\Helper\FormElementErrors $errorHelper
     *
     * @return self
     */
    public function setElementErrorHelper(FormElementErrors $errorHelper): self
    {
        $errorHelper->setView($this->getView());

        $this->elementErrorHelper = $errorHelper;

        return $this;
    }

    /**
     * Get Description Helper
     *
     * @return FormDescription
     */
    public function getDescriptionHelper(): FormDescription
    {
        if (!$this->descriptionHelper) {
            $this->setDescriptionHelper($this->view->plugin('ztbformdescription'));
        }

        return $this->descriptionHelper;
    }

    /**
     * Set Description Helper
     *
     * @param FormDescription
     *
     * @return self
     */
    public function setDescriptionHelper(FormDescription $descriptionHelper): self
    {
        $descriptionHelper->setView($this->getView());
        $this->descriptionHelper = $descriptionHelper;

        return $this;
=======
        if (null !== ($translator = $this->formLabel->getTranslator())) {
            $label = $translator->translate($label);
        }

        return $label;
>>>>>>> Stashed changes
    }

    /**
     * Get Group Wrapper
     *
     * @return string
     */
    public function getGroupWrapper(): string
    {
        return $this->groupWrapper;
    }

    /**
     * Set Group Wrapper
     *
     * @param  string $groupWrapper
     *
     * @return self
     */
    public function setGroupWrapper($groupWrapper): self
    {
        $this->groupWrapper = (string)$groupWrapper;

        return $this;
    }

    /**
     * Get Control Wrapper
     *
     * @return string
     */
    public function getControlWrapper(): string
    {
        return $this->controlWrapper;
    }

    /**
     * Set Control Wrapper
     *
     * @param  string $controlWrapper ;
     *
     * @return self
     */
    public function setControlWrapper($controlWrapper): self
    {
        $this->controlWrapper = (string)$controlWrapper;

        return $this;
    }

    private function parseLabel(ElementInterface $element): string
    {
        $label = $this->findLabel($element);

        $openTagAttributes = ['for' => $element->getName()];

        if (!$this->inline) {
            $openTagAttributes['class'] = 'col-sm-3 col-form-label';
        }

        $openTag = $this->formLabel->openTag($openTagAttributes);


        if (!$element instanceof LabelAwareInterface || !$element->getLabelOption('disable_html_escape')) {
            $label = $this->escapeHtml->__invoke($label);
        }

        return $openTag . $label . $this->formLabel->closeTag();


        return \sprintf('%s%s', $this->formLabel->openTag(), $this->formLabel->closeTag());
    }
}
