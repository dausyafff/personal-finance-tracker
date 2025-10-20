<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with('category')
            ->where('user_id', $request->user()->id)
            ->orderBy('transaction_date', 'desc')
            ->get();

        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'description' => 'required|string|max:500',
            'transaction_date' => 'required|date',
        ]);

        $transaction = Transaction::create([
            'user_id' => $request->user()->id,
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'description' => $request->description,
            'transaction_date' => $request->transaction_date,
        ]);

        return response()->json($transaction, Response::HTTP_CREATED);
    }

    public function show(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        return response()->json($transaction->load('category'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'amount' => 'sometimes|numeric|min:0.01',
            'type' => 'sometimes|in:income,expense',
            'description' => 'sometimes|string|max:500',
            'transaction_date' => 'sometimes|date',
        ]);

        $transaction->update($request->all());

        return response()->json($transaction);
    }

    public function destroy(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
        }

        $transaction->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
