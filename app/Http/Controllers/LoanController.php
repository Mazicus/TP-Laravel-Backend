<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;

class LoanController extends Controller
{
    /**
     * Fetch and return all loans.
     */
    public function index()
    {
        $loans = Loan::all();

        return response()->json([
            'data'    => $loans,
            'count'   => $loans->count(),
            'status'  => 'success',
            'message' => 'All loans retrieved.',
        ], 200);
    }

    /**
     * Create a new loan record.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'borrower_name'  => 'required|string|max:255',
            'borrower_email' => 'required|email|max:255',
            'book_title'     => 'required|string|max:255',
            'borrowed_at'    => 'required|date',
            'due_date'       => 'required|date|after:borrowed_at',
            'returned'       => 'required|boolean',
            'status'         => 'required|in:active,returned,overdue',
        ]);

        $loan = Loan::create($validatedData);

        return response()->json([
            'data'    => $loan,
            'status'  => 'success',
            'message' => 'Loan record created.',
        ], 201);
    }

    /**
     * Retrieve a specific loan by ID.
     */
    public function show($id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Loan not found.',
            ], 404);
        }

        return response()->json([
            'data'    => $loan,
            'status'  => 'success',
            'message' => 'Loan details retrieved.',
        ], 200);
    }

    /**
     * Update an existing loan record.
     */
    public function update(Request $request, $id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Loan not found.',
            ], 404);
        }

        $validatedData = $request->validate([
            'borrower_name'  => 'sometimes|string|max:255',
            'borrower_email' => 'sometimes|email|max:255',
            'book_title'     => 'sometimes|string|max:255',
            'borrowed_at'    => 'sometimes|date',
            'due_date'       => 'sometimes|date|after:borrowed_at',
            'returned'       => 'sometimes|boolean',
            'status'         => 'sometimes|in:active,returned,overdue',
        ]);

        $loan->update($validatedData);

        return response()->json([
            'data'    => $loan,
            'status'  => 'success',
            'message' => 'Loan record updated.',
        ], 200);
    }

    /**
     * Delete a loan record.
     */
    public function destroy($id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Loan not found.',
            ], 404);
        }

        $loan->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Loan record deleted.',
        ], 200);
    }

    /**
     * Mark a loan as returned.
     */
    public function Returned($id)
    {
        $loan = Loan::find($id);

        if (!$loan) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Loan not found.',
            ], 404);
        }

        $loan->update(['returned' => true]);

        return response()->json([
            'data'    => $loan,
            'status'  => 'success',
            'message' => 'Loan marked as returned.',
        ], 200);
    }
}
