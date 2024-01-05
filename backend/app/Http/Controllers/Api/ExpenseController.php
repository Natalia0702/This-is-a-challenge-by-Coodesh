<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:sanctum'); //NOCOMMIT
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
        $idInt = intval($id);

        return Expense::find($idInt);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $expense = Expense::findOrFail($id);

        $this->authorize('update', $expense);

        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'value' => 'required|numeric|min:0.01',
        ]);

        $expense->update($validatedData);

        return response()->json(['message' => 'Expense updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $idInt = intval($id);

        Expense::destroy($idInt);

        return response()->json(['message' => 'Expense deleted successfully'], 204);
    }
}
