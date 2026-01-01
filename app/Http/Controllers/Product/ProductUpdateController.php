<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\RedirectResponse;

class ProductUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Product $product, UpdateProductRequest $request): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('products.index');
    }
}
