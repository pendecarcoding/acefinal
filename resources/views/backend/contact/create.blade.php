@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<!-- <div class="col-md-6">
			<h1 class="h3">{{translate('All Staffs')}}</h1>
		</div> -->

	</div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Contact')}}</h5>
       <div class="col-md-6 text-md-right">
                <a href="{{ route('contact.index') }}" class="btn btn-circle btn-danger">
                    <li class="las la-times"></li>
                </a>
            </div>
    </div>
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('contact.store') }}" method="POST">
            {{csrf_field()}}

            <div class="form-group">
                   <div class="input-group" data-toggle="aizuploader" data-type="image">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-soft-secondary font-weight-medium">
                                        {{ translate('Browse')}}
                                    </div>
                                </div>
                                <div class="form-control file-amount">{{ translate('Choose File') }}</div>
                                <input type="hidden" name="id_image" class="selected-files">
                            </div>
                            <div class="file-preview box sm">
                            </div>
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="{{ translate('Name') }}">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="address" placeholder="{{ translate('Address') }}">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="{{ translate('Email') }}">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="telp" placeholder="{{ translate('Telp') }}">
            </div>
             <div class="form-group">
                <input type="text" class="form-control" name="link" placeholder="{{ translate('Link (google maps or Waze)') }}">
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="orderto"  placeholder="{{ translate('Order to') }}">
            </div>
            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>

        </form>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
