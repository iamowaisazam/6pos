<div class="modal fade" id="order_cancel{{$order->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CPU\translate('order_cancel')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.pos.order-cancel',$order->id)}}" class="
                    customer_order_cancel_form row">
                        <input type="hidden" name="customer_id" value="{{$order->user_id}}" />

                        <div class="form-group col-12 col-sm-6">
                            <label>{{\App\CPU\translate('customer')}}</label>
                            <input type="text" class="form-control" readonly
                            value="{{$order->cus->name}}" >
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label class="input-label">{{\App\CPU\translate('balance_receive_account')}}</label>
                                <select name="account_id" class="account_id form-control js-select2-custom" required>
                                    @foreach ($accounts as $account)
                                        @if ($account['id']!=2 && $account['id']!=3)
                                            <option 
                                            data-balance="{{$account['balance']}}" 
                                            value="{{$account['id']}}">{{$account['account']}} Account Balance ({{$account['balance']}})  
                                        </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="order_total form-group col-12 col-md-6">
                            <label>{{\App\CPU\translate('order_total_amount')}}</label>
                            <input readonly name="order_amount" value="{{$order->total}}" 
                            type="number" class="form-control" />
                        </div>
                      
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('date')}} </label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                        </div>
                       
                        <div class="col-sm-12">
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