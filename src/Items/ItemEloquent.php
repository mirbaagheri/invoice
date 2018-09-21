<?php
namespace Mirbaagheri\Invoice\Items;

use Illuminate\Database\Eloquent\Model;

class ItemEloquent extends Model implements ItemInterface{

    protected $table = 'invoice_items';

    protected $fillable = [
        'invoice_id',
        'item_info',
        'price'
    ];

    protected static $invoicesModel = 'Mirbaagheri\Invoice\Invoices\InvoiceEloquent';

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    public function invoice()
    {
        return $this->belongsTo(static::$invoicesModel,'invoice_id');
    }

}
?>