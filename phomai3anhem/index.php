<?php
// ============================================================
// File: index.php
// Chức năng: Trang chủ giới thiệu doanh nghiệp (Không chứa sản phẩm)
// Phong cách: Tối giản (Clean & Simple), Màu vàng mật ong, Kính mờ (Glassmorphism)
// ============================================================

// Nhúng phần Header chung (Chứa cấu trúc HTML, CSS Glassmorphism và Thanh điều hướng)
include_once 'includes/header.php';
?>

<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-dark shadow-sm" 
     style="background: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)), url('https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?q=80&w=1200') no-repeat center center; background-size: cover; min-height: 500px; border-radius: 24px;">
    
    <div class="col-md-7 p-lg-5 mx-auto my-5 text-white" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-3">Tinh Hoa Phô Mai Quốc Tế</h1>
        <p class="lead fw-normal text-white-50 mb-4">Mang câu chuyện từ những hầm ủ đá lâu đời tại Châu Âu đến bàn tiệc ấm cúng của gia đình bạn.</p>
        <a class="btn btn-gold btn-lg text-uppercase fs-6 px-4 py-3" href="product.php">Khám Phá Sản Phẩm Ngay</a>
    </div>
</div>

<div class="container my-5 py-4" id="about">
    <div class="row align-items-center g-5">
        <div class="col-md-6" data-aos="fade-right">
            <img src="https://images.unsplash.com/photo-1596450514735-111a2fe02935?q=80&w=600" alt="Câu chuyện phô mai 3 anh em" class="img-fluid rounded-4 shadow-sm w-100" style="max-height: 400px; object-fit: cover;">
        </div>
        
        <div class="col-md-6" data-aos="fade-left">
            <span class="text-uppercase fw-bold text-warning small tracking-wider">Hành Trình Khởi Đầu</span>
            <h2 class="display-6 fw-bold mt-1 mb-4" style="color: var(--text-charcoal);">Câu Chuyện "3 Anh Em"</h2>
            <p class="text-muted text-justify lh-lg">
                Được thành lập bởi ba người anh em có niềm đam mê mãnh liệt với ẩm thực phương Tây, chúng tôi bắt đầu hành trình với mong muốn định nghĩa lại cách người Việt thưởng thức phô mai. Không chỉ là một nguyên liệu đơn thuần, phô mai là một tác phẩm nghệ thuật cần thời gian, sự kiên nhẫn và điều kiện ủ hoàn hảo.
            </p>
            <p class="text-muted text-justify lh-lg">
                Mỗi bánh phô mai tại cửa hàng đều được tuyển chọn kỹ lưỡng từ các trang trại thủ công danh tiếng tại Ý, Pháp, và Hà Lan, đảm bảo hương vị nguyên bản và trọn vẹn nhất khi tới tay bạn.
            </p>
        </div>
    </div>
</div>

<div class="py-5" style="background-color: #F4EFE6; border-radius: 24px; margin: 0 1rem;">
    <div class="container py-3">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold" style="color: var(--text-charcoal);">Cam Kết Từ "3 Anh Em"</h2>
            <p class="text-muted">Chất lượng tạo nên giá trị cốt lõi và uy tín bền vững của thương hiệu</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="glass-card p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center">
                    <div class="fs-1 mb-2" style="color: var(--primary-gold);"><i class="bi bi-shield-check"></i></div>
                    <h5 class="fw-bold mb-2">Nhập Khẩu 100%</h5>
                    <p class="small text-muted mb-0">Đầy đủ giấy tờ chứng nhận nguồn gốc xuất xứ tiêu chuẩn quốc tế (AOP, DOP) rõ ràng từ các quốc gia Âu Mỹ.</p>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <div class="glass-card p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center">
                    <div class="fs-1 mb-2" style="color: var(--primary-gold);"><i class="bi bi-snow2"></i></div>
                    <h5 class="fw-bold mb-2">Bảo Quản Chuẩn Kho</h5>
                    <p class="small text-muted mb-0">Hệ thống tủ bảo quản chuyên dụng giữ đúng nhiệt độ và độ ẩm tiêu chuẩn khắt khe cho từng dòng phô mai.</p>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
                <div class="glass-card p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center">
                    <div class="fs-1 mb-2" style="color: var(--primary-gold);"><i class="bi bi-truck"></i></div>
                    <h5 class="fw-bold mb-2">Giao Hàng Giữ Nhiệt</h5>
                    <p class="small text-muted mb-0">Đóng gói kèm đá gel giữ nhiệt chuyên dụng, giao nhanh nội thành đảm bảo độ tươi ngon nguyên bản tuyệt đối.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
// Nhúng phần Footer chung để đóng các thẻ và kích hoạt hiệu ứng AOS Script
include_once 'includes/footer.php'; 
?>