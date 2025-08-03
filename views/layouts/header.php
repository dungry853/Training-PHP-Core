<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Trang quản trị' ?></title>
    <!-- Dùng mà không có integrity -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/assets/css/login-register.css">

</head>
<?php

use App\Models\RoleType; ?>

<body>
    <header class="header">
        <a href="<?php


                    echo isset($_SESSION['user']) ? '/admin/dashboard' : '/'; ?>" class="logo-link">
            <img class="logo" src="https://t4.ftcdn.net/jpg/04/77/84/59/360_F_477845928_d7f2VuoDerVNAVfZTeKfAmWBOzkJvKIj.jpg" alt="">
        </a>
        <div class="nav-links">

            <?php if (isset($_SESSION['user'])): ?>
                <?php if ($_SESSION['user']['role_id'] != RoleType::USER->value): ?>
                    <a href="/admin/author">Tác Giả</a>
                    <a href="/admin/category">Thể Loại</a>
                    <a href="/admin/book">Sách</a>
                    <a href="/admin/user">Người Dùng</a>
                <?php endif; ?>
                <span>
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Xin chào <?php echo $_SESSION['user']['full_name']; ?>
                    </a>
                    <ul class="dropdown-menu">

                        <li><a class="dropdown-item" href="/logout">Đăng xuất</a></li>
                    </ul>
                </span>
            <?php else: ?>
                <a href="/login">Đăng nhập</a>
            <?php endif; ?>


        </div>

    </header>