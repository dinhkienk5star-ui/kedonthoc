<?php
/**
 * Cấu hình chung ứng dụng
 */

// Session configuration
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
if (!isset($_SESSION)) {
    session_start();
}

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Session timeout (1 hour)
$timeout = 3600;
if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > $timeout) {
        session_destroy();
        header('Location: ' . APP_URL . '/modules/auth/login.php');
        exit;
    }
}
$_SESSION['last_activity'] = time();

// CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Hàm helper - Xác thực CSRF Token
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Hàm helper - Lấy CSRF Token
 */
function get_csrf_token() {
    return $_SESSION['csrf_token'] ?? '';
}

/**
 * Hàm helper - Mã hóa mật khẩu
 */
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

/**
 * Hàm helper - Kiểm tra mật khẩu
 */
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Hàm helper - Làm sạch dữ liệu đầu vào
 */
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Hàm helper - Redirect
 */
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

/**
 * Hàm helper - Check if user is logged in
 */
function is_logged_in() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Hàm helper - Check user role
 */
function has_role($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

/**
 * Hàm helper - Format currency
 */
function format_currency($amount) {
    return number_format($amount, 0, ',', '.') . ' ₫';
}

/**
 * Hàm helper - Format date
 */
function format_date($date) {
    return date('d/m/Y', strtotime($date));
}

/**
 * Hàm helper - Format datetime
 */
function format_datetime($datetime) {
    return date('d/m/Y H:i', strtotime($datetime));
}
?>
