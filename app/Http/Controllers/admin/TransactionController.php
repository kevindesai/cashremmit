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
//        $searchTerm = Input::get('search', '');
//        $transferrate = TransferRate::SearchByKeyword($searchTerm)->paginate(16);
        $transaction = Transactions::paginate(15);
        return view('transaction.index', compact('transaction'));
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
            if ($transaction->switchTransfer()) {
                $response = array(
                    'status' => '1',
                    'message' => 'Transfer successful.'
                );
            } else {
                $response = array(
                    'status' => '0',
                    'message' => 'Transaction failed'
                );
            }
        }
        echo json_encode($response);die;
    }

}
