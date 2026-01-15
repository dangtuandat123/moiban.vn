# Internal API Documentation

Tài liệu API nội bộ cho hệ thống moiban.vn. Các API này chỉ dùng cho internal services (ACB.py, cron jobs, etc.).

---

## Authentication

Tất cả internal API yêu cầu header:

```
X-Internal-Token: {secret_token}
```

Secret token được cấu hình trong `.env`:

```env
INTERNAL_API_SECRET=your_secret_token_here
```

---

## Endpoints

### 1. Wallet Deposit (Nạp tiền)

**POST** `/api/internal/wallet/deposit`

Được gọi bởi ACB.py khi phát hiện giao dịch nạp tiền.

#### Request Headers
```
Content-Type: application/json
X-Internal-Token: {INTERNAL_API_SECRET}
```

#### Request Body
```json
{
  "user_id": 123,
  "amount": 100000,
  "reference_code": "TTGR_123_NAP_20260115_143567"
}
```

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `user_id` | integer | Yes | ID của user (trích từ nội dung chuyển khoản TTGR_{user_id}_NAP) |
| `amount` | integer | Yes | Số tiền nạp (VND) |
| `reference_code` | string | Yes | Mã tham chiếu unique từ ngân hàng |

#### Response Success (200)
```json
{
  "success": true,
  "message": "Deposit successful",
  "data": {
    "transaction_id": 456,
    "user_id": 123,
    "amount": 100000,
    "new_balance": 250000
  }
}
```

#### Response Error (400/401/422)
```json
{
  "success": false,
  "message": "Error message here"
}
```

| Status | Meaning |
|--------|---------|
| 200 | Nạp tiền thành công |
| 400 | Reference code đã tồn tại (duplicate) |
| 401 | Token không hợp lệ |
| 404 | User không tồn tại |
| 422 | Validation error |

---

### 2. Get Invitation (Public API)

**GET** `/api/invitations/{slug}`

Lấy thông tin thiệp công khai (dùng cho OG Image generator, external integrations).

#### Request
```
GET /api/invitations/an-va-binh-wedding
```

#### Response (200)
```json
{
  "success": true,
  "data": {
    "slug": "an-va-binh-wedding",
    "title": "Thiệp cưới Anh & Bình",
    "groom_name": "Nguyễn Văn An",
    "bride_name": "Trần Thị Bình",
    "event_date": "2026-02-14",
    "template": "romantic-rose",
    "status": "active"
  }
}
```

---

## VietQR Integration

### Nội dung chuyển khoản

Format: `TTGR_{user_id}_NAP`

Ví dụ: `TTGR_123_NAP` (User ID = 123)

### VietQR Image URL

```
https://api.vietqr.io/image/{bank_code}-{account_number}-rdXzPHV.jpg?accountName={name}&addInfo={content}
```

Ví dụ:
```
https://api.vietqr.io/image/970416-11183041-rdXzPHV.jpg?accountName=DANG%20TUAN%20DAT&addInfo=TTGR_123_NAP
```

---

## ACB.py Integration

### Sample Python Code

```python
import requests

def notify_deposit(user_id: int, amount: int, reference: str):
    url = "https://moiban.vn/api/internal/wallet/deposit"
    headers = {
        "Content-Type": "application/json",
        "X-Internal-Token": "YOUR_SECRET_TOKEN"
    }
    payload = {
        "user_id": user_id,
        "amount": amount,
        "reference_code": reference
    }
    
    response = requests.post(url, json=payload, headers=headers)
    return response.json()
```

### Parsing User ID from Transfer Content

```python
import re

def parse_user_id(content: str) -> int:
    """
    Parse user ID from transfer content.
    Expected format: TTGR_{user_id}_NAP
    """
    match = re.search(r'TTGR_(\d+)_NAP', content.upper())
    if match:
        return int(match.group(1))
    return None
```

---

## Security Notes

1. **IP Whitelist**: Recommended to whitelist server IPs that can call internal APIs
2. **Rate Limiting**: Internal API không có rate limit, nhưng nên implement ở caller side
3. **Idempotency**: `reference_code` phải unique, API sẽ reject duplicate requests
4. **HTTPS**: Production phải dùng HTTPS

---

## Environment Variables

```env
# Internal API
INTERNAL_API_SECRET=your_secret_token_here

# VietQR Config
VIETQR_BANK_CODE=970416
VIETQR_ACCOUNT_NUMBER=11183041
VIETQR_ACCOUNT_NAME=DANG TUAN DAT

# Telegram Notifications
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_CHAT_ID=your_chat_id
```
