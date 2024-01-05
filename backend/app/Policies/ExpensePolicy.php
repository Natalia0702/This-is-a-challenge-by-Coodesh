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
        if ($user->hasAnyRole([
            'Admin',
            // 'Outro papel',
        ])) {
            return true;
        }

        return $user->id === $expense->user_id
            ? Response::allow()
                : Response::deny('You do not own this record');
    }

    public function update(User $user, Expense $expense)
    {
        if ($user->hasAnyRole([
            'Admin',
            // 'Outro papel',
        ])) {
            return true;
        }

        return $user->id === $expense->user_id
            ? Response::allow()
                : Response::deny('You do not own this record');
    }

    public function delete(User $user, Expense $expense)
    {
        if ($user->hasAnyRole([
            'Admin',
            // 'Outro papel',
        ])) {
            return true;
        }

        return $user->id === $expense->user_id
            ? Response::allow()
                : Response::deny('You do not own this record');
    }

    public function __construct()
    {
        //
    }
}
