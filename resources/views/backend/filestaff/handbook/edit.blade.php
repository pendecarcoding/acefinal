@extends('backend.layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Update Handbook')}}</h5>
                <a style="float:right" href="{{ route('handbook.staff') }}" class="btn btn-danger">X</a>
            </div>
            <div class="card-body">
                <form id="add_form" class="form-horizontal" action="{{ route('handbook.update') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="hidden" value="{{$data->id}}" name="id">
                    <input type="hidden" value="{{$data->file}}" name="fileold">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            {{translate('Name')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <input type="text" placeholder="{{translate('Name')}}" value="{{$data->name}}"  id="name" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">
                            {{translate('Version')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">
                            <input type="text" placeholder="{{translate('Version')}}" value="{{$data->version}}" id="version" name="version" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">
                            {{translate('Effective')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">

                            <input type="date" value="{{$data->effective}}" name="date" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">
                            {{translate('File')}}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="col-md-9">

                            <input type="file" name="file" class="form-control">
                        </div>
                    </div>




                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">
                            {{translate('Save')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function makeSlug(val) {
        let str = val;
        let output = str.replace(/\s+/g, '-').toLowerCase();
        $('#slug').val(output);
    }
</script>
@endsection
