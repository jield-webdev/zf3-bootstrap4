<?php
/**
 * Zf3Bootstrap4
 */

namespace Zf3Bootstrap4\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

/**
 * Class FormDescription
 *
 * @package Zf3Bootstrap4\Form\View\Helper
 */
final class FormDescription extends AbstractHelper
{
    protected $inlineWrapper = '<small class="form-text text-muted">%s</small>';
    private $blockWrapper = '<small class="form-text text-muted">%s</small>';

    public function getBlockWrapper(): string
    {
        return $this->blockWrapper;
    }

    public function setBlockWrapper($blockWrapper): self
    {
        $this->blockWrapper = (string)$blockWrapper;

        return $this;
    }

    public function getInlineWrapper(): string
    {
        return $this->inlineWrapper;
    }

    public function setInlineWrapper($inlineWrapper): self
    {
        $this->inlineWrapper = (string)$inlineWrapper;

        return $this;
    }

    public function __invoke(ElementInterface $element = null, string $blockWrapper = null, string $inlineWrapper = null
    ) {
        if ($element) {
            return $this->render($element, $blockWrapper, $inlineWrapper);
        }

        return $this;
    }

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

            $html .= \sprintf($inlineWrapper, $inline);
        }
        if ($block = $element->getOption('help-block')) {

            if (null !== ($translator = $this->getTranslator())) {
                $block = $translator->translate(
                    $block, $this->getTranslatorTextDomain()
                );
            }

            $html .= \sprintf($blockWrapper, $block);
        }

        return $html;
    }
}
