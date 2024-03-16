composer require mirbaagheri/invoice

Add `Mirbaagheri\Invoice\Laravel\InvoiceServiceProvider::class` to `providers` array of your Laravel config file located at `config/app.php`
Add bellow to aliases:
'Invoice'	    => Mirbaagheri\Invoice\Laravel\Facades\Invoice::class,
