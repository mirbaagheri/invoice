<?php
namespace Mirbaagheri\Invoice\Laravel\Facades;
use Illuminate\Support\Facades\Facade;

class Invoice extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'invoice';
    }
}
?>