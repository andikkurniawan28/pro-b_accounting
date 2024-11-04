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
        // return $data;
        return view('welcome', compact('data'));
    }

    public static function data()
    {
        $year = date("Y");
        $data['cash_flow'] = CashFlowController::monthlyData($year);
        for($i = 1; $i <= 12; $i++){
            $data['revenue_vs_expenses'][$i] = IncomeStatementController::export($year, $i);
        }
        return $data;
    }
}
