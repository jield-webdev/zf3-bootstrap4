<?php
/**
 * Zf3Bootstrap4
 */

namespace Zf3Bootstrap4\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

/**
 * Form Description
 */
class FormDescription extends AbstractHelper
{
    /**
     * @var string wrapper for displaying block help
     */
    protected $blockWrapper = '<small class="form-text text-muted">%s</small>';

    /**
     * @var string wrapper for displaying inline help
     */
    protected $inlineWrapper = '<small class="form-text text-muted">%s</small>';

    /**
     * Set Block Wrapper
     *
     * @param  string $blockWrapper
     * @return self
     */
    public function setBlockWrapper($blockWrapper):self
    {
        $this->blockWrapper = (string) $blockWrapper;

        return $this;
    }

    /**
     * Get Block Wrapper
     *
     * @return string
     */
    public function getBlockWrapper():string
    {
        return $this->blockWrapper;
    }

    /**
     * Set Inline wrapper
     *
     * @param  string $inlineWrapper
     * @return self
     */
    public function setInlineWrapper($inlineWrapper): self
    {
        $this->inlineWrapper = (string) $inlineWrapper;

        return $this;
    }

    /**
     * Get Inline Wrapper
     *
     * @return string
     */
    public function getInlineWrapper():string
    {
        return $this->inlineWrapper;
    }

    /**
     * Render
     *
     * @param  \Zend\Form\ElementInterface $element
     * @param  string                      $blockWrapper
     * @param  string                      $inlineWrapper
     * @return string
     * @throws \InvalidArgumentException
     */
    public function render(ElementInterface $element, string $blockWrapper = null, string $inlineWrapper = null)
    {
        $blockWrapper = $blockWrapper ?: $this->blockWrapper;
        $inlineWrapper = $inlineWrapper ?: $this->inlineWrapper;

        $html = '';
        if ($inline = $element->getOption('help-inline')) {

            if (null !== ($translator = $this->getTranslator())) {
                $inline = $translator->translate(
                    $inline, $this->getTranslatorTextDomain()
                );
            }

            $html .= sprintf($inlineWrapper, $inline);
        }
        if ($block = $element->getOption('help-block')) {

            if (null !== ($translator = $this->getTranslator())) {
                $block = $translator->translate(
                    $block, $this->getTranslatorTextDomain()
                );
            }

            $html .= sprintf($blockWrapper, $block);
        }

        return $html;
    }

    /***
     * @param ElementInterface|null $element
     * @param string|null $blockWrapper
     * @param string|null $inlineWrapper
     * @return $this|string
     */
    public function __invoke(ElementInterface $element = null, string $blockWrapper = null, string $inlineWrapper = null)
    {
        if ($element) {
            return $this->render($element, $blockWrapper, $inlineWrapper);
        }

        return $this;
    }
}
