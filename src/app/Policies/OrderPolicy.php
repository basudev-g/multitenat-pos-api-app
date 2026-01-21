<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
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
        return true;
    }

    public function view(User $user, Order $order): bool
    {
        return $user->tenant_id === $order->tenant_id;
    }

    public function create(User $user)
    {
        return true; // both can create order
    }

    public function cancel(User $user, Order $order)
    {
        return $user->isOwner()
            && $user->tenant_id === $order->tenant_id;
    }
}
