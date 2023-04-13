@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <form class="" id="sort_announcements" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Data Margin SET ') }}</h5>
                </div>


            </div>
        </form>
        <div class="card-body">
            <table id="example" class="table table-striped table-bordered dataTable no-footer">
                <thead>
                    <tr>
                        <th>#</th>
                        <th data-breakpoints="lg">{{ translate('Name') }}</th>
                        <th data-breakpoints="lg">{{ translate('Denomination') }}</th>
                        <th class="text-right">{{ translate('Margin') }}</th>
                        <th class="text-right">{{ translate('Option') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $i => $v)
                    <tr>
                        <td>{{$i+1}}</td>
                        <td> <div class="row gutters-5 w-200px w-md-300px mw-100">
                            <div class="col-auto">
                                <img src="{{ uploaded_asset($v->thumbnail_img)}}" alt="Image" class="size-50px img-fit">
                            </div>
                            <div class="col">
                                <span class="text-muted text-truncate-2">{{ $v->getTranslation('name') }}</span>
                            </div>
                        </div></td>
                        <td>{{$v->denominations}}</td>
                        <td>{{$v->margin}}</td>
                        <td><a data-toggle="modal" data-target="#edit{{$v->id}}" class="btn btn-soft-primary btn-icon btn-circle btn-sm"><i class="las la-edit"></i></a></td>
                    </tr>
                    <div id="edit{{$v->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">SET MARGIN FOR {{$v->denominations}} gram</h4>
                              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">&times;</button>

                            </div>
                            <form action="{{route('margin.update')}}" method="post">{{ csrf_field() }}
                                <div class="modal-body">
                                    <label for="">MARGIN</label>
                                    <input type="hidden" name="id" value="{{$v->id}}">
                                    <input type="number" value="{{$v->margin}}" class="form-control" required name="margin">
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
            <div class="aiz-pagination">

            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection



