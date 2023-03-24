@extends('layouts.admin.app')

@section('title',\App\CPU\translate('sale_invoice'))

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
                      class="tio-filter-list"></i> {{\App\CPU\translate('sale_invoice')}}
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
                                <div class="form-group col-12">
                                    <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('Search')}} </label>
                                    <input class="form-control" type="text" name="search" value="{{request()->search}}"
                                    placeholder="{{\App\CPU\translate('search_by_id_or_description')}}"
                                    />
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('customer')}}</label>
                                        <select name="customer_id" class="form-control js-select2-custom" >
                                           
                                            <option value="" selected >---{{\App\CPU\translate('select')}}---</option>
                                            @foreach ($customers as $customer)
                                                    <option 
                                                       @if(request()->customer_id != '' 
                                                       && request()->customer_id == $customer->id)
                                                        selected
                                                       @endif
                                                       value="{{$customer->id}}"
                                                       >{{$customer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group col-12 col-sm-6 col-md-3 col-lg-3">
                                    <label class="input-label" 
                                    for="exampleFormControlInput1">{{\App\CPU\translate('start_date')}} </label>
                                    <input id="start_date" type="date" 
                                    name="from" class="form-control" value="{{request()->from}}">
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-3 col-lg-3">
                                    <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('end_date')}} </label>
                                    <input id="end_date" type="date" name="to" class="form-control" 
                                    value="{{request()->to}}">
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
                                <div class="col-12 text-center">
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
                            <div class="col-12 col-sm-7 col-md-6 col-lg-4 col-xl-6 mb-3 mb-sm-0">
                                Showing {{($data->currentpage()-1)*$data->perpage()+1}} to {{ $data->currentpage()*(($data->perpage() < $data->total()) ? $data->perpage(): $data->total())}} of {{ $data->total()}} entries
                            </div>
                            <div class="col-12 col-sm-5 text-right">
                                <div class="dropdown">
                                    <button class="btn btn-info dropdown-toggle" 
                                      type="button"
                                      data-toggle="dropdown" 
                                      aria-expanded="false">{{\App\CPU\translate('action')}}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            type="button" 
                                            data-toggle="modal" 
                                            data-target="#add_sale_invoice" 
                                        >Add New</a>
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
                                <th>{{\App\CPU\translate('ID')}}</th>
                                <th class="text-center" >{{ \App\CPU\translate('date') }}</th>
                                <th class="text-center" >{{\App\CPU\translate('customer')}}</th>
                                <th class="text-center" >{{\App\CPU\translate('description')}}</th>
                                <th class="text-center" >{{\App\CPU\translate('amount')}}</th>
                                <th class="text-center" >{{\App\CPU\translate('action')}}</th>
                            </tr>
                            </thead>
                            <tbody id="set-rows">
                                    @foreach($data as $key=> $item)
                                        <tr>
                                            <td>#{{$item->id}}</td>
                                            <td class="text-center p-5" >
                                                {{$item->date}}
                                            </td>
                                            <td>   <a class="text-primary" 
                                                href="{{route('admin.customer.edit',$item->customer_id)}}">
                                                    {{ $item->customer->name }}
                                                </a>
                                            </td>
                                            <td class="text-center p-5" >
                                                {{$item->description}}
                                            </td>
                                            <td class="text-center p-5" >
                                                {{$item->amount}}
                                            </td>
                                            <td class="text-center p-5" >

                                                <a class="btn btn-primary" 
                                                type="button" 
                                                data-toggle="modal" 
                                                data-target="#edit_sale_invoice{{$item->id}}"
                                                >{{\App\CPU\translate('edit')}}</a>

                                                <a href="{{route('admin.saleinvoices.delete',$item->id)}}" class="btn btn-danger" 
                                                type="button">{{\App\CPU\translate('delete')}}</a>

                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>

                        <div class="page-area">
                            <table>
                                <tfoot class="border-top">
                                {!! $data->links() !!}
                                </tfoot>
                            </table>
                        </div>
                        @if(count($data)==0)
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
    
    @include('admin-views.partials.add_sale_invoice')
@endsection
@push('script_2')
    <script src={{asset("public/assets/admin/js/global.js")}}></script>
@endpush