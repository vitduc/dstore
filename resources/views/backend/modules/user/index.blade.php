@extends('backend.layouts.master')
@section('Content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Danh sách thành viên</h1>
            </div>
            <div class="col-sm-6">
                <form action="" class="form-inline">
                    <div class="form-group">
                        <input type="text" class="form-control" name="key" placeholder="Tìm kiếm theo tên...">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        @if (session('message'))
        <div class="alert alert-{{session('type_alert')}} alert-dismissible fade show" role="alert">
            {{session('message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <hr>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách thành viên</h3>
                        <a href="{{Route('user.create')}}" class="btn btn-success float-right">+ Thêm</a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Quyền</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="load">
                            @php
                            $stt = ($data->currentPage() - 1) * $data->perPage() ;
                            @endphp
                            @foreach ($data as $item)
                            @php
                            $stt = $stt + 1 ;
                            @endphp
                            <tr>
                                <td>{{$stt}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>
                                    @if($item->admin == 1)
                                        Admin
                                        @else
                                        User
                                    @endif
                                </td>
                                <td>
                                    <a href="{{Route('user.edit', $item->id)}}" class="btn btn-success">Sửa</a>
                                    <a href="{{Route('user.destroy', $item->id)}}" class="btn btn-danger btn-delete">Xóa</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form action="" method="POST" id="form-delete">
                        @csrf
                        @method("DELETE")
                    </form>
                    <div class="card-footer clearfix">
                        {!! $data->appends(Request::all())->links() !!}
                    </div>
                </div>
            </div>
        </div>
</section>

@endsection()

@push('my_js')
<script>
    $('.btn-delete').click(function(ev){
        ev.preventDefault();
        var _herf = $(this).attr('href');
        // submit form delete với link(href)
        $('form#form-delete').attr('action', _herf);
        if(confirm('Bạn chắc chắn muốn xóa thành viên này?')){
            $('form#form-delete').submit();
        }
    })
</script>
@endpush