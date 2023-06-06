@extends('backend.layouts.app')

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <!-- <div class="col-md-6">
                                   <h1 class="h3">{{ translate('All Staffs') }}</h1>
                                  </div> -->

        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Data Staff') }}</h5>
            @can('add_staff')
                <!-- <div class="col-md-6 text-md-right">
                    <a href="{{ route('staffs.create') }}" class="btn btn-primary">
                        <span>{{ translate('Add New Staffs') }}</span>
                    </a>
                </div> -->
            @endcan
        </div>
        <div class="card-body">
            <table id="example" class="table table-striped table-bordered dataTable no-footer">
                <thead>
                    <tr>
                        <th data-breakpoints="lg" width="5%">#</th>
                        <th>{{ translate('Name') }}</th>
                        <th>{{ translate('Staff ID') }}</th>
                        <th data-breakpoints="lg">{{ translate('Position') }}</th>
                        <th data-breakpoints="lg">{{ translate('Status') }}</th>
                        <!-- <th width="10%">{{ translate('Options') }}</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $i => $v)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $v->name }}</td>
                            <td>{{ $v->stuff_id }}</td>
                            <td>{{ $v->position }}</td>
                            <td>
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input onchange="update_published(this)" value="{{ $v->id }}" type="checkbox"
                                        <?php if ($v->status == 'A') {
                                            echo 'checked';
                                        } ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>


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

<script>
     function update_published(el){
            if(el.checked){
                var status = 'A';
            }
            else{
                var status = 'B';
            }
            $.post('{{ route('changestatus.staff') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 'success'){
                    AIZ.plugins.notify('success', '{{ translate('Published products updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
</script>
