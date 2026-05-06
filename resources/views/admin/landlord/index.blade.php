@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        {{-- Page Heading --}}
        <h1 class="h3 mb-2 text-gray-800">ThÃƒÆ’Ã‚Â´ng BÃƒÆ’Ã‚Â¡o XÃƒÆ’Ã‚Â¡c ThÃƒÂ¡Ã‚Â»Ã‚Â±c ChÃƒÂ¡Ã‚Â»Ã‚Â§ Cho ThuÃƒÆ’Ã‚Âª ChÃƒÂ¡Ã‚Â»Ã‚Â DuyÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¡t</h1>
        <p class="mb-4">Danh sÃƒÆ’Ã‚Â¡ch cÃƒÆ’Ã‚Â¡c thÃƒÆ’Ã‚Â´ng bÃƒÆ’Ã‚Â¡o chuyÃƒÂ¡Ã‚Â»Ã†â€™n khoÃƒÂ¡Ã‚ÂºÃ‚Â£n tÃƒÂ¡Ã‚Â»Ã‚Â« ngÃƒâ€ Ã‚Â°ÃƒÂ¡Ã‚Â»Ã‚Âi dÃƒÆ’Ã‚Â¹ng, phÃƒÆ’Ã‚Â¢n loÃƒÂ¡Ã‚ÂºÃ‚Â¡i theo trÃƒÂ¡Ã‚ÂºÃ‚Â¡ng thÃƒÆ’Ã‚Â¡i khÃƒÂ¡Ã‚Â»Ã¢â‚¬Âºp lÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¡nh.</p>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">ChÃƒâ€ Ã‚Â°a khÃƒÂ¡Ã‚Â»Ã¢â‚¬Âºp</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['unmatched'] ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-question-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Ãƒâ€žÃ‚ÂÃƒÆ’Ã‚Â£ khÃƒÂ¡Ã‚Â»Ã¢â‚¬Âºp</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['matched'] ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-link fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ãƒâ€žÃ‚ÂÃƒÆ’Ã‚Â£ duyÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¡t</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['approved'] ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">TÃƒÂ¡Ã‚Â»Ã‚Â« chÃƒÂ¡Ã‚Â»Ã¢â‚¬Ëœi</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['rejected'] ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Table Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap:8px">
                    <h6 class="m-0 font-weight-bold text-primary">Danh sÃƒÆ’Ã‚Â¡ch thÃƒÆ’Ã‚Â´ng bÃƒÆ’Ã‚Â¡o</h6>

                    {{-- Filter buttons --}}
                    <div class="d-flex flex-wrap" style="gap:6px">
                        <button class="btn btn-secondary btn-sm filter-btn active" data-status="all">TÃƒÂ¡Ã‚ÂºÃ‚Â¥t cÃƒÂ¡Ã‚ÂºÃ‚Â£</button>
                        <button class="btn btn-outline-secondary btn-sm filter-btn" data-status="unmatched">
                            <i class="fas fa-question-circle mr-1"></i>ChÃƒâ€ Ã‚Â°a khÃƒÂ¡Ã‚Â»Ã¢â‚¬Âºp
                        </button>
                        <button class="btn btn-outline-info btn-sm filter-btn" data-status="matched">
                            <i class="fas fa-link mr-1"></i>Ãƒâ€žÃ‚ÂÃƒÆ’Ã‚Â£ khÃƒÂ¡Ã‚Â»Ã¢â‚¬Âºp
                        </button>
                        <button class="btn btn-outline-success btn-sm filter-btn" data-status="approved">
                            <i class="fas fa-check mr-1"></i>Ãƒâ€žÃ‚ÂÃƒÆ’Ã‚Â£ duyÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¡t
                        </button>
                        <button class="btn btn-outline-danger btn-sm filter-btn" data-status="rejected">
                            <i class="fas fa-times mr-1"></i>TÃƒÂ¡Ã‚Â»Ã‚Â« chÃƒÂ¡Ã‚Â»Ã¢â‚¬Ëœi
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="notifyTable">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:5%">ID</th>
                                <th>NgÃƒâ€ Ã‚Â°ÃƒÂ¡Ã‚Â»Ã‚Âi dÃƒÆ’Ã‚Â¹ng</th>
                                <th>SÃƒÂ¡Ã‚Â»Ã¢â‚¬Ëœ tiÃƒÂ¡Ã‚Â»Ã‚Ân</th>
                                <th>NÃƒÂ¡Ã‚Â»Ã¢â€žÂ¢i dung CK</th>
                                <th>TrÃƒÂ¡Ã‚ÂºÃ‚Â¡ng thÃƒÆ’Ã‚Â¡i</th>
                                <th>ThÃƒÂ¡Ã‚Â»Ã‚Âi gian bÃƒÆ’Ã‚Â¡o</th>
                                <th style="width:10%" class="text-center">Thao tÃƒÆ’Ã‚Â¡c</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notifications as $item)
                                <tr data-status="{{ $item->match_status }}">
                                    <td><strong>#{{ $item->id }}</strong></td>

                                    <td>
                                        <div class="d-flex align-items-center" style="gap:8px">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white font-weight-bold"
                                                style="width:32px;height:32px;font-size:.75rem;flex-shrink:0;background:linear-gradient(135deg,#4e73df,#36b9cc)">
                                                {{ strtoupper(substr($item->walletTransaction?->user?->name ?? 'N', 0, 2)) }}
                                            </div>
                                            <span>{{ $item->walletTransaction?->user?->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>

                                    <td><strong>{{ number_format($item->amount) }} Ãƒâ€žÃ¢â‚¬Ëœ</strong></td>

                                    <td>
                                        <code style="font-size:.8rem;color:#4e73df">{{ $item->transfer_content }}</code>
                                    </td>

                                    <td>
                                        @if($item->match_status == 'unmatched')
                                            <span class="badge badge-secondary">ChÃƒâ€ Ã‚Â°a khÃƒÂ¡Ã‚Â»Ã¢â‚¬Âºp</span>
                                        @elseif($item->match_status == 'matched')
                                            <span class="badge badge-info">Ãƒâ€žÃ‚ÂÃƒÆ’Ã‚Â£ khÃƒÂ¡Ã‚Â»Ã¢â‚¬Âºp</span>
                                        @elseif($item->match_status == 'approved')
                                            <span class="badge badge-success">Ãƒâ€žÃ‚ÂÃƒÆ’Ã‚Â£ duyÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¡t</span>
                                        @elseif($item->match_status == 'rejected')
                                            <span class="badge badge-danger">TÃƒÂ¡Ã‚Â»Ã‚Â« chÃƒÂ¡Ã‚Â»Ã¢â‚¬Ëœi</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $item->match_status }}</span>
                                        @endif
                                    </td>

                                    <td class="text-muted" style="font-size:.82rem;white-space:nowrap">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ optional($item->notified_at)->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.wallet_notifications.show', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary fw-bold">
                                            <i class="fa fa-eye"></i> Xem
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x d-block mb-2 text-gray-300"></i>
                                        ChÃƒâ€ Ã‚Â°a cÃƒÆ’Ã‚Â³ thÃƒÆ’Ã‚Â´ng bÃƒÆ’Ã‚Â¡o nÃƒÆ’Ã‚Â o.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($notifications->hasPages())
                <div class="card-footer d-flex align-items-center justify-content-between flex-wrap" style="gap:10px">
                    <small class="text-muted">
                        HiÃƒÂ¡Ã‚Â»Ã†â€™n thÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¹ {{ $notifications->firstItem() }}ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Å“{{ $notifications->lastItem() }} /
                        {{ $notifications->total() }} kÃƒÂ¡Ã‚ÂºÃ‚Â¿t quÃƒÂ¡Ã‚ÂºÃ‚Â£
                    </small>
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>

    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#notifyTable').DataTable({
                    pageLength: 10,
                    order: [[0, 'desc']],
                    columnDefs: [{ orderable: false, targets: 6 }],
                    language: {
                        search: "TÃƒÆ’Ã‚Â¬m kiÃƒÂ¡Ã‚ÂºÃ‚Â¿m:",
                        lengthMenu: "HiÃƒÂ¡Ã‚Â»Ã†â€™n thÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¹ _MENU_ dÃƒÆ’Ã‚Â²ng",
                        info: "Trang _PAGE_ / _PAGES_",
                        paginate: {
                            previous: "TrÃƒâ€ Ã‚Â°ÃƒÂ¡Ã‚Â»Ã¢â‚¬Âºc",
                            next: "Sau"
                        }
                    }
                });
            });

            // Filter buttons (ÃƒÂ¡Ã‚ÂºÃ‚Â©n/hiÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¡n row theo status, tÃƒâ€ Ã‚Â°Ãƒâ€ Ã‚Â¡ng thÃƒÆ’Ã‚Â­ch DataTables)
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    // Reset all buttons
                    document.querySelectorAll('.filter-btn').forEach(b => {
                        b.classList.remove('active');
                        b.className = b.className
                            .replace('btn-info', 'btn-outline-info')
                            .replace('btn-success', 'btn-outline-success')
                            .replace('btn-danger', 'btn-outline-danger')
                            .replace('btn-secondary', 'btn-outline-secondary');
                    });

                    // Activate clicked button
                    this.classList.add('active');
                    this.className = this.className.replace('btn-outline-', 'btn-');

                    const status = this.dataset.status;

                    // Filter visible rows
                    document.querySelectorAll('#notifyTable tbody tr[data-status]').forEach(row => {
                        row.style.display = (status === 'all' || row.dataset.status === status) ? '' : 'none';
                    });
                });
            });
        </script>
    @endpush
@endsection
