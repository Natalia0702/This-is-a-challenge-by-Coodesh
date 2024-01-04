<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;


class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    public function getAll()
    {
        $expense = Expense::all();

        return $expense;
    }

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

    public function getById(string $id)
    {
        $idInt = intval($id);
        
        return Expense::find($idInt);
    }

    public function destroy(string $id)
    {
        $idInt = intval($id);

        Expense::destroy($idInt);
        
        return response()->json(['message' => 'Expense deleted successfully'], 204);
    }
    
    public function put(Request $request, $id)
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
}
