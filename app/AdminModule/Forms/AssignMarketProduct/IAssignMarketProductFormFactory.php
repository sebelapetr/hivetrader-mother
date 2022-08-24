<?php
declare(strict_types=1);

namespace App\AdminModule\Forms;

use App\Model\Product;
use App\Model\User;

interface IAssignMarketProductFormFactory
{
    function create(Product $product): AssignMarketProductForm;
}