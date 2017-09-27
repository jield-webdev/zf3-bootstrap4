<?php
/**
 * Zf3Bootstrap4
 */

namespace Zf3Bootstrap4\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Alert
 */
class Alert extends AbstractHelper
{
    /**
     * @var string
     */
    protected $format = '<div class="alert %s" role="alert">%s%s</div>';

    /**
     * Display an Informational Alert
     *
     * @param  string $alert
     * @param  bool $isDismissable
     *
     * @return string
     */
    public function info(string $alert, bool $isDismissable = false): string
    {
        return $this->render($alert, 'alert-info', $isDismissable);
    }

    /**
     * Display an Danger Alert
     *
     * @param  string $alert
     * @param  bool $isDismissable
     *
     * @return string
     */
    public function danger(string $alert, bool $isDismissable = false): string
    {
        return $this->render($alert, 'alert-danger', $isDismissable);
    }

    /**
     * Display a Success Alert
     *
     * @param  string $alert
     * @param  bool $isDismissable
     *
     * @return string
     */
    public function success(string $alert, bool $isDismissable = false): string
    {
        return $this->render($alert, 'alert-success', $isDismissable);
    }

    /**
     * Display a Warning Alert
     *
     * @param  string $alert
     * @param  bool $isDismissable
     *
     * @return string
     */
    public function warning(string $alert, bool $isDismissable = false): string
    {
        return $this->render($alert, 'alert-warning', $isDismissable);
    }

    /**
     * Render an Alert
     *
     * @param  string $alert
     * @param  bool $isDismissable
     * @param  string $class
     *
     * @return string
     */
    public function render(string $alert, string $class = '', bool $isDismissable = false): string
    {
        $closeButton = '';
        if ($isDismissable) {
            $closeButton = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        }
        $class = trim($class);

        return sprintf($this->format, $class, $closeButton, $alert);
    }

    /**
     * Invoke Alert
     *
     * @param string|null $alert
     * @param string $class
     * @param bool $isDismissable
     * @return $this|string
     */
    public function __invoke(string $alert = null, string $class = '', bool $isDismissable = false)
    {
        if (null !== $alert) {
            return $this->render($alert, $class, $isDismissable);
        }

        return $this;
    }
}
