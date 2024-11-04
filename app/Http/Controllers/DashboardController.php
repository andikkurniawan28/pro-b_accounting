<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\IncomeStatementController;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = self::data();
        //return $data;
        return view('welcome', compact('data'));
    }

    public static function data()
    {
        $year = date("Y");
        $data['cash_flow'] = CashFlowController::monthlyData($year);
        $data['revenue_vs_expenses'] = IncomeStatementController::monthlyData($year);
        return $data;
    }
}
