@extends('backend.layouts.master')
@section('Content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="font-weight:bold">Thêm mới loại sản phẩm</h3>
                    </div>
                    <form action="{{Route('user.store')}}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input type="text" class="form-control" placeholder="Tên hiển thị" name="name" required="">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" placeholder="Email" name="email">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="Mật khẩu" name="pass">
                            </div>
                            <div class="offset-sm-2 col-sm-2">
                                <select name="role" id="" class="form-control">
                                    <option value="1">Quyền quản trị</option>
                                    <option value="0">Thành viên</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section>

@endsection
