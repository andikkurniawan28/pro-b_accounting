<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IncomeStatementController;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $setting = Setting::init();
        $data = self::data();
        return view('welcome', compact('data', 'setting'));
    }

    public static function data()
    {
        $year = date("Y");
        $data['cash_flow'] = CashFlowController::monthlyData($year);
        $data['revenue_vs_expenses'] = IncomeStatementController::monthlyData($year);
        return $data;
    }
}
