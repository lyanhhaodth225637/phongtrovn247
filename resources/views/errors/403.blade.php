<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>403 - Forbidden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #dc3545 0%, #ff6b35 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .error-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 60px 40px;
            max-width: 600px;
            text-align: center;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-code {
            font-size: 120px;
            font-weight: 900;
            background: linear-gradient(135deg, #dc3545 0%, #ff6b35 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            line-height: 1;
        }

        .error-title {
            font-size: 28px;
            font-weight: 700;
            color: #2d3748;
            margin: 20px 0;
        }

        .error-message {
            font-size: 16px;
            color: #718096;
            margin: 15px 0 30px;
            line-height: 1.6;
        }

        .error-image {
            max-width: 100%;
            height: auto;
            margin: 30px 0;
            border-radius: 10px;
            max-height: 300px;
        }

        .btn-home {
            display: inline-block;
            padding: 12px 40px;
            background: linear-gradient(135deg, #dc3545 0%, #ff6b35 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-home:active {
            transform: translateY(0);
        }

        .image-placeholder {
            width: 100%;
            height: 250px;
            background: #f0f4ff;
            border: 2px dashed #cbd5e0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #a0aec0;
            font-size: 14px;
            margin: 30px 0;
        }

        @media (max-width: 600px) {
            .error-container {
                padding: 40px 25px;
            }

            .error-code {
                font-size: 80px;
            }

            .error-title {
                font-size: 22px;
            }

            .error-message {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="error-container">
        <h1 class="error-code">403</h1>
        <h2 class="error-title">Truy cập bị từ chối</h2>
        <p class="error-message">Bạn không có quyền truy cập vào trang này. Vui lòng đăng nhập bằng tài khoản hợp lệ
            hoặc liên hệ với quản trị viên.</p>

        <!-- Hình ảnh 403 Error từ Google -->
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZOB_h2LYcZElwic1uVIIZ4DUDrDAb7OhNwg&s"
            alt="403 Forbidden" class="error-image">

        <a href="{{ url('/') }}" class="btn-home">
            ← Về trang chủ
        </a>
    </div>

</body>

</html>