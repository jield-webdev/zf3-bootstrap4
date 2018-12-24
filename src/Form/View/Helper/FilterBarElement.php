<?php
/**
 * Zf3Bootstrap4
 */

namespace Zf3Bootstrap4\Form\View\Helper;

use Search\Form\SearchResult;
use Zend\Form\Element\MultiCheckbox;
use Zend\Form\ElementInterface;

/**
 * Class FilterBarElement
 *
 * @package Zf3Bootstrap4\Form\View\Helper
 */
class FilterBarElement extends FormElement
{


    public function __invoke(ElementInterface $element = null, $groupWrapper = null, $controlWrapper = null)
    {

        if ($element) {
            return $this->renderFilterBar($element);
        }

        return $this;
    }


    private function renderFilterBar(SearchResult $element)
    {

        $wrapper = '
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Filter</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#filterBar"
                    aria-controls="filterBar" aria-expanded="false" aria-label="Toggle Filter">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse" id="filterBar">
                <ul class="navbar-nav mr-auto">
                     %s                   
                </ul>
                <div class="input-group col-lg-5">%s
                    <div class="input-group-append">
                        %s
                        %s
                    </div>
                </div>
            </div>
        </nav>
        
        <style type="text/css">
            .dropdown-item > label > input {
                margin-right: 0.3rem;  
            }
        </style>
    ';

        return \sprintf(
            $wrapper,
            $this->renderFacets($element),
            $this->renderRaw($element->get('query')),
            $this->renderRaw($element->get('search')),
            $this->renderRaw($element->get('reset'))
        );
    }

    private function renderFacets(SearchResult $element): string
    {
        $facets = [];

        $facetWrapper = '  <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown-%d" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            %s
                        </a>
                        
                        <div class="dropdown-menu inactive" area-labelledby="searchDropdown-%d">%s</div>

                        
                    </li>';


        $counter = 1;
        /** @var MultiCheckbox $facet */
        foreach ($element->get('facet') as $facet) {
            $facets[] = \sprintf($facetWrapper, $counter, $facet->getLabel(), $counter, $this->renderRaw($facet));
            $counter++;
        }

        return \implode(PHP_EOL, $facets);


    }


    private function renderRaw(ElementInterface $element): string
    {
        $elementHelper = $this->getElementHelper();
        $descriptionHelper = $this->getDescriptionHelper();
        $controls = $elementHelper->render($element);

        $controls = str_replace(
            ['<label>', '</label>'],
            ['<span class="d-block dropdown-item"><label>', '</label></span>'],
            $controls
        );

        $html = sprintf(
            "%s%s",
            $controls,
            $descriptionHelper->render($element)

        );

        return \sprintf('%s', $html);
    }
}
