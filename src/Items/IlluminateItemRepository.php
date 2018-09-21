<?php

namespace Mirbaagheri\Invoice\Items;

use Cartalyst\Support\Traits\RepositoryTrait;
use Cartalyst\Support\Traits\EventTrait;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;
use Illuminate\Contracts\Events\Dispatcher;

class IlluminateItemRepository implements ItemRepositoryInterface
{
    use RepositoryTrait,EventTrait;

    protected $model = 'Mirbaagheri\Invoice\Items\ItemEloquent';
    public $item;
    public $data;
    public $totalPrice;

    public function __construct(
        $model = null,
        Dispatcher $dispatcher = null
    ){
        $this->dispatcher = $dispatcher;

        if (isset($model)) {
            $this->model = $model;
        }
    }

    protected function isCollection($data)
    {
        return $data  instanceof Collection?true:false;
    }

    public function addToInvoice($invoice,$data)
    {

        if(is_object($invoice) && $invoice->id){
            $this->totalPrice = $invoice->price;

            if($this->isCollection($data))
                $data = $data->toArray();

            foreach($data as $value)
            {
                $this->totalPrice+=$value['price']*$value['quantity'];
                $this->data = $value;

                $item = $this->createModel();
                $item->invoice_id = $invoice->id;
                $item->quantity = $value['quantity'];
                $item->fill($value);
                $item->save();

                $this->fireEvent('invoice.item.added',collect(['item' => $item,'data' => $value]));
            }
            $invoice->update(['price'=>$this->totalPrice]);

            return $this;
        }
        throw new InvalidArgumentException('Invoice does not exists. you must set Invoice_ID first or use create invoice method.');
    }


}
