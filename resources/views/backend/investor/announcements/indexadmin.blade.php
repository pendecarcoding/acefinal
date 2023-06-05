@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <form class="" id="sort_announcements" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Announcements ') }}</h5>
                </div>
                
                <div class="col text-center text-md-right">
                    @can('add_announcements')
                    <div class="col text-right">
                        <a href="{{ route('announcementsadmin.create') }}" class="btn btn-primary btn-sm">
                            <span>{{ translate('Add New Announcements') }}</span>
                        </a>
                    </div>
                    @endcan
                </div>
            </div>
        </form>
        <div class="card-body">
            <table id="example" class="table table-striped table-bordered dataTable no-footer">
                <thead>
                    <tr>
                        <th style="width:20px;text-align: center;">#</th>
                        <th data-breakpoints="lg">{{ translate('title') }}</th>
                        <th data-breakpoints="lg">{{ translate('Date') }}</th>
                        <th style="width:20px;text-align: center;" class="text-right">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $v)
                        <tr>
                            <td style="text-align: center;">{{ $i + 1 }}</td>
                            <td>{{ $v->title }}</td>
                            <td>{{ $v->created_at }}</td>
                            <td>
                                @can('edit_announcements')
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="{{ route('announcementsadmin.edit', base64_encode($v->id)) }}"
                                        title="{{ translate('Edit') }}">
                                        <i class="las la-pen"></i>
                                    </a>
                                @endcan
                                @can('delete_announcements')
                                    <a class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('announcementsadmin.destroy', base64_encode($v->id)) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
            <!-- <div class="aiz-pagination">

            </div> -->
        </div>
    </div>
@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection


@section('script')
    <script type="text/javascript">
        function change_status(el) {
            var status = 0;
            if (el.checked) {
                var status = 1;
            }
            $.post('{{ route('blog.change-status') }}', {
                _token: '{{ csrf_token() }}',
                id: el.value,
                status: status
            }, function(data) {
                if (data == 1) {
                    AIZ.plugins.notify('success', '{{ translate('Change blog status successfully') }}');
                } else {
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
    </script>
@endsection
