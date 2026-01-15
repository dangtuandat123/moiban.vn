# Project Memory (Context & Conventions)

File này lưu trữ các quy ước quan trọng của dự án. Agent PHẢI đọc file này trước khi thực hiện các task liên quan đến UI hoặc Database.

## 🎨 Design System (UI/UX)
*   **Primary Color**: Rose Gold (`#b76e79`) & Champagne (`#f7e7ce`).
*   **Font Family**: `Be Vietnam Pro` (Body), `Great Vibes` (Script/Heading).
*   **Style**: Glassmorphism (Premium, Dark Mode base).
*   **Framework**: Tailwind CSS.

## 🗄️ Database Conventions
*   **Table Names**: Snake case, số nhiều (e.g., `user_profiles`, `order_items`).
*   **Primary Key**: `id` (BigInteger Unsigned).
*   **Foreign Keys**: `model_id` (e.g., `user_id`, `product_id`).
*   **Timestamps**: Luôn có `created_at`, `updated_at`.

## 🛠️ Tech Stack
*   **Backend**: Laravel 10+.
*   **Frontend**: Blade Templates + Vanilla JS (hoặc Alpine.js).
*   **Database**: MySQL 8.0.

## 📝 Business Rules (Luật Bất Thành Văn)
1.  Không xóa cứng dữ liệu quan trọng -> Dùng `SoftDeletes`.
2.  Mọi thay đổi về tiền tệ phải dùng Transaction.
3.  Comment code bằng Tiếng Việt.
