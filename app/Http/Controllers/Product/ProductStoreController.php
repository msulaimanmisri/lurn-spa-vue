<?php

namespace App\Http\Controllers\Product;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Container\Attributes\CurrentUser;

class ProductStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(#[CurrentUser] User $user, StoreProductRequest $request)
    {
        $validatedRequest = $request->validated();

        Product::create($validatedRequest);

        return redirect()->route('products.index');
    }
}
