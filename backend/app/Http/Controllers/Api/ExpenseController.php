<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expense = Expense::paginate(20);

        return $expense;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'value' => 'required|numeric|min:0.01',
        ]);

        $expense = Expense::create($validatedData);

        return response()->json(['message' => 'Expense created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = Expense::findOrFail(intval($id));

        $this->authorize('view', $expense);

        return $expense;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $expense = Expense::findOrFail($id);
        $this->authorize('update', $expense);

        $validatedData = $request->validate([
            'description' => 'string|max:255',
            'date' => 'date',
            'user_id' => 'exists:users,id',
            'value' => 'numeric|min:0.01',
        ]);

        $updated = $expense->update($validatedData);

        return response()->json(
            [
                'message' => $updated ? 'Expense updated successfully' : 'Fail on update expense',
            ],
            $updated ? 200 : 422
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::findOrFail(intval($id));

        $this->authorize('update', $expense);

        $deleted = $expense->delete();

        return response()->json(
            [
                'message' => $deleted ? 'Expense deleted successfully' : 'Fail on delete expense',
            ],
            $deleted ? 200 : 422
        );
    }
}
