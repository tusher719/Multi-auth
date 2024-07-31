<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Calculate_Amounts;
use App\Models\Main_Amounts;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    //
    public function Wallet()
    {
        $monthe     = date('F');
        $lastMonthName = date('F', strtotime('last month'));
        $year       = date('Y');
        $lastYearName = date('Y', strtotime('-1 year'));

        $alldata    = Wallet::orderBy('rdate', 'desc')->get();
        $income     = DB::table('wallets')->where('record', 'income')->sum('amount');
        $expense    = DB::table('wallets')->where('record', 'expense')->sum('amount');
        $saving     = DB::table('wallets')->where('record', 'saving')->sum('amount');
        $total      = Wallet::sum('amount');

        // Today
        $today      = Carbon::today()->format('Y-m-d');
        $todayIncome   = Wallet::where('rdate', $today)->where('record', 'income')->sum('amount');

        // Yesterday
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $yesterdayIncome = Wallet::where('rdate', $yesterday)->where('record', 'income')->sum('amount');

        // Last 7 Days
        $sevenDaysAgo = now()->subDays(6)->format('Y-m-d');
        $currentDate = now()->format('Y-m-d');
        $lastSevenDaysData = Wallet::whereBetween('rdate', [$sevenDaysAgo, $currentDate])->where('record', 'income')->get();
        $lastsevenday  = $lastSevenDaysData->sum('amount');

        // Current Week
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY);
        $thisWeekData = Wallet::whereBetween('rdate', [$startOfWeek, $endOfWeek])->where('record', 'income')->get();
        $thisWeek = $thisWeekData->sum('amount');

        //        $monthdata      = Wallet::whereMonth('rdate', Carbon::now())->where('record', 'expense')->get();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Current Month
        $monthData = Wallet::whereYear('rdate', $currentYear)->whereMonth('rdate', $currentMonth)->where('record', 'expense')->get();
        $thismonth  = $monthData->sum('amount');

        // Last Month
        $firstDayOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastDayOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        $lastMonthData = Wallet::whereBetween('rdate', [$firstDayOfLastMonth, $lastDayOfLastMonth])->where('record', 'expense')->get();
        $lastmonth   = $lastMonthData->sum('amount');

        // Current Year
        $yeardata      = Wallet::whereYear('rdate', Carbon::now()->year)->where('record', 'expense')->get();
        $thisyear   = $yeardata->sum('amount');

        // Last Year
        $startOfLastYear = Carbon::now()->subYear()->startOfYear();
        $endOfLastYear = Carbon::now()->subYear()->endOfYear();
        $lastYearData = Wallet::whereBetween('rdate', [$startOfLastYear, $endOfLastYear])->where('record', 'expense')->get();
        $lastYear = $lastYearData->sum('amount');

        return view('backend.wallet.wallet', [
            'alldata' => $alldata,

            'monthe' => $monthe,
            'lastMonthName' => $lastMonthName,
            'year' => $year,
            'lastYearName' => $lastYearName,

            'total' => $total,
            'today' => $today,
            'todayIncome' => $todayIncome,

            'yesterday' => $yesterday,
            'yesterdayIncome' => $yesterdayIncome,

            'sevenDaysAgo' => $sevenDaysAgo,
            'currentDate' => $currentDate,
            'lastsevenday' => $lastsevenday,

            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'thisWeek' => $thisWeek,

            'monthData' => $monthData,
            'thismonth' => $thismonth,
            'lastmonth' => $lastmonth,

            'thisyear' => $thisyear,
            'lastYear' => $lastYear,

            'income' => $income,
            'expense' => $expense,
            'saving' => $saving,
        ]);
    }


    public function StoreWallet(Request $request)
    {

        $data                   = new Wallet();
        $data->name             = $request->name;
        $data->amount           = str_replace(['$', ','], '', $request->amount);
        $data->record           = $request->record;
        $data->payment_type     = $request->payment_type;
        $data->rdate            = $request->rdate;
        $data->rtime            = $request->rtime;
        $data->note             = $request->note;
        $data->status           = $request->status;
        $data->save();

        $notification = array(
            'message'       => 'New Record Added Successfully!',
            'alert-type'    => 'success',
        );
        return redirect()->back()->with($notification);
    }

    // Edit Method
    public function EditWallet($id)
    {
        $info = Wallet::findOrFail($id);
        return view('backend.wallet.edit', compact('info'));
    } // End Method

    // Update Method
    public function UpdateWallet(Request $request, $id)
    {
        $data = Wallet::where('id', $id)->first();
        $data->name             = $request->name;
        $data->amount           = $request->amount;
        $data->record           = $request->record;
        $data->payment_type     = $request->payment_type;
        $data->rdate            = $request->rdate;
        $data->rtime            = $request->rtime;
        $data->note             = $request->note;
        $data->status           = $request->status;
        $data->save();

        $notification = array(
            'message'       => 'Update Wallet Successfully!',
            'alert-type'    => 'success',
        );
        return redirect()->route("wallet")->with($notification);
    }



    // Delete Permission
    public function DeleteWallet($id)
    {
        Wallet::findOrFail($id)->delete();

        $notification = array(
            'message'       => 'Record Deleted Successfully',
            'alert-type'    => 'success',
        );
        return redirect()->back()->with($notification);
    } // End Method


    // Pie Chart
    public function ShowPieChart()
    {
        $monthe     = date('F');
        $lastMonthName = date('F', strtotime('last month'));
        $year       = date('Y');
        $lastYearName = date('Y', strtotime('-1 year'));

        $total      = Wallet::sum('amount');

        // Today
        $today      = Carbon::today()->format('Y-m-d');
        $todayIncome   = Wallet::where('rdate', $today)->where('record', 'income')->sum('amount');

        // Yesterday
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $yesterdayIncome = Wallet::where('rdate', $yesterday)->where('record', 'income')->sum('amount');

        // Last 7 Days
        $sevenDaysAgo = now()->subDays(6)->format('Y-m-d');
        $currentDate = now()->format('Y-m-d');
        $lastSevenDaysData = Wallet::whereBetween('rdate', [$sevenDaysAgo, $currentDate])->where('record', 'income')->get();
        $lastsevenday  = $lastSevenDaysData->sum('amount');

        // Current Week
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY);
        $thisWeekData = Wallet::whereBetween('rdate', [$startOfWeek, $endOfWeek])->where('record', 'income')->get();
        $thisWeek = $thisWeekData->sum('amount');

        //        $monthdata      = Wallet::whereMonth('rdate', Carbon::now())->where('record', 'expense')->get();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Current Month
        $monthData = Wallet::whereYear('rdate', $currentYear)->whereMonth('rdate', $currentMonth)->where('record', 'expense')->get();
        $thismonth  = $monthData->sum('amount');

        // Last Month
        $firstDayOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastDayOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        $lastMonthData = Wallet::whereBetween('rdate', [$firstDayOfLastMonth, $lastDayOfLastMonth])->where('record', 'expense')->get();
        $lastmonth   = $lastMonthData->sum('amount');

        // Current Year
        $yeardata      = Wallet::whereYear('rdate', Carbon::now()->year)->where('record', 'expense')->get();
        $thisyear   = $yeardata->sum('amount');

        // Last Year
        $startOfLastYear = Carbon::now()->subYear()->startOfYear();
        $endOfLastYear = Carbon::now()->subYear()->endOfYear();
        $lastYearData = Wallet::whereBetween('rdate', [$startOfLastYear, $endOfLastYear])->where('record', 'expense')->get();
        $lastYear = $lastYearData->sum('amount');

        $incomeData = Wallet::select(
            'name',
            DB::raw('SUM(amount) as total_income'),
            DB::raw('COUNT(*) as income_count')
        )
            ->where('record', 'income')
            ->groupBy('name')
            ->get();

        $expenseData = Wallet::select(
            'name',
            DB::raw('SUM(amount) as total_income'),
            DB::raw('COUNT(*) as income_count')
        )
            ->where('record', 'expense')
            ->groupBy('name')
            ->get();

        $incomeExpenseData = Wallet::select(
            'name',
            DB::raw('SUM(CASE WHEN record = "income" THEN amount ELSE 0 END) as total_income'),
            DB::raw('SUM(CASE WHEN record = "expense" THEN amount ELSE 0 END) as total_expense'),
            DB::raw('SUM(CASE WHEN record = "saving" THEN amount ELSE 0 END) as total_saving')
        )
            ->groupBy('name')
            ->get();

        return view('backend.wallet.analytics', [
            'monthe' => $monthe,
            'lastMonthName' => $lastMonthName,
            'year' => $year,
            'lastYearName' => $lastYearName,

            'total' => $total,
            'today' => $today,
            'todayIncome' => $todayIncome,

            'yesterday' => $yesterday,
            'yesterdayIncome' => $yesterdayIncome,

            'sevenDaysAgo' => $sevenDaysAgo,
            'currentDate' => $currentDate,
            'lastsevenday' => $lastsevenday,

            'startOfWeek' => $startOfWeek,
            'endOfWeek' => $endOfWeek,
            'thisWeek' => $thisWeek,

            'monthData' => $monthData,
            'thismonth' => $thismonth,
            'lastmonth' => $lastmonth,

            'thisyear' => $thisyear,
            'lastYear' => $lastYear,
            'incomeData' => $incomeData,
            'expenseData' => $expenseData,
            'incomeExpenseData' => $incomeExpenseData,
        ]);
    }


    // Record Page
    public function recordPage()
    {
        return view('backend.wallet.record');
    }

    // Store Method
    public function submitForm(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'main_amount' => 'required|numeric',
            'name.*' => 'required',
            //            'amount.*' => 'required|numeric',
            //            'due.*' => 'required|numeric',
            //            'extra.*' => 'required|numeric',
        ]);

        // Create a new MainAmount instance
        $mainAmount = Main_Amounts::create([
            'main_amount' => $validatedData['main_amount']
        ]);

        // Create FormData instances for each submitted form data
        foreach ($validatedData['name'] as $key => $name) {
            Calculate_Amounts::create([
                'main_amount_id' => $mainAmount->id,
                'name' => $name,
                'amount' => $validatedData['amount'][$key],
                'due' => $validatedData['due'][$key],
                'extra' => $validatedData['extra'][$key],
            ]);
        }

        return response()->json(['message' => 'Form data saved successfully']);
    }
}
