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
        @can('add_contact')
            <div class="col-md-6 text-md-right">
                <a href="{{ route('contact.create') }}" class="btn btn-circle btn-info">
                    <span>{{translate('Add Contact')}}</span>
                </a>
            </div>
        @endcan
    </div>
    <div class="card-body">
        <table id="example" class="table table-striped table-bordered dataTable no-footer">
            <thead>
                <tr>
                    <th data-breakpoints="lg" width="10%">#</th>
                    <th>{{translate('Company Image')}}</th>
                    <th>{{translate('Name')}}</th>
                    <th>{{translate('Address')}}</th>
                    <th data-breakpoints="lg">{{translate('Email')}}</th>
                    <th data-breakpoints="lg">{{translate('Telp')}}</th>

                    <th width="10%">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $i => $contact)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><img style="width:30%" src="{{ asset('public/' .$contact->getImage->file_name) }}"></td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->address }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->telp }}</td>
                    <td>
                         @can('edit_contact')
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                            href="{{ route('contact.edit', $contact->id) }}" title="{{ translate('Edit') }}">
                                            <i class="las la-pen"></i>
                                        </a>
                                    @endcan
                                    @can('delete_contact')
                                        <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                            data-href="{{ route('contact.destroy', $contact->id) }}"
                                            title="{{ translate('Delete') }}">
                                            <i class="las la-trash"></i>
                                        </a>
                                    @endcan
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
        <div class="aiz-pagination">
        <div class="aiz-pagination">
            <!-- $staffs->appends(request()->input())->links()  -->
        </div>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
