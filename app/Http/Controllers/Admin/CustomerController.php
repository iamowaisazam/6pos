<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use Brian2694\Toastr\Facades\Toastr;
use App\CPU\Helpers;
use App\Models\Account;
use App\Models\SaleInvoice;
use App\Models\Transection;
use function App\CPU\translate;
use DB;

class CustomerController extends Controller
{
    public function index()
    {

        return view('admin-views.customer.index');
    }

    public function status(Request $request,$id)
    {

        $customer = Customer::find($id);
        $customer->status = $request->status;
        $customer->save();

        Toastr::success(translate('Status Updated'));
        return back();
    }

    public function add_recievable(Request $request)
    {

        $customer = Customer::find($request->customer_id);
        $grand_total = $request->amount;
       
        if($customer->balance <= 0){

            $receivable_account = Account::find(3);
            $receivable_transaction = new Transection;
            $receivable_transaction->tran_type = 'Receivable';
            $receivable_transaction->account_id = $receivable_account->id;
            $receivable_transaction->amount = $grand_total;
            $receivable_transaction->description = $request->description;
            $receivable_transaction->debit = 0;
            $receivable_transaction->credit = 1;
            $receivable_transaction->balance = $receivable_account->balance + $grand_total;
            $receivable_transaction->date = $request->date;
            $receivable_transaction->customer_id = $customer->id;
            $receivable_transaction->order_id = null;
            $receivable_transaction->save();

            $receivable_account->total_in = $receivable_account->total_in + $grand_total;
            $receivable_account->balance = $receivable_account->balance + $grand_total;
            $receivable_account->save();

            $customer->balance = $customer->balance - $grand_total;
            $customer->save();

            Toastr::success(translate('Added'));
            return back();
        }

    
        if($customer->balance > 0){

             $remaining_balance = $customer->balance - $request->amount;

             if($remaining_balance < 0) {

                $payable_account = Account::find(2);
                $payable_transaction = new Transection;
                $payable_transaction->tran_type = 'Payable';
                $payable_transaction->account_id = $payable_account->id;
                $payable_transaction->amount = $customer->balance;
                $payable_transaction->description = $request->description;
                $payable_transaction->debit = 1;
                $payable_transaction->credit = 0;
                $payable_transaction->balance = $payable_account->balance - $customer->balance;
                $payable_transaction->date = $request->date;
                $payable_transaction->customer_id = $customer->id;
                $payable_transaction->order_id = null;
                $payable_transaction->save();
                $payable_account->total_out = $payable_account->total_out + $customer->balance;
                $payable_account->balance = $payable_account->balance - $customer->balance;
                $payable_account->save();

                $receivable_account = Account::find(3);
                $receivable_transaction = new Transection;
                $receivable_transaction->tran_type = 'Receivable';
                $receivable_transaction->account_id = $receivable_account->id;
                $receivable_transaction->amount = -$remaining_balance;
                $receivable_transaction->description = $request->description;
                $receivable_transaction->debit = 0;
                $receivable_transaction->credit = 1;
                $receivable_transaction->balance = $receivable_account->balance - $remaining_balance;
                $receivable_transaction->date = $request->date;
                $receivable_transaction->customer_id = $customer->id;
                $receivable_transaction->order_id = null;
                $receivable_transaction->save();
                $receivable_account->total_in = $receivable_account->total_in - $remaining_balance;
                $receivable_account->balance = $receivable_account->balance - $remaining_balance;
                $receivable_account->save();

             }else{

                $payable_account = Account::find(2);
                $payable_transaction = new Transection;
                $payable_transaction->tran_type = 'Payable';
                $payable_transaction->account_id = $payable_account->id;
                $payable_transaction->amount = $request->amount;
                $payable_transaction->description = $request->description;
                $payable_transaction->debit = 1;
                $payable_transaction->credit = 0;
                $payable_transaction->balance = $payable_account->balance - $request->amount;
                $payable_transaction->date = $request->date;
                $payable_transaction->customer_id = $customer->id;
                $payable_transaction->order_id = null;
                $payable_transaction->save();
                $payable_account->total_out = $payable_account->total_out + $request->amount;
                $payable_account->balance = $payable_account->balance - $request->amount;
                $payable_account->save();
             }

             $customer->balance = $remaining_balance;
             $customer->save();
        }

        Toastr::success(translate('Added'));
        return back();
    }

