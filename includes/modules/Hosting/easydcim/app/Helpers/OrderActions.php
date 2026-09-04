<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;

/**
 * Builds the `actions` block of an EasyDCIM order.
 *
 * EasyDCIM can run its own provisioning actions when a service is activated,
 * suspended, unsuspended or terminated. The product picks which, and what
 * should happen when one of them fails.
 */
class OrderActions
{
    /**
     * Product option holding the action list for each service event.
     */
    protected const ACTION_OPTIONS = [
        'activate'  => 'ActivateActions',
        'suspend'   => 'SuspendActions',
        'unsuspend' => 'UnsuspendActions',
        'terminate' => 'TerminateActions',
    ];

    /**
     * What EasyDCIM should do when one of the actions fails.
     */
    protected const ERROR_MODES = ['continue', 'abort'];

    protected const DEFAULT_ERROR_MODE = 'continue';

    /**
     * @var array product options, as stored by HostBill
     */
    protected $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array|null null when the product does not use order actions
     */
    public function build(): ?array
    {
        if (($this->options['OrderActions'] ?? '') != 'on')
        {
            return null;
        }

        $selected = [];

        foreach (self::ACTION_OPTIONS as $event => $option)
        {
            $actions = $this->normalise($this->options[$option] ?? []);

            if (!empty($actions))
            {
                $selected[$event] = $actions;
            }
        }

        if (empty($selected))
        {
            return null;
        }

        $actions = $selected;
        $actions['provisioning_settings'] = $this->buildProvisioningSettings($selected);

        return $actions;
    }

    /**
     * Each chosen action carries its own error-handling mode; the product sets
     * one mode for all of them.
     */
    protected function buildProvisioningSettings(array $selected): array
    {
        $mode = $this->getErrorMode();
        $settings = [];

        foreach ($selected as $event => $actions)
        {
            $settings[$event] = array_fill_keys($actions, $mode);
        }

        return $settings;
    }

    protected function getErrorMode(): string
    {
        $mode = (string) ($this->options['InCaseOfError'] ?? '');

        return in_array($mode, self::ERROR_MODES, true) ? $mode : self::DEFAULT_ERROR_MODE;
    }

    /**
     * HostBill hands multi-selects back as a list of strings, but a product
     * saved before an option existed can hold a scalar or nothing at all.
     *
     * @return array<string>
     */
    protected function normalise($value): array
    {
        if (empty($value))
        {
            return [];
        }

        $actions = [];

        foreach ((array) $value as $item)
        {
            if (is_string($item) && $item !== '')
            {
                $actions[] = $item;
            }
        }

        return array_values(array_unique($actions));
    }
}
