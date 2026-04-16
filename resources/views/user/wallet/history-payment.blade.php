@extends('layouts.user.app')

@section('content')
    <style>
        /* Layout */
        .hw {
            max-width: 960px;
            margin: 0 auto;
            padding: 2rem 1.25rem;
            font-family: system-ui, -apple-system, sans-serif;
        }

        /* Header */
        .hw-title {
            font-size: 18px;
            font-weight: 600;
            color: #111;
            margin: 0 0 1.5rem;
        }

        /* Stat cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: .9rem 1.1rem;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 700;
            color: #111;
            letter-spacing: -1px;
            line-height: 1;
        }

        .stat-value.sm {
            font-size: 17px;
        }

        /* Filter bar */
        .filter-bar {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 1rem;
        }

        .filter-label {
            font-size: 11px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-right: 2px;
        }

        .filter-sep {
            width: 1px;
            height: 16px;
            background: #e5e7eb;
            margin: 0 6px;
        }

        .f-btn {
            font-size: 12px;
            font-weight: 500;
            padding: 5px 13px;
            border-radius: 999px;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #6b7280;
            cursor: pointer;
            transition: background .12s, color .12s, border-color .12s;
            line-height: 1;
        }

        .f-btn:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
            color: #374151;
        }

        .f-btn.active {
            background: #111;
            color: #fff;
            border-color: #111;
        }

        /* Table card */
        .table-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            overflow: hidden;
        }

        .table-card table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-card thead tr {
            background: #f9fafb;
            border-bottom: 1px solid #f0f0f0;
        }

        .table-card thead th {
            padding: 11px 16px;
            font-size: 10.5px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .6px;
            white-space: nowrap;
            text-align: left;
        }

        .table-card tbody tr {
            border-bottom: 1px solid #f5f5f5;
            transition: background .1s;
        }

        .table-card tbody tr:last-child {
            border-bottom: none;
        }

        .table-card tbody tr:hover {
            background: #fafafa;
        }

        .table-card tbody td {
            padding: 13px 16px;
            color: #111;
            vertical-align: middle;
        }

        /* Code cell */
        .code-cell {
            font-family: ui-monospace, monospace;
            font-size: 12px;
            color: #6b7280;
        }

        /* Type badges */
        .tbadge {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 999px;
            white-space: nowrap;
        }

        .tbadge-buy {
            background: #ede9fe;
            color: #5b21b6;
        }

        .tbadge-renew {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .tbadge-push {
            background: #fee2e2;
            color: #b91c1c;
        }

        .tbadge-other {
            background: #f3f4f6;
            color: #374151;
        }

        /* Amount */
        .amt {
            font-size: 13px;
            font-weight: 600;
            color: #9f1239;
        }

        /* Status badges */
        .sbadge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 999px;
        }

        .sbadge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .sbadge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .sbadge-success::before {
            background: #10b981;
        }

        .sbadge-pending {
            background: #fef9c3;
            color: #854d0e;
        }

        .sbadge-pending::before {
            background: #eab308;
        }

        .sbadge-failed {
            background: #fee2e2;
            color: #991b1b;
        }

        .sbadge-failed::before {
            background: #ef4444;
        }

        /* Date */
        .date-cell {
            font-size: 12px;
            color: #9ca3af;
            white-space: nowrap;
        }

        /* Empty state */
        .empty-state td {
            padding: 3.5rem 1rem;
            text-align: center;
            color: #d1d5db;
            font-size: 13px;
        }

        /* Pagination */
        .pagination-wrap {
            padding: 1rem 1.25rem;
            border-top: 1px solid #f0f0f0;
        }

        .pagination-wrap .pagination {
            margin: 0;
        }

        /* Result counter */
        .result-count {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: .75rem;
        }

        /* No-match row (injected by JS) */
        .js-empty td {
            padding: 3rem 1rem;
            text-align: center;
            color: #d1d5db;
            font-size: 13px;
        }
    </style>

    <div class="hw">
        <div class="hw-title">Lịch sử thanh toán</div>

        {{-- Stats --}}
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
                <div class="stat-value">
                    {{ $transactions->getCollection()->whereIn('status', ['pending', 'processing'])->count() }}
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Tổng chi</div>
                <div class="stat-value sm">
                    {{ number_format($transactions->getCollection()->where('status', 'success')->sum('amount'), 0, ',', '.') }}đ
                </div>
            </div>
        </div>

        {{-- Filter bar --}}
        <div class="filter-bar">
            <span class="filter-label">Loại</span>
            <button class="f-btn active" data-filter="type" data-val="">Tất cả</button>
            <button class="f-btn" data-filter="type" data-val="buy_membership">Mua gói</button>
            <button class="f-btn" data-filter="type" data-val="renew_membership">Gia hạn</button>
            <button class="f-btn" data-filter="type" data-val="push_post">Đẩy bài</button>

            <div class="filter-sep"></div>

            <span class="filter-label">Trạng thái</span>
            <button class="f-btn active" data-filter="status" data-val="">Tất cả</button>
            <button class="f-btn" data-filter="status" data-val="success">Thành công</button>
            <button class="f-btn" data-filter="status" data-val="pending">Chờ xử lý</button>
            <button class="f-btn" data-filter="status" data-val="failed">Thất bại</button>
        </div>

        <div class="result-count" id="result-count"></div>

        {{-- Table --}}
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
                <tbody id="tx-body">
                    @forelse($transactions as $item)
                        <tr data-type="{{ $item->type }}"
                            data-status="{{ in_array($item->status, ['pending', 'processing']) ? 'pending' : $item->status }}">

                            <td class="code-cell">#{{ $item->transaction_code }}</td>

                            <td>
                                @if($item->type === 'buy_membership')
                                    <span class="tbadge tbadge-buy">Mua gói dịch vụ</span>
                                @elseif($item->type === 'renew_membership')
                                    <span class="tbadge tbadge-renew">Gia hạn gói</span>
                                @elseif($item->type === 'push_post')
                                    <span class="tbadge tbadge-push">Đẩy bài đăng</span>
                                @else
                                    <span class="tbadge tbadge-other">{{ $item->type }}</span>
                                @endif
                            </td>

                            <td><span class="amt">-{{ number_format($item->amount, 0, ',', '.') }}đ</span></td>

                            <td>
                                @if($item->status === 'success')
                                    <span class="sbadge sbadge-success">Thành công</span>
                                @elseif(in_array($item->status, ['pending', 'processing']))
                                    <span class="sbadge sbadge-pending">Chờ xử lý</span>
                                @elseif($item->status === 'failed')
                                    <span class="sbadge sbadge-failed">Thất bại</span>
                                @else
                                    <span class="sbadge sbadge-pending">{{ $item->status }}</span>
                                @endif
                            </td>

                            <td class="date-cell">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr class="empty-state">
                            <td colspan="5">Bạn chưa có giao dịch nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($transactions->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $transactions->links() }}
                </div>
            @endif

        </div>
    </div>

    <script>
        (function () {
            const state = { type: '', status: '' };
            const tbody = document.getElementById('tx-body');
            const counter = document.getElementById('result-count');
            let jsEmptyRow = null;

            const allRows = () => [...tbody.querySelectorAll('tr[data-type]')];
            const total = allRows().length;

            function applyFilter() {
                let shown = 0;
                allRows().forEach(row => {
                    const ok = (!state.type || row.dataset.type === state.type)
                        && (!state.status || row.dataset.status === state.status);
                    row.style.display = ok ? '' : 'none';
                    if (ok) shown++;
                });

                if (!jsEmptyRow) {
                    jsEmptyRow = document.createElement('tr');
                    jsEmptyRow.className = 'js-empty';
                    jsEmptyRow.innerHTML = '<td colspan="5">Không có giao dịch phù hợp</td>';
                    tbody.appendChild(jsEmptyRow);
                }
                jsEmptyRow.style.display = shown === 0 ? '' : 'none';

                counter.textContent = shown < total
                    ? `Hiển thị ${shown} / ${total} giao dịch`
                    : `${total} giao dịch`;
            }

            document.querySelectorAll('.f-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const f = btn.dataset.filter;
                    state[f] = btn.dataset.val;
                    document.querySelectorAll(`.f-btn[data-filter="${f}"]`)
                        .forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    applyFilter();
                });
            });

            applyFilter();
        })();
    </script>
@endsection