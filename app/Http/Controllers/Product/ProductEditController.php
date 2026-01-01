<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class ProductEditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Product $product): Response
    {
        return Inertia::render('Products/ProductEdit', [
            'product' => $product,
        ]);
    }
}
