<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Calculate_Amounts;
use App\Models\Main_Amounts;
use App\Models\RecordCategory;
use App\Models\RecordSubCategory;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    //
    public function Wallet(Request $request)
    {
        $dynamicData = Wallet::select('name',)
            ->groupBy('name')
            ->get();
        $monthe     = date('F');
        $lastMonthName = date('F', strtotime('last month'));

        $lastYearName = date('Y', strtotime('-1 year'));

        $alldata    = Wallet::orderBy('rdate', 'desc')->get();
        $income     = DB::table('wallets')->where('record', 'income')->sum('amount');
        $expense    = DB::table('wallets')->where('record', 'expense')->sum('amount');
        $saving     = DB::table('wallets')->where('record', 'saving')->sum('amount');
        $total      = Wallet::sum('amount');
        $totalMbrs  = Wallet::count();

        // Today
        $todayIncome = Wallet::whereDate('rdate', Carbon::today())
            ->where('record', 'income')
            ->sum('amount');
        $todayExp = Wallet::whereDate('rdate', Carbon::today())
            ->where('record', 'expense')
            ->sum('amount');

        // Yesterday
        $yesterdayIncome = Wallet::whereDate('rdate', Carbon::yesterday())
            ->where('record', 'income')
            ->sum('amount');
        $yesterdayExp = Wallet::whereDate('rdate', Carbon::yesterday())
            ->where('record', 'expense')
            ->sum('amount');

        // Last 7 Days
        $sevenDaysAgo = now()->subDays(6); // No need to format
        $currentDate = now();
        $lastsevenday = Wallet::whereBetween('rdate', [$sevenDaysAgo, $currentDate])
            ->where('record', 'income')
            ->sum('amount');
        $lastsevendayExp = Wallet::whereBetween('rdate', [$sevenDaysAgo, $currentDate])
            ->where('record', 'expense')
            ->sum('amount');

        // Current Week
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SATURDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY);
        $thisWeek = Wallet::whereBetween('rdate', [$startOfWeek, $endOfWeek])
            ->where('record', 'income')
            ->sum('amount');
        $thisWeekExp = Wallet::whereBetween('rdate', [$startOfWeek, $endOfWeek])
            ->where('record', 'expense')
            ->sum('amount');

        // Current Month
        $thismonth = Wallet::whereYear('rdate', Carbon::now()->year)
            ->whereMonth('rdate', Carbon::now()->month)
            ->where('record', 'income')
            ->sum('amount');
        $thismonthExp = Wallet::whereYear('rdate', Carbon::now()->year)
            ->whereMonth('rdate', Carbon::now()->month)
            ->where('record', 'expense')
            ->sum('amount');

        // Last Month
        $firstDayOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastDayOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        $lastmonth = Wallet::whereBetween('rdate', [$firstDayOfLastMonth, $lastDayOfLastMonth])
            ->where('record', 'income')
            ->sum('amount');
        $lastmonthExp = Wallet::whereBetween('rdate', [$firstDayOfLastMonth, $lastDayOfLastMonth])
            ->where('record', 'expense')
            ->sum('amount');

        // Current Year
        $thisyear = Wallet::whereYear('rdate', Carbon::now()->year)
            ->where('record', 'income')
            ->sum('amount');
        $thisyearExp = Wallet::whereYear('rdate', Carbon::now()->year)
            ->where('record', 'expense')
            ->sum('amount');

        // Last Year
        $lastYear = Wallet::whereBetween('rdate', [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])
            ->where('record', 'income')
            ->sum('amount');
        $lastYearExp = Wallet::whereBetween('rdate', [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()])
            ->where('record', 'expense')
            ->sum('amount');

        if (!empty($request->year)) {
            $year = $request->year;
        } else {
            $year = date('Y');
        }

        // Chart Data
        $getTotalCustomerMonth = [];
        $getTotalIncomeMonth = [];
        $getTotalExpenseMonth = [];

        for ($month = 1; $month <= 12; $month++) {
            $startDate = new \DateTime("$year-$month-01");
            $endDate = new \DateTime("$year-$month-01");
            $endDate->modify('last day of this month');

            $start_date = $startDate->format('Y-m-d');
            $end_date = $endDate->format('Y-m-d');

            // Fetching data for the given month
            $customerCount = Wallet::getTotalCustomerMonth($start_date, $end_date);

            $customerIncome = Wallet::getTotalIncomeMonth($start_date, $end_date);

            $customerExpense = Wallet::getTotalExpenseMonth($start_date, $end_date);

            // Adding all data (customers, income, expense) for the current month
            $getTotalCustomerMonth[] = [
                'month' => $startDate->format('M'), // E.g., 'Jan', 'Feb'
                'totalCustomers' => $customerCount,
                'totalIncome' => $customerIncome,
                'totalExpense' => $customerExpense,
            ];
        }



        // Passing the data to the view
        $data['getTotalCustomerMonth'] = $getTotalCustomerMonth;
        // dd($data['getTotalCustomerMonth']);


        return view('backend.wallet.wallet', [
            'dynamicData' => $dynamicData,
            'data' => $data,
            'alldata' => $alldata,

            'monthe' => $monthe,
            'lastMonthName' => $lastMonthName,
            'year' => $year,
            'lastYearName' => $lastYearName,

            'total' => $total,
            'totalMbrs' => $totalMbrs,
            // 'today' => $today,
            'todayIncome' => $todayIncome,
            'todayExp' => $todayExp,

            'yesterdayIncome' => $yesterdayIncome,
            'yesterdayExp' => $yesterdayExp,

            'lastsevenday' => $lastsevenday,
            'lastsevendayExp' => $lastsevendayExp,

            'thisWeek' => $thisWeek,
            'thisWeekExp' => $thisWeekExp,

            'thismonth' => $thismonth,
            'thismonthExp' => $thismonthExp,

            'lastmonth' => $lastmonth,
            'lastmonthExp' => $lastmonthExp,

            'thisyear' => $thisyear,
            'thisyearExp' => $thisyearExp,
            'lastYear' => $lastYear,
            'lastYearExp' => $lastYearExp,

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

        $mergedData = Wallet::select(
            'name',
            DB::raw('SUM(CASE WHEN record = "income" THEN amount ELSE 0 END) as total_income'),
            DB::raw('COUNT(CASE WHEN record = "income" THEN 1 ELSE NULL END) as income_count'),
            DB::raw('SUM(CASE WHEN record = "expense" THEN amount ELSE 0 END) as total_expense'),
            DB::raw('COUNT(CASE WHEN record = "expense" THEN 1 ELSE NULL END) as expense_count')
        )
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
            'mergedData' => $mergedData,
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

    // Wallet Record
    public function AddMore()
    {
        $records = RecordCategory::with('stocks')->latest()->get();
        $categoryCount = RecordCategory::count(); // Count record_category rows
        $subCategoryCount = RecordSubCategory::count(); // Count record_sub_category rows

        return view('backend.wallet.addMore', compact('records', 'categoryCount', 'subCategoryCount'));
    }

    // Record AddMore Storage
    public function AddMoreStore(Request $request)
    {
        $rules = [
            'name' => 'required',
            'amount' => 'required|numeric', // If amount validation is needed
            'description' => 'nullable|string|max:255', // Add rule for description
            'stocks' => 'required|array',
        ];

        $messages = [
            'name.required' => 'The product name is required.',
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a valid number.',
            'description.string' => 'The description must be a valid string.',
            'description.max' => 'The description must not exceed 255 characters.',
            'stocks.required' => 'At least one stock entry is required.',
        ];

        foreach ($request->stocks as $key => $value) {
            $rules["stocks.$key.name"] = 'required';
            $rules["stocks.$key.price"] = 'required|numeric';
            $rules["stocks.$key.description"] = 'nullable|string|max:255';

            // Customizing messages for each stock item
            $messages["stocks.$key.name.required"] = "The name is required for Stock #" . ($key + 1) . ".";
            $messages["stocks.$key.name.required"] = "The name must be a number for Stock #" . ($key + 1) . ".";
            $messages["stocks.$key.price.required"] = "The price is required for Stock #" . ($key + 1) . ".";
            $messages["stocks.$key.price.numeric"] = "The price must be a number for Stock #" . ($key + 1) . ".";
            $messages["stocks.$key.description.string"] = "The description must be a valid string for Stock #" . ($key + 1) . ".";
            $messages["stocks.$key.description.max"] = "The description must not exceed 255 characters for Stock #" . ($key + 1) . ".";
        }

        $request->validate($rules, $messages);

        // Proceed with saving the data
        $product = RecordCategory::create([
            'name' => $request->name,
            'amount' => $request->amount,
            'description' => $request->description, // Save description
        ]);
        foreach ($request->stocks as $stock) {
            // $product->stocks()->create($stock);
            $product->stocks()->create([
                'name' => $stock['name'],
                'price' => $stock['price'],
                'description' => $stock['description'] ?? null, // Handle optional description
            ]);
        }

        // Notifications
        $notification = array(
            'message'       => 'New Record Added Successfully!',
            'alert-type'    => 'success',
        );
        return redirect()->back()->with($notification);
    }

    // Delete the record and its related stocks
    public function delete($id)
    {
        $record = RecordCategory::findOrFail($id);

        // Deleting all related stocks first
        $record->stocks()->delete();

        // Now deleting the record
        $record->delete();

        return redirect()->route('add.more')->with('success', 'Record and its stocks deleted successfully.');
    }
}