    public function customers_transaction(Request $request,$id){

        $customer = Customer::find($id);
        $data = Transection::where('customer_id',$id);

        if($request->type != null){
            $data = $data->whereIn('tran_type',$request->type);
        }

        if($request->from != null){
            $data = $data->where('date', '>=', $request->from);
        }

        if($request->to != null){
            $data = $data->where('date', '<=', $request->to);
        }
    
        $data = $data->get();
        return view('admin-views.customer.transactions',compact('customer','data'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile'=> 'required|unique:customers',
        ]);

        if (!empty($request->file('image'))) {
            $image_name =  Helpers::upload('customer/', 'png', $request->file('image'));
        } else {
            $image_name = 'def.png';
        }

        $customer = new Customer;
        $customer->name = $request->name;
        $customer->mobile = $request->mobile;
        $customer->email = $request->email;
        $customer->image = $image_name;
        $customer->state = $request->state;
        $customer->city = $request->city;
        $customer->zip_code = $request->zip_code;
        $customer->address = $request->address;
        $customer->balance = $request->balance;
        $customer->save();

        Toastr::success(translate('Customer Added successfully'));
        return back();
    }

    public function list(Request $request)
    {

        $accounts = Account::orderBy('id')->get();
        $customers = Customer::query();

        $customers = $customers->addSelect(['rc' =>  function ($query) use($request){

            $tr = $query->select(DB::raw('sum(amount)'))
            ->from('transections')
            ->whereColumn('customer_id','customers.id');
            $tr = $tr->where('credit',1)
            ->whereIn('tran_type',['receivable']);
        }])
        ->addSelect(['rd' =>  function ($query) use($request){
            $tr = $query->select(DB::raw('sum(amount)'))
            ->from('transections')
            ->whereColumn('customer_id','customers.id');
            $tr = $tr->where('debit',1)
            ->whereIn('tran_type',['receivable']);
        }])
        ->addSelect(['pc' =>  function ($query) use($request){
            $tr = $query->select(DB::raw('sum(amount)'))
            ->from('transections')
            ->whereColumn('customer_id','customers.id');
            $tr = $tr->where('credit',1)
            ->whereIn('tran_type',['Payable']);
        }])
        ->addSelect(['pd' =>  function ($query) use($request){
            $tr = $query->select(DB::raw('sum(amount)'))
            ->from('transections')
            ->whereColumn('customer_id','customers.id');
            $tr = $tr->where('debit',1)
            ->whereIn('tran_type',['Payable']);
        }])
        ->addSelect(['income_credit' =>  function ($query) use($request){
            $tr = $query->select(DB::raw('sum(amount)'))
            ->from('transections')
            ->whereColumn('customer_id','customers.id');
            $tr = $tr->where('credit',1)
            ->whereIn('tran_type',['Income']);
        }])
        ->addSelect(['income_debit' =>  function ($query) use($request){
            $tr = $query->select(DB::raw('sum(amount)'))
            ->from('transections')
            ->whereColumn('customer_id','customers.id');
            $tr = $tr->where('debit',1)
            ->whereIn('tran_type',['Income']);
        }]);

        $search = $request['search'];
        if ($request->has('search') && $request->search != null) {
            $customers = $customers->where('name', 'like', '%'.$request->search.'%')
            ->orwhere('mobile', 'like', '%'.$request->search.'%');
        } 

        if ($request->has('status') && $request->status != null) {
            $customers = $customers->where('status',$request->status);
        } 

        if ($request->has('per_page') && $request->per_page != null) {
            $customers = $customers->paginate($request->per_page);
        } else{
            $customers = $customers->paginate(10);
        }
    
             
        return view('admin-views.customer.list',compact('customers','accounts','search'));

    }


