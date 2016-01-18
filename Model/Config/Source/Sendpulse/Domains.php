<?php
/**
 * Copyright © 2015 Martin Kramer. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Shockwavedesign\Mail\Sendpulse\Model\Config\Source\Sendpulse;

class Domains implements \Magento\Framework\Option\ArrayInterface
{
    protected $scopeConfig;
    protected $messageManager;

    public function __construct(
        \Shockwavedesign\Mail\Sendpulse\Model\Config $scopeConfig,
        \Magento\Framework\Message\ManagerInterface $messageManager
    )
    {
        /** @var scopeConfig */
        $this->scopeConfig = $scopeConfig;
        $this->messageManager = $messageManager;
    }

    protected function getDomainsFromMailgun()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $domains = array();

        return $domains;
    }
}
