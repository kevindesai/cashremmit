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
}
