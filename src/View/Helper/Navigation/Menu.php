<?php
/**
 * ZfcTwitterBootstrap
 */

namespace Zf3Bootstrap4\View\Helper\Navigation;

use RecursiveIteratorIterator;
use Zend\Navigation\AbstractContainer;
use Zend\Navigation\Page\AbstractPage;
use Zend\Navigation\Page\Mvc;
use Zend\View\Helper\Navigation\Menu as ZendMenu;

/**
 * Helper for rendering menus from navigation containers
 */
class Menu extends ZendMenu
{
    /**
     * CSS class to use for the ul element
     *
     * @var string
     */
    protected $ulClass = 'nav';

    /**
     * Renders a normal menu (called from {@link renderMenu()}).
     *
     * @param  AbstractContainer $container          container to render
     * @param  string            $ulClass            CSS class for first UL
     * @param  string            $indent             initial indentation
     * @param  int|null          $minDepth           minimum depth
     * @param  int|null          $maxDepth           maximum depth
     * @param  bool              $onlyActive         render only active branch?
     * @param  bool              $escapeLabels       Whether or not to escape the labels
     * @param  bool              $addClassToListItem Whether or not page class applied to <li> element
     * @param  string            $liActiveClass      CSS class for active LI
     * @return string
     */
    protected function renderNormalMenu(
        AbstractContainer $container,
        $ulClass,
        $indent,
        $minDepth,
        $maxDepth,
        $onlyActive,
        $escapeLabels,
        $addClassToListItem,
        $liActiveClass
    ): string {
        $html = '';

        // find deepest active
        $found = $this->findActive($container, $minDepth, $maxDepth);

        /* @var $escaper \Zend\View\Helper\EscapeHtmlAttr */
        $escaper = $this->view->plugin('escapeHtmlAttr');

        if ($found) {
            /** @var Mvc $foundPage */
            $foundPage  = $found['page'];
            $foundDepth = $found['depth'];
        } else {
            $foundPage = null;
        }

        // create iterator
        $iterator = new RecursiveIteratorIterator(
            $container,
            RecursiveIteratorIterator::SELF_FIRST
        );

        if (is_int($maxDepth)) {
            $iterator->setMaxDepth($maxDepth);
        }

        // iterate container
        $prevDepth = -1;
        /** @var Mvc $page */
        foreach ($iterator as $page) {
            $depth = $iterator->getDepth();
            $isActive = $page->isActive(true);
            if ($depth < $minDepth || ! $this->accept($page)) {
                // page is below minDepth or not accepted by acl/visibility
                continue;
            } elseif ($onlyActive && ! $isActive) {
                // page is not active itself, but might be in the active branch
                $accept = false;
                if ($foundPage) {
                    if ($foundPage->hasPage($page)) {
                        // accept if page is a direct child of the active page
                        $accept = true;
                    } elseif ($foundPage->getParent()->hasPage($page)) {
                        // page is a sibling of the active page...
                        if (! $foundPage->hasPages(! $this->renderInvisible)
                            || is_int($maxDepth) && $foundDepth + 1 > $maxDepth
                        ) {
                            // accept if active page has no children, or the
                            // children are too deep to be rendered
                            $accept = true;
                        }
                    }
                }
                if (! $accept) {
                    continue;
                }
            }

            // make sure indentation is correct
            $depth -= $minDepth;
            $myIndent = $indent.str_repeat('        ', $depth);
            if ($depth > $prevDepth) {
                // start new ul tag
                if ($ulClass && $depth == 0) {
                    $ulClass = ' class="' . $escaper($ulClass) . '"';
                } else {
                    $ulClass = '';
                }

                if ($depth === 0) {
                    $html .= $myIndent . '<ul' . $ulClass . '>' . PHP_EOL;
                } else {
                    $html .= $myIndent . '<div class="dropdown-menu">' . PHP_EOL;
                }
            }

            // render li tag and page
            $liClasses = ['nav-item'];

            // Is page active?
            if ($isActive) {
                $liClasses[] = $liActiveClass;
            }

            if ($page->hasPages())
            {
                $liClasses[] = 'dropdown';
            }

            // Add CSS class from page to <li>
            if ($addClassToListItem && $page->getClass()) {
                $liClasses[] = $page->getClass();
            }
            $liClass = empty($liClasses) ? '' : ' class="' . $escaper(implode(' ', $liClasses)) . '"';
            $html .= $myIndent
                . ($depth === 0 ? '    <li' . $liClass . '>' : '')
                . PHP_EOL
                . $myIndent
                . '        '
                . $this->htmlify($page, $escapeLabels, $depth > 0)
                . PHP_EOL;

            // store as previous depth for next iteration
            $prevDepth = $depth;
        }

        return $html;
    }

    /**
     * Returns an HTML string containing an 'a' element for the given page if
     * the page's href is not empty, and a 'span' element if it is empty.
     *
     * Overrides {@link AbstractHelper::htmlify()}.
     *
     * @param  AbstractPage $page               page to generate HTML for
     * @param  bool         $escapeLabel        Whether or not to escape the label
     * @param  bool         $isChild Whether or not to add the page class to the list item
     * @return string
     */
    public function htmlify(AbstractPage $page, $escapeLabel = true, $isChild = false): string
    {
        // get attribs for element
        $attribs = [
            'id'     => $page->getId(),
            'title'  => $this->translate($page->getTitle(), $page->getTextDomain()),
        ];


        $class[] = $page->getClass();

        if (!$isChild && $page->hasPages()) {
            $attribs['data-toggle'] = 'dropdown';
            $class[] = 'dropdown-toggle';
        }

        if ($isChild) {
            $class[] = 'dropdown-item';
        } else {
            $class[] = 'nav-link';
        }

        // does page have a href?
        $href = $page->getHref();
        if ($href) {
            $element           = 'a';
            $attribs['href']   = $href;
            $attribs['target'] = $page->getTarget();
        } else {
            $element = 'span';
        }

        if (count($class) > 0) {
            $attribs['class'] = implode(' ', $class);
        }

        $html  = '<' . $element . $this->htmlAttribs($attribs) . '>';
        $label = $this->translate($page->getLabel(), $page->getTextDomain());

        if ($escapeLabel === true) {
            /** @var \Zend\View\Helper\EscapeHtml $escaper */
            $escaper = $this->view->plugin('escapeHtml');
            $html .= $escaper($label);
        } else {
            $html .= $label;
        }

        $html .= '</' . $element . '>';
        return $html;
    }
}
