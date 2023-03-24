<div class="modal fade" id="order_cancel{{$order->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CPU\translate('order_cancel')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.pos.order-cancel',$order->id)}}" class="row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('account')}}</label>
                                <select name="account_id" class="form-control js-select2-custom" required>
                                    <option value="">---{{\App\CPU\translate('select')}}---</option>
                                    @foreach ($accounts as $account)
                                        @if ($account['id']!=2 && $account['id']!=3)
                                            <option value="{{$account['id']}}">{{$account['account']}} ({{$account['balance']}} {{\App\CPU\Helpers::currency_symbol() }})</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-12 col-sm-6">
                            <label for="">{{\App\CPU\translate('refund_amount')}}</label>
                            <input type="number" 
                                step="0.01"
                                readonly 
                                min="0"
                                max="{{$order->total}}"
                                value="{{$order->total}}" 
                                class="form-control" 
                                name="amount" 
                                required />
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('date')}} </label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
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