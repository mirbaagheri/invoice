<?php
namespace Mirbaagheri\Invoice;

use Mirbaagheri\Invoice\Invoices\InvoiceRepositoryInterface;
use Mirbaagheri\Invoice\Items\ItemRepositoryInterface;
use Cartalyst\Support\Traits\EventTrait;
use BadMethodCallException;
use Illuminate\Contracts\Events\Dispatcher;

class Invoice
{
    use EventTrait;

    protected $call = array();
    protected $availableMethods = array();
    protected $invoices;
    protected $items;

    public function __construct(
        InvoiceRepositoryInterface $invoices,
        ItemRepositoryInterface $items,
        Dispatcher $dispatcher
    )
    {
        $this->invoices = $invoices;
        $this->items    = $items;
        $this->dispatcher = $dispatcher;
    }

    protected function invoiceMethods()
    {
        if (empty($this->availableMethods['invoice']))
        {
            $methods = get_class_methods($this->invoices);
            $this->availableMethods['invoice'] = array_diff($methods, ['__construct']);
        }
    }

    protected function itemMethods()
    {
        if (empty($this->availableMethods['item']))
        {
            $methods = get_class_methods($this->items);
            $this->availableMethods['item'] = array_diff($methods, ['__construct']);
        }
    }

    public function getInvoiceRepository()
    {
        return $this->invoices;
    }

    public function getItemRepository()
    {
        return $this->items;
    }



    public function __call($method, $parameters)
    {
        $this->CallDetect($method);
        $Repository_Method = $this->call['model'].'Methods';
        $this->$Repository_Method();

        if (in_array($this->call['method'], $this->availableMethods[$this->call['model']])) {
            $Repository_Name = 'get'.ucfirst($this->call['model']).'Repository';
            $CallMethod = $this->$Repository_Name();
            return call_user_func_array([$CallMethod, $this->call['method']], $parameters);
        }

        throw new BadMethodCallException("Call to undefined method {$this->call['model']}::{$method}()");
    }

    private function CallDetect($method)
    {
        $method = $this->splitAtUpperCase($method);
        $this->call['model'] = strtolower ($method[1]);
        unset($method[1]);
        $this->call['method'] = implode('',$method);
    }

    private function splitAtUpperCase($s)
    {
        return preg_split('/(?=[A-Z])/', $s, -1, PREG_SPLIT_NO_EMPTY);
    }
}