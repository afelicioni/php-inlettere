# php-inlettere
Quick repo to get number translated in italian words for a known amount

## why
Needed a way to get suggestion for amount to be written in words on bank cheque (as mandated by [Banca d'Italia / Central Bank of Italy (ECB member)][1]).

## usage
Used as a static method.

The parameter for amount is based on cents (so if you need to translate `1.23` EUR to `uno/23` EUR, you have to pass `123`).

Second parameter is optional, letting specify a custom separator.

Should be nice from 0.01 EUR up to 999999999999.00 EUR

## license
See [LICENSE][2]

[1]: https://www.bancaditalia.it/servizi-cittadino/servizi/accesso-cai/faq-assegno/index.html
[2]: LICENSE
