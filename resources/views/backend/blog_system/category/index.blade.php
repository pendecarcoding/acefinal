@extends('backend.layouts.app')
@section('content')
<div class="card">
    <div class="card-header d-block d-md-flex">
        <h5 class="mb-0 h6">{{ translate('Blog Categories') }}</h5>
        @can('add_blog_category')
            <div class="col-md-6 text-md-right">
                <a href="{{ url('admin/blog-category/create') }}" class="btn btn-primary">
                    <span>{{translate('Add New category')}}</span>
                </a>
            </div>
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered dataTable no-footer">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>{{translate('Name')}}</th>
                        <th width="10%" class="text-right">{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $key => $category)
                    <tr>
                        <td style="text-align:center">{{ ($key+1) + ($categories->currentPage() - 1)*$categories->perPage() }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td class="text-right">
                            @can('edit_blog_category')
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{url('admin/blog-category/'.$category->id.'/edit')}}" title="{{ translate('Edit') }}">
                                    <i class="las la-edit"></i>
                                </a>
                            @endcan
                            @can('delete_blog_category')
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('blog-category.destroy', $category->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="aiz-pagination">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection


@section('modal')
@include('modals.delete_modal')
@endsection

