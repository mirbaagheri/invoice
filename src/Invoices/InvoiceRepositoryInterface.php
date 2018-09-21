<?php

namespace Mirbaagheri\Invoice\Invoices;


interface InvoiceRepositoryInterface
{
    public function create(string $description, array $items);
}
