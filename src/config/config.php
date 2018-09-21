<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    |
    | Please provide the Products model used in Proxy Shopping card.
    |
    */
    'invoice' =>[
        'model' => 'Mirbaagheri\Invoice\Invoices\InvoiceEloquent',
    ],
    'item' =>[
        'model' => 'Mirbaagheri\Invoice\Items\ItemEloquent',
    ]
];
