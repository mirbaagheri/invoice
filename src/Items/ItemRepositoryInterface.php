<?php

namespace Mirbaagheri\Invoice\Items;


interface ItemRepositoryInterface
{
    public function addToInvoice($invoice,$data);
}
