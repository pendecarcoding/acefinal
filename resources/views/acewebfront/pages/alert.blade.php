@if ($errors->any())
    @foreach ($errors->all() as $eror)
        <div class="alert alert-danger alert-dismissible">
            
            <i class="icon fa fa-warning"></i>
            {{ $eror }}
        </div>
    @endforeach
@endif
@if (Session::has('success'))
    <div class="alert alert-info alert-dismissible">
      
        <i class="icon fa fa-check"></i>
        {{ Session::get('success') }}
    </div>
@endif
@if (Session::has('danger'))
    <div class="alert alert-danger alert-dismissible">
        
        <i class="icon fa fa-warning"></i>
        {{ Session::get('danger') }}

    </div>
@endif
