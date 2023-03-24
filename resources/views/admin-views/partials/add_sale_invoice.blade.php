<div class="modal fade" id="add_sale_invoice" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CPU\translate('create_sale_invoice')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('admin.saleinvoices.store')}}" class="row">
                    @csrf
                    <div class="col-12">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('customer')}}</label>
                            <select name="customer_id" class="form-control js-select2-custom" required>
                                <option value="">---{{\App\CPU\translate('select')}}---</option>
                                @foreach ($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                      </div>
                        <div class="form-group col-12">
                            <label for="">{{\App\CPU\translate('amount')}}</label>
                            <input type="number" 
                                step="0.01" 
                                class="form-control" 
                                name="amount" 
                                required />
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('date')}} </label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                                <label class="input-label">{{\App\CPU\translate('description')}} </label>
                                <input type="text" name="description" class="form-control" placeholder="{{\App\CPU\translate('description')}}" required >
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <button class="btn btn-sm btn-primary" type="submit">{{\App\CPU\translate('submit')}}</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>