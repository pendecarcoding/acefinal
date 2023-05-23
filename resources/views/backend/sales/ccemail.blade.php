@extends('backend.layouts.app')

@section('content')
    <div class="card">

            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">

                    <h5 class="mb-md-0 h6">{{ translate('List EMAIL ') }}</h5>

                </div>
                @can('add_ccemail')
                <a data-toggle="modal" data-target="#addccemail" style="float:right;color:white" class="btn btn-primary">Add CC Email</a>
                @endcan

            </div>
            <div id="addccemail" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Add Email</h4>
                      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">&times;</button>

                    </div>
                    <form action="{{route('ccemail.add')}}" method="post">{{ csrf_field() }}
                        <div class="modal-body">
                            <label for="">Email</label>
                            <input type="email" value="" class="form-control" required name="email">
                        </div>
                        <div class="modal-footer">
                        <a type="button" class="btn btn-default" data-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                   </form>
                  </div>

                </div>
              </div>

        <div class="card-body">
            <table id="example" class="table table-striped table-bordered dataTable no-footer">
                <thead>
                    <tr>
                        <th style="width:20px">#</th>
                        <th data-breakpoints="lg">{{ translate('email') }}</th>
                        <th style="width:30px" class="text-right">{{ translate('Option') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $i =>$v)
                    <tr>
                        <td style="text-align: center;">{{$i+1}}</td>
                        <td>{{$v->email}}</td>
                        <td>
                                @can('edit_ccemail')
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                    data-toggle="modal" data-target="#edit{{$v->id}}" title="{{ translate('Edit') }}">
                                        <i class="las la-pen"></i>
                                    </a>
                                @endcan
                                @can('delete_ccemail')
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                    data-href="{{route('cc_email.delete', $v->id)}}" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                @endcan
                        </td>
                    </tr>

                    <div id="edit{{$v->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Update Email</h4>
                              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">&times;</button>

                            </div>
                            <form action="{{route('ccemail.update')}}" method="post">{{ csrf_field() }}
                                <div class="modal-body">
                                    <label for="">Email</label>
                                    <input type="hidden" name="id" value="{{$v->id}}">
                                    <input type="email" value="{{$v->email}}" class="form-control" required name="email">
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



