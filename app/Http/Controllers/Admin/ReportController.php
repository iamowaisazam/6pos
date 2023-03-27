<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\CPU\Helpers;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use function App\CPU\translate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Transection;
use App\Models\Order;
use App\Models\SaleInvoice;

class ReportController extends Controller
{

    public function customers(Request $request)
    {

        DB::connection()->enableQueryLog();

        $customers = Customer::query();

        if($request->status != null){
            $customers = $customers->where('status',$request->status);
        }

        $customers =  $customers->addSelect(['rc' =>  function ($query) use($request){

            $tr = $query->select(DB::raw('sum(amount)'))
            ->from('transections')
            ->whereColumn('customer_id','customers.id');
            
            if($request->from != null){
                $tr = $tr->where('date', '>=', $request->from);
            }

            if($request->to != null){
                $tr = $tr->where('date', '<=', $request->to);
            }

            $tr = $tr->where('credit',1)
            ->whereIn('tran_type',['receivable']);
        }])
        ->addSelect(['rd' =>  function ($query) use($request){

            $tr = $query->select(DB::raw('sum(amount)'))
            ->from('transections')
            ->whereColumn('customer_id','customers.id');
            
            if($request->from != null){
                $tr = $tr->where('date', '>=', $request->from);
            }
            
            if($request->to != null){
                $tr = $tr->where('date', '<=', $request->to);
            }

            $tr = $tr->where('debit',1)
            ->whereIn('tran_type',['receivable']);
        }])
        ->addSelect(['pc' =>  function ($query) use($request){

            $tr = $query->select(DB::raw('sum(amount)'))
            ->from('transections')
            ->whereColumn('customer_id','customers.id');
            
            if($request->from != null){
                $tr = $tr->where('date', '>=', $request->from);
            }

            if($request->to != null){
                $tr = $tr->where('date', '<=', $request->to);
            }

            $tr = $tr->where('credit',1)
            ->whereIn('tran_type',['Payable']);
        }])
        ->addSelect(['pd' =>  function ($query) use($request){

            $tr = $query->select(DB::raw('sum(amount)'))
            ->from('transections')
            ->whereColumn('customer_id','customers.id');
            
            if($request->from != null){
                $tr = $tr->where('date', '>=', $request->from);
            }

            if($request->to != null){
                $tr = $tr->where('date', '<=', $request->to);
            }

            $tr = $tr->where('debit',1)
            ->whereIn('tran_type',['Payable']);
        }])
        ->addSelect(['income_credit' =>  function ($query) use($request){

            $tr = $query->select(DB::raw('sum(amount)'))
            ->from('transections')
            ->whereColumn('customer_id','customers.id');
            
            if($request->from != null){
                $tr = $tr->where('date', '>=', $request->from);
            }

            if($request->to != null){
                $tr = $tr->where('date', '<=', $request->to);
            }

            $tr = $tr->where('credit',1)
            ->whereIn('tran_type',['Income']);
        }])
        ->addSelect(['income_debit' =>  function ($query) use($request){

            $tr = $query->select(DB::raw('sum(amount)'))
            ->from('transections')
            ->whereColumn('customer_id','customers.id');
            
            if($request->from != null){
                $tr = $tr->where('date', '>=', $request->from);
            }

            if($request->to != null){
                $tr = $tr->where('date', '<=', $request->to);
            }

            $tr = $tr->where('debit',1)
            ->whereIn('tran_type',['Income']);
        }]);

        // dd($customers->get()->toArray());
        
        
        if($request->per_page != null ){
            $customers = $customers->paginate($request->per_page);
        }else{
            $customers = $customers->paginate(10);
        }
        
        return view('admin-views.reports.customers',compact('customers'));
    }


    public function customers_detail(Request $request,$id)
    {

        
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

        
        return view('admin-views.reports.customer-detail',compact('data','customer'));
    }

   
   
   
  
  
}
