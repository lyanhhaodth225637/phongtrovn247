@extends('layouts.frontend.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-3">{{ $membership->name }}</h2>

        @if($membership->description)
            <p class="text-muted mb-4">{{ $membership->description }}</p>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="thead-light">
                    <tr>
                        <th>Thời hạn</th>
                        <th>Giá</th>
                        <th>Mô tả</th>
                        <th width="160">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($membership->membershipPackages as $package)
                        <tr>
                            <td>
                                {{ $package->duration_days }} ngày
                            </td>

                            <td class="text-danger font-weight-bold">
                                {{ number_format($package->price, 0, ',', '.') }}đ
                            </td>

                            <td>
                                {{ $package->description ?? 'Không có mô tả' }}
                            </td>

                            <td class="text-center">
                                @auth
                                    <a href="{{ route('user.membership.confirm', $package->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-crown mr-1"></i>
                                        Đăng ký
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                        Đăng nhập để đăng ký
                                    </a>
                                @endauth
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Chưa có gói dịch vụ nào
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection