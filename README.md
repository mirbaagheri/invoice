composer require mirbaagheri/invoice

Add below to your Laravel config file located at `config/app.php`:
Add `Mirbaagheri\Invoice\Laravel\InvoiceServiceProvider::class` to `providers` array.
Add `'Invoice' => Mirbaagheri\Invoice\Laravel\Facades\Invoice::class` to `aliases class`.
