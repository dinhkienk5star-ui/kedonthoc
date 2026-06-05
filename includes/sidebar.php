<!-- Sidebar -->
<aside class="sidebar bg-dark text-white">
    <div class="sidebar-header p-3 border-bottom">
        <h5 class="mb-0">
            <i class="fas fa-hospital"></i> Kê Đơn Thuốc
        </h5>
        <small class="text-muted">v1.0.0</small>
    </div>

    <nav class="nav flex-column p-2">
        <!-- Dashboard -->
        <a href="<?php echo APP_URL; ?>/index.php" class="nav-link">
            <i class="fas fa-home"></i> Dashboard
        </a>

        <!-- For Admin Only -->
        <?php if (has_role('admin')) { ?>
        <hr class="my-2">
        <span class="nav-link disabled text-muted">
            <i class="fas fa-cogs"></i> Quản Lý
        </span>

        <!-- User Management -->
        <a href="<?php echo APP_URL; ?>/modules/auth/users.php" class="nav-link ps-4">
            <i class="fas fa-users"></i> Quản Lý Người Dùng
        </a>

        <!-- Doctor Management -->
        <a href="<?php echo APP_URL; ?>/modules/doctors/list.php" class="nav-link ps-4">
            <i class="fas fa-user-md"></i> Quản Lý Bác Sĩ
        </a>

        <!-- Patient Management -->
        <a href="<?php echo APP_URL; ?>/modules/patients/list.php" class="nav-link ps-4">
            <i class="fas fa-users"></i> Quản Lý Bệnh Nhân
        </a>

        <!-- Medicine Management -->
        <a href="<?php echo APP_URL; ?>/modules/medicines/list.php" class="nav-link ps-4">
            <i class="fas fa-pills"></i> Quản Lý Thuốc
        </a>
        <?php } ?>

        <!-- Prescriptions -->
        <hr class="my-2">
        <span class="nav-link disabled text-muted">
            <i class="fas fa-prescription-bottle"></i> Đơn Thuốc
        </span>

        <a href="<?php echo APP_URL; ?>/modules/prescriptions/create.php" class="nav-link ps-4">
            <i class="fas fa-plus-circle"></i> Kê Đơn Mới
        </a>

        <a href="<?php echo APP_URL; ?>/modules/prescriptions/list.php" class="nav-link ps-4">
            <i class="fas fa-list"></i> Danh Sách Đơn
        </a>

        <!-- Import/Export -->
        <?php if (has_role('admin')) { ?>
        <hr class="my-2">
        <span class="nav-link disabled text-muted">
            <i class="fas fa-exchange-alt"></i> Dữ Liệu
        </span>

        <a href="<?php echo APP_URL; ?>/modules/medicines/import.php" class="nav-link ps-4">
            <i class="fas fa-file-import"></i> Nhập Thuốc
        </a>

        <a href="<?php echo APP_URL; ?>/modules/medicines/export.php" class="nav-link ps-4">
            <i class="fas fa-file-export"></i> Xuất Dữ Liệu
        </a>

        <!-- Reports -->
        <hr class="my-2">
        <span class="nav-link disabled text-muted">
            <i class="fas fa-chart-bar"></i> Báo Cáo
        </span>

        <a href="<?php echo APP_URL; ?>/modules/reports/index.php" class="nav-link ps-4">
            <i class="fas fa-chart-pie"></i> Thống Kê
        </a>

        <a href="<?php echo APP_URL; ?>/modules/reports/revenue.php" class="nav-link ps-4">
            <i class="fas fa-money-bill-wave"></i> Doanh Thu
        </a>

        <a href="<?php echo APP_URL; ?>/modules/reports/audit.php" class="nav-link ps-4">
            <i class="fas fa-history"></i> Nhật Ký
        </a>
        <?php } ?>
    </nav>

    <div class="sidebar-footer p-3 border-top mt-auto">
        <div class="text-muted small">
            <p class="mb-1">Đăng nhập: <strong><?php echo $_SESSION['username'] ?? 'Guest'; ?></strong></p>
            <p class="mb-0">Vai trò: <strong><?php echo ucfirst($_SESSION['role'] ?? 'User'); ?></strong></p>
        </div>
    </div>
</aside>

<script>
    // Sidebar toggle for mobile
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('show');
    });
</script>
