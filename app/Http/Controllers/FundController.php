<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanDetail;
use Illuminate\Http\Request;
use App\Models\MonthlyDeposit;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class FundController extends Controller
{

    public function login()
    {
        return view('loginpage');
    }

    public function userlogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    public function friendList()
    {
        $friendList = User::orderBy('name')->get();
        return view('friendlist', compact('friendList'));
    }

    public function addFund()
    {
        $friendList = User::orderBy('name')->get();
        return view('addfund', compact('friendList'));
    }

    public function datasaved(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'monthlyamt' => 'nullable|numeric', // Optional field
            'month' => 'required_with:monthlyamt|integer|min:1|max:12', // Required if monthlyamt is present
            'year' => 'required_with:monthlyamt|integer|min:1900|max:2100', // Required if monthlyamt is present
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $ifExist =  MonthlyDeposit::where('user_id', $request->userId)
                ->where('month', $request->month)
                ->where('year', $request->year)
                ->first();

            if ($ifExist)
                throw new Exception("Fund already submitted for this month");


            $overdueLoanAmt = Loan::select('loan_amt', 'paid_amt')->where('user_id', $request->userId)->first();

            $overdueLoanAmt = $overdueLoanAmt->loan_amt - $overdueLoanAmt->paid_amt;

            if ($overdueLoanAmt < $request->loanamt)
                throw new Exception("Deposited loan amount should be less than overdue loan.");


            $lastTranDtl = Transaction::orderbydesc('id')->first();
            DB::connection()->beginTransaction();

            #_Monthly Amount
            if ($request->montlhlyamt) {
                $mMonthlyDeposit = new MonthlyDeposit();
                $mMonthlyDeposit->user_id      = $request->userId;
                $mMonthlyDeposit->month        = $request->month;
                $mMonthlyDeposit->year         = $request->year;
                $mMonthlyDeposit->amount       = $request->montlhlyamt;
                $mMonthlyDeposit->deposited_on = $request->deposited_on;
                $mMonthlyDeposit->created_at = Carbon::now();
                $mMonthlyDeposit->save();

                $mTransaction1 = new Transaction();
                $mTransaction1->date        = $request->deposited_on;
                $mTransaction1->user_id     = $request->userId;
                $mTransaction1->type        = "Credit";
                $mTransaction1->balance     = $lastTranDtl->balance + $request->montlhlyamt;
                $mTransaction1->description = $request->description;
                $mTransaction1->amount      = $request->montlhlyamt;
                $mTransaction1->created_at  = Carbon::now();
                $mTransaction1->save();
            }

            if ($request->loanamt) {
                $mTransaction2 = new Transaction();
                $mTransaction2->date        = $request->deposited_on;
                $mTransaction2->user_id     = $request->userId;
                $mTransaction2->type        = "Credit";
                $mTransaction2->balance     = $lastTranDtl->balance + $request->loanamt;
                $mTransaction2->description = $request->description;
                $mTransaction2->amount      = $request->loanamt;
                $mTransaction2->created_at  = Carbon::now();
                $mTransaction2->save();

                $mLoanDetail = new LoanDetail();
                $mLoanDetail->user_id   = $request->userId;
                $mLoanDetail->type      = "Contribution";
                $mLoanDetail->amount    = $request->loanamt;
                $mLoanDetail->date      = $request->deposited_on;
                $mLoanDetail->save();
            }

            $loanUser = Loan::where('user_id', $request->userId)->first();
            $loanUser->paid_amt = $loanUser->paid_amt + $request->loanamt;
            $loanUser->save();

            $user = User::find($request->userId);
            $user->total_contribution = $user->total_contribution + $request->montlhlyamt;

            $user->save();
            DB::connection()->commit();

            return view('datasaved');
        } catch (Exception $e) {
            DB::connection()->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function addUser()
    {
        return view('adduser');
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s]+$/' // Allow only letters, numbers, and spaces
            ],
            'amt'  => 'required|integer',
        ], [
            'name.regex' => 'The name field may only contain letters, numbers, and spaces.', // Custom error message for regex
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['loan_amt' => 'The loan amount must be less than or equal to the balance left.']);
            return response()->json($validator->errors(), 422);
        }

        try {
            $mUser = new User();
            $mUser->name               = $request->name;
            $mUser->total_contribution = $request->amt;
            $mUser->created_at         = Carbon::now();
            $mUser->save();

            return view('datasaved');
        } catch (Exception $e) {
            return $e;
            DB::connection()->rollBack();
        }
    }

    public function fundDetailbyId($id)
    {
        try {
            $monthlyDeposit = MonthlyDeposit::select('monthly_deposits.*', 'users.name', 'users.total_contribution')
                ->where('user_id', $id)
                ->join('users', 'users.id', 'monthly_deposits.user_id')
                ->orderByDesc('id')
                ->get();

            return view('funddetail', compact('monthlyDeposit'));
        } catch (Exception $e) {
            return $e;
        }
    }

    public function ledger()
    {
        $transactions   = Transaction::select('transactions.id', 'date', 'type', 'balance', 'amount', 'description', 'users.name')
            ->leftjoin('users', 'users.id', 'transactions.user_id')
            ->orderBydesc('id')
            ->get();

        $currentBalance = Transaction::select('balance')->orderByDesc('id')->first();
        return view('ledger', compact(['transactions', 'currentBalance']));
    }

    public function createLedger()
    {
        $currentBalance = Transaction::select('balance')->orderByDesc('id')->first();
        return view('addledger', compact('currentBalance'));
    }

    public function storeLedger(Request $request)
    {
        return $request;
        // Validate and save the data (example validation)
        $validatedData = $request->validate([
            'date' => 'required|date',
            'type' => 'required|string',
            'amount' => 'required|numeric',
            'balance' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // Save the ledger entry to the database (assuming a Ledger model)
        Transaction::create($validatedData);

        // Redirect to the ledger list with a success message
        return redirect()->route('transactions')->with('success', 'Ledger entry added successfully!');
    }

    public function loanHome()
    {
        $currentBalance = Transaction::select('balance')->orderByDesc('id')->first();
        $loanDetails = User::select('users.id as id', 'name', 'loan_amt', 'paid_amt')
            ->leftjoin('loans', 'loans.user_id', 'users.id')
            ->orderBy('name')
            ->get();

        $totalLoanAmt = Loan::sum('loan_amt');
        $totalPaidAmt = Loan::sum('paid_amt');
        $outstandingLoanAmt = $totalLoanAmt - $totalPaidAmt;
        return view('loanhome', compact('loanDetails', 'currentBalance', 'outstandingLoanAmt'));
    }

    public function loanDetails($id)
    {
        $loanDetail = LoanDetail::select('name', 'type', 'loan_details.amount', 'loan_details.date')
            ->where('user_id', $id)
            ->join('users', 'users.id', 'loan_details.user_id')
            ->orderByDesc('loan_details.id')
            ->get();
        return view('loandetail', compact('loanDetail'));
    }

    public function storeLoan(Request $request)
    {
        $currentBalance = Transaction::select('balance')->orderByDesc('id')->first();
        $validated = $request->validate([
            'user_id' => 'required',
            'loan_amt' => [
                'required',
                'numeric',
                'min:1'
            ],
            'loan_date' => 'required|date',
        ]);
        // Custom Error Message (if needed)
        if ($request->loan_amt > $currentBalance->balance) {
            return back()->withErrors(['loan_amt' => 'The loan amount must be less than or equal to the balance left.']);
        }

        try {
            $mLoan        = new Loan();
            $mLoanDetail  = new LoanDetail();
            $mTransaction = new Transaction();
            $todayDate    = Carbon::now();

            $checkUser = $mLoan::where('user_id', $validated['user_id'])->first();

            DB::beginTransaction();

            if (!$checkUser) {
                $mLoan->user_id = $validated['user_id'];
                $mLoan->loan_amt = $validated['loan_amt'];
                $mLoan->created_at = $todayDate;
                $mLoan->save();
            } else {
                $mLoan::where('user_id', $validated['user_id'])->update([
                    'loan_amt' => $validated['loan_amt'] + $checkUser->loan_amt,
                ]);
            }

            $mLoanDetail->user_id    = $validated['user_id'];
            $mLoanDetail->type       = "Borrowed";
            $mLoanDetail->amount     = $validated['loan_amt'];
            $mLoanDetail->date       = $validated['loan_date'];
            $mLoanDetail->created_at = $todayDate;
            $mLoanDetail->save();

            $mTransaction->date        = $validated['loan_date'];
            $mTransaction->user_id     = $validated['user_id'];
            $mTransaction->type        = "Debit";
            $mTransaction->balance     = $currentBalance->balance - $validated['loan_amt'];
            $mTransaction->description = "Loan";
            $mTransaction->amount      = $validated['loan_amt'];
            $mTransaction->created_at  = Carbon::now();
            $mTransaction->save();

            DB::commit();
            return redirect()->back()->with('success', 'Loan amount updated successfully.');
        } catch (Exception $e) {
            return $e->getMessage();
            return redirect()->back()->with('failed', $e->getMessage());
            DB::rollBack();
        }
    }

    public function viewFixdeposit()
    {
        $currentBalance = Transaction::select('balance')->orderByDesc('id')->first();
        return view('fixdeposit', compact('currentBalance'));
    }

    public function  storeFixdeposit(Request $request)
    {
        $currentBalance = Transaction::select('balance')->orderByDesc('id')->first();
        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:1'
            ],
            'accountNo' => 'required',
            'date' => 'required|date',
        ]);
        // Custom Error Message (if needed)
        if ($request->amount > $currentBalance->balance) {
            return back()->withErrors(['amount' => 'The loan amount must be less than or equal to the balance left.']);
        }
        try {
            $mTransaction = new Transaction();
            $mTransaction->date        = $validated['date'];
            $mTransaction->user_id     = auth()->user()->id;
            $mTransaction->type        = "Debit";
            $mTransaction->balance     = $currentBalance->balance - $validated['amount'];
            $mTransaction->description = "Fixed Deposit to account " . $request->accountNo . ".";
            $mTransaction->amount      = $validated['amount'];
            $mTransaction->created_at  = Carbon::now();
            $mTransaction->save();

            return redirect()->back()->with('success', 'Fixed Deposit Saved Successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    function logout()
    {
        Auth::logout(); // logging out user
        return Redirect::to('login'); // redirection to login screen
    }
}
