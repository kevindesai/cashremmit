<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Transactions;
use App\Country;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class TransactionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index() {
        $searchTerm = Input::get('search', '');
        $no = (int) $searchTerm;
        if (trim($searchTerm) != '') {
            $transaction = Transactions::where('status', '<>', 'pending')->where('id', 'LIKE', '%' . $no . '%')->orderBy('id', 'DESC')->paginate(15);
        } else {
            $transaction = Transactions::where('status', '<>', 'pending')->orderBy('id', 'DESC')->paginate(15);
        }
        return view('transaction.index', compact('transaction', 'searchTerm'));
    }

    public function show($id) {
        $transaction = Transactions::find($id);
        $transactionData = array();
        if ($transaction) {
            if (isset($transaction->token) && $transaction->token != '') {
                $transactionData = Transactions::getTransactionDetail($transaction->token);
            }
        }
        return view('transaction.show', compact('transaction', 'transactionData'));
    }

    public function makeTransaction($id) {
        $transaction = Transactions::find($id);
        $response = array(
            'status' => '-1',
            'message' => 'You cannot do this without success transaction.'
        );
        if ($transaction->status == 'success') {
            $res = $transaction->switchTransfer();
            if ($res['status'] == '1') {
                $response = array(
                    'status' => '1',
                    'message' => 'Payment successful.',
                    'response' => $res
                );
            } else {
                $response = array(
                    'status' => '0',
                    'message' => 'Payment failed',
                    'response' => $res
                );
            }
        }
        echo json_encode($response);
        die;
    }

}
