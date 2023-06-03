@extends('backend.layouts.app')
@section('content')
<br>

<div class="col-md-12">
    <div class="card">
            <div class="card-header row gutters-5">
                <div class="col text-center text-md-left">
                    <h5 class="mb-md-0 h6">{{ translate('Handbook Staff ') }}</h5>
                </div>
                <div class="col text-center text-md-right">
                    <a href="{{route('handbook.create')}}" class="btn btn-primary btn-sm" style="color:white">Add Handbook</a>
                </div>
            </div>
        <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Version</th>
                        <th>Name</th>
                        <th>File</th>
                        <th>Effective</th>
                        <th>Published</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $i =>$v)
                    <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$v->version}}</td>
                        <td>{{$v->name}}</td>
                        <td>{{$v->file}}</td>
                        <td>{{$v->effective}}</td>
                        <td> <label class="aiz-switch aiz-switch-success mb-0">
                                <input onchange="update_published(this)" value="{{ $v->id }}" type="checkbox" <?php if ($v->published == 1) echo "checked"; ?> >
                                <span class="slider round"></span>
                            </label></td>
                        <td>
                        @can('edit_handbook')
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                href="{{ route('handbook.edit', base64_encode($v->id)) }}" title="{{ translate('Edit') }}">
                                <i class="las la-pen"></i>
                            </a>
                        @endcan
                        @can('delete_handbook')
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                data-href="{{ route('handbook.destroy', base64_encode($v->id)) }}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>

</div>
@endsection
@section('modal')
    @include('modals.delete_modal')
@endsection
@section('script')
<script type="text/javascript">
    function makeSlug(val) {
        let str = val;
        let output = str.replace(/\s+/g, '-').toLowerCase();
        $('#slug').val(output);
    }

    function update_published(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('handbook.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Published Handbook updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }
</script>
@endsection
