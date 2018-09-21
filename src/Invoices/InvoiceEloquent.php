<?php
namespace Mirbaagheri\Invoice\Invoices;

use Illuminate\Database\Eloquent\Model;

class InvoiceEloquent extends Model implements InvoiceInterface{

    protected $table = 'invoice';

    protected $fillable = [
        'refer_table',
        'description',
        'status',
        'price'
    ];

    //Status 
    // 0 -> Created
    // 1 -> Paid
    // 2 -> Cancelled

    protected $with = array('items');

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    protected static $itemsModel = 'Mirbaagheri\Invoice\Items\ItemEloquent';

    public function items()
    {
        return $this->hasMany(static::$itemsModel,'invoice_id');
    }
}
?>