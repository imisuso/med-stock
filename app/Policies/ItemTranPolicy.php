<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;

class ItemTranPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function CheckOutItem(User $user)
    {
        return $user->abilities->contains('checkout_item');
    }

    public function CheckInItem(User $user)
    {
        return $user->abilities->contains('checkin_item');
    }
}
