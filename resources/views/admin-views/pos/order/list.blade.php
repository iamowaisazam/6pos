@extends('layouts.admin.app')
@section('title','Order List')
@push('css_or_js')
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/custom.css"/>
@endpush

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center mb-3">
                <div class="col-sm">
                    <h1 class="page-header-title text-capitalize">{{\App\CPU\translate('pos')}} {{\App\CPU\translate('orders')}}
                        <span class="badge badge-soft-dark ml-2">{{$orders->total()}}</span></h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Card -->

        <div class="card mb-3">
            <div class="card-body">
                <form action="{{url()->current()}}" method="GET">
                    <div class="row m-1">
                        <div class="form-group col-12 col-sm-3">
                            <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('search')}} </label>
                            <input type="text" name="search" class="form-control" value="{{request()->search}}" />
                        </div>
                        <div class="form-group col-12 col-sm-3">
                            <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('customers')}} </label>
                            <select id="customers" name="customer_id" class="form-control js-select2-custom">
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer) 
                                 <option {{request()->customer_id != null && request()->customer_id == $customer->id ? 'selected' : ''}} 
                                value="{{$customer->id}}">{{$customer->name}}</option>
                               @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-sm-2">
                            <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('Status')}} </label>
                            <select id="status" name="status" class="form-control js-select2-custom">
                                <option value="">{{\App\CPU\translate('All')}}</option>
                                
                                <option {{request()->status != null && request()->status == 0 ?'selected' : ''}} value="0">
                                    {{\App\CPU\translate('pending')}}</option>

                                <option {{request()->status != null && request()->status == 1 ?'selected' : ''}} value="1">
                                    {{\App\CPU\translate('complete')}}</option>
                                
                                <option {{request()->status != null && request()->status == 2 ?'selected' : ''}} value="2">
                                        {{\App\CPU\translate('canceled')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-sm-2">
                            <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('Payment')}} </label>
                            <select id="payment" name="payment" class="form-control js-select2-custom">
                                <option value="">{{\App\CPU\translate('All')}}</option>
                                <option {{request()->payment != null && request()->payment == 1 ?'selected' : ''}} value="1">{{\App\CPU\translate('paid')}}</option>
                                <option {{request()->payment != null && request()->payment == 0 ?'selected' : ''}} value="0">{{\App\CPU\translate('unpaid')}}</option>
                            </select>
                        </div>
                        <div class="form-group col-12 col-md-2">
                            <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('Show')}} </label>
                            <select id="tran_type" name="per_page" class="form-control js-select2-custom">
                                <option {{request()->per_page == 10 ? 'selected' : ''}} value="10">{{\App\CPU\translate('10')}}</option>
                                <option {{request()->per_page == 20 ? 'selected' : ''}} value="20">{{\App\CPU\translate('20')}}</option>
                                <option {{request()->per_page == 50 ? 'selected' : ''}} value="50">{{\App\CPU\translate('50')}}</option>
                                <option {{request()->per_page == 100 ? 'selected' : ''}} value="100">{{\App\CPU\translate('100')}}</option>
                            </select>
                        </div>
                        <div class="col-12 text-center ">
                            <button class="btn btn-primary">{{\App\CPU\translate('search')}}</button>
                        </div>
                   </div>
                </form>
            </div>
        </div>

        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-12 col-sm-3">
                        Showing {{($orders->currentpage()-1)*$orders->perpage()+1}} to {{ $orders->currentpage()*(($orders->perpage() < $orders->total()) ? $orders->perpage(): $orders->total())}} of {{ $orders->total()}} entries
                    </div>
                    <div class="col-12 col-sm-9 text-right">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" 
                              type="button"
                              data-toggle="dropdown" 
                              aria-expanded="false">{{\App\CPU\translate('action')}}
                            </button>
                            <div class="dropdown-menu">
                                <a href="{{route('admin.customer.add')}}" class="dropdown-item btn btn-primary float-right"><i
                                    class="tio-add-circle"></i> {{\App\CPU\translate('add_new_customer')}}
                                 </a>
                            </div>
                          </div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive ">
                <table
                    class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                    <tr>
                        <th class="">
                            {{\App\CPU\translate('#')}}
                        </th>
                        <th class="table-column-pl-0">{{\App\CPU\translate('order')}}</th>
                        <th>{{\App\CPU\translate('date')}}</th>
                        <th>{{\App\CPU\translate('status')}}</th>
                        <th>{{\App\CPU\translate('customer')}}</th>
                        <th>{{\App\CPU\translate('payment_status')}}</th>
                        <th>{{\App\CPU\translate('subtotal')}}</th>
                        <th>{{\App\CPU\translate('tax')}}</th>
                        <th>{{\App\CPU\translate('discount')}}</th>
                        <th>{{\App\CPU\translate('grand_total')}}</th>
                        <th>{{\App\CPU\translate('actions')}}</th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    @foreach($orders as $key=>$order)
                        <tr class="status-{{$order['order_status']}} class-all">
                            <td class="">
                                {{$key+$orders->firstItem()}}
                            </td>
                            <td class="table-column-pl-0">
                                <a class="text-primary" href="#"
                                   onclick="print_invoice('{{$order->id}}')">{{$order['id']}}</a>
                            </td>
                            <td>{{date('d M Y',strtotime($order['created_at']))}}</td>
                            <td class="text-center">
                                @if($order->status == 1)
                                <a class="btn btn-sm btn-success w-100">{{\App\CPU\translate('complete')}}</a>
                                @elseif($order->status == 2)
                                <a class="btn btn-sm btn-danger w-100">{{\App\CPU\translate('canceled')}}</a>
                                @else
                                 <a class="btn btn-sm btn-warning w-100">{{\App\CPU\translate('pending')}}</a>
                                @endif
                            </td>
                            <td>{{$order->cus->name}}</td>
                            <td class="text-center" >
                                @if($order->payment_id == 1)
                                    {{\App\CPU\translate('paid')}}
                                @else
                                    {{\App\CPU\translate('unpaid')}}
                                @endif
                            </td>
                            <td>
                                {{ $order->order_amount . ' ' . \App\CPU\Helpers::currency_symbol()}}
                            </td>
                            <td>{{$order['total_tax'] . ' ' . \App\CPU\Helpers::currency_symbol()}}</td>
                            <td>{{ $order->extra_discount?$order->extra_discount .' '.\App\CPU\Helpers::currency_symbol():0 .' '.\App\CPU\Helpers::currency_symbol() }}</td>
                           
                            <td>{{ $order->total .' '.\App\CPU\Helpers::currency_symbol()}}</td>
                           
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle" 
                                      type="button"
                                      data-toggle="dropdown" 
                                      aria-expanded="false">{{\App\CPU\translate('action')}}
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item"  onclick="print_invoice('{{$order->id}}')" >{{\App\CPU\translate('invoice')}}</a>
                                     
                                      
                                        @if($order->payment_id != 1)
                                            <a class="dropdown-item"
                                              type="button" 
                                              data-toggle="modal" 
                                              data-target="#customer_order_payment_form{{$order->id}}" 
                                            >{{\App\CPU\translate('make_payment')}}</a>
                                        @endif
                                      
                                      @if($order->status == 0)
                                        <a class="dropdown-item" 
                                         href="{{route('admin.pos.order-complete',$order->id)}}">{{\App\CPU\translate('make_order_completed')}}</a>
                                        @elseif($order->status == 1)
                                            <a class="dropdown-item" 
                                            type="button" 
                                            data-toggle="modal" 
                                            data-target="#order_cancel{{$order->id}}" 
                                            href="{{route('admin.pos.order-cancel',$order->id)}}">{{\App\CPU\translate('order_cancel')}}</a>
                                        @else 
                                     @endif

                                    </div>
                                  </div>

                                  @include('admin-views.partials.make_customer_payment')
                                  @include('admin-views.partials.order_cancel_form')
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        
            <div class="card-footer">
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm-auto">
                        <div class="d-flex justify-content-center justify-content-sm-end">
                            {!! $orders->links() !!}
                        </div>
                    </div>
                </div>
            </div>
            @if(count($orders)==0)
                <div class="text-center p-4">
                    <img class="mb-3 img-one-ol" src="{{asset('public/assets/admin')}}/svg/illustrations/sorry.svg"
                         alt="Image Description">
                    <p class="mb-0">{{ \App\CPU\translate('No_data_to_show')}}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="print-invoice" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content modal-content1">
                <div class="modal-header">
                    <h5 class="modal-title">{{\App\CPU\translate('print')}} {{\App\CPU\translate('invoice')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row font-one-ol">
                    <div class="col-md-12">
                        <center>
                            <input type="button" class="mt-2 btn btn-primary non-printable"
                                   onclick="printDiv('printableArea')"
                                   value="{{\App\CPU\translate('Proceed, If thermal printer is ready')}}."/>
                            <a href="{{url()->previous()}}"
                               class="mt-2 btn btn-danger non-printable">{{\App\CPU\translate('Back')}}</a>
                        </center>
                        <hr class="non-printable">
                    </div>
                    <div class="row m-auto" id="printableArea">

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script_2')
    <script>
        "use strict";
        function print_invoice(order_id) {
            $.get({
                url: '{{url('/')}}/admin/pos/invoice/' + order_id,
                dataType: 'json',
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    //console.log("success...")
                    $('#print-invoice').modal('show');
                    $('#printableArea').empty().html(data.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }
    </script>

    <script src={{asset("public/assets/admin/js/global.js")}}></script>
@endpush
