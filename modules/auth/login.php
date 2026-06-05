<?php
/**
 * Trang đăng nhập
 */
session_start();

require_once '../../config/database.php';
require_once '../../config/config.php';

// Kiểm tra nếu đã đăng nhập
if (is_logged_in()) {
    redirect(APP_URL . '/index.php');
}

$error = '';
$success = '';

// Xử lý form đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Vui lòng nhập tên đăng nhập và mật khẩu';
    } else {
        try {
            $stmt = $pdo->prepare('
                SELECT id, username, password, full_name, email, role, doctor_id, status 
                FROM users 
                WHERE username = ? AND status = "active"
            ');
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && verify_password($password, $user['password'])) {
                // Đăng nhập thành công
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['doctor_id'] = $user['doctor_id'];

                // Cập nhật last_login
                $updateStmt = $pdo->prepare('UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?');
                $updateStmt->execute([$user['id']]);

                // Ghi nhật ký
                $logStmt = $pdo->prepare('
                    INSERT INTO audit_logs (user_id, action, ip_address, user_agent)
                    VALUES (?, "login", ?, ?)
                ');
                $logStmt->execute([
                    $user['id'],
                    $_SERVER['REMOTE_ADDR'],
                    $_SERVER['HTTP_USER_AGENT']
                ]);

                redirect(APP_URL . '/index.php');
            } else {
                $error = 'Tên đăng nhập hoặc mật khẩu không chính xác';
            }
        } catch (PDOException $e) {
            $error = 'Lỗi kết nối database';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - <?php echo APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
        }
        .login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .login-header h2 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .login-header p {
            font-size: 14px;
            opacity: 0.9;
            margin: 0;
        }
        .login-body {
            padding: 30px;
        }
        .form-control {
            border-radius: 5px;
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            font-weight: 500;
            border-radius: 5px;
            width: 100%;
        }
        .btn-login:hover {
            color: white;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .alert {
            border-radius: 5px;
            border: none;
        }
        .demo-info {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .demo-info h6 {
            color: #667eea;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .demo-account {
            font-size: 13px;
            margin-bottom: 5px;
        }
        .demo-account strong {
            color: #764ba2;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <h2>
                    <i class="fas fa-hospital"></i> Kê Đơn Thuốc
                </h2>
                <p>Hệ Thống Quản Lý Kê Đơn Thuốc</p>
            </div>

            <!-- Body -->
            <div class="login-body">
                <!-- Alert Messages -->
                <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (!empty($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <!-- Login Form -->
                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-user"></i> Tên Đăng Nhập
                        </label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="username" 
                            placeholder="Nhập tên đăng nhập"
                            required
                            autofocus
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Mật Khẩu
                        </label>
                        <input 
                            type="password" 
                            class="form-control" 
                            name="password" 
                            placeholder="Nhập mật khẩu"
                            required
                        >
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">
                            Nhớ tôi
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt"></i> Đăng Nhập
                    </button>
                </form>

                <!-- Demo Info -->
                <div class="demo-info">
                    <h6><i class="fas fa-info-circle"></i> Tài Khoản Demo</h6>
                    <div class="demo-account">
                        <strong>Admin:</strong> admin / 123456
                    </div>
                    <div class="demo-account">
                        <strong>Bác sĩ:</strong> doctor1 / 123456
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-4 text-white">
            <small>&copy; 2026 Hệ Thống Quản Lý Kê Đơn Thuốc - Tất cả quyền được bảo lưu</small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