    public function view(Request $request, $id)
    {
        $customer = Customer::where('id',$id)->first();
        if(isset($customer))
        {
            $query_param = [];
            $search = $request['search'];
            if ($request->has('search')) {
                $key = explode(' ', $request['search']);
                $orders = Order::where(['user_id' => $id])
                                    ->where(function ($q) use ($key) {
                                        foreach ($key as $value) {
                                            $q->where('id', 'like', "%{$value}%");
                                        }
                                    });
                $query_param = ['search' => $request['search']];
            } else {
                $orders = Order::where(['user_id' => $id]);
            }

            $orders = $orders->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
            return view('admin-views.customer.view',compact('customer', 'orders','search'));
        }
        Toastr::error('Customer not found!');
        return back();
    }


    public function transaction_list(Request $request, $id)
    {
        $accounts = Account::get();
        $customer = Customer::where('id',$id)->first();
        if(isset($customer))
        {
            $acc_id = $request['account_id'];
            $tran_type = $request['tran_type'];
            $orders = Order::where(['user_id' => $id])->get();
            $transactions = Transection::where(['customer_id' => $id])
                                ->when($acc_id!=null, function($q) use ($request){
                                    return $q->where('account_id',$request['account_id']);
                                })
                                ->when($tran_type!=null, function($q) use ($request){
                                    return $q->where('tran_type',$request['tran_type']);
                                })->latest()->paginate(Helpers::pagination_limit())
                                ->appends(['account_id' => $request['account_id'],'tran_type'=>$request['tran_type']]);
            return view('admin-views.customer.transaction-list',compact('customer', 'transactions','orders','tran_type','accounts','acc_id'));
        }
        Toastr::error(translate('Customer not found'));
        return back();
    }

    public function edit(Request $request)
    {
        $customer = Customer::where('id',$request->id)->first();
        return view('admin-views.customer.edit',compact('customer'));
    }


    public function update(Request $request)
    {
        $customer = Customer::where('id',$request->id)->first();
        $request->validate([
            'name' => 'required',
            'mobile'=> 'required|unique:customers,mobile,'.$customer->id,
        ]);

        $customer->name = $request->name;
        $customer->mobile = $request->mobile;
        $customer->email = $request->email;
        $customer->image = $request->has('image') ? Helpers::update('customer/', $customer->image, 'png', $request->file('image')) : $customer->image;
        $customer->state = $request->state;
        $customer->city = $request->city;
        $customer->zip_code = $request->zip_code;
        $customer->address = $request->address;
        $customer->balance = $request->balance;
        $customer->save();

        Toastr::success(translate('Customer updated successfully'));
        return back();
    }


    public function delete(Request $request)
    {   

        $transection = Transection::where('customer_id',$request->id)->first();
        if($transection != null){
            Toastr::warning(translate('This Customer Have Transaction Can Not Be Deleted'));
            return back();
        }

        $order = Order::where('user_id',$request->id)->first();
        if($order != null){
            Toastr::warning(translate('This Customer Have Orders Can Not Be Deleted'));
            return back();
        }

        $customer = Customer::find($request->id);
        Helpers::delete('customer/' . $customer['image']);
        $customer->delete();

        Toastr::success(translate('Customer removed successfully'));
        return back();
    }

