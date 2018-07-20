<?php

namespace fortabbit\MemcachedCli;

use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * ConsoleOutput
 *
 * Block styles
 */
class ConsoleOutput extends SymfonyStyle
{
    const EXIT_SUCCESS = 0;
    const EXIT_ERROR = 1;

    const BAR_STATUS_OK = 'fg=green';
    const BAR_STATUS_WARNING = 'fg=yellow';
    const BAR_STATUS_CRITICAL = 'fg=red';

    /**
     * Formats a message as a block of text.
     *
     * @param string|array $messages The message to write in the block
     * @param string|null  $type     The block type (added in [] on first line)
     * @param string|null  $style    The style to apply to the whole block
     * @param string       $prefix   The prefix for the block
     * @param bool         $padding  Whether to add vertical padding
     * @param bool         $escape   Whether to escape the message
     */
    public function block($messages, $type = null, $style = null, $prefix = ' ', $padding = true, $escape = true)
    {
        parent::block($messages, $type, $style, $prefix, $padding, $escape);
    }


    /**
     * Formats a command comment.
     *
     * @param string|array $message
     */
    public function commentBlock($message)
    {
        $this->block($message, null, null, '<fg=default;bg=default> // </>', false, false);
    }

    /**
     * {@inheritdoc}
     */
    public function successBlock($message)
    {
        $this->block($message, 'OK', 'fg=black;bg=green', ' ', true);
    }

    /**
     * {@inheritdoc}
     */
    public function errorBlock($message)
    {
        $this->block($message, 'ERROR', 'fg=white;bg=red', ' ', true);
    }

    /**
     * {@inheritdoc}
     */
    public function warningBlock($message)
    {
        $this->block($message, 'WARNING', 'fg=white;bg=red', ' ', true);
    }

    /**
     * {@inheritdoc}
     */
    public function noteBlock($message)
    {
        $this->block($message, 'NOTE', 'fg=yellow', ' ░ ');
    }

    /**
     * {@inheritdoc}
     */
    public function cautionBlock($message)
    {
        $this->block($message, 'CAUTION', 'fg=white;bg=red', '» ', true);
    }

    public function createStaticBar($barStatus = self::BAR_STATUS_OK)
    {
        $bar = parent::createProgressBar(100);
        $bar->setFormat("<$barStatus>%message%</>" . PHP_EOL . '%bar% %percent:3s% %' . PHP_EOL . PHP_EOL);
        $bar->setBarCharacter("<$barStatus>" . $bar->getBarCharacter() . "</>");
        $bar->setBarWidth(100);

        return $bar;

    }
}
