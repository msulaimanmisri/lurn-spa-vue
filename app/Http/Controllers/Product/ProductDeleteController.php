<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ProductDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index');
    }
}
