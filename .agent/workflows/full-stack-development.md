---
description: Quy trình phát triển Full-Stack Laravel chuẩn (Design -> UI -> Code -> Test)
---

# Full-Stack Development Workflow

Quy trình này hướng dẫn Agent phối hợp các Skill để giải quyết yêu cầu phát triển tính năng trọn vẹn.

## 🔄 The 4-Phase Protocol

Khi nhận yêu cầu phát triển tính năng, hãy thực hiện tuần tự 4 bước sau:

### Phase 1: Phân tích & Thiết kế (Architect)
> **Goal**: Hiểu rõ vấn đề và có bản thiết kế chi tiết.
*   **Skill**: `@[skill-phan-tich-he-thong]`
*   **Actions**:
    1.  Phân tích User Stories & Actors.
    2.  Thiết kế Database Schema (ERD).
    3.  Thiết kế API Endpoints.
    4.  **Critical Thinking**: Đánh giá rủi ro và biện pháp phòng ngừa.
*   **Output**: File `implementation_plan.md`.

### Phase 2: Giao diện & Trải nghiệm (Frontend)
> **Goal**: Có giao diện đẹp, responsive và đúng mood.
*   **Skill**: `@[glassmorphism-ui]`, `@[tailwind-css]`
*   **Actions**:
    1.  Tạo file Blade Views/Components.
    2.  Áp dụng Glassmorphism effects (nếu phù hợp) hoặc Tailwind UI.
    3.  Đảm bảo Mobile Responsive.

### Phase 3: Lập trình Logic (Backend)
> **Goal**: Code chạy đúng, sạch và tối ưu.
*   **Skill**: `@[laravel-coding-expert]`
*   **Actions**:
    1.  Tạo Migrations & Models.
    2.  Viết Service Layer để xử lý logic nghiệp vụ.
    3.  Viết Slim Controllers & FormRequests.
    4.  Tối ưu Eloquent Queries.

### Phase 4: Kiểm thử (Quality Assurance)
> **Goal**: Đảm bảo không có bug.
*   **Skill**: `@[laravel-testing-pro]`
*   **Actions**:
    1.  Viết Feature Tests cho các luồng chính (Happy/Sad paths).
    2.  Chạy test và fix bug.

---

## 💡 Cách sử dụng
Để áp dụng quy trình này, User hãy ra lệnh:
> "Thực hiện tính năng [Tên tính năng] theo quy trình @[.agent/workflows/full-stack-development.md]"

Agent sẽ tự động load file này và biết cần phải sử dụng các skill nào theo trình tự nào.
