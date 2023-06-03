@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <form action="{{ route('discountextra.update') }}" method="post">{{ csrf_field() }}
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Price Info ') }}</h5>
                </div>
                <a  data-toggle="modal" data-target="#setextradiscount" style="color:white" class="btn btn-sm btn-danger"><i class="las la-cog"></i> Set Discount Extra</a>
                <div id="setextradiscount" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <img style="width:100%" src="/public/aceweb/assets/img/extraset.png">

                            </div>

                                <div class="modal-body">
                                    <label for="">Discounted prices for purchases of more than 100 grams. Please Set Amount (RM)</label>
                                    <input type="hidden" name="types[]" value="DISCOUNT_EXTRA">
                                    <input id="doubleInput" oninput="validateNumberFormat(this)"
                                        value="{{ env('DISCOUNT_EXTRA') }}" class="form-control" required name="DISCOUNT_EXTRA">
                                </div>
                                <div class="modal-footer">
                                    <a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
                                    <button type="submit" class="btn btn-primary">SET</button>
                                </div>

                        </div>

                    </div>
                </div>

            </div>
        </form>
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered dataTable no-footer">
                <thead>
                    <tr>
                        <th>#</th>
                        <th data-breakpoints="lg">{{ translate('Name') }}</th>
                        <th style="width:50px">{{ translate('Denomination') }}</th>
                        <th data-breakpoints="lg">{{ translate('Live Price') }}</th>
                        <th>{{ translate('Margin') }}</th>
                        <th>{{ translate('Promotion Price') }}</th>
                        <th>{{ translate('Selling Price') }}</th>
                        <th class="text-right">{{ translate('Option') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $v)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                <div class="row gutters-5 w-200px w-md-300px mw-100">
                                    <div class="col-auto">
                                        <img src="{{ uploaded_asset($v->thumbnail_img) }}" alt="Image"
                                            class="size-50px img-fit">
                                    </div>
                                    <div class="col">
                                        <span class="text-muted text-truncate-2">{{ $v->getTranslation('name') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $v->denominations }}</td>
                            <td>{{ single_price(getlastprice()) }}</td>
                            <td>{{ $v->margin }}</td>
                            <td>{{ single_price($v->promo_price) }}</td>
                            <td>
                                @if (home_price($v) != home_discounted_price($v))
                                    <div style="display: flex;"></div>
                                    <div class="price"> {{ home_discounted_price($v) }}</div>
                                    <div class="price">
                                        <del style="color:#bec0c2">
                                            {{ home_price($v) }}
                                        </del>
                                    </div>
                                @else
                                    <div class="price">{{ format_price($v->unit_price) }}</div>
                                @endif
                            </td>
                            <td>
                                <a style="color:white" data-toggle="modal" data-target="#edit{{ $v->id }}"class="btn btn-circle btn-sm btn-info btn-icon "><i class="las la-money-bill-wave"></i></a>
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('products.seller.editdiscount', ['id'=>$v->id_product, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <div id="edit{{ $v->id }}" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">SET MARGIN FOR {{ $v->denominations }} gram</h4>
                                        <button type="button" class="btn btn-danger btn-sm"
                                            data-dismiss="modal">&times;</button>

                                    </div>
                                    <form action="{{ route('margin.update') }}" method="post">{{ csrf_field() }}
                                        <div class="modal-body">
                                            <label for="">MARGIN</label>
                                            <input type="hidden" name="id" value="{{ $v->id }}">
                                            <input id="doubleInput{{ $v->id }}" oninput="validateNumberFormat(this)"
                                                value="{{ $v->margin }}" class="form-control" required name="margin">
                                        </div>
                                        <div class="modal-footer">
                                            <a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    @endforeach



                </tbody>
            </table>
            </div>
            <div class="aiz-pagination">

            </div>
        </div>
    </div>
    <script>
        function validateNumberFormat(input) {
            // Remove any non-digit characters from the input
            var cleanedInput = input.value.replace(/[^\d.]/g, '');

            // Validate the input format
            var isValidFormat = /^\d+(\.\d{0,2})?$/.test(cleanedInput);

            // Update the input value if the format is valid
            if (isValidFormat) {
                input.value = cleanedInput;
            } else {
                // Clear the input value or display an error message
                input.value = '';
                // You can also display an error message to the user
                // by targeting an HTML element and setting its innerHTML
                // For example: document.getElementById("errorMessage").innerHTML = "Invalid format";
            }
        }
    </script>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
