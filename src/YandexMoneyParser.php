<?php

namespace YandexMoneyParser;

require 'YandexMoneyPayment.php';
require 'YandexMoneyParserException.php';

class YandexMoneyParser
{
    const ERROR_WRONG_PURSE = 0;
    const ERROR_WRONG_AMOUNT = 1;

    /**
     * @var string
     */
    protected $text;
    /**
     * @var int
     */
    protected $errorCode;
    /**
     * @var string
     */
    protected $errorText;

    /**
     * YandexMoneyParser constructor.
     * @param string $text
     */
    public function __construct(string $text)
    {
        // adding simbols for correct parsing
        $this->text = "\n$text\n";
    }

    /**
     * Main parse function which return YandexMoneyPayment or null if non critical error was happened
     * @return null|YandexMoneyPayment
     * @throws YandexMoneyParserException
     */
    public function parse() : ?YandexMoneyPayment
    {
        if ($this->hasResponseErrors()) {
            return null;
        }
        $payment = new YandexMoneyPayment();
        // parsing a sms code
        if (preg_match_all("![^0-9](\d{4})[^0-9]!u", $this->text, $matches) != 1) {
            throw new YandexMoneyParserException("Can't parse the Code field! Text: {$this->text}");
        }
        $payment->setCode((int)$matches[1][0]);
        // parsing an amount
        if (preg_match_all("![^0-9](\d{1,}[.,-]\d{2})[^0-9]!u", $this->text, $matches) != 1) {
            throw new YandexMoneyParserException("Can't parse the Amount field! Text: {$this->text}");
        }
        // replacing wrong float delimiters
        $payment->setAmount((float)str_replace([',', '-'], '.', $matches[1][0]));
        // parsing a purse number
        if (preg_match_all("![^0-9](\d{12,15})[^0-9]!u", $this->text, $matches) != 1) {
            throw new YandexMoneyParserException("Can't parse the Purse field! Text: {$this->text}");
        }
        $payment->setPurse($matches[1][0]);

        return $payment;
    }

    /**
     * Check response on errors
     * @return bool
     */
    protected function hasResponseErrors() : bool
    {
        if (preg_match('!Сумма указана неверно!iu', $this->text)) {
            $this->errorCode = self::ERROR_WRONG_AMOUNT;
            $this->errorText = 'Error value in the amount field';

            return true;
        }
        if (preg_match('!Кошелек Яндекс\.Денег указан неверно\.!iu', $this->text)) {
            $this->errorCode = self::ERROR_WRONG_PURSE;
            $this->errorText = 'Error value in the purse field';

            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getErrorText(): string
    {
        return $this->errorText;
    }




}
