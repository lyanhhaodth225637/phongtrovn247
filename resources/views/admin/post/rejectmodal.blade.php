<style>
    /* ── Reject Modal ── */
    #rejectModal .modal-content {
        border: none;
        border-radius: 14px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .18);
        overflow: hidden;
        font-family: 'Be Vietnam Pro', sans-serif;
    }

    #rejectModal .modal-header {
        background: #fff5f5;
        border-bottom: 1px solid #fecdd3;
        padding: 18px 24px;
    }

    #rejectModal .modal-title {
        font-size: .98rem;
        font-weight: 700;
        color: #e02424;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    #rejectModal .modal-title::before {
        content: '✖';
        font-size: .85rem;
        background: #e02424;
        color: #fff;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    #rejectModal .btn-close {
        opacity: .4;
        transition: opacity .15s;
    }

    #rejectModal .btn-close:hover {
        opacity: .9;
    }

    #rejectModal .modal-body {
        padding: 22px 24px;
        background: #ffffff;
    }

    #rejectModal .form-label {
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 6px;
        display: block;
    }

    #rejectModal .form-select,
    #rejectModal .form-control {
        font-size: .9rem;
        color: #1e293b;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 9px 14px;
        background: #f8fafc;
        box-shadow: none;
        transition: border-color .15s, box-shadow .15s;
    }

    #rejectModal .form-select:focus,
    #rejectModal .form-control:focus {
        border-color: #e02424;
        box-shadow: 0 0 0 3px rgba(224, 36, 36, .12);
        outline: none;
        background: #fff;
    }

    #rejectModal textarea.form-control {
        resize: vertical;
        min-height: 90px;
    }

    #rejectModal .modal-footer {
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        padding: 14px 24px;
        gap: 8px;
    }

    #rejectModal .btn-secondary {
        font-size: .85rem;
        font-weight: 600;
        background: #fff;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 8px 18px;
        transition: background .15s, color .15s;
    }

    #rejectModal .btn-secondary:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    #rejectModal .btn-danger {
        font-size: .85rem;
        font-weight: 700;
        background: #e02424;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 20px;
        transition: filter .15s, transform .1s, box-shadow .15s;
    }

    #rejectModal .btn-danger:hover {
        filter: brightness(1.08);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(224, 36, 36, .3);
    }

    #rejectModal .btn-danger:active {
        transform: translateY(0);
    }
</style>
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.post.reject',['id'=>$post->id,'slug'=>$post->slug]) }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Lý do từ chối</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Select lý do -->
                    <div class="mb-3">
                        <label class="form-label">Chọn lý do</label>
                        <select name="reason_type" class="form-select" required>
                            <option value="">-- Chọn lý do --</option>
                            <option value="spam">Spam</option>
                            <option value="scam">Lừa đảo</option>
                            <option value="false_info">Sai sự thật</option>
                            <option value="duplicate">Trùng bài</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>

                    <!-- Mô tả thêm -->
                    <div class="mb-3">
                        <label class="form-label">Lý do khác</label>
                        <textarea name="reason_detail" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-danger">Xác nhận từ chối</button>
                </div>
            </form>
        </div>
    </div>
</div>