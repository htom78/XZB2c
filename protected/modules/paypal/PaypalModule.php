<?php

class PaypalModule extends PaymentModule
{
    public function getPaypalUrl()
	{
			return 1 ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
	}
}
