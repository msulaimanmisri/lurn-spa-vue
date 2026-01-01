<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Inertia\Inertia;
use Inertia\Response;

class ProductIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(#[CurrentUser] User $user): Response
    {
        $products = Product::all();

        return Inertia::render('Products/ProductIndex', [
            'user' => $user,
            'products' => $products,
        ]);
    }
}
