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
                        <span
                            class="badge badge-soft-dark ml-2">{{$orders->total()}}</span></h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Card -->
        <div class="card">
            <!-- Header -->
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-sm-8 col-md-6 col-lg-6 mb-3 mb-lg-0">
                        <form action="{{url()->current()}}" method="GET">

                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input type="search" name="search" class="form-control"
                                       placeholder="{{\App\CPU\translate('search_by_order_id')}}" aria-label="Search"
                                       value="{{ $search }}" required>
                                <button type="submit" class="btn btn-primary">{{\App\CPU\translate('search')}}</button>
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>

                    <div class="col-lg-6"></div>
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
                                     
                                      @if($order->status == 1)
                                        @if($order->payment_id != 1)
                                            <a class="dropdown-item"
                                              type="button" 
                                              data-toggle="modal" 
                                              data-target="#customer_order_payment_form{{$order->id}}" 
                                            >{{\App\CPU\translate('make_payment')}}</a>
                                        @endif
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
