<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Dashboard {{ config('app.name') }}</title>
</head>
<body>
    <h1>Xin Chào Việt Nam</h1>
    <p>Chào mừng đến với {{ config('app.name') }}</p>

    <p>{{ config('app.timezone') }}</p>
    <p>Ngày {{ $ngay }}</p>
    <p>Giờ {{ $gio }}</p>
</body>
</html>