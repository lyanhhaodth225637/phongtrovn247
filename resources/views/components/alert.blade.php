@if(session('success'))
    <div class="alert-notification alert-success" role="alert">
        <div class="alert-content">
            <i class="fa-solid fa-circle-check alert-icon"></i>
            <span class="alert-message">{{ session('success') }}</span>
        </div>
        <button type="button" class="alert-close" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert-notification alert-danger" role="alert">
        <div class="alert-content">
            <i class="fa-solid fa-triangle-exclamation alert-icon"></i>
            <span class="alert-message">{{ session('error') }}</span>
        </div>
        <button type="button" class="alert-close" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

<style>
    /* Alert Notification Styles */
    .alert-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 20px;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        font-size: 14px;
        font-weight: 500;
        min-width: 300px;
        max-width: 450px;
        z-index: 9999;
        animation: slideInRight 0.3s ease-out;
        backdrop-filter: blur(10px);
    }

    .alert-notification.alert-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-left: 4px solid #ffffff;
    }

    .alert-notification.alert-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border-left: 4px solid #ffffff;
    }

    .alert-content {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }

    .alert-icon {
        font-size: 18px;
        flex-shrink: 0;
        animation: bounceIn 0.5s ease-out;
    }

    .alert-message {
        line-height: 1.5;
        word-break: break-word;
    }

    .alert-close {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s ease;
        flex-shrink: 0;
    }

    .alert-close:hover {
        transform: rotate(90deg);
    }

    /* Animations */
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }

        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }

    @keyframes bounceIn {
        0% {
            transform: scale(0.3);
            opacity: 0;
        }

        50% {
            opacity: 1;
        }

        70% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

  
    .alert-notification.removing {
        animation: slideOutRight 0.3s ease-out forwards;
    }

   
    @media (max-width: 576px) {
        .alert-notification {
            min-width: auto;
            max-width: calc(100% - 20px);
            right: 10px;
            left: 10px;
            top: 10px;
        }

        .alert-message {
            font-size: 13px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alerts = document.querySelectorAll('.alert-notification');

        alerts.forEach(function (alert) {
           
            const timeout = setTimeout(function () {
                closeAlert(alert);
            }, 5000);

            
            const closeBtn = alert.querySelector('.alert-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    clearTimeout(timeout);
                    closeAlert(alert);
                });
            }
        });

        function closeAlert(alert) {
            alert.classList.add('removing');
            setTimeout(function () {
                alert.remove();
            }, 300);
        }
    });
</script>