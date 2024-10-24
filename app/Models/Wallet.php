<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    static public function getTotalCustomerMonth($start_date, $end_date)
    {
        return self::select('id')
            ->whereDate('rdate', '>=', $start_date)
            ->whereDate('rdate', '<=', $end_date)
            ->count();
    }
    static public function getTotalIncomeMonth($start_date, $end_date)
    {
        return self::select('id')
            ->where('record', '=', 'income')          // Filter by income
            ->whereDate('rdate', '>=', $start_date)   // Use 'rdate' instead of 'created_at'
            ->whereDate('rdate', '<=', $end_date)     // Use 'rdate' instead of 'created_at'
            ->sum('amount');                          // Sum of income amounts
    }
    static public function getTotalExpenseMonth($start_date, $end_date)
    {
        return self::select('id')
            ->where('record', '=', 'expense')         // Filter by expense
            ->whereDate('rdate', '>=', $start_date)   // Use 'rdate' instead of 'created_at'
            ->whereDate('rdate', '<=', $end_date)     // Use 'rdate' instead of 'created_at'
            ->sum('amount');                          // Sum of expense amounts
    }
}
