<?php

namespace IWD\BluePay\Model;

use Magento\Framework\ObjectManagerInterface;
use Magento\Vault\Api\Data\PaymentTokenInterface;
use IWD\BluePay\Api\Data\PaymentTokenFactoryInterface;

/**
 * PaymentTokenFactory class
 */
class PaymentTokenFactory implements PaymentTokenFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var array
     */
    private $tokenTypes = [];

    /**
     * PaymentTokenFactory constructor.
     * @param ObjectManagerInterface $objectManager
     * @param array $tokenTypes
     */
    public function __construct(ObjectManagerInterface $objectManager, array $tokenTypes = [])
    {
        $this->objectManager = $objectManager;
        $this->tokenTypes = $tokenTypes;
    }

    /**
     * Create payment token entity
     * @param $type string
     * @return PaymentTokenInterface
     * @since 100.3.0
     */
    public function create($type = null)
    {
        /**
         * This code added for Backward Compatibility reasons only, as previous implementation of Code Generated factory
         * accepted an array as any other code generated factory
         */
        if (is_array($type)) {
            return $this->objectManager->create(
                PaymentTokenInterface::class,
                $type
            );
        }

        if ($type !== null && !in_array($type, $this->tokenTypes, true)) {
            throw new \LogicException('There is no such payment token type: ' . $type);
        }

        return $this->objectManager->create(
            PaymentTokenInterface::class,
            ['data' => [PaymentTokenInterface::TYPE => $type]]
        );
    }
}