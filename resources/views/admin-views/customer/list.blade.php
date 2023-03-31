@extends('layouts.admin.app')

@section('title',\App\CPU\translate('customer_list'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('public/assets/admin')}}/css/custom.css"/>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title text-capitalize"><i
                            class="tio-filter-list"></i> {{\App\CPU\translate('customer_list')}}
                        <span class="badge badge-soft-dark ml-2">{{$customers->total()}}</span>
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <div class="row gx-2 gx-lg-3">
            <div class="col-sm-12 col-lg-12 mb-3 mb-lg-2">

                <div class="card mb-3">
                    <div class="card-body">
                        <form action="{{url()->current()}}" method="GET">
                            <div class="row m-1">
                                <div class="form-group col-12 col-sm-3">
                                    <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('search')}} </label>
                                    <input type="text" placeholder="Search" name="search" class="form-control" value="{{request()->search}}" />
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-3 col-lg-3">
                                    <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('Status')}} </label>
                                    <select id="status" name="status" class="form-control js-select2-custom">
                                        <option {{request()->status == null || request()->status == 1 ? 'selected' : ''}} value="1">{{\App\CPU\translate('active')}}</option>
                                        <option {{request()->status == '0' ? 'selected' : ''}} value="0">{{\App\CPU\translate('deactive')}}</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-3 col-lg-3">
                                    <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('Show')}} </label>
                                    <select id="tran_type" name="per_page" class="form-control js-select2-custom">
                                        <option {{request()->per_page == 10 ? 'selected' : ''}} value="10">{{\App\CPU\translate('10')}}</option>
                                        <option {{request()->per_page == 20 ? 'selected' : ''}} value="20">{{\App\CPU\translate('20')}}</option>
                                        <option {{request()->per_page == 50 ? 'selected' : ''}} value="50">{{\App\CPU\translate('50')}}</option>
                                        <option {{request()->per_page == 100 ? 'selected' : ''}} value="100">{{\App\CPU\translate('100')}}</option>
                                    </select>
                                </div>
                                <div class="col-md-2 text-center align-self-center">
                                    <button class="btn btn-primary">{{\App\CPU\translate('search')}}</button>
                                </div>
                           </div>
                        </form>
                    </div>
                </div>
                <!-- Card -->
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-12 col-sm-3">
                                Showing {{($customers->currentpage()-1)*$customers->perpage()+1}} to {{ $customers->currentpage()*(($customers->perpage() < $customers->total()) ? $customers->perpage(): $customers->total())}} of {{ $customers->total()}} entries
                            </div>
                            <div class="col-12 col-sm-9 text-right">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" 
                                      type="button"
                                      data-toggle="dropdown" 
                                      aria-expanded="false">{{\App\CPU\translate('action')}}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a href="{{route('admin.customer.add')}}" class="dropdown-item btn btn-primary float-right">{{\App\CPU\translate('add_new_customer')}}
                                        </a>
                                        <a 
                                         href="{{route('admin.customer.export')}}?search={{request()->search}}&status={{request()->status}}&per_page={{request()->per_page}}" 
                                         class="dropdown-item btn btn-primary float-right">{{\App\CPU\translate('export')}}
                                        </a>
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{\App\CPU\translate('#')}}</th>
                                <th>{{ \App\CPU\translate('image') }}</th>
                                <th>{{\App\CPU\translate('name')}}</th>
                                <th>{{ \App\CPU\translate('orders') }}</th>
                                <th>{{ \App\CPU\translate('status') }}</th>
                                <th>{{ \App\CPU\translate('receivable') }}</th>
                                <th>{{ \App\CPU\translate('payable') }}</th>
                                <th class="text-center" >{{ \App\CPU\translate('balance') }}</th>
                                <th>{{ \App\CPU\translate('income') }}</th>
                                <th>{{ \App\CPU\translate('net_profit') }}</th>
                                <th>{{\App\CPU\translate('action')}}</th>
                            </tr>
                            </thead>
                            <tbody id="set-rows">
                            
                            @foreach($customers as $key=>$customer)

                            <?php 

                                $total = 0;
                                $income = 0;
                                $receivable = 0;
                                $payable = 0;
                                $profit = 0;

                                $receivable += $customer->rc;
                                $receivable -= $customer->rd;

                                $payable += $customer->pc;
                                $payable -= $customer->pd;

                                $income += $customer->income_credit;
                                $income -= $customer->income_debit;


                                $profit = $income + $receivable;
                                $profit = $profit - $payable;

                           ?>
                      
                                <tr>
                                    <td>{{ $customers->firstItem()+$key+1 }}</td>
                                    <td>
                                        <a>
                                            <img class="img-one-cl"
                                            onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'"
                                            src="{{asset('storage/app/public/customer')}}/{{ $customer->image }}" alt="">
                                        </a>
                                    </td>
                                    <td>
                                        <a class="text-primary">
                                            {{ $customer->name }}
                                        </a>
                                    </td>
                                    
                                    <td>{{ $customer->orders->count() }}</td>
                                    <td>
                                        {{$customer->status == 1 ? 'Active' : 'Deactive'}}
                                    </td>
                                    <td>
                                        {{$receivable  . ' ' . \App\CPU\Helpers::currency_symbol()}}
                                    </td>
                                    <td>
                                        {{$payable  . ' ' . \App\CPU\Helpers::currency_symbol()}}
                                    </td>
                                    <td class="text-center p-5" >
                                        {{$customer->balance . ' ' . \App\CPU\Helpers::currency_symbol() }}
                                    </td>
                                    <td>
                                        {{$income  . ' ' . \App\CPU\Helpers::currency_symbol()}}
                                    </td>
                                    <td>
                                        {{$profit  . ' ' . \App\CPU\Helpers::currency_symbol()}}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-info dropdown-toggle" 
                                              type="button"
                                              data-toggle="dropdown" 
                                              aria-expanded="false">{{\App\CPU\translate('action')}}
                                            </button>
                                            <div class="dropdown-menu">

                                                <a class="dropdown-item"  
                                                id="{{ $customer->id }}" 
                                                 type="button" 
                                                 data-toggle="modal" 
                                                 data-target="#update-customer-balance{{$customer['id']}}">
                                                {{\App\CPU\translate('add_balance')}}</a>

                                                <a class="dropdown-item"  
                                                id="{{ $customer->id }}" 
                                                 type="button" 
                                                 data-toggle="modal" 
                                                 data-target="#add_receivable{{$customer['id']}}">
                                                 {{\App\CPU\translate('add_receivable')}}</a>

                                                 <a class="dropdown-item"
                                                 href="{{route('admin.customer.transactions',[$customer['id']])}}">
                                                 View Transaction</a>

                                                @if($customer['id'] != 0)
                                                <a class="dropdown-item"
                                                    href="{{route('admin.customer.edit',[$customer['id']])}}">
                                                    Edit</a>
                                                @endif

                                                @if($customer['id'] != 0)
                                                <a class="dropdown-item" href="javascript:"
                                                    onclick="form_alert('customer-{{$customer['id']}}','Want to delete this customer?')">Delete</a>
                                                    <form action="{{route('admin.customer.delete',[$customer['id']])}}"
                                                            method="post" id="customer-{{$customer['id']}}">
                                                        @csrf @method('delete')
                                                    </form>
                                                @endif

                                                @if($customer['id'] != 0)
                                                    @if($customer['status'] == 0)
                                                    <a class="dropdown-item" href="{{route('admin.customer.status',[$customer['id']])}}?status=1">Active</a>
                                                    @else
                                                    <a class="dropdown-item" 
                                                    href="{{route('admin.customer.status',[$customer['id']])}}?status=0">Deactive</a>
                                                    @endif
                                                @endif
                                            </div>
                                          </div>

                                          @include('admin-views.partials.add_customer_balance')
                                          @include('admin-views.partials.add_customer_recievable')

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="page-area">
                            <table>
                                <tfoot class="border-top">
                                {!! $customers->links() !!}
                                </tfoot>
                            </table>
                        </div>
                        @if(count($customers)==0)
                            <div class="text-center p-4">
                                <img class="mb-3 w-one-cl" src="{{asset('public/assets/admin')}}/svg/illustrations/sorry.svg" alt="{{\App\CPU\translate('Image Description')}}">
                                <p class="mb-0">{{ \App\CPU\translate('No_data_to_show')}}</p>
                            </div>
                        @endif
                    </div>
                    <!-- End Table -->
                </div>
                <!-- End Card -->
            </div>
        </div>
    </div>

@endsection

@push('script_2')
    <script src={{asset("public/assets/admin/js/global.js")}}></script>
@endpush