<?php

namespace Mirbaagheri\Invoice\Invoices;

use Cartalyst\Support\Traits\RepositoryTrait;
use Cartalyst\Support\Traits\EventTrait;
use Illuminate\Contracts\Events\Dispatcher;
use Mirbaagheri\Invoice\Items\IlluminateItemRepository as Items;

class IlluminateInvoiceRepository implements InvoiceRepositoryInterface
{
    use RepositoryTrait,EventTrait;

    public $invoice;
    protected $model = 'Mirbaagheri\Invoice\Invoices\InvoiceEloquent';

    public function __construct(
        $model = null,
        Dispatcher $dispatcher = null
    ){
        $this->dispatcher = $dispatcher;

        if (isset($model)) {
            $this->model = $model;
        }
    }

    public function create(string $description,array $items)
    {
        $this->fireEvent('invoice.creating',collect($items));
        $invoice = $this->createModel();
        $invoice->description = $description;
        $invoice->save();

        $invoiceItems = new Items(config()->get('mirbaagheri.invoice.item.model'),app()->get('events'));
        $invoiceItems->addToInvoice($invoice,$items);

        $this->fireEvent('invoice.created',$invoice);

        return $invoice;
    }

    public function getList()
    {

    }

    public function findById($id)
    {
        return $this
            ->createModel()
            ->newQuery()
            ->find($id);
    }

    public function findByStatus()
    {

    }

    public function findByPrice()
    {

    }

    public function update($data)
    {
        $this->invoice->fill($data);
        $this->invoice->save();
        return $this;
    }

    public function destroy()
    {

    }

}
