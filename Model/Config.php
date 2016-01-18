<?php
/**
 * Copyright © 2016 Martin Kramer. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Shockwavedesign\Mail\Sendpulse\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Sendpulse config
 */
class Config
{
    const XML_PATH_TYPE = 'system/smtp/type';

    const XML_PATH_USERNAME = 'system/smtp/username';

    const XML_PATH_PASSWORD = 'system/smtp/password';

    const XML_PATH_AUTHENTICATION = 'system/smtp/authentication';

    const XML_PATH_SSL = 'system/smtp/ssl';

    const XML_PATH_HOST = 'system/smtp/host';

    const XML_PATH_PORT = 'system/smtp/port';

    /**
     * Core store config
     *
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    protected $encryptor;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->encryptor = $encryptor;
    }

    public function getHost()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_HOST);
    }

    public function getSmtpParameters()
    {
        $username = $this->scopeConfig->getValue(self::XML_PATH_USERNAME);
        $encryptedPassword = $this->scopeConfig->getValue(self::XML_PATH_PASSWORD);

        if(!empty($encryptedPassword))
        {
            $decryptedPassword = $this->encryptor->decrypt($encryptedPassword);
        }

        $port = $this->scopeConfig->getValue(self::XML_PATH_PORT);
        $auth = $this->scopeConfig->getValue(self::XML_PATH_AUTHENTICATION);
        $ssl = $this->scopeConfig->getValue(self::XML_PATH_SSL);

        $parameters = array();

        if (!empty($decryptedPassword) && !empty($username) && $auth != self::AUTHENTICATION_NONE)
        {
            $parameters['auth'] = $auth;
            $parameters['username'] = $username;
            $parameters['password'] = $decryptedPassword;
        }

        if (!empty($port))
        {
            $parameters['port'] = $port;
        }

        if (!empty($ssl) && $ssl != self::SSL_NONE)
        {
            $parameters['ssl'] = $ssl;
        }

        return $parameters;
    }
}
