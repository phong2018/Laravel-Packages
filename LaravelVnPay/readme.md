===================================================
Install package: LaravelVnpay
- sail composer require phonglg/laravelvnpay
- sail php artisan vendor:publish --provider="Phonglg\LaravelVnPay\LaravelVnPayServiceProvider" --tag="assets"
==================================================
Trả lời câu hỏi:
1, Nếu call server đơn vị không thành công VNPAY có cơ chế retry, gọi lại server đơn vị 10 lần mỗi lần cách nhau 5 phút.
Trường hợp query (truy vấn) nên thực hiện sau 30 phút khi đã kết thúc phiên giao dịch.
===================================================
Demo return url:
http://127.0.0.1/vnpay_return?vnp_Amount=1176000&vnp_BankCode=NCB&vnp_BankTranNo=20211103104910&vnp_CardType=ATM&vnp_OrderInfo=phong+mot+thanh+to%C3%A1n+mua+v%C3%A9+s%E1%BB%91+11760.00%C4%90&vnp_PayDate=20211103104905&vnp_ResponseCode=00&vnp_TmnCode=KRQQ6XRU&vnp_TransactionNo=13618714&vnp_TransactionStatus=00&vnp_TxnRef=32&vnp_SecureHash=42c4b5e9b942c07d266518f24d2998b775fa04f22cefec3ab9d88de101112f64df64fee6746186db60cf9e7c5e7292d22bd27e0fd58dcd187f4635f702689fdd

===================================================
Build package: LaravelVnpay
- https://sandbox.vnpayment.vn/apis/docs/mo-hinh-ket-noi/
- php artisan vendor:publish --provider="Phonglg\LaravelVnPay\LaravelVnPayServiceProvider" --tag="assets"
https://thantai39.vn/
phong2018@gmail.com
pass: Sonthantai39@
Mọi thắc mắc và góp ý, xin vui lòng liên hệ với chúng tôi qua:
Email: support.vnpayment@vnpay.vn
Hotline: 1900 55 55 77
===================================================
Thông tin dưới đây là môi trường Sandbox của VNPAY, sử dụng để kết nối kiểm thử hệ thống. Merchant không sử dụng thông tin này để đưa ra cho khách hàng thanh toán thật.
Merchant cần tạo địa chỉ IPN (server call server) sử dụng cập nhật tình trạng thanh toán (trạng thái thanh toán) cho giao dịch. Merchant cần gửi cho VNPAY URL này.
Thông tin cấu hình:
Terminal ID / Mã Website (vnp_TmnCode): KRQQ6XRU
Secret Key / Chuỗi bí mật tạo checksum (vnp_HashSecret): ZZNYKATTPJDWKZUYUKGMWPYKSDKYYADS
Url thanh toán môi trường TEST (vnp_Url): https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
Thông tin truy cập Merchant Admin để quản lý giao dịch:
Địa chỉ: https://sandbox.vnpayment.vn/merchantv2/

Tên đăng nhập: phong2018@gmail.com

Mật khẩu: (Là mật khẩu nhập tại giao diện đăng ký Merchant môi trường TEST)

Kiểm tra (test case) – IPN URL:
Kịch bản test (SIT): https://sandbox.vnpayment.vn/vnpaygw-sit-testing/user/login

Tên đăng nhập: phong2018@gmail.com

Mật khẩu: (Là mật khẩu nhập tại giao diện đăng ký Merchant môi trường TEST)

Tài liệu:
Tài liệu hướng dẫn tích hợp: https://sandbox.vnpayment.vn/apis/docs/gioi-thieu/

Code demo tích hợp: https://sandbox.vnpayment.vn/apis/vnpay-demo/code-demo-tích-hợp

Thẻ test:
Ngân hàng	NCB
Số thẻ	9704198526191432198
Tên chủ thẻ	NGUYEN VAN A
Ngày phát hành	07/15
Mật khẩu OTP	123456

Ngoài ra anh/chị có thể dùng thử demo Cổng thanh toán VNPAY tại: https://sandbox.vnpayment.vn/apis/vnpay-demo/để có những trải nghiệm đầu tiên khi tích hợp với Cổng thanh toán VNPAYQR.
Cần thêm thông tin, anh/chị có thể trao đổi trực tiếp với em qua thông tin ở phần chữ ký của email này.
Cảm ơn anh/chị.
Mọi thắc mắc và góp ý, xin vui lòng liên hệ với chúng tôi qua:
Email: support.vnpayment@vnpay.vn
Hotline: 1900 55 55 77
===================================================
# LaravelVnPay

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require phonglg/laravelvnpay
```

## Usage

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/phonglg/laravelvnpay.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phonglg/laravelvnpay.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/phonglg/laravelvnpay/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/phonglg/laravelvnpay
[link-downloads]: https://packagist.org/packages/phonglg/laravelvnpay
[link-travis]: https://travis-ci.org/phonglg/laravelvnpay
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/phonglg
[link-contributors]: ../../contributors
