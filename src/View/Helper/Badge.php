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
    protected $format = '<span class="badge %s %s">%s</span>';

    /**
     * Display a primary Badge
     *
     * @param  string $badge
     * @param bool $pill
     * @return string
     */
    public function primary($badge, $pill = false): string
    {
        return $this->render($badge, 'badge-primary', $pill);
    }

    /**
     * Display a secondary Badge
     *
     * @param  string $badge
     * @param bool $pill
     * @return string
     */
    public function secondary($badge, $pill = false): string
    {
        return $this->render($badge, 'badge-secondary', $pill);
    }

    /**
     * Display an info Badge
     *
     * @param  string $badge
     * @param bool $pill
     * @return string
     */
    public function info($badge, $pill = false): string
    {
        return $this->render($badge, 'badge-info', $pill);
    }

    /**
     * Display a success Badge
     *
     * @param  string $badge
     * @param bool $pill
     * @return string
     */
    public function success($badge, $pill = false): string
    {
        return $this->render($badge, 'badge-success', $pill);
    }

    /**
     * Display a warning Badge
     *
     * @param  string $badge
     * @param bool $pill
     * @return string
     */
    public function warning($badge, $pill = false): string
    {
        return $this->render($badge, 'badge-warning', $pill);
    }

    /**
     * Display a danger Badge
     *
     * @param  string $badge
     * @param bool $pill
     * @return string
     */
    public function danger($badge, $pill = false): string
    {
        return $this->render($badge, 'badge-danger', $pill);
    }

    /**
     * Display a light Badge
     *
     * @param  string $badge
     * @param bool $pill
     * @return string
     */
    public function light($badge, $pill = false): string
    {
        return $this->render($badge, 'badge-light', $pill);
    }

    /**
     * Display a dark Badge
     *
     * @param  string $badge
     * @param bool $pill
     * @return string
     */
    public function dark($badge, $pill = false): string
    {
        return $this->render($badge, 'badge-dark', $pill);
    }

    /**
     * Render the badge
     *
     * @param string $badge
     * @param string $class
     * @param bool $pill
     * @return string
     */
    public function render(string $badge, string $class = '', bool $pill = false): string
    {
        $class = trim($class);

        return sprintf($this->format, $class, $pill ? 'badge-pill' : '', $badge);
    }

    /**
     * Invoke Badge
     *
     * @param  string $badge
     * @param  string $class
     * @param bool $pill
     * @return string|self
     */
    public function __invoke($badge = null, string $class = '', bool $pill = false)
    {
        if (null !== $badge) {
            return $this->render($badge, $class, $pill);
        }

        return $this;
    }
}
