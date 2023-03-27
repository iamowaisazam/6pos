<div class="modal fade" id="add_receivable{{$customer['id']}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CPU\translate('add_customer_receivable')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.customer.add_recievable')}}" method="post" class="
                remove_balance_form row">
                    @csrf
                        <input type="hidden" id="customer_id" name="customer_id"  value="{{$customer['id']}}" />
                        <div class="form-group col-12 col-sm-6">
                            <label for="">{{\App\CPU\translate('customer')}}</label>
                            <input type="text" class="form-control" readonly
                            value="{{$customer['name']}}" >
                        </div>
                        <div class="form-group col-12 col-sm-6">
                            <label for="">{{\App\CPU\translate('balance')}}</label>
                            <input type="number"
                            class="form-control current_balance" 
                            readonly
                            value="{{$customer['balance']}}" >
                        </div>
                        <div class="form-group col-12 col-sm-6">
                            <label for="">{{\App\CPU\translate('amount')}}</label>
                            <input type="number" step="0.01" min="0" class="form-control add_balance" 
                            name="amount" />
                        </div>
                        <div class="form-group col-12 col-sm-6">
                            <label for="">{{\App\CPU\translate('remaining_balance')}}</label>
                            <input type="number" class="form-control remaining_balance"/>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('date')}} </label>
                                <input type="datetime-local" name="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="input-label">{{\App\CPU\translate('description')}} </label>
                                <input type="text" name="description" class="form-control" placeholder="{{\App\CPU\translate('description')}}" >
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