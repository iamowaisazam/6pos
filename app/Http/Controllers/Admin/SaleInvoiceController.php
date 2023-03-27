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

class SaleInvoiceController extends Controller
{

    public function index(Request $request)
    {

        $customers = Customer::all();
        $data = SaleInvoice::query();
        $data =  $data;
        
        if($request->search != null){
            $data = $data->where('id', 'like', '%'.$request->search.'%')
            ->orWhere('description', 'like', '%'.$request->search.'%');
        }

        if($request->customer_id != null){
            $data = $data->where('customer_id','=', $request->customer_id);
        }
 
        if($request->from != null){
            $data = $data->where('date', '>=', $request->from);
        }

        if($request->to != null){
            $data = $data->where('date', '<=', $request->to);
        }

        if($request->per_page != null ){
            $data = $data->paginate($request->per_page);
        }else{
            $data = $data->paginate(10);
        }

        return view('admin-views.saleinvoices.index',compact('data','customers'));

    }

    public function store(Request $request)
    {
          
        SaleInvoice::create([
        "customer_id" => $request->customer_id,
        "date" => $request->date,
        "amount" => $request->amount,
        "description" => $request->description,
        ]);

        Toastr::success(translate('SaleInvoice Created successfully'));
        return redirect()->back();

    }

    public function update(Request $request,$id)
    {
          
        SaleInvoice::where('id',$id)->update([
        "customer_id" => $request->customer_id,
        "date" => $request->date,
        "amount" => $request->amount,
        "description" => $request->description,
        ]);

        Toastr::success(translate('SaleInvoice Updated successfully'));
        return redirect()->back();

    }

    public function delete($id)
    {
          
        SaleInvoice::where('id',$id)->delete();
        Toastr::success(translate('SaleInvoice Deleted successfully'));
        return back();
    }

}
