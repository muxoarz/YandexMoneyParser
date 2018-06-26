<?php

namespace YandexMoneyParser;

/**
 * Class YandexMoneyPayment entity for response data
 * @package YandexMoneyParser
 */
class YandexMoneyPayment
{
    /**
     * @var float
     */
    protected $amount;
    /**
     * @var int
     */
    protected $code;
    /**
     * @var string
     */
    protected $purse;

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return self
     */
    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     * @return self
     */
    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getPurse(): string
    {
        return $this->purse;
    }

    /**
     * @param string $purse
     * @return self
     */
    public function setPurse(string $purse): self
    {
        $this->purse = $purse;

        return $this;
    }



}
