<?php
/**
 * Zf3Bootstrap4
 */

namespace Zf3Bootstrap4\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Badge
 */
class Badge extends AbstractHelper
{

    /**
     * @var string
     */
    protected $format = '<span class="badge %s">%s</span>';

    /**
     * Display an Informational Badge
     *
     * @param  string $badge
     * @return string
     */
    public function info($badge): string
    {
        return $this->render($badge, 'badge-info');
    }

    /**
     * Display an Important Badge
     *
     * @param  string $badge
     * @return string
     */
    public function important($badge): string
    {
        return $this->render($badge, 'badge-important');
    }

    /**
     * Display an Inverse Badge
     *
     * @param  string $badge
     * @return string
     */
    public function inverse($badge): string
    {
        return $this->render($badge, 'badge-inverse');
    }

    /**
     * Display a Sucess Badge
     *
     * @param  string $badge
     * @return string
     */
    public function success($badge): string
    {
        return $this->render($badge, 'badge-success');
    }

    /**
     * Display a Warning Badge
     *
     * @param  string $badge
     * @return string
     */
    public function warning($badge): string
    {
        return $this->render($badge, 'badge-warning');
    }

    /**
     * Render an Badge
     *
     * @param  string $badge
     * @param  string $class
     * @return string
     */
    public function render($badge, $class = ''): string
    {
        $class = trim($class);

        return sprintf($this->format, $class, $badge);
    }

    /**
     * Invoke Badge
     *
     * @param  string $badge
     * @param  string $class
     * @return string|self
     */
    public function __invoke($badge = null, $class = '')
    {
        if (null === $badge) {
            return $this->render($badge, $class);
        }

        return $this;
    }
}
