@extends('backend.layouts.app')

@section('content')
    <div class="card">
        <form class="" id="sort_slider" action="" method="GET">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('All Request Become Patner ') }}</h5>
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
                        <th data-breakpoints="lg">{{ translate('Email') }}</th>
                        <th data-breakpoints="lg">{{ translate('Contact Number') }}</th>
                        <th data-breakpoints="lg">{{ translate('Subject') }}</th>
                        <th data-breakpoints="lg">{{ translate('Date Time') }}</th>
                        <th class="text-center">{{ translate('Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $v)
                        <tr>
                            <td style="text-align:center">{{ $i + 1 }}</td>
                            <td>{{ $v->name }}</td>
                            <td>{{ $v->email }}</td>
                            <td>{{ $v->contact }}</td>
                            <td>{{ $v->subject }}</td>
                            <td>{{ $v->created_at }}</td>
                            <td>
                                <center>
                                    <a href="{{ url('/admin/requestpatner/viewmessage/' . base64_encode($v->id)) }}"
                                        class="btn btn-soft-danger btn-icon btn-circle btn-sm" href=""
                                        title="Reply use Email">
                                        <i class="las la-paper-plane"></i>
                                    </a>
                                    <a target="_blank" href="https://wa.me/{{ $v->contact }}?text='HI'"
                                        class="btn btn-success btn-icon btn-circle btn-sm" href=""
                                        title="Reply use whatsapp">
                                        <i class="lab la-whatsapp"></i>
                                    </a>
                                </center>

                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </div>
            </table>
            <div class="aiz-pagination">

            </div>
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