    public function update_balance(Request $request)
    {
        $request->validate([
            'customer_id'=>'required',
            'amount' => 'required',
            'account_id'=> 'required',
            'date' => 'required',
        ]);
        $customer = Customer::find($request->customer_id);

        if($customer->balance >= 0)
        {
            $account = Account::find(2);
            $transection = new Transection;
            $transection->tran_type = 'Payable';
            $transection->account_id = $account->id;
            $transection->amount = $request->amount;
            $transection->description = $request->description;
            $transection->debit = 0;
            $transection->credit = 1;
            $transection->balance = $account->balance + $request->amount;
            $transection->date = $request->date;
            $transection->customer_id = $request->customer_id;
            $transection->save();

            $account->total_in = $account->total_in + $request->amount;
            $account->balance = $account->balance + $request->amount;
            $account->save();

            $receive_account = Account::find($request->account_id);
            $receive_transection = new Transection;
            $receive_transection->tran_type = 'Income';
            $receive_transection->account_id = $receive_account->id;
            $receive_transection->amount = $request->amount;
            $receive_transection->description = $request->description;
            $receive_transection->debit = 0;
            $receive_transection->credit = 1;
            $receive_transection->balance = $receive_account->balance + $request->amount;
            $receive_transection->date = $request->date;
            $receive_transection->customer_id = $request->customer_id;
            $receive_transection->save();

            $receive_account->total_in = $receive_account->total_in + $request->amount;
            $receive_account->balance = $receive_account->balance + $request->amount;
            $receive_account->save();
        }else{
            $remaining_balance = $customer->balance + $request->amount;

            if($remaining_balance >= 0)
            {
                if($remaining_balance!=0)
                {
                    $payable_account = Account::find(2);
                    $payable_transection = new Transection;
                    $payable_transection->tran_type = 'Payable';
                    $payable_transection->account_id = $payable_account->id;
                    $payable_transection->amount = $remaining_balance;
                    $payable_transection->description = $request->description;
                    $payable_transection->debit = 0;
                    $payable_transection->credit = 1;
                    $payable_transection->balance = $payable_account->balance + $remaining_balance;
                    $payable_transection->date = $request->date;
                    $payable_transection->customer_id = $request->customer_id;
                    $payable_transection->save();

                    $payable_account->total_in = $payable_account->total_in + $remaining_balance;
                    $payable_account->balance = $payable_account->balance + $remaining_balance;
                    $payable_account->save();
                }

                $receive_account = Account::find($request->account_id);
                $receive_transection = new Transection;
                $receive_transection->tran_type = 'Income';
                $receive_transection->account_id = $request->account_id;
                $receive_transection->amount = $request->amount;
                $receive_transection->description = $request->description;
                $receive_transection->debit = 0;
                $receive_transection->credit = 1;
                $receive_transection->balance = $receive_account->balance + $request->amount;
                $receive_transection->date = $request->date;
                $receive_transection->customer_id = $request->customer_id;
                $receive_transection->save();

                $receive_account->total_in = $receive_account->total_in + $request->amount;
                $receive_account->balance = $receive_account->balance + $request->amount;
                $receive_account->save();


                $receivable_account = Account::find(3);
                $receivable_transaction = new Transection;
                $receivable_transaction->tran_type = 'Receivable';
                $receivable_transaction->account_id = $receivable_account->id;
                $receivable_transaction->amount = -$customer->balance;
                $receivable_transaction->description = $request->description;
                $receivable_transaction->debit = 1;
                $receivable_transaction->credit = 0;
                $receivable_transaction->balance = $receivable_account->balance + $customer->balance;
                $receivable_transaction->date = $request->date;
                $receivable_transaction->customer_id = $request->customer_id;
                $receivable_transaction->save();

                $receivable_account->total_out = $receivable_account->total_out - $customer->balance;
                $receivable_account->balance = $receivable_account->balance + $customer->balance;
                $receivable_account->save();

            }else{

                $receive_account = Account::find($request->account_id);
                $receive_transection = new Transection;
                $receive_transection->tran_type = 'Income';
                $receive_transection->account_id = $receive_account->id;
                $receive_transection->amount = $request->amount;
                $receive_transection->description = $request->description;
                $receive_transection->debit = 0;
                $receive_transection->credit = 1;
                $receive_transection->balance = $receive_account->balance + $request->amount;
                $receive_transection->date = $request->date;
                $receive_transection->customer_id = $request->customer_id;
                $receive_transection->save();

                $receive_account->total_in = $receive_account->total_in + $request->amount;
                $receive_account->balance = $receive_account->balance + $request->amount;
                $receive_account->save();

                $receivable_account = Account::find(3);
                $receivable_transaction = new Transection;
                $receivable_transaction->tran_type = 'Receivable';
                $receivable_transaction->account_id = $receivable_account->id;
                $receivable_transaction->amount = $request->amount;
                $receivable_transaction->description = $request->description;
                $receivable_transaction->debit = 1;
                $receivable_transaction->credit =0;
                $receivable_transaction->balance = $receivable_account->balance - $request->amount;
                $receivable_transaction->date = $request->date;
                $receivable_transaction->customer_id = $request->customer_id;
                $receivable_transaction->save();

                $receivable_account->total_out = $receivable_account->total_out + $request->amount;
                $receivable_account->balance = $receivable_account->balance - $request->amount;
                $receivable_account->save();
            }

        }
        $customer->balance = $customer->balance + $request->amount;
        $customer->save();

        Toastr::success(translate('Customer balance updated successfully'));
        return back();
    }


}
