<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        return true; // owner & staff both
    }

    public function view(User $user, Product $product)
    {
        return $user->tenant_id === $product->tenant_id;
    }

    public function create(User $user)
    {
        return $user->isOwner();
    }

    public function update(User $user, Product $product)
    {
        return $user->isOwner()
            && $user->tenant_id === $product->tenant_id;
    }

    public function delete(User $user, Product $product)
    {
        return $user->isOwner()
            && $user->tenant_id === $product->tenant_id;
    }
}
