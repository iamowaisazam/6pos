<div class="modal fade" id="customer_order_payment_form{{$order->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CPU\translate('make_payment')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.pos.make-payment',$order->id)}}" class="
                    customer_order_payment_form row">
                        <input type="hidden" name="customer_id" value="{{$order->user_id}}" />
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('payment_type')}}</label>
                                <select name="payment_type" class="payment_type form-control js-select2-custom" required>
                                    <option value="cash">{{\App\CPU\translate('cash')}}</option>
                                    <option value="customer_balance">{{\App\CPU\translate('customer_balance')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-12 col-sm-6">
                            <label>{{\App\CPU\translate('customer')}}</label>
                            <input type="text" class="form-control" readonly
                            value="{{$order->cus->name}}" >
                        </div>
                        <div style="display:none" class="current_balance form-group col-12 col-sm-6">
                            <label>{{\App\CPU\translate('customer_account_balance')}}</label>
                            <input type="number" class="form-control" readonly
                            value="{{$order->cus->balance}}" >
                        </div>
                        <div class="order_total form-group col-12 col-md-6">
                            <label>{{\App\CPU\translate('order_total_amount')}}</label>
                            <input readonly value="{{$order->total}}" 
                            type="number" class="form-control" />
                        </div>
                        <div class="collected_cash form-group col-12 col-md-6">
                            <label>{{\App\CPU\translate('collected_cash')}}</label>
                            <input type="number" step="0.01" min="{{$order->total}}" 
                            class="form-control amount" 
                            name="amount" required>
                        </div>
                        <div style="display:none" class="remaining_balance form-group col-12 col-md-6">
                            <label>{{\App\CPU\translate('remaining_acount_balance')}}</label>
                            <input type="number" readonly class="form-control " />
                        </div>
                        <div class="returned_amount form-group col-12 col-md-6">
                            <label>{{\App\CPU\translate('returned_amount')}}</label>
                            <input name="returned_amount" type="text" readonly class="form-control" />
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('balance_receive_account')}}</label>
                                <select name="account_id" class="form-control js-select2-custom" required>
                                    <option value="">---{{\App\CPU\translate('select')}}---</option>
                                    @foreach ($accounts as $account)
                                        @if ($account['id']!=2 && $account['id']!=3)
                                            <option value="{{$account['id']}}">{{$account['account']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
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