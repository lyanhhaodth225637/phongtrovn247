@extends('layouts.user.app')

@section('content')
    <style>
        .history-wrap {
            /* max-width: 860px; */
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .history-title {
            font-size: 20px;
            font-weight: 600;
            color: #111;
            margin-bottom: 1.5rem;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem 1.25rem;
        }

        .stat-label {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: #111;
            letter-spacing: -0.5px;
        }

        .table-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            overflow: hidden;
        }

        .table-card table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .table-card thead tr {
            border-bottom: 1px solid #e9ecef;
            background: #f8f9fa;
        }

        .table-card thead th {
            padding: 11px 14px;
            font-size: 11px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: .5px;
            white-space: nowrap;
        }

        .table-card tbody tr {
            border-bottom: 1px solid #f1f3f5;
            transition: background .1s;
        }

        .table-card tbody tr:last-child {
            border-bottom: none;
        }

        .table-card tbody tr:hover {
            background: #fafafa;
        }

        .table-card tbody td {
            padding: 12px 14px;
            color: #111;
            vertical-align: middle;
        }

        .code-cell {
            font-family: monospace;
            font-size: 12px;
            color: #495057;
        }

        .type-badge {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 999px;
        }

        .type-deposit {
            background: #dbeafe;
            color: #1e40af;
        }

        .type-withdraw {
            background: #fce7f3;
            color: #9d174d;
        }

        .type-other {
            background: #f1f3f5;
            color: #495057;
        }

        .amount-pos {
            color: #065f46;
            font-weight: 600;
        }

        .amount-neg {
            color: #9f1239;
            font-weight: 600;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 999px;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .status-success {
            background: #d1fae5;
            color: #065f46;
        }

        .status-success::before {
            background: #10b981;
        }

        .status-pending {
            background: #fef9c3;
            color: #854d0e;
        }

        .status-pending::before {
            background: #eab308;
        }

        .status-failed {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-failed::before {
            background: #ef4444;
        }

        .date-cell {
            font-size: 12.5px;
            color: #6c757d;
            white-space: nowrap;
        }

        .empty-row td {
            padding: 3rem 1rem;
            text-align: center;
            color: #adb5bd;
            font-size: 14px;
        }

        .pagination-wrap {
            padding: 1rem 1.25rem;
            border-top: 1px solid #f1f3f5;
        }

        .pagination-wrap .pagination {
            margin: 0;
        }
    </style>

    <div class="history-wrap">
        <div class="history-title">Lịch sử giao dịch</div>

        {{-- Tóm tắt --}}
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-label">Tổng giao dịch</div>
                <div class="stat-value">{{ $transactions->total() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Thành công</div>
                <div class="stat-value">{{ $transactions->getCollection()->where('status', 'success')->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Chờ xử lý</div>
                <div class="stat-value">{{ $transactions->getCollection()->where('status', 'pending')->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Tổng nạp</div>
                <div class="stat-value" style="font-size:16px">
                    {{ number_format($transactions->getCollection()->where('type', 'deposit')->where('status', 'success')->sum('amount'), 0, ',', '.') }}đ
                </div>
            </div>
        </div>

        {{-- Bảng --}}
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Mã GD</th>
                        <th>Loại</th>
                        <th>Số tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $item)
                        <tr>
                            <td class="code-cell">#{{ $item->transaction_code }}</td>

                            <td>
                                @if($item->type === 'deposit')
                                    <span class="type-badge type-deposit">Nạp tiền</span>
                                @elseif($item->type === 'promotion')
                                    @if(str_contains(strtolower($item->description ?? ''), 'giới thiệu'))
                                        <span class="type-badge type-withdraw">Thưởng giới thiệu</span>
                                    @else
                                        <span class="type-badge type-withdraw">Khuyến mãi</span>
                                    @endif
                                @else
                                    <span class="type-badge type-other">
                                        {{ $item->type }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if(in_array($item->type, ['deposit', 'promotion']))
                                    <span class="amount-pos">
                                        +{{ number_format($item->amount, 0, ',', '.') }}đ
                                    </span>
                                @else
                                    <span class="amount-neg">
                                        -{{ number_format($item->amount, 0, ',', '.') }}đ
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($item->status === 'success')
                                    <span class="status-badge status-success">Thành công</span>
                                @elseif(in_array($item->status, ['pending', 'processing']))
                                    <span class="status-badge status-pending">Chờ xử lý</span>
                                @elseif($item->status === 'failed')
                                    <span class="status-badge status-failed">Thất bại</span>
                                @else
                                    <span class="status-badge status-pending">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>

                            <td class="date-cell">
                                {{ $item->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="5">Chưa có giao dịch nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($transactions->hasPages())
                <div class="pagination-wrap">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection