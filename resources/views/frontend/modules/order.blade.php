@extends('frontend.layouts.master')
@section('Content')



<div class="container" style="min-height:500px">

    @if(Auth::check())
    <div class="login"><a href="#"><h4>Xin chào: {{Auth::user()->name}}</h4></a></div>
    @if($order)
    <span style="color: #FF8C00">(NẾU ĐÃ MUA HÀNG THÔNG TIN SẼ HIỆN Ở ĐÂY)</span> <br>
    <br>
    @foreach ($order as $item)
                @php
                $data = DB::table('orders as o')
                ->join('order_detail as d', 'o.id', '=', 'd.id_order')
                ->join('products as p', 'd.id_sp', '=', 'p.id')
                ->select([
                    'o.id as order_id',
                    'o.phone as customer_phone',
                    'o.created_at as order_created_at',
                    'o.address as order_address',
                    'd.qty as product_qty',
                    'p.price_sale as product_price',
                    'p.name_product as product_name',
                    'p.preview as product_preview'
                ])
                ->where('o.id', $item->id)
                ->get();
                @endphp
    <strong>
    -- SĐT: {{$item->phone}} <br>
    -- Địa chỉ: {{$item->address}} <br>
    -- Ngày đặt: {{$item->created_at}} <br>
    -- Trạng thái đơn hàng:
    @if($item->status == 1)
    <span class="price">ĐƠN HÀNG CHƯA XÁC NHẬN</span>
    @else
    <span class="price">ĐƠN HÀNG ĐÃ XÁC NHẬN</span>
    @endif</strong>
    <br>
    <br>
    CHI TIẾT ĐƠN HÀNG:
    <table class="table table-striped">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Mô tả</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @php
            $stt=1;
            @endphp
            @foreach ($data as $item)
            <tr>
                <td>{{$stt++}}</td>
                <td>{{$item->product_name}}</td>
                <td>{{$item->product_qty}}</td>
                <td>{{number_format($item->product_price)}} .đ</td>
                <td>{!!$item->product_preview!!}</td>
                <td>{{number_format($item->product_qty * $item->product_price)}}.đ</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br><br>
    @endforeach
    @else
    Bạn chưa mua sản phẩm nào
    @endif
    @else
    <div class="login">Bạn cần <a href="{{Route('login')}}"><span>ĐĂNG NHẬP</span> </a> để xem đơn hàng của mình</div>
    @endif
    @endsection
