<?php
/**
 * LoggerAwareTrait trait file.
 *
 * @package   Atan\Common
 * @author    atanvarno69 <https://github.com/atanvarno69>
 * @copyright 2017 atanvarno.com
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Atan\Common;

/** PSR-3 use block. */
use Psr\Log\LoggerInterface;

trait LoggerAwareTrait
{
    /** @var LoggerInterface $logger PSR-3 logger. */
    protected $logger;
    
    /**
     * Sets a logger.
     *
     * @param LoggerInterface $logger PSR-3 logger.
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    /**
     * Access the `log()` method from the logger.
     *
     * @param string $level   Use `LogLevel` constants.
     * @param string $message Message to log.
     * @param array  $context Context array for the message.
     *
     * @return void
     */
    protected function log(string $level, string $message, array $context = [])
    {
        if (isset($this->logger)) {
            $message = get_class($this) . ': ' . $message;
            $this->logger->log($level, $message, $context);
        }
    }
}
