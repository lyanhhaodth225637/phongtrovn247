@extends('layouts.frontend.app')
@section('content')

    {{-- ── Inline style chỉ cho trang mới nhất ── --}}
    <style>
        /* Lưới 5 cột – responsive */
        .new-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        @media (min-width: 576px) {
            .new-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 992px) {
            .new-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (min-width: 1200px) {
            .new-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }
    </style>

    {{-- ══ TAB: MỚI NHẤT ══ --}}
    <div class="tab-pane-custom active" id="tab-moiNhat">

        <div class="new-grid">

            @php
                $posts = [
                    ['img' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=400&q=80', 'vip' => 5, 'time' => '1 phút trước', 'title' => 'Căn hộ mini 2PN mặt tiền đường Nguyễn Thị Minh Khai – ban công rộng, view thành phố', 'price' => '8.5 triệu/tháng', 'area' => '50m²', 'loc' => 'Q.3, TP.HCM', 'call' => true],
                    ['img' => 'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=400&q=80', 'vip' => 4, 'time' => '8 phút trước', 'title' => 'Phòng trọ mới xây có nội thất cơ bản khu Tân Phú – điện nước giá dân', 'price' => '2.3 triệu/tháng', 'area' => '20m²', 'loc' => 'Tân Phú', 'call' => true],
                    ['img' => 'https://images.unsplash.com/photo-1550439062-609e1531270e?w=300&q=80', 'vip' => 3, 'time' => '15 phút trước', 'title' => 'Phòng trọ sạch sẽ khu vực Bình Chánh – có wifi, chỗ để xe, gần KCN', 'price' => '1.3 triệu/tháng', 'area' => '14m²', 'loc' => 'Bình Chánh', 'call' => false],
                    ['img' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=400&q=80', 'vip' => 5, 'time' => '22 phút trước', 'title' => 'Căn hộ cao cấp full nội thất đường Nguyễn Huệ Q.1 – thoáng mát, an ninh 24/7', 'price' => '6.5 triệu/tháng', 'area' => '35m²', 'loc' => 'Q.1, TP.HCM', 'call' => true],
                    ['img' => 'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=300&q=80', 'vip' => 2, 'time' => '31 phút trước', 'title' => 'Ký túc xá nữ quận 12 – an ninh tốt, wifi mạnh, cách ĐH Công Nghiệp 500m', 'price' => '700.000đ/tháng', 'area' => '7m²', 'loc' => 'Q.12, TP.HCM', 'call' => false],
                    ['img' => 'https://images.unsplash.com/photo-1503174971373-b1f69850bded?w=300&q=80', 'vip' => 1, 'time' => '45 phút trước', 'title' => 'Phòng trọ giá rẻ khu vực Thủ Đức – tự do giờ giấc, WC riêng biệt', 'price' => '1.5 triệu/tháng', 'area' => '15m²', 'loc' => 'Thủ Đức', 'call' => false],
                    ['img' => 'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?w=400&q=80', 'vip' => 4, 'time' => '58 phút trước', 'title' => 'Nhà nguyên căn 2PN hẻm thoáng đường Phan Văn Trị Bình Thạnh – yên tĩnh', 'price' => '5.0 triệu/tháng', 'area' => '45m²', 'loc' => 'Bình Thạnh', 'call' => true],
                    ['img' => 'https://images.unsplash.com/photo-1518780664697-55e3ad937233?w=300&q=80', 'vip' => 3, 'time' => '1 giờ trước', 'title' => 'Phòng trọ mới xây khu Tân Bình – ban công, máy lạnh, điện nước dân', 'price' => '2.2 triệu/tháng', 'area' => '18m²', 'loc' => 'Tân Bình', 'call' => false],
                    ['img' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=400&q=80', 'vip' => 5, 'time' => '1 giờ trước', 'title' => 'Phòng trọ cao cấp có ban công đường Lê Lợi – gần chợ Bến Thành', 'price' => '4.2 triệu/tháng', 'area' => '28m²', 'loc' => 'Q.1, TP.HCM', 'call' => true],
                    ['img' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=400&q=80', 'vip' => 4, 'time' => '2 giờ trước', 'title' => 'Studio thông minh có gác lửng đường Điện Biên Phủ – tiện nghi hiện đại', 'price' => '3.8 triệu/tháng', 'area' => '22m²', 'loc' => 'Bình Thạnh', 'call' => true],
                ];

                $vipLabels = [
                    5 => '<i class="bi bi-star-fill"></i> VIP 5',
                    4 => '<i class="bi bi-star-half"></i> VIP 4',
                    3 => 'VIP 3',
                    2 => 'VIP 2',
                    1 => 'VIP 1',
                ];
              @endphp

            @foreach($posts as $p)
                <div class="card-vertical">
                    <div class="card-vertical-img">
                        <img src="{{ $p['img'] }}" alt="{{ $p['title'] }}" loading="lazy">
                        <span class="vip-badge vip-{{ $p['vip'] }} card-vertical-vip">{!! $vipLabels[$p['vip']] !!}</span>
                    </div>
                    <div class="card-vertical-body">
                        <span class="time-ago"><i class="bi bi-clock"></i> {{ $p['time'] }}</span>
                        <a href="#" class="title-link mt-1">{{ $p['title'] }}</a>
                        <div class="price mt-1">{{ $p['price'] }}</div>
                        <div class="meta-row mt-1">
                            <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $p['area'] }}</span>
                            <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ $p['loc'] }}</span>
                        </div>
                        @if($p['call'])
                            <button class="phone-btn w-100 mt-2" style="justify-content:center;font-size:0.72rem">
                                <i class="bi bi-telephone-fill"></i> Gọi ngay
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection