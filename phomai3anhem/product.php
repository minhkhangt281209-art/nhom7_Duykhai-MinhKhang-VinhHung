<?php
// ============================================================
// File: product.php
// Chức năng: Hiển thị danh sách sản phẩm, tích hợp tìm kiếm & lọc dữ liệu
// ============================================================
include_once 'config/db.php';
include_once 'includes/header.php';

// 1. Lấy danh sách danh mục làm dữ liệu cho thanh bộ lọc
$stmt_cate = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
$categories = $stmt_cate->fetchAll();

// 2. Tiếp nhận dữ liệu tìm kiếm & lọc từ thanh Request URL
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$cate_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Xây dựng chuỗi truy vấn SQL động tối ưu an toàn chống SQL Injection
$sql = "SELECT p.*, c.name AS category_name FROM products p 
        JOIN categories c ON p.category_id = c.id 
        WHERE p.is_active = 1";
$params = [];

if (!empty($search)) {
    $sql .= " AND p.name LIKE ?";
    $params[] = "%$search%";
}

if ($cate_id > 0) {
    $sql .= " AND p.category_id = ?";
    $params[] = $cate_id;
}

$sql .= " ORDER BY p.id DESC";

$stmt_prod = $pdo->prepare($sql);
$stmt_prod->execute($params);
$products = $stmt_prod->fetchAll();
?>

<div class="container my-5">
    <div class="text-center mb-5" data-aos="fade-up">
        <h1 class="fw-bold">Danh Mục Phô Mai Cao Cấp</h1>
        <p class="text-muted">Khám phá thế giới hương vị phô mai phong châu Âu được tuyển chọn kỹ lưỡng</p>
    </div>

    <div class="glass-card p-4 mb-5" data-aos="fade-up">
        <form method="GET" action="product.php" class="row g-3">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Tìm tên phô mai..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="0">--- Tất cả phân loại ---</option>
                    <?php foreach($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo ($cate_id == $cat['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['name']); ?>
                        </option>
                    <?php endforeach; ?> </select>
            </div>
            <div class="col-md-3 d-grid">
                <button type="submit" class="btn btn-gold"><i class="bi bi-filter me-2"></i>Áp Dụng Lọc</button>
            </div>
        </form>
    </div>

    <div class="row g-4">
        <?php if (count($products) > 0): ?>
            <?php foreach($products as $prod): ?>
                <div class="col-sm-6 col-md-4 col-lg-3" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden product-card-hover bg-white">
                        
                        <div class="position-relative bg-light text-center p-3">
                            <?php if ($prod['is_featured'] == 1): ?>
                                <span class="position-absolute top-0 start-0 m-3 badge bg-danger px-2 py-1 small rounded-pill">Bán chạy</span>
                            <?php endif; ?>
                            <img src="https://images.unsplash.com/photo-1528750994863-30f4a7c05267?q=80&w=400" class="img-fluid rounded-3" style="max-height: 160px; object-fit: contain;" alt="<?php echo htmlspecialchars($prod['name']); ?>">
                        </div>
                        
                        <div class="card-body d-flex flex-column p-4">
                            <span class="text-uppercase text-warning fw-bold" style="font-size: 0.75rem;"><?php echo htmlspecialchars($prod['category_name']); ?></span>
                            <h6 class="fw-bold my-2 text-dark"><?php echo htmlspecialchars($prod['name']); ?></h6>
                            <p class="text-muted small mb-3 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?php echo htmlspecialchars($prod['short_desc']); ?>
                            </p>
                            
                            <div class="mb-3">
                                <span class="badge bg-light text-dark border">Xuất xứ: <?php echo htmlspecialchars($prod['origin']); ?></span>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                <div>
                                    <span class="fw-bold text-danger d-block"><?php echo number_format($prod['price'], 0, ',', '.'); ?> đ</span>
                                </div>
                                <form method="POST" action="cart.php?action=add">
                                    <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-gold p-2 lh-1 rounded-circle">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center my-5">
                <i class="bi bi-emoji-frown display-4 text-muted"></i>
                <p class="mt-3 text-muted">Không tìm thấy sản phẩm phô mai nào phù hợp với bộ lọc.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>