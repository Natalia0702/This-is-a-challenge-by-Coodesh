<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expense; 
use Illuminate\Auth\Access\Response;

class ExpensePolicy
{
    /**
     * Create a new policy instance.
     */

    public function view(User $user, Expense $expense)
    {
        return $user->id === $expense->user_id;
    }

    public function update(User $user, Expense $expense)
    {
        return $user->id === $expense->user_id
            ? Response::allow()
                : Response::deny('You do not own this update.');
    }

    public function delete(User $user, Expense $expense)
    {
        return $user->id === $expense->user_id;
    }
    
    public function __construct()
    {
        //
    }
}
