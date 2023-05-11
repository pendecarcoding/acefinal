@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<!-- <div class="col-md-6">
			<h1 class="h3">{{translate('All Staffs')}}</h1>
		</div> -->
        <!-- @can('add_staff')
            <div class="col-md-6 text-md-right">
                <a href="{{ route('staffs.create') }}" class="btn btn-circle btn-info">
                    <span>{{translate('Add New Staffs')}}</span>
                </a>
            </div>
        @endcan -->
	</div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Staffs')}}</h5>
    </div>
    <div class="card-body">
        <table id="example" class="table table-striped table-bordered dataTable no-footer">
            <thead>
                <tr>
                    <th data-breakpoints="lg" width="10%">#</th>
                    <th>{{translate('Name')}}</th>
                    <th data-breakpoints="lg">{{translate('Position')}}</th>
                    <th data-breakpoints="lg">{{translate('Email')}}</th>
                    <th data-breakpoints="lg">{{translate('Last Login')}}</th>
                    <th data-breakpoints="lg">{{translate('How Much Login')}}</th>
                    <!-- <th width="10%">{{translate('Options')}}</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i =>$v)
                <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$v->name}}</td>
                    <td>{{$v->position}}</td>
                    <td>{{$v->email}}</td>
                    <td>{{lastlogin($v->id,'login')}}</td>
                    <td>{{numberlogin($v->id,'login')}}</td>
                    <!-- <td></td> -->
                </tr>
                @endforeach
               
            </tbody>
        </table>
        <div class="aiz-pagination">
            <!-- $staffs->appends(request()->input())->links()  -->
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
