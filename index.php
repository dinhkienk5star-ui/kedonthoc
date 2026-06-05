<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ Thống Quản Lý Kê Đơn Thuốc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'config/database.php';
    require_once 'config/config.php';

    // Check if logged in
    if (!is_logged_in()) {
        redirect(APP_URL . '/modules/auth/login.php');
    }
    ?>

    <div class="wrapper">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Content -->
        <div class="content">
            <!-- Header -->
            <?php include 'includes/header.php'; ?>

            <!-- Main Content -->
            <main class="main-content">
                <div class="container-fluid p-4">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="mb-4">
                                <i class="fas fa-home"></i> Dashboard
                            </h1>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="row">
                        <?php if (has_role('admin')) { ?>
                        <div class="col-md-3 mb-4">
                            <div class="card stats-card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Tổng Bác Sĩ</h6>
                                            <h3 class="mb-0" id="total-doctors">0</h3>
                                        </div>
                                        <div class="fs-1">
                                            <i class="fas fa-user-md"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="card stats-card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Tổng Bệnh Nhân</h6>
                                            <h3 class="mb-0" id="total-patients">0</h3>
                                        </div>
                                        <div class="fs-1">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="card stats-card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Tổng Thuốc</h6>
                                            <h3 class="mb-0" id="total-medicines">0</h3>
                                        </div>
                                        <div class="fs-1">
                                            <i class="fas fa-pills"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="card stats-card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Tổng Đơn Thuốc</h6>
                                            <h3 class="mb-0" id="total-prescriptions">0</h3>
                                        </div>
                                        <div class="fs-1">
                                            <i class="fas fa-prescription-bottle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card stats-card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Đơn Thuốc Của Tôi</h6>
                                            <h3 class="mb-0" id="my-prescriptions">0</h3>
                                        </div>
                                        <div class="fs-1">
                                            <i class="fas fa-prescription-bottle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card stats-card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Bệnh Nhân</h6>
                                            <h3 class="mb-0" id="total-patients">0</h3>
                                        </div>
                                        <div class="fs-1">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card stats-card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="card-title">Tổng Thuốc</h6>
                                            <h3 class="mb-0" id="total-medicines">0</h3>
                                        </div>
                                        <div class="fs-1">
                                            <i class="fas fa-pills"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-bolt"></i> Hành Động Nhanh
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php if (has_role('admin')) { ?>
                                        <div class="col-md-3 mb-3">
                                            <a href="modules/doctors/list.php" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-user-md"></i> Quản Lý Bác Sĩ
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="modules/patients/list.php" class="btn btn-outline-success w-100">
                                                <i class="fas fa-users"></i> Quản Lý Bệnh Nhân
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="modules/medicines/list.php" class="btn btn-outline-info w-100">
                                                <i class="fas fa-pills"></i> Quản Lý Thuốc
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="modules/medicines/import.php" class="btn btn-outline-warning w-100">
                                                <i class="fas fa-file-import"></i> Nhập Thuốc
                                            </a>
                                        </div>
                                        <?php } ?>
                                        <div class="col-md-3 mb-3">
                                            <a href="modules/prescriptions/create.php" class="btn btn-outline-primary w-100">
                                                <i class="fas fa-prescription-bottle"></i> Kê Đơn Mới
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <a href="modules/prescriptions/list.php" class="btn btn-outline-success w-100">
                                                <i class="fas fa-list"></i> Danh Sách Đơn
                                            </a>
                                        </div>
                                        <?php if (has_role('admin')) { ?>
                                        <div class="col-md-3 mb-3">
                                            <a href="modules/reports/index.php" class="btn btn-outline-info w-100">
                                                <i class="fas fa-chart-bar"></i> Báo Cáo
                                            </a>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Prescriptions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-history"></i> Đơn Thuốc Gần Đây
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Mã Đơn</th>
                                                    <th>Bác Sĩ</th>
                                                    <th>Bệnh Nhân</th>
                                                    <th>Ngày Kê</th>
                                                    <th>Trạng Thái</th>
                                                    <th>Hành Động</th>
                                                </tr>
                                            </thead>
                                            <tbody id="recent-prescriptions">
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-4">
                                                        Đang tải dữ liệu...
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/dashboard.js"></script>
</body>
</html>
