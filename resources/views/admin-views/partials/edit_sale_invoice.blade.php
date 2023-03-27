<div class="modal fade" id="edit_sale_invoice{{$item->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{\App\CPU\translate('create_sale_invoice')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{route('admin.saleinvoices.update',$item->id)}}" class="row">
                    @csrf

                    <?php 
                    // dd($item->customer->status);
                    ?>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('customer')}}</label>
                            <select name="customer_id" class="form-control js-select2-custom" required>
                                <option value="">---{{\App\CPU\translate('select')}}---</option>
                                
                                
                                @if($item->customer->status != 1)
                                    @foreach ($customers as $customer)
                                    <option 
                                    @if($item->customer_id == $customer->id) selected @endif
                                        value="{{$customer->id}}"
                                    >{{$customer->name}}</option>
                                    @endforeach
                                @else
                                   @foreach ($customers->where('status',1) as $customer)
                                    <option 
                                    @if($item->customer_id == $customer->id) selected @endif
                                        value="{{$customer->id}}"
                                    >{{$customer->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                      </div>
                        <div class="form-group col-12">
                            <label for="">{{\App\CPU\translate('amount')}}</label>
                            <input type="number" 
                                step="0.01" 
                                class="form-control" 
                                name="amount"
                                value="{{$item->amount}}" 
                                required />
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="input-label" for="exampleFormControlInput1">{{\App\CPU\translate('date')}} </label>
                                <input 
                                   value="{{$item->date->format('Y-m-d')}}"
                                   type="date" 
                                   name="date" 
                                   class="form-control" 
                                   required />
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                                <label class="input-label">{{\App\CPU\translate('description')}} </label>
                                <input type="text" name="description" class="form-control" placeholder="{{\App\CPU\translate('description')}}" required
                                value="{{$item->description}}"
                                >
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