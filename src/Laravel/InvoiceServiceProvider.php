<?php
namespace Mirbaagheri\Invoice\Laravel;

use Illuminate\Support\ServiceProvider;

use Mirbaagheri\Invoice\Invoices\IlluminateInvoiceRepository;
use Mirbaagheri\Invoice\Items\IlluminateItemRepository;
use Mirbaagheri\Invoice\Invoice;

class InvoiceServiceProvider extends ServiceProvider{

    private $config;

	public function register()
	{
	    //dd('Invoice!!');
	    $this->prepareResources();
        $this->registerInvoices();
        $this->registerItems();
	    $this->registerInvoice();
	}

    protected function prepareResources()
    {
        $config = realpath(__DIR__.'/../config/config.php');

        $this->mergeConfigFrom($config, 'mirbaagheri.invoice');

        $this->publishes([
            $config => config_path('mirbaagheri.invoice.php'),
        ], 'config');

        $this->config = $this->app['config']->get('mirbaagheri.invoice');

        // Publish migrations
        $migrations = realpath(__DIR__.'/../migrations');

        $this->publishes([
            $migrations => $this->app->databasePath().'/migrations',
        ], 'migrations');
    }

    protected function registerInvoices()
    {
        $this->app->singleton('invoice.invoices', function ($app) {
            $model = $this->config['invoice']['model'];
            return new IlluminateInvoiceRepository($model,$app['events']);
        });
    }

    protected function registerItems()
    {
        $this->app->singleton('invoice.items', function ($app) {
            $model = $this->config['item']['model'];
            return new IlluminateItemRepository($model,$app['events']);
        });
    }

	protected function registerInvoice()
	{
	    $this->app->singleton('invoice', function ($app) {
		    $invoice = new Invoice(
                $app['invoice.invoices'],
                $app['invoice.items'],
                $app['events']
            );
			return $invoice;
		});
	}
}
?>
