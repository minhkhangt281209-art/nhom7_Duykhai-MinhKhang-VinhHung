<?php
// ============================================================
// File: cart.php
// Chức năng: Quản lý giỏ hàng (Thêm, Sửa, Xóa) bằng Session PHP
// ============================================================
include_once 'config/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Khởi tạo giỏ hàng nếu chưa tồn tại
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

// 1. XỬ LÝ LOGIC BACKEND (Thêm/Sửa/Xóa) trước khi render giao diện
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $product_id = (int)$_POST['product_id'];
    
    // Lấy thông tin sản phẩm từ DB xem có tồn tại không
    $stmt = $pdo->prepare("SELECT id, name, price, image FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    if ($product) {
        // Nếu sản phẩm đã có trong giỏ, tăng số lượng lên 1
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            // Ngược lại, thêm mới vào giỏ hàng
            $_SESSION['cart'][$product_id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1
            ];
        }
    }
    header('Location: product.php'); // Thêm xong quay lại trang sản phẩm
    exit();
}

// Xử lý Xóa sản phẩm khỏi giỏ hàng
if ($action === 'remove' && isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    unset($_SESSION['cart'][$product_id]);
    header('Location: cart.php');
    exit();
}

// 2. GIAO DIỆN HIỂN THỊ GIỎ HÀNG
include_once 'includes/header.php';
?>

<div class="container my-5">
    <h1 class="fw-bold mb-4">Giỏ Hàng Của Bạn</h1>
    
    <?php if(!empty($_SESSION['cart'])): ?>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="glass-card p-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th style="width: 100px;">SL</th>
                                    <th>Tổng</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $grand_total = 0;
                                foreach($_SESSION['cart'] as $id => $item): 
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $grand_total += $subtotal;
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="assets/images/<?php echo $item['image']; ?>" style="width: 50px; height: 50px; object-fit: contain;">
                                            <span class="fw-semibold text-dark"><?php echo htmlspecialchars($item['name']); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?> đ</td>
                                    <td>
                                        <span class="badge bg-light text-dark border p-2 w-100 text-center"><?php echo $item['quantity']; ?></span>
                                    </td>
                                    <td class="fw-bold text-danger"><?php echo number_format($subtotal, 0, ',', '.'); ?> đ</td>
                                    <td>
                                        <a href="cart.php?action=remove&id=<?php echo $id; ?>" class="text-danger fs-5"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="glass-card p-4">
                    <h4 class="fw-bold mb-3">Tóm tắt đơn hàng</h4>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tạm tính:</span>
                        <span class="fw-bold"><?php echo number_format($grand_total, 0, ',', '.'); ?> đ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span>Phí vận chuyển:</span>
                        <span class="text-success fw-bold">Miễn phí</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4 fs-5 fw-bold">
                        <span>Tổng cộng:</span>
                        <span class="text-danger"><?php echo number_format($grand_total, 0, ',', '.'); ?> đ</span>
                    </div>
                    <div class="d-grid">
                        <a href="checkout.php" class="btn btn-gold btn-lg fs-6">Tiến Hành Thanh Toán</a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5 glass-card">
            <i class="bi bi-bag-x display-1 text-muted"></i>
            <p class="mt-3 text-muted fs-5">Giỏ hàng của bạn đang trống rỗng.</p>
            <a href="product.php" class="btn btn-gold mt-2">Quay lại mua sắm</a>
        </div>
    <?php endif; ?>
</div>

<?php include_once 'includes/footer.php'; ?>