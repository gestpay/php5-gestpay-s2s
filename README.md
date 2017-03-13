# php5-gestpay-s2s
Examples of Gestpay Server-to-Server API. 

Each `php` file contains an usage example of every S2S Gestpay capability.

The SOAP endpoints and their input/output specifications are described [here](http://api.gestpay.it/#wss2s-api).

> Note: to start these examples, your account must be enabled to S2S functions. Ask Gestpay customer care for help about this.

Have a look at the source code to see the logic; change the data and do your experiments.

## Files

| Filename | Description |
| -------- | ----------- |
| `callPagamS2S.php` | `callPagamS2S` will perform a payment. Based on your M.O.T.O. configuration, the operation might be only an authorization or authorization/settlement. See [the docs for more info](http://docs.gestpay.it/gs/how-gestpay-works.html#moto--what-happens-after-a-transaction). |
| `callSettleS2S.php` | If M.O.T.O. is set on authorize only, this call will settle the payment. |
| `callDeleteS2S.php` | This operation will delete an authorized operation. |
| `callRefundS2S.php` | Merchants can use this method to perform a partial or complete transaction amount refund. |
| `callReadTrxS2S.php` | This method will return the transaction status. |
| `callVerifycardS2S.php` | Merchants can use this method to check the Credit Card validity. |
| `callCheckCartaS2S.php` | Merchants can use this method to check the Credit Card, and to also get other info regarding the card. |
| `callRequestTokenS2S.php` | Merchants can use this method to request the token generation for a Credit Card. |
| `callDeleteTokenS2S.php` | Merchants can use this method to disable a token linked to a Credit Card. |
| `callUpdateTokenS2S.php` | Merchants can use this method to update the expiry date of a token. |
| `callIdealListS2S.php` | Merchants can use this method to have the list of the Banks available for their customers for IDeal payment method. |
| `callMyBankListS2S.php` | Merchants can use this method to have the list of the Banks available for their customers for MyBank payment method. |
| `callUpdatOrderS2S.php` | Merchants can use this method to update the order values for Risk Fraud management.  |
| `README.md` | This file. |


## How to start

The only prerequisite is to have Apache and PHP5+ installed on your system.

Start the apache server and load this directory inside. For example, if your server answers at `http://localhost:8080`, you can
load the directory under `http://localhost:8080/php5-gestpay-s2s/`.

To load `callPagamS2S.php`, just navigate to `http://localhost:8080/php5-gestpay-s2s/callPagamS2S.php`.

When you open a file, the call to Gestpay is performed. The result will be shown on page. Set your `shopLogin` and other
relavant data before.

## Ideas? Requests?

you can open an issue here on Github.