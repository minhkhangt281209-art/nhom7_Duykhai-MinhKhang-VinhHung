<?php
// ============================================================
// File: product-detail.php
// Chức năng: Hiển thị thông tin chi tiết một loại phô mai cụ thể
// ============================================================
include_once 'config/db.php';
include_once 'includes/header.php';

// Kiểm tra ID sản phẩm truyền lên qua URL thanh địa chỉ
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Truy vấn thông tin sản phẩm và kết nối danh mục tương ứng
$stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p 
                        JOIN categories c ON p.category_id = c.id 
                        WHERE p.id = ? AND p.is_active = 1");
$stmt->execute([$id]);
$product = $stmt->fetch();

// Nếu không tìm thấy sản phẩm, thông báo hoặc chuyển hướng
if (!$product) {
    echo "<div class='container my-5 text-center'><p class='alert alert-warning'>Sản phẩm phô mai này không tồn tại hoặc đã ngừng kinh doanh.</p><a href='product.php' class='btn btn-gold'>Quay lại cửa hàng</a></div>";
    include_once 'includes/footer.php';
    exit();
}
?>

<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4" data-aos="fade-up">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="index.php" class="text-muted text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="product.php" class="text-muted text-decoration-none">Sản phẩm</a></li>
            <li class="breadcrumb-item active text-dark fw-bold" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-md-6" data-aos="fade-right">
            <div class="bg-white p-4 rounded-4 shadow-sm text-center border">
                <img src="https://images.unsplash.com/photo-1528750994863-30f4a7c05267?q=80&w=600" class="img-fluid rounded-3" style="max-height: 380px; object-fit: contain;" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
        </div>

        <div class="col-md-6" data-aos="fade-left">
            <span class="badge bg-warning text-dark text-uppercase mb-2 px-3 py-2 rounded-pill fw-bold" style="font-size: 0.75rem;">
                <?php echo htmlspecialchars($product['category_name']); ?>
            </span>
            <h1 class="fw-bold mb-3 text-dark"><?php echo htmlspecialchars($product['name']); ?></h1>
            
            <div class="mb-4 py-2 px-3 bg-light rounded-3 d-inline-block">
                <span class="fs-3 fw-bold text-danger"><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</span>
                <?php if(!empty($product['original_price'])): ?>
                    <del class="text-muted small ms-3"><?php echo number_format($product['original_price'], 0, ',', '.'); ?> đ</del>
                <?php endif; ?>
            </div>

            <p class="text-muted mb-4 fs-6 leading-relaxed"><?php echo htmlspecialchars($product['short_desc']); ?></p>

            <div class="glass-card p-3 mb-4">
                <div class="row g-2 small">
                    <div class="col-6"><strong>Xuất xứ thương hiệu:</strong></div>
                    <div class="col-6 text-end text-dark fw-semibold"><?php echo htmlspecialchars($product['origin']); ?></div>
                    <hr class="my-1 border-light">
                    <div class="col-6"><strong>Trọng lượng đóng gói:</strong></div>
                    <div class="col-6 text-end text-dark fw-semibold"><?php echo number_format($product['weight_grams'], 0, ',', '.'); ?> gram</div>
                    <hr class="my-1 border-light">
                    <div class="col-6"><strong>Tình trạng kho hàng:</strong></div>
                    <div class="col-6 text-end text-success fw-semibold">Còn <?php echo $product['stock_quantity']; ?> sản phẩm</div>
                </div>
            </div>

            <form method="POST" action="cart.php?action=add" class="d-flex gap-3 align-items-center">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <button type="submit" class="btn btn-gold btn-lg w-100 py-3 text-uppercase fs-6 fw-bold">
                    <i class="bi bi-cart-plus me-2 fs-5"></i>Thêm Vào Giỏ Hàng
                </button>
            </form>
        </div>
    </div>

    <div class="row mt-5" data-aos="fade-up">
        <div class="col-12">
            <div class="glass-card p-4 p-md-5">
                <h4 class="fw-bold mb-4 border-bottom pb-2 text-dark"><i class="bi bi-file-text me-2 text-warning"></i>Đặc Điểm & Hương Vị Chi Tiết</h4>
                <div class="text-muted lh-lg" style="white-space: pre-line; text-align: justify;">
                    <?php echo htmlspecialchars($product['full_desc']); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>