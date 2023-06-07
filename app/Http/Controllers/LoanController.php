<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Cheque;
use App\Models\Loan;
use App\Models\PaymentSchedule;


class LoanController extends Controller
{
    public function addNewPayment(Request $request){
        Payment::create([
            'document_no' => $request->document_no,
            'borrower' => $request->borrower,
            'amount' => $request->amount,
            'total_balance' => $request->total_balance,
            'outstanding_balance' => $request->outstanding_balance,
            'receivable' => $request->receivable,
            'total_payment' => $request->total_payment,
            'short_over' => $request->short_over,
            'payment_start_date' => $request->payment_start_date,
            'maturity_date' => $request->maturity_date,
            'payment_type' => $request->payment_type,
            'penalty' => $request->penalty,
            'penalty_balance' => $request->penalty_balance,
            'contact_numbers' => $request->contact_numbers,
            'loan_description' => $request->loan_description,
            'loan_status' => $request->loan_status,
            'agent' => $request->agent,
            'interest_rate' => $request->interest_rate,
            'payment_date' => $request->payment_date,
            'is_void' => $request->is_void,
            'void_date' => $request->void_date,
            'remarks' => $request->remarks,
            'status' => $request->status,
            'date_cleared' => $request->date_cleared,
        ]);

        return "Success!";
    }

    public function getPayment(Request $request){
       $cashpayment  = Payment::all();

        return $cashpayment ;
    }

    public function addNewLoan(Request $request){
        Loan::create([
            'document_no' => $request->document_no,
            'borrower' => $request->borrower,
            'amount' => $request->amount,
            'total_balance' => $request->total_balance,
            'outstanding_balance' => $request->outstanding_balance,
            'receivable' => $request->receivable,
            'total_payment' => $request->total_payment,
            'short_over' => $request->short_over,
            'payment_start_date' => $request->payment_start_date,
            'maturity_date' => $request->maturity_date,
            'payment_type' => $request->payment_type,
            'penalty' => $request->penalty,
            'penalty_balance' => $request->penalty_balance,
            'contact_numbers' => $request->contact_numbers,
            'agent' => $request->agent,
            'interest_rate' => $request->interest_rate,
            'loan_description' => $request->loan_description,
            'loan_status' => $request->loan_status,
            'payment_date' => $request->penalty,
        ]);

        return "Success!";
    }

    public function getLoansByID(Request $request){
        $loansid = User::query()
            ->where('id', $request->id)
            ->first();

        return $loansid;
    }

    public function getLoans(Request $request){
        $loans = Loan::all();

        return $loans;
    }

    public function addPaymentSchedule(Request $request){
            PaymentSchedule::create([
                'due_date' => $request->due_date,
                'day_of_week' => $request->day_of_week,
                'cheque_details' => $request->cheque_details,
                'due_amount' => $request->due_amount,
            ]);
    
            return "Success!";
    }

    public function getPaymentSchedule(Request $request){
        $paymentschedule = PaymentSchedule::all();

        return $paymentschedule;
    }

    public function getPrintChequePage(Request $request){
        $cheque = Loan::all();

        return view('admin.funding.print_cheque', compact('cheque'))->render();
    }

    public function getPrintContractPage(Request $request){
        $contracts = Loan::all() ?? [];

        return view('admin.funding.print_contract', compact('contracts'))->render();
    }

    public function getCashPaymentPage(Request $request){
        $cashpayment = Payment::all();

        return view('admin.workspace.cash_payment', compact('cashpayment'))->render();
    }
}
