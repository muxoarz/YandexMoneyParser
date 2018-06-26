<?php

use YandexMoneyParser\YandexMoneyParser;
use YandexMoneyParser\YandexMoneyParserException;

require 'src/YandexMoneyParser.php';

$text = "Пароль: 7490
Спишется 123,62р.
Перевод на счет 41001293002091";
//$text="Сумма указана неверно";

$parser = new YandexMoneyParser($text);
try {
    if ($result = $parser->parse()) {
        echo "Parsing OK. Code: {$result->getCode()}, Sum: {$result->getAmount()}, Purse: {$result->getPurse()}\n";
    } else {
        echo "Parsing NON CRITICAL error: {$parser->getErrorText()}\n";
    }
} catch (YandexMoneyParserException $e) {
    // here we can handle a parser critical exception
    throw $e;
}
