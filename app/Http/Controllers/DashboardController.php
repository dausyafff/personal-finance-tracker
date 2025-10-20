<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        // Total income, expense, dan balance
        $totals = Transaction::where('user_id', $user_id)
            ->selectRaw('
                SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as total_income,
                SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as total_expense,
                SUM(CASE WHEN type = "income" THEN amount ELSE -amount END) as balance
            ')
            ->first();

        // Recent transactions
        $recentTransactions = Transaction::with('category')
            ->where('user_id', $user_id)
            ->orderBy('transaction_date', 'desc')
            ->limit(5)
            ->get();

        // Expense by category (last 30 days)
        $expenseByCategory = Transaction::with('category')
            ->where('user_id', $user_id)
            ->where('type', 'expense')
            ->where('transaction_date', '>=', now()->subDays(30))
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->get();

        // Monthly summary
        $monthlySummary = Transaction::where('user_id', $user_id)
            ->whereYear('transaction_date', date('Y'))
            ->selectRaw('
                MONTH(transaction_date) as month,
                SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income,
                SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense
            ')
            ->groupBy(DB::raw('MONTH(transaction_date)'))
            ->get();

        return response()->json([
            'totals' => $totals,
            'recent_transactions' => $recentTransactions,
            'expense_by_category' => $expenseByCategory,
            'monthly_summary' => $monthlySummary,
        ]);
    }
}
