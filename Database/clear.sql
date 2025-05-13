-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 05, 2025 lúc 03:44 PM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `andinasia_quanlytoanha`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_cauhinh`
--

CREATE TABLE `qlcvsd_cauhinh` (
  `id` int(11) NOT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ghi_chu` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ckeditor` tinyint(1) DEFAULT 0,
  `giai_thich` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_cauhinh`
--

INSERT INTO `qlcvsd_cauhinh` (`id`, `content`, `ghi_chu`, `name`, `ckeditor`, `giai_thich`) VALUES
(1, 'http://localhost/quanlytoanha/', 'domain', NULL, 0, NULL),
(2, 'http://localhost/quanlytoanha/hinh-anh/no-image.jpg', 'no_image', 'No Image', 0, NULL),
(28, '128', 'ma_hop_dong', 'Mã hợp đồng mới nhất', 0, NULL),
(29, '<p><strong>&nbsp; &nbsp; </strong></p>\r\n\r\n<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:295px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n			<p><strong>TH&Ocirc;NG B&Aacute;O TIỀN PH&Ograve;NG TRỌ</strong></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:170px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>Th&aacute;ng {thang} năm {nam}</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>\r\n\r\n<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\" style=\"width:600px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>K&iacute;nh gửi: {ten_khach_hang}</td>\r\n			<td>Số điện thoại: {so_dien_thoai}</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Ở ph&ograve;ng số: {phong}</td>\r\n			<td>T&ograve;a nha: {toa_nha}</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:700px\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\">Xin th&ocirc;ng b&aacute;o &ocirc;ng b&agrave; biết, tiền thu&ecirc; ph&ograve;ng v&agrave; c&aacute;c chi ph&iacute; dịch vụ kh&aacute;c trong th&aacute;ng {thang} năm {nam}. Cụ thể như sau:</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>{bang}</p>\r\n\r\n<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:400px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>Phần thanh to&aacute;n:</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>- Số tiền c&ograve;n nợ th&aacute;ng trước</td>\r\n			<td>{so_tien_no}</td>\r\n		</tr>\r\n		<tr>\r\n			<td>- Đ&atilde; thanh to&aacute;n th&aacute;ng n&agrave;y</td>\r\n			<td>{da_thanh_toan}</td>\r\n		</tr>\r\n		<tr>\r\n			<td>- Phải trả th&aacute;ng n&agrave;y:</td>\r\n			<td>{so_tien_phai_tra}</td>\r\n		</tr>\r\n		<tr>\r\n			<td><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Tổng cộng:&nbsp;</strong></td>\r\n			<td>{tong_cong}</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Chi tiết thanh to&aacute;n:&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td colspan=\"2\">&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"text-align:center\"><strong>Quản l&yacute; nh&agrave; trọ</strong></td>\r\n			<td style=\"text-align:center\"><strong>Người trọ</strong></td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'in_hoa_don', 'printBill', 1, NULL),
(30, 'https://img.vietqr.io/image/{bank_id}-{so_tai_khoan}-compact2.png?amount={so_tien}&addInfo={noi_dung}&accountName={ten_nguoi_nhan}', 'Link QR', 'Mã QR', 0, NULL),
(36, '1000', 'So_tien_toi_thieu', 'Số tiền tối thiểu', 0, NULL),
(41, '1425', 'maHoaDon', 'Mã hóa đơn', 0, NULL),
(44, '168', 'thoi_gian', 'Thời gian sửa HD', 0, NULL),
(45, 'btYSQouR6cYTSvXd8H4UQ99rds8e2qCeynA_IZicSKFuEeme6o9zFiuXdbS8N4Sdz3oTJ4uAH3cREu5ZHrbl2ALbb6njPN8HY6s_RsHgVGM8IhfzPL1L2AvJptbNT0eDhX3uJdvp3JI0PU9EOm0p7OSzurnr3oDNgJ3dD7fDDrsfTBKA418tMlq0wrX78oiRlpdpOtyv8ZUPN-9_QrmvVBD_o0LLN2fnbKRwFrj3E7oPOkajLbCq8wzIwtP9RIWXyGpHHJKJBJJk3lnaAXqjDy8YoNKu0WrZmIhGAZrC5bBXBTWi7nefTCyoyoCzEo1mXY6d9sH8P4wzJkG5NLSTSx16nG5nPJbzeq6vB7OZH2F5HSTFBI038ECIu5KSCGKVkmpRHsO99n62EzfcQGXSRQqgt2OG30HKLufGjpif1XXa', 'access_token', 'Access Token', 0, NULL),
(46, 'eJddHW9eDrkhCkDA3M8pMwGqv4y4U6u9rIh20Gmz4KRH5A4i83bjMu0ulJnO2ovedL-h06D-FX2zN-X3JdH3FwfYzc0EI7qKsc3EM2XCGadVO_ahDZ9zRz4ahHmsF1n9pIUrAMq39ckV6OCuDYHFK-GytnGiDLW1-GRx7IzH8rVN2eSK55mJTxHSiJT1VGXBuoYP3p0z4HxnBgDwFdm1BV4eh5WF62v4fmo22W883rpB88mA40mw7xOKw6v_9aKwkNENTXrw9YN9NVyp87XwTC9hunauRp1TdcAQ6Mb8Ib6jO-qtK4X8JRbGvY8TMM0qsKFpInuLLWZ5Ge5U3Ha85T8an0KtDs8Lb0_GNLu9U0gh0Du2LWXjOVycnY0dFKv8pJFtMJzcN3R8N8WXFWagQjOVhdn4K91YuIK5TJLN', 'refresh_token', 'Refresh Token', 0, NULL),
(47, '393476', 'template_id', 'Template ID', 0, NULL),
(48, '152', 'tracking_id', 'Tracking ID', 0, NULL),
(49, '1', 'thoi_gian_thong_bao', 'Ngày gửi thông báo thanh toán', 0, NULL),
(50, '', 'loading_image', 'loading_image', 0, NULL),
(51, '99999', 'so_dien_toi_da', 'Số điện tối đa', 0, NULL),
(52, '99999', 'so_nuoc_toi_da', 'Số nước tối đa', 0, NULL),
(53, '2', 'ngay_giua_thang', 'Ngày giữa tháng', 0, NULL),
(54, '{\"error\":0,\"data\":[{\"id\":0,\"tid\":\"MA_GIAO_DICH_THU_NGHIEM\",\"description\":\"giao dich thu nghiem\",\"amount\":599000,\"cusum_balance\":25000000,\"when\":\"2024-11-08 17:31:42\",\"bank_sub_acc_id\":\"88888888\",\"subAccId\":\"88888888\",\"bankName\":\"VPBank\",\"bankAbbreviation\":\"VPB\",\"virtualAccount\":\"\",\"virtualAccountName\":\"\",\"corresponsiveName\":\"NGUYEN VAN A\",\"corresponsiveAccount\":\"8888888888\",\"corresponsiveBankId\":\"970415\",\"corresponsiveBankName\":\"VietinBank\"}]}', 'Test_Thanh_toan_luong', 'Test_Thanh_toan_luong', 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_chi_phi`
--

CREATE TABLE `qlcvsd_chi_phi` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_tien` decimal(20,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_chi_phi`
--

INSERT INTO `qlcvsd_chi_phi` (`id`, `name`, `so_tien`) VALUES
(1, 'Chi phí môi giới', '0'),
(2, 'Mã khách hàng nước', '0'),
(3, 'Mã khách hàng điện 1', '0'),
(4, 'Mã khách hàng điện 2', '0'),
(5, 'Tiền thuê nhà', '100000000'),
(6, 'Tiền Internet ', '265000'),
(7, 'Cảnh Sát khu vực', '1000000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_chi_tiet_chi_phi`
--

CREATE TABLE `qlcvsd_chi_tiet_chi_phi` (
  `id` int(11) NOT NULL,
  `chi_phi_id` int(11) DEFAULT NULL,
  `phieu_chi_id` int(11) DEFAULT NULL,
  `so_tien` decimal(20,0) DEFAULT 0,
  `ghi_chu` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ten_chi_phi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `da_thanh_toan` decimal(20,0) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_chi_tiet_chi_phi`
--

INSERT INTO `qlcvsd_chi_tiet_chi_phi` (`id`, `chi_phi_id`, `phieu_chi_id`, `so_tien`, `ghi_chu`, `ten_chi_phi`, `da_thanh_toan`) VALUES
(1, NULL, 1, '900000', '', 'Chi phí môi giới', '0'),
(2, NULL, 1, '1000000', '', 'Mã khách hàng nước', '0'),
(3, NULL, 1, '0', '', 'Mã khách hàng điện 1', '0'),
(4, NULL, 1, '0', '', 'Mã khách hàng điện 2', '0'),
(5, NULL, 1, '100000000', '', 'Tiền thuê nhà', '0'),
(6, NULL, 1, '265000', 'VNPT', 'Tiền Internet', '0'),
(7, NULL, 1, '1000000', '', 'Cảnh Sát khu vực', '0'),
(9, NULL, 1, '2500000', 'Bác Thu', 'Dọn vệ sinh', '0'),
(10, NULL, 2, '10560000', '', 'Chi phí môi giới', '0'),
(11, NULL, 2, '3572676', '', 'Mã khách hàng nước', '0'),
(12, NULL, 2, '3009438', '', 'Mã khách hàng điện 1', '0'),
(13, NULL, 2, '3490164', '', 'Mã khách hàng điện 2', '0'),
(14, NULL, 2, '100000000', '', 'Tiền thuê nhà', '0'),
(15, NULL, 2, '265000', '', 'Tiền Internet', '0'),
(16, NULL, 2, '1000000', '', 'Cảnh Sát khu vực', '0'),
(25, NULL, 2, '2380000', '', 'Dọn vệ sinh', '0'),
(26, NULL, 2, '6000000', '', 'Lương quản lý', '0'),
(27, NULL, 2, '950000', '', 'Đầu tư homestay', '0'),
(28, NULL, 2, '400000', '', 'Tiền rác', '0'),
(29, 1, 3, '10560000', NULL, 'Chi phí môi giới', '900000'),
(30, 2, 3, '4948188', '', 'Mã khách hàng nước', '4948188'),
(31, 3, 3, '3254706', '', 'Mã khách hàng điện 1', '3254706'),
(32, 4, 3, '4169556', '', 'Mã khách hàng điện 2', '4169556'),
(33, 5, 3, '100000000', '', 'Tiền thuê nhà', '100000000'),
(34, 6, 3, '265000', '', 'Tiền Internet ', '265000'),
(35, 7, 3, '1000000', '', 'Cảnh Sát khu vực', '1000000'),
(36, 1, 4, NULL, NULL, 'Chi phí môi giới', NULL),
(37, 2, 4, '0', NULL, 'Mã khách hàng nước', '0'),
(38, 3, 4, '0', NULL, 'Mã khách hàng điện 1', '0'),
(39, 4, 4, '0', NULL, 'Mã khách hàng điện 2', '0'),
(40, 5, 4, '100000000', NULL, 'Tiền thuê nhà', '0'),
(41, 6, 4, '265000', NULL, 'Tiền Internet ', '0'),
(42, 7, 4, '1000000', NULL, 'Cảnh Sát khu vực', '0'),
(44, 1, 5, '2800000', NULL, 'Chi phí môi giới', '0'),
(45, 2, 5, '5033786', '', 'Mã khách hàng nước', '5033786'),
(46, 3, 5, '4772915', '', 'Mã khách hàng điện 1', '4772915'),
(47, 4, 5, '5815304', '', 'Mã khách hàng điện 2', '5815304'),
(48, 5, 5, '95000000', '', 'Tiền thuê nhà', '95000000'),
(49, 6, 5, '265000', '', 'Tiền Internet ', '265000'),
(50, 7, 5, '1000000', '', 'Cảnh Sát khu vực', '1000000'),
(51, NULL, 3, '1520000', '', 'Dọn vệ sinh', '1520000'),
(52, NULL, 3, '6000000', '', 'Lương quản lý', '6000000'),
(53, NULL, 3, '220000', '', 'Homestay', '220000'),
(54, NULL, 3, '400000', '', 'Rác', '400000'),
(55, NULL, 3, '2000000', '', 'Lương nhân viên code', '2000000'),
(56, NULL, 3, '1220000', '', 'Sơn phòng', '1220000'),
(57, NULL, 5, '2040000', '', 'Tiền dọn vệ sinh', '2040000'),
(58, NULL, 5, '8000000', '', 'Lương quản lý', '8000000'),
(59, NULL, 5, '400000', '', 'Tiền Rác', '400000'),
(60, NULL, 5, '2000000', '', 'Lương nhân viên code', '2000000'),
(61, 1, 6, '7000000', NULL, 'Chi phí môi giới', '0'),
(62, 2, 6, '0', NULL, 'Mã khách hàng nước', '0'),
(63, 3, 6, '0', NULL, 'Mã khách hàng điện 1', '0'),
(64, 4, 6, '0', NULL, 'Mã khách hàng điện 2', '0'),
(65, 5, 6, '100000000', '', 'Tiền thuê nhà', '100000000'),
(66, 6, 6, '265000', '', 'Tiền Internet ', '265000'),
(67, 7, 6, '1000000', '', 'Cảnh Sát khu vực', '1000000');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_chi_tiet_hoa_don`
--

CREATE TABLE `qlcvsd_chi_tiet_hoa_don` (
  `id` int(11) NOT NULL,
  `hoa_don_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `dich_vu_id` int(11) DEFAULT NULL,
  `don_gia` decimal(20,0) DEFAULT NULL,
  `so_luong` int(11) DEFAULT 0,
  `don_vi_tinh` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thanh_tien` decimal(20,0) DEFAULT NULL,
  `chi_so_cu` int(11) DEFAULT NULL,
  `anh` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT 'no-image.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_chi_tiet_hoa_don`
--

INSERT INTO `qlcvsd_chi_tiet_hoa_don` (`id`, `hoa_don_id`, `created`, `user_id`, `dich_vu_id`, `don_gia`, `so_luong`, `don_vi_tinh`, `thanh_tien`, `chi_so_cu`, `anh`) VALUES
(7458, 1543, '2025-05-05 20:38:50', 1, 2, NULL, 1921, NULL, '115500', 1888, 'no-image.jpg'),
(7459, 1543, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7460, 1543, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7461, 1543, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7462, 1543, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7463, 1543, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg'),
(7464, 1544, '2025-05-05 20:38:50', 1, 2, NULL, 0, NULL, '0', 1888, 'no-image.jpg'),
(7465, 1544, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7466, 1544, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7467, 1544, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7468, 1544, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7469, 1544, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg'),
(7470, 1545, '2025-05-05 20:38:50', 1, 2, NULL, 0, NULL, '0', 1888, 'no-image.jpg'),
(7471, 1545, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7472, 1545, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7473, 1545, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7474, 1545, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7475, 1545, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg'),
(7476, 1546, '2025-05-05 20:38:50', 1, 2, NULL, 0, NULL, '0', 1888, 'no-image.jpg'),
(7477, 1546, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7478, 1546, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7479, 1546, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7480, 1546, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7481, 1546, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg'),
(7482, 1547, '2025-05-05 20:38:50', 1, 2, NULL, 0, NULL, '0', 1888, 'no-image.jpg'),
(7483, 1547, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7484, 1547, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7485, 1547, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7486, 1547, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7487, 1547, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg'),
(7488, 1548, '2025-05-05 20:38:50', 1, 2, NULL, 0, NULL, '0', 1888, 'no-image.jpg'),
(7489, 1548, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7490, 1548, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7491, 1548, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7492, 1548, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7493, 1548, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg'),
(7494, 1549, '2025-05-05 20:38:50', 1, 2, NULL, 0, NULL, '0', 1888, 'no-image.jpg'),
(7495, 1549, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7496, 1549, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7497, 1549, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7498, 1549, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7499, 1549, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg'),
(7500, 1550, '2025-05-05 20:38:50', 1, 2, NULL, 0, NULL, '0', 1888, 'no-image.jpg'),
(7501, 1550, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7502, 1550, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7503, 1550, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7504, 1550, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7505, 1550, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg'),
(7506, 1551, '2025-05-05 20:38:50', 1, 2, NULL, 0, NULL, '0', 1888, 'no-image.jpg'),
(7507, 1551, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7508, 1551, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7509, 1551, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7510, 1551, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7511, 1551, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg'),
(7512, 1552, '2025-05-05 20:38:50', 1, 2, NULL, 0, NULL, '0', 1888, 'no-image.jpg'),
(7513, 1552, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7514, 1552, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7515, 1552, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7516, 1552, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7517, 1552, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg'),
(7518, 1553, '2025-05-05 20:38:50', 1, 2, NULL, 0, NULL, '0', 1888, 'no-image.jpg'),
(7519, 1553, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7520, 1553, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7521, 1553, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7522, 1553, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7523, 1553, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg'),
(7524, 1554, '2025-05-05 20:38:50', 1, 2, NULL, 0, NULL, '0', 1888, 'no-image.jpg'),
(7525, 1554, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7526, 1554, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7527, 1554, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7528, 1554, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7529, 1554, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg'),
(7530, 1555, '2025-05-05 20:38:50', 1, 2, NULL, 0, NULL, '0', 1888, 'no-image.jpg'),
(7531, 1555, '2025-05-05 20:38:50', 1, 3, NULL, 0, NULL, '200000', 40, 'no-image.jpg'),
(7532, 1555, '2025-05-05 20:38:50', 1, 4, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7533, 1555, '2025-05-05 20:38:50', 1, 5, NULL, 0, NULL, '100000', 0, 'no-image.jpg'),
(7534, 1555, '2025-05-05 20:38:50', 1, 6, NULL, 0, NULL, '30000', 0, 'no-image.jpg'),
(7535, 1555, '2025-05-05 20:38:50', 1, 7, NULL, 0, NULL, '0', 0, 'no-image.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_chi_tiet_o_cung`
--

CREATE TABLE `qlcvsd_chi_tiet_o_cung` (
  `id` int(11) NOT NULL,
  `nguoi_o_cung_id` int(11) DEFAULT NULL,
  `hoa_don_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_chi_tiet_o_cung`
--

INSERT INTO `qlcvsd_chi_tiet_o_cung` (`id`, `nguoi_o_cung_id`, `hoa_don_id`) VALUES
(811, 121, 1543),
(812, 121, 1544),
(813, 121, 1545),
(814, 121, 1546),
(815, 121, 1547),
(816, 121, 1548),
(817, 121, 1549),
(818, 121, 1550),
(819, 121, 1551),
(820, 121, 1552),
(821, 121, 1553),
(822, 121, 1554),
(823, 121, 1555);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_chuc_nang`
--

CREATE TABLE `qlcvsd_chuc_nang` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nhom` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller_action` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT 'webapp',
  `platform` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT 'browser',
  `method` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `screen_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_chuc_nang`
--

INSERT INTO `qlcvsd_chuc_nang` (`id`, `name`, `nhom`, `controller_action`, `type`, `platform`, `method`, `screen_name`, `action_name`) VALUES
(61, 'Quản lý chức năng', 'Quản lý chức năng', 'ChucNang;Index', 'webapp', 'browser', NULL, NULL, NULL),
(62, 'Lưu chức năng', 'Quản lý chức năng', 'ChucNang;Save', 'webapp', 'browser', NULL, NULL, NULL),
(63, 'Thêm chức năng', 'Quản lý chức năng', 'ChucNang;Create', 'webapp', 'browser', NULL, NULL, NULL),
(64, 'Sửa thông tin chức năng', 'Quản lý chức năng', 'ChucNang;Update', 'webapp', 'browser', NULL, NULL, NULL),
(65, 'Xoá thông tin chức năng', 'Quản lý chức năng', 'ChucNang;Delete', 'webapp', 'browser', NULL, NULL, NULL),
(66, 'Xem thông tin chức năng', 'Quản lý chức năng', 'ChucNang;View', 'webapp', 'browser', NULL, NULL, NULL),
(67, 'Quản lý danh mục chung', 'Danh mục', 'DanhMuc;Index', 'webapp', 'browser', NULL, NULL, NULL),
(68, 'Thêm danh mục chung', 'Danh mục', 'DanhMuc;Create', 'webapp', 'browser', NULL, NULL, NULL),
(69, 'Sửa thông tin danh mục', 'Danh mục', 'DanhMuc;Update', 'webapp', 'browser', NULL, NULL, NULL),
(70, 'Xoá danh mục chung', 'Danh mục', 'DanhMuc;Delete', 'webapp', 'browser', NULL, NULL, NULL),
(81, 'Danh sách vai trò', 'Vai trò', 'VaiTro;Index', 'webapp', 'browser', NULL, NULL, NULL),
(82, 'Tải thông tin phân quyền', 'Phân quyền', 'PhanQuyen;Getphanquyen', 'webapp', 'browser', NULL, NULL, NULL),
(83, 'Lưu thông tin phân quyền', 'Phân quyền', 'PhanQuyen;Save', 'webapp', 'browser', NULL, NULL, NULL),
(99, 'Thêm vai trò', 'Vai trò', 'VaiTro;Create', 'webapp', 'browser', NULL, NULL, NULL),
(100, 'Lưu thông tin vai trò', 'Vai trò', 'VaiTro;Save', 'webapp', 'browser', NULL, NULL, NULL),
(101, 'Sửa thông tin vai trò', 'Vai trò', 'VaiTro;Update', 'webapp', 'browser', NULL, NULL, NULL),
(102, 'Xoá thông tin vai trò', 'Vai trò', 'VaiTro;Delete', 'webapp', 'browser', NULL, NULL, NULL),
(124, 'Xem danh sách cấu hình', 'Cấu hình hệ thống', 'Cauhinh;Index', 'webapp', 'browser', NULL, NULL, NULL),
(125, 'Sửa thông tin cấu hình', 'Cấu hình hệ thống', 'Cauhinh;Update', 'webapp', 'browser', NULL, NULL, NULL),
(126, 'Xem chi tiết thông tin cấu hình', 'Cấu hình hệ thống', 'Cauhinh;View', 'webapp', 'browser', NULL, NULL, NULL),
(127, 'Tạo cấu hình mới', 'Cấu hình hệ thống', 'Cauhinh;Create', 'webapp', 'browser', NULL, NULL, NULL),
(138, 'Xem danh sách phân quyền', 'Phân quyền', 'PhanQuyen;Index', 'webapp', 'browser', NULL, NULL, NULL),
(181, 'Xem danh sách nhân sự', 'Người dùng', 'User;Index', 'webapp', 'browser', NULL, NULL, NULL),
(182, 'Xem thông tin người dùng', 'Người dùng', 'User;View', 'webapp', 'browser', NULL, NULL, NULL),
(183, 'Thêm người dùng', 'Người dùng', 'User;Create', 'webapp', 'browser', NULL, NULL, NULL),
(184, 'Cập nhật thông tin người dùng', 'Người dùng', 'User;Update', 'webapp', 'browser', NULL, NULL, NULL),
(185, 'Xóa thông tin người dùng', 'Người dùng', 'User;Delete', 'webapp', 'browser', NULL, NULL, NULL),
(186, 'Thay đổi trạng thái người dùng', 'Người dùng', 'User;Change-status', 'webapp', 'browser', NULL, NULL, NULL),
(187, 'Liệt kê người dùng', 'Người dùng', 'User;List', 'webapp', 'browser', NULL, NULL, NULL),
(247, 'Xem danh sách đơn hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Index', 'webapp', 'browser', NULL, NULL, NULL),
(248, 'Huỷ đơn hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Huy-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(249, 'Xem chi tiết đơn hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Chi-tiet-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(250, 'Cập nhật trạng thái đơn hàng tức thời trong bảng', 'Quản lý đơn hàng', 'QuanLyDonHang;Change-status-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(251, 'Xem danh sách giỏ hàng của tôi', 'Quản lý đơn hàng', 'QuanLyDonHang;Gio-hang', 'webapp', 'browser', NULL, NULL, NULL),
(252, 'Xem tất cả giỏ hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Xem-tat-ca-gio-hang', 'webapp', 'browser', NULL, NULL, NULL),
(253, 'Xem giỏ hàng mà khách hàng của tôi đã đặt', 'Quản lý đơn hàng', 'QuanLyDonHang;Xem-danh-sach-gio-hang-cua-khach-hang-cua-toi', 'webapp', 'browser', NULL, NULL, NULL),
(254, 'Update thông tin giỏ hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Update-gio-hang', 'webapp', 'browser', NULL, NULL, NULL),
(255, 'Cập nhật ghi chú đơn hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Save-ghi-chu-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(256, 'Lưu ghi chú chi tiết đơn hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Save-ghi-chu-chi-tiet-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(257, 'Xoá đơn hàng trong giỏ', 'Quản lý đơn hàng', 'QuanLyDonHang;Delete-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(258, 'Xoá chi tiết đơn hàng trong Giỏ hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Delete-chi-tiet-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(259, 'Thanh toán đơn hàng từ giỏ vào đơn hàng chính thức', 'Quản lý đơn hàng', 'QuanLyDonHang;Checkout', 'webapp', 'browser', NULL, NULL, NULL),
(261, 'Khởi tạo dữ liệu profile', 'Người dùng', 'User;Khoi-tao-du-lieu-profile', 'webapp', 'browser', NULL, NULL, NULL),
(262, 'Sinh mã QRCODE', 'Giao dịch', 'GiaoDich;Sinh-ma-qrcode', 'webapp', 'browser', NULL, NULL, NULL),
(263, 'Xác nhận chuyển khoản', 'Giao dịch', 'GiaoDich;Xac-nhan-chuyen-khoan', 'webapp', 'browser', NULL, NULL, NULL),
(264, 'Quản lý dữ liệu giao dịch', 'Giao dịch', 'GiaoDich;Index', 'webapp', 'browser', NULL, NULL, NULL),
(265, 'Duyệt / không duyệt giao dịch', 'Giao dịch', 'GiaoDich;Duyet-giao-dich', 'webapp', 'browser', NULL, NULL, NULL),
(266, 'Xem chi tiết giao dịch', 'Giao dịch', 'GiaoDich;View', 'webapp', 'browser', NULL, NULL, NULL),
(267, 'Huỷ giao dịch', 'Giao dịch', 'GiaoDich;Huy-giao-dich', 'webapp', 'browser', NULL, NULL, NULL),
(268, 'Tải danh sách sản phẩm đã đặt theo đơn hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Get-list-chi-tiet-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(270, 'Chọn đơn hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Chon-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(271, 'Tải dữ liệu id đơn hàng đã chọn', 'Quản lý đơn hàng', 'QuanLyDonHang;Get-don-hang-da-chon', 'webapp', 'browser', NULL, NULL, NULL),
(272, 'Bỏ chọn đơn hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Xoa-don-hang-da-chon', 'webapp', 'browser', NULL, NULL, NULL),
(273, 'LoadForm', 'Site', 'Site;Loadform', 'webapp', 'browser', NULL, NULL, NULL),
(274, 'Lưu trạng thái đơn hàng loạt', 'Quản lý đơn hàng', 'QuanLyDonHang;Luu-trang-thai-don-hang-loat', 'webapp', 'browser', NULL, NULL, NULL),
(275, 'Cập nhật mã vận đơn', 'Quản lý đơn hàng', 'QuanLyDonHang;Update-ma-van-don', 'webapp', 'browser', NULL, NULL, NULL),
(276, 'Updaet chi phí mua hộ', 'Quản lý đơn hàng', 'QuanLyDonHang;Update-phi-mua-ho', 'webapp', 'browser', NULL, NULL, NULL),
(277, 'Cập nhật khối lượng đơn hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Update-khoi-luong', 'webapp', 'browser', NULL, NULL, NULL),
(278, 'Cập nhật chi phí ship nội địa', 'Quản lý đơn hàng', 'QuanLyDonHang;Update-phi-ship-noi-dia', 'webapp', 'browser', NULL, NULL, NULL),
(279, 'Thanh toán thêm đơn hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Luu-thanh-toan-them', 'webapp', 'browser', NULL, NULL, NULL),
(280, 'Cập nhập giao dịch', 'Giao dịch', 'GiaoDich;Update', 'webapp', 'browser', NULL, NULL, NULL),
(281, 'Cập nhật thông tin cá nhân', 'Người dùng', 'User;Save-profile', 'webapp', 'browser', NULL, NULL, NULL),
(282, 'Xác nhận hoàn thành hợp đồng', 'Hợp đồng', 'PhongKhach;Hoan-thanh', 'webapp', 'browser', NULL, NULL, NULL),
(283, 'Quản lý tiền môi giới', 'Danh mục', 'DanhMuc;Moi-gioi', 'webapp', 'browser', NULL, NULL, NULL),
(284, 'Danh sách khách hàng', 'Quản lý khách hàng', 'User;Khach-hang', 'webapp', 'browser', NULL, NULL, NULL),
(285, 'Hủy giao dịch', 'Giao dịch', 'GiaoDich;Delete', 'webapp', 'browser', NULL, NULL, NULL),
(286, 'Thêm đơn hàng xuất khẩu', 'Đơn hàng', 'DonHang;Create-xuat', 'webapp', 'browser', NULL, NULL, NULL),
(287, 'Huỷ kích hoạt tài khoản', 'Người dùng', 'User;Huy-kich-hoat-tai-khoan-on-app', 'webapp', 'browser', NULL, NULL, NULL),
(288, 'Kích hoạt tài khoản', 'Người dùng', 'User;Kich-hoat-tai-khoan-on-app', 'webapp', 'browser', NULL, NULL, NULL),
(289, 'Đổi mật khẩu khách hàng', 'Người dùng', 'User;Doi-mat-khau-khach-hang', 'webapp', 'browser', NULL, NULL, NULL),
(290, 'Load thông tin khách hàng để sửa', 'Người dùng', 'User;Load-thong-tin-khach-hang', 'webapp', 'browser', NULL, NULL, NULL),
(291, 'Lưu thông tin mới của khách hàng', 'Người dùng', 'User;Update-thong-tin-khach-hang', 'webapp', 'browser', NULL, NULL, NULL),
(292, 'Khôi phục hoạt động của tài khoản', 'Người dùng', 'User;Mo-tai-khoan-on-app', 'webapp', 'browser', NULL, NULL, NULL),
(293, 'Khoá tài khoản khách hàng', 'Người dùng', 'User;Khoa-tai-khoan-on-app', 'webapp', 'browser', NULL, NULL, NULL),
(294, 'Thống kê công nợ', 'Hóa đơn', 'HoaDon;Cong-no', 'webapp', 'browser', NULL, NULL, NULL),
(295, 'Thống kê hóa đơn', 'Hóa đơn', 'HoaDon;Thong-ke', 'webapp', 'browser', NULL, NULL, NULL),
(296, 'Danh sách nạp tiền chờ duyệt', 'Giao dịch', 'GiaoDich;Get-list-nap-tien-cho-duyet', 'webapp', 'browser', NULL, NULL, NULL),
(297, 'Duyệt giao dịch nạp tiền', 'Giao dịch', 'GiaoDich;Duyet-giao-dich-nap-tien', 'webapp', 'browser', NULL, NULL, NULL),
(298, 'Danh sách giao dịch rút tiền chờ duyệt', 'Giao dịch', 'GiaoDich;Get-list-rut-tien-cho-duyet', 'webapp', 'browser', NULL, NULL, NULL),
(299, 'Duyệt giao dịch rút tiền', 'Giao dịch', 'GiaoDich;Duyet-giao-dich-rut-tien', 'webapp', 'browser', NULL, NULL, NULL),
(300, 'Tải thông tin ngân hàng', 'Hệ thống', 'User;Get-tai-khoan-ngan-hang', 'webapp', 'browser', NULL, NULL, NULL),
(301, 'Lưu thông tin tài khoản ngân hàng', 'Hệ thống', 'User;Luu-tai-khoan-ngan-hang', 'webapp', 'browser', NULL, NULL, NULL),
(302, 'Chi phí mua hàng hộ', 'Hệ thống', 'User;Get-cau-hinh-phi-mua-hang-ho', 'webapp', 'browser', NULL, NULL, NULL),
(303, 'Lưu thông tin phí mua hộ', 'Hệ thống', 'User;Save-cau-hinh-phi-mua-hang-ho', 'webapp', 'browser', NULL, NULL, NULL),
(304, 'Cấu hình chi phí vận chuyển theo line', 'Hệ thống', 'User;Get-cau-hinh-phi-van-chuyen', 'webapp', 'browser', NULL, NULL, NULL),
(306, 'Lưu thông tin cấu hình phí vận chuyển', 'Hệ thống', 'User;Save-cau-hinh-phi-van-chuyen', 'webapp', 'browser', NULL, NULL, NULL),
(307, 'Load thông tin cấu hình khác', 'Hệ thống', 'User;Get-thong-tin-cau-hinh', 'webapp', 'browser', NULL, NULL, NULL),
(308, 'Lưu thông tin cấu hình', 'Hệ thống', 'User;Save-thong-tin-cau-hinh', 'webapp', 'browser', NULL, NULL, NULL),
(309, 'Khách hàng tự huỷ đơn hàng', 'Đơn hàng', 'QuanLyDonHang;Huy-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(310, 'Cập nhật thông tin đơn hàng đã đặt', 'Đơn hàng', 'QuanLyDonHang;Update-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(311, 'Hoàn tiền đơn hàng', 'Đơn hàng', 'QuanLyDonHang;Hoan-tien-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(312, 'Yêu cầu giao hàng', 'Đơn hàng', 'QuanLyDonHang;Yeu-cau-giao-hang', 'webapp', 'browser', NULL, NULL, NULL),
(313, 'Get ngày tháng theo gói', 'Danh mục', 'DanhMuc;Get-ngay-thang', 'webapp', 'browser', NULL, NULL, NULL),
(314, 'Thêm ảnh số điện', 'Hóa đơn', 'HoaDon;Chon-anh', 'webapp', 'browser', NULL, NULL, NULL),
(315, 'Xóa ảnh số điện', 'Hóa đơn', 'HoaDon;Xoa-anh', 'webapp', 'browser', NULL, NULL, NULL),
(316, 'Get ở cùng hóa đơn', 'Hóa đơn', 'HoaDon;Get-o-cung', 'webapp', 'browser', NULL, NULL, NULL),
(317, 'Lưu người ở cùng', 'Hóa đơn', 'HoaDon;Save-o-cung', 'webapp', 'browser', NULL, NULL, NULL),
(318, 'Lưu chỉnh sửa hợp đồng', 'Hợp đồng', 'PhongKhach;Save-update', 'webapp', 'browser', NULL, NULL, NULL),
(319, 'Gửi lại nhắn giao dịch', 'Giao dịch', 'GiaoDich;Gui-tin-nhan', 'webapp', 'browser', NULL, NULL, NULL),
(320, 'Thống kê phòng', 'Danh mục', 'DanhMuc;Thong-ke-phong', 'webapp', 'browser', NULL, NULL, NULL),
(321, 'Thống kê môi giới', 'Danh mục', 'DanhMuc;Thong-ke-moi-gioi', 'webapp', 'browser', NULL, NULL, NULL),
(322, 'Update đã thanh toán môi giới', 'Danh mục', 'DanhMuc;Update-moi-gioi', 'webapp', 'browser', NULL, NULL, NULL),
(323, 'Quản lý chi phí', 'Danh mục', 'DanhMuc;Chi-phi', 'webapp', 'browser', NULL, NULL, NULL),
(324, 'Get giá nước khối', 'Danh mục', 'DanhMuc;Get-gia-nuoc-khoi', 'webapp', 'browser', NULL, NULL, NULL),
(325, 'Thống kê lợi nhuận', 'Danh mục', 'DanhMuc;Tong-hop', 'webapp', 'browser', NULL, NULL, NULL),
(326, 'Get List tuyến vận chuyển', 'Danh mục', 'DanhMuc;Get-list-tuyen-van-chuyen', 'webapp', 'browser', NULL, NULL, NULL),
(327, 'Lấy dữ liệu thống kê lợi nhuận', 'Danh mục', 'DanhMuc;Get-chart-data', 'webapp', 'browser', NULL, NULL, NULL),
(328, 'Xoá hóa đơn', 'Hóa đơn', 'HoaDon;Delete', 'webapp', 'browser', NULL, NULL, NULL),
(329, 'List trạng thái đơn ký gửi', 'Ký gửi', 'QuanLyDonKyGui;Get-list-trang-thai-don-ky-gui', 'webapp', 'browser', NULL, NULL, NULL),
(330, 'Thanh toán thêm đơn hàng ký gửi', 'Ký gửi', 'QuanLyDonKyGui;Thanh-toan-them-nhieu-don-hang-ky-gui', 'webapp', 'browser', NULL, NULL, NULL),
(331, 'Get danh sách ngắn hạn', 'Hóa đơn', 'HoaDon;Get-ngan-han', 'webapp', 'browser', NULL, NULL, NULL),
(332, 'Cập nhật trạng thái đơn ký gửi tức thời trong bảng', 'Ký gửi', 'QuanLyDonKyGui;Change-status-don-ky-gui', 'webapp', 'browser', NULL, NULL, NULL),
(333, 'Xem chi tiết đơn ký gửi', 'Ký gửi', 'QuanLyDonKyGui;Xem-chi-tiet-don-ky-gui', 'webapp', 'browser', NULL, NULL, NULL),
(334, 'Sửa đơn ký gửi', 'Ký gửi', 'QuanLyDonKyGui;Sua-don-ky-gui', 'webapp', 'browser', NULL, NULL, NULL),
(335, 'Chọn đơn ký gửi', 'Ký gửi', 'QuanLyDonKyGui;Chon-don-ky-gui', 'webapp', 'browser', NULL, NULL, NULL),
(336, 'Tải dữ liệu id đơn ký gửi đã chọn', 'Ký gửi', 'QuanLyDonKyGui;Get-don-ky-gui-da-chon', 'webapp', 'browser', NULL, NULL, NULL),
(337, 'Bỏ chọn đơn ký gửi', 'Ký gửi', 'QuanLyDonKyGui;Xoa-don-ky-gui-da-chon', 'webapp', 'browser', NULL, NULL, NULL),
(338, 'Lưu trạng thái đơn ký gửi hàng loạt', 'Ký gửi', 'QuanLyDonKyGui;Luu-trang-thai-don-ky-gui-hang-loat', 'webapp', 'browser', NULL, NULL, NULL),
(339, 'Thay đổi thông tin đơn ký gửi trên lưới', 'Ký gửi', 'QuanLyDonKyGui;Change-info-don-ky-gui', 'webapp', 'browser', NULL, NULL, NULL),
(340, 'Save tòa nhà phòng ở', 'Danh mục', 'DanhMuc;Save-phong', 'webapp', 'browser', NULL, NULL, NULL),
(341, 'Cập nhật thông tin người dùng', 'Site', 'Site;Update-profile', 'webapp', 'browser', NULL, NULL, NULL),
(342, 'Thêm khách hàng', 'Người dùng', 'User;Them-khach-hang', 'webapp', 'browser', NULL, NULL, NULL),
(343, 'Cập nhật thông tin khách hàng', 'Người dùng', 'User;Update-khach-hang', 'webapp', 'browser', NULL, NULL, NULL),
(344, 'Xóa giỏ hàng thành viên khác', 'Quản lý đơn hàng', 'QuanLyDonHang;Xoa-gio-hang-thanh-vien-khac', 'webapp', 'browser', NULL, NULL, NULL),
(345, 'Chọn thanh toán', 'Quản lý đơn hàng', 'QuanLyDonHang;Chon-thanh-toan', 'webapp', 'browser', NULL, NULL, NULL),
(346, 'Get đơn hàng thanh toán đã chọn', 'Quản lý đơn hàng', 'QuanLyDonHang;Get-don-hang-thanh-toan', 'webapp', 'browser', NULL, NULL, NULL),
(347, 'Thanh toán giỏ hàng trên web', 'Quản lý đơn hàng', 'QuanLyDonHang;Thanh-toan-gio-hang', 'webapp', 'browser', NULL, NULL, NULL),
(348, 'Chon chi tiết đơn hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Chon-chi-tiet-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(349, 'Thay đổi số lượng chi tiết đơn hàng', 'Quản lý đơn hàng', 'QuanLyDonHang;Change-quantity-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(350, 'Hoàn tiền đơn ký gửi', 'Ký gửi', 'QuanLyDonKyGui;Hoan-tien-don-hang', 'webapp', 'browser', NULL, NULL, NULL),
(351, 'Xóa đơn hàng đã chọn để thanh toán', 'Quản lý đơn hàng', 'QuanLyDonHang;Xoa-don-hang-da-chon-de-thanh-toan', 'webapp', 'browser', NULL, NULL, NULL),
(352, 'Xóa vai trò', 'Vai trò', 'VaiTro;Delete-vai-tro', 'webapp', 'browser', NULL, NULL, NULL),
(353, 'Xóa ảnh đại diện', 'Người dùng', 'User;Xoa-anh', 'webapp', 'browser', NULL, NULL, NULL),
(354, 'Xem danh sách hợp đồng', 'Hợp đồng', 'PhongKhach;Index', 'webapp', 'browser', NULL, NULL, NULL),
(355, 'Thêm mới hợp đồng', 'Hợp đồng', 'PhongKhach;Create', 'webapp', 'browser', NULL, NULL, NULL),
(356, 'Tìm phòng ở', 'Danh mục', 'DanhMuc;Tim-phong-o', 'webapp', 'browser', NULL, NULL, NULL),
(357, 'Xem đơn giá theo ID phòng', 'Danh mục', 'DanhMuc;Get-don-gia-phong', 'webapp', 'browser', NULL, NULL, NULL),
(358, 'Popup thêm khách hàng', 'Người dùng', 'User;Popup-khach-hang', 'webapp', 'browser', NULL, NULL, NULL),
(359, 'Xem chi tiết hợp đồng', 'Hợp đồng', 'PhongKhach;View', 'webapp', 'browser', NULL, NULL, NULL),
(360, 'Sửa hợp đồng', 'Hợp đồng', 'PhongKhach;Update', 'webapp', 'browser', NULL, NULL, NULL),
(361, 'Lưu thông tin hợp đồng', 'Hợp đồng', 'PhongKhach;Save-hop-dong', 'webapp', 'browser', NULL, NULL, NULL),
(362, 'Danh sách hóa đơn', 'Hóa đơn', 'HoaDon;Index', 'webapp', 'browser', NULL, NULL, NULL),
(363, 'Xem chi tiết hóa đơn', 'Hóa đơn', 'HoaDon;View', 'webapp', 'browser', NULL, NULL, NULL),
(364, 'Thêm mới hóa đơn', 'Hóa đơn', 'HoaDon;Create', 'webapp', 'browser', NULL, NULL, NULL),
(365, 'Get hóa đơn', 'Hóa đơn', 'HoaDon;Get-hoa-don', 'webapp', 'browser', NULL, NULL, NULL),
(366, 'Lập hóa đơn', 'Hóa đơn', 'HoaDon;Lap-hoa-don', 'webapp', 'browser', NULL, NULL, NULL),
(367, 'Xóa hợp đồng', 'Hợp đồng', 'PhongKhach;Delete', 'webapp', 'browser', NULL, NULL, NULL),
(368, 'Xóa file hợp đồng', 'Hợp đồng', 'PhongKhach;Xoa-file-hop-dong', 'webapp', 'browser', NULL, NULL, NULL),
(369, 'Thanh toán hợp đồng', 'Hợp đồng', 'PhongKhach;Thanh-toan', 'webapp', 'browser', NULL, NULL, NULL),
(370, 'Lưu giao dịch', 'Hợp đồng', 'PhongKhach;Save-giao-dich', 'webapp', 'browser', NULL, NULL, NULL),
(371, 'In hóa đơn', 'Hóa đơn', 'HoaDon;Print', 'webapp', 'browser', NULL, NULL, NULL),
(372, 'In hóa đơn theo tháng', 'Hóa đơn', 'HoaDon;In-theo-thang', 'webapp', 'browser', NULL, NULL, NULL),
(373, 'Kiểm tra thời gian sửa hợp đồng', 'Hợp đồng', 'PhongKhach;Kiem-tra', 'webapp', 'browser', NULL, NULL, NULL),
(374, 'Tòa nhà phòng ở', 'Danh mục', 'DanhMuc;Toa-nha-phong-o', 'webapp', 'browser', NULL, NULL, NULL),
(375, 'Chuyển khoản hợp đồng', 'Hợp đồng', 'PhongKhach;Chuyen-khoan', 'webapp', 'browser', NULL, NULL, NULL),
(376, 'Lập giao dịch hóa đơn', 'Hóa đơn', 'HoaDon;Thanh-toan', 'webapp', 'browser', NULL, NULL, NULL),
(377, 'Tạo mã QR hóa đơn', 'Hóa đơn', 'HoaDon;Lap-giao-dich', 'webapp', 'browser', NULL, NULL, NULL),
(378, 'Lấy số tiền tối thiểu', 'Hợp đồng', 'Cauhinh;Get-minimum', 'webapp', 'browser', NULL, NULL, NULL),
(379, 'Lấy danh sách hóa đơn', 'Hóa đơn', 'HoaDon;Get-list-hoa-don', 'webapp', 'browser', NULL, NULL, NULL),
(380, 'Lấy danh sách hợp đồng', 'Hợp đồng', 'PhongKhach;Get-list-hop-dong', 'webapp', 'browser', NULL, NULL, NULL),
(381, 'Cập nhập dịch vụ hóa đơn', 'Hóa đơn', 'HoaDon;Cap-nhap-dich-vu', 'webapp', 'browser', NULL, NULL, NULL),
(382, 'Thanh toán môi giới', 'Hợp đồng', 'PhongKhach;Thanh-toan-moi-gioi', 'webapp', 'browser', NULL, NULL, NULL),
(383, 'Lưu thanh toán môi giới', 'Hợp đồng', 'PhongKhach;Save-moi-gioi', 'webapp', 'browser', NULL, NULL, NULL),
(384, 'Quản lý chi phí', 'Danh mục', 'DanhMuc;View', 'webapp', 'browser', NULL, NULL, NULL),
(385, 'Get chi phí tòa nhà', 'Danh mục', 'DanhMuc;Get-chi-phi', 'webapp', 'browser', NULL, NULL, NULL),
(386, 'Xóa chi phí', 'Danh mục', 'DanhMuc;Xoa-chi-phi', 'webapp', 'browser', NULL, NULL, NULL),
(387, 'Lưu chi phí', 'Danh mục', 'DanhMuc;Luu-chi-phi', 'webapp', 'browser', NULL, NULL, NULL),
(388, 'Get tiền điện', 'Hợp đồng', 'PhongKhach;Get-tien-dien', 'webapp', 'browser', NULL, NULL, NULL),
(389, 'Update tòa nhà phòng ở', 'Danh mục', 'DanhMuc;Update-phong', 'webapp', 'browser', NULL, NULL, NULL),
(390, 'Xóa tòa nhà phòng ở', 'Danh mục', 'DanhMuc;Xoa-phong', 'webapp', 'browser', NULL, NULL, NULL),
(391, 'Thuê ngắn hạn', 'Hợp đồng', 'PhongKhach;Thue-ngan-han', 'webapp', 'browser', NULL, NULL, NULL),
(392, 'Get list trạng thái phòng', 'Hợp đồng', 'PhongKhach;Get-list-phong', 'webapp', 'browser', NULL, NULL, NULL),
(393, 'Đóng phòng', 'Hợp đồng', 'PhongKhach;Dong-phong', 'webapp', 'browser', NULL, NULL, NULL),
(394, 'Mở phòng', 'Hợp đồng', 'PhongKhach;Mo-phong', 'webapp', 'browser', NULL, NULL, NULL),
(395, 'Get khách hàng', 'Hợp đồng', 'PhongKhach;Get-khach-hang', 'webapp', 'browser', NULL, NULL, NULL),
(396, 'Get tiền theo phút', 'Hợp đồng', 'PhongKhach;Get-tien-theo-phut', 'webapp', 'browser', NULL, NULL, NULL),
(397, 'Lưu hợp đồng ngắn hạn', 'Hợp đồng', 'PhongKhach;Save-hop-dong-ngan-han', 'webapp', 'browser', NULL, NULL, NULL),
(398, 'Get form thông tin', 'Hợp đồng', 'PhongKhach;Get-form-thong-tin', 'webapp', 'browser', NULL, NULL, NULL),
(399, 'Get lịch đặt phòng', 'Hợp đồng', 'PhongKhach;Get-lich-dat', 'webapp', 'browser', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_danh_muc`
--

CREATE TABLE `qlcvsd_danh_muc` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('Toà nhà','Phòng ở') COLLATE utf8mb4_unicode_ci NOT NULL,
  `dai_han` tinyint(1) DEFAULT 1,
  `hide` tinyint(1) DEFAULT 0,
  `parent_id` int(11) DEFAULT NULL,
  `gia_dich_vu` text COLLATE utf8mb4_unicode_ci DEFAULT '[{"label":"Rác","name":"rac","value":"30000"},{"label":"Internet","name":"internet","value":"100000"},{"label":"Giặt","name":"giat","value":"100000"}]',
  `gia_thue_ngan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thu_tu` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) DEFAULT 1,
  `hinh_anh` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selected` tinyint(1) DEFAULT 0,
  `ghi_chu` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `don_gia` decimal(20,0) DEFAULT NULL,
  `gia_dien` int(11) DEFAULT 3500,
  `gia_nuoc` int(11) DEFAULT 15000,
  `so_dien` int(11) DEFAULT 0,
  `so_nuoc` int(11) DEFAULT 0,
  `gia_nuoc_nguoi` int(11) DEFAULT 100000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_danh_muc`
--

INSERT INTO `qlcvsd_danh_muc` (`id`, `name`, `type`, `dai_han`, `hide`, `parent_id`, `gia_dich_vu`, `gia_thue_ngan`, `thu_tu`, `active`, `hinh_anh`, `selected`, `ghi_chu`, `don_gia`, `gia_dien`, `gia_nuoc`, `so_dien`, `so_nuoc`, `gia_nuoc_nguoi`) VALUES
(9, 'Tòa 90D3', 'Toà nhà', 1, 0, NULL, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":\"30000\"},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":\"100000\"},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":\"100000\"}]', NULL, 0, 1, NULL, 1, NULL, NULL, 3500, 15000, 0, 0, 100000),
(10, 'K1', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":30000}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 1, NULL, '4400000', 3500, 15000, 1921, 40, 100000),
(11, 'K2', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":0},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 1, NULL, '5000000', 3500, 15000, 6334, 0, 100000),
(12, 'K3', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4300000', 3500, 15000, 1179, 0, 100000),
(13, 'K4', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4100000', 3500, 0, 2964, 0, 100000),
(14, '101', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":100000}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4600000', 3500, 15000, 2284, 0, 100000),
(15, '102', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4900000', 3500, 15000, 2460, 0, 100000),
(16, '103', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '3500000', 3500, 15000, 1388, 0, 70000),
(17, '104', 'Phòng ở', 1, 1, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":0},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":0},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":450000}', 0, 1, NULL, 0, NULL, '8000000', 0, 0, 0, 0, 0),
(18, '105', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":100000}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4000000', 3500, 15000, 0, 0, 100000),
(19, '106', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":100000}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4400000', 3500, 15000, 2675, 0, 100000),
(20, '107', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":100000}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4000000', 3500, 15000, 2388, 0, 100000),
(21, '108', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":100000}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4000000', 3500, 15000, 1408, 0, 70000),
(22, '201', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4600000', 3500, 15000, 2301, 0, 70000),
(23, '202', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":100000}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4800000', 3500, 15000, 3798, 0, 100000),
(24, '203', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4000000', 3500, 15000, 1866, 0, 100000),
(25, '204', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4500000', 3500, 15000, 2738, 0, 70000),
(26, '205', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":100000}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '3800000', 3500, 15000, 1870, 0, 100000),
(27, '206', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":100000}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4300000', 3500, 15000, 1820, 0, 100000),
(28, '207', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4100000', 3500, 15000, 2171, 0, 70000),
(29, '208', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4200000', 3500, 15000, 1868, 0, 70000),
(30, '301', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":\"30000\"},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":\"100000\"},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":\"100000\"}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 0, NULL, 0, NULL, '4700000', 3500, 15000, 0, 0, 100000),
(31, '302', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":\"30000\"},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":\"100000\"},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":\"100000\"}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 0, NULL, 0, NULL, '4600000', 3500, 15000, 0, 0, 100000),
(32, '303', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":\"30000\"},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":\"100000\"},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":\"100000\"}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 0, NULL, 0, NULL, '4000000', 3500, 15000, 0, 0, 100000),
(33, '304', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4500000', 3500, 15000, 2035, 0, 70000),
(34, '305', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4000000', 3500, 15000, 1231, 0, 70000),
(35, '306', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":100000}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 0, NULL, '4300000', 3500, 15000, 2130, 0, 100000),
(36, '307', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":100000}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 1, NULL, '4000000', 3500, 15000, 3352, 0, 70000),
(37, '308', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":100000}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":500000}', 0, 1, NULL, 1, NULL, '4400000', 3500, 15000, 2623, 0, 100000),
(38, '309', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":\"30000\"},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":\"100000\"},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":\"100000\"}]', '{\"3_gio\":200000,\"6_gio\":350000,\"ngay\":500000}', 0, 0, NULL, 0, NULL, '9000000', 3500, 15000, 0, 0, 100000),
(39, '301', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":450000}', 0, 0, NULL, 0, NULL, '4700000', 3500, 15000, 1842, 0, 100000),
(40, '302', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":450000}', 0, 1, NULL, 0, NULL, '4600000', 3500, 15000, 1578, 0, 100000),
(41, '303', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":250000,\"6_gio\":350000,\"ngay\":450000}', 0, 1, NULL, 0, NULL, '4000000', 3500, 15000, 1700, 0, 100000),
(42, '301', 'Phòng ở', 1, 0, 9, '[{\"label\":\"Rác\",\"name\":\"rac\",\"value\":30000},{\"label\":\"Internet\",\"name\":\"internet\",\"value\":100000},{\"label\":\"Giặt\",\"name\":\"giat\",\"value\":0}]', '{\"3_gio\":0,\"6_gio\":0,\"ngay\":0}', 0, 1, NULL, 0, NULL, '4700000', 3500, 15000, 1960, 0, 100000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_file_hop_dong`
--

CREATE TABLE `qlcvsd_file_hop_dong` (
  `id` int(11) NOT NULL,
  `phong_khach_id` int(11) DEFAULT NULL,
  `file` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_giao_dich`
--

CREATE TABLE `qlcvsd_giao_dich` (
  `id` int(11) NOT NULL,
  `khach_hang_id` int(11) DEFAULT NULL,
  `trang_thai_giao_dich` enum('Khởi tạo','Hoàn thành','Thành công','Không thành công','Chờ duyệt huỷ','Đã huỷ') COLLATE utf8mb4_unicode_ci DEFAULT 'Khởi tạo',
  `tong_tien` decimal(20,0) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `so_tien_giao_dich` decimal(20,0) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `phong_khach_id` int(11) NOT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `giao_dich_old_id` int(11) DEFAULT NULL,
  `loai_giao_dich` enum('Thanh toán hợp đồng','Phí môi giới') COLLATE utf8mb4_unicode_ci NOT NULL,
  `anh_chuyen_khoan` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ma_qr` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hoa_don_id` int(11) DEFAULT NULL,
  `noi_dung_chuyen_khoan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ma_id_casso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_giao_dich`
--

INSERT INTO `qlcvsd_giao_dich` (`id`, `khach_hang_id`, `trang_thai_giao_dich`, `tong_tien`, `active`, `so_tien_giao_dich`, `user_id`, `created`, `phong_khach_id`, `ghi_chu`, `giao_dich_old_id`, `loai_giao_dich`, `anh_chuyen_khoan`, `ma_qr`, `hoa_don_id`, `noi_dung_chuyen_khoan`, `ma_id_casso`) VALUES
(814, 127, 'Thành công', '4400000', 1, '4400000', 1, '2025-05-05 20:39:25', 283, NULL, NULL, 'Thanh toán hợp đồng', '1746452365pexels-zhuzichun-229759257-12086414.jpg', NULL, NULL, NULL, NULL),
(815, 127, 'Thành công', '4307758', 1, '4307758', 1, '2025-05-05 20:40:23', 283, NULL, NULL, 'Thanh toán hợp đồng', NULL, 'https://img.vietqr.io/image/BIDV-3131990666-compact2.png?amount=4307758&addInfo=GD%20815%20HD%201543&accountName=LE%20ANH%20TUAN', 1543, '', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_gia_dien`
--

CREATE TABLE `qlcvsd_gia_dien` (
  `id` int(11) NOT NULL,
  `bac_1` int(11) DEFAULT NULL,
  `bac_2` int(11) DEFAULT NULL,
  `bac_3` int(11) DEFAULT NULL,
  `bac_4` int(11) DEFAULT NULL,
  `bac_5` int(11) DEFAULT NULL,
  `bac_6` int(11) DEFAULT NULL,
  `ngay_bat_dau` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_gia_dien`
--

INSERT INTO `qlcvsd_gia_dien` (`id`, `bac_1`, `bac_2`, `bac_3`, `bac_4`, `bac_5`, `bac_6`, `ngay_bat_dau`) VALUES
(2, 1893, 1956, 2271, 286, 3197, 3302, '2024-10-11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_gia_nuoc`
--

CREATE TABLE `qlcvsd_gia_nuoc` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `luong_nuoc` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `don_gia` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thue` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_gia_nuoc`
--

INSERT INTO `qlcvsd_gia_nuoc` (`id`, `name`, `luong_nuoc`, `don_gia`, `thue`) VALUES
(1, 'Giá biểu 11/21', '0-4-6', '6700-12900-14400', 32),
(2, 'Giá biểu 15', '0-4', '6700-21300', 38);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_hoa_don`
--

CREATE TABLE `qlcvsd_hoa_don` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `thang` int(11) DEFAULT NULL,
  `nam` int(11) DEFAULT NULL,
  `phong_khach_id` int(11) DEFAULT NULL,
  `tien_phong` decimal(20,0) DEFAULT NULL,
  `chi_phi_dich_vu` decimal(20,0) DEFAULT NULL,
  `tong_tien` decimal(20,0) DEFAULT NULL,
  `da_thanh_toan` decimal(20,0) DEFAULT NULL,
  `chot_hoa_don` tinyint(1) DEFAULT 0,
  `active` tinyint(1) DEFAULT 1,
  `trang_thai` enum('Hoàn thành','Đã thanh toán','Chưa thanh toán') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Chưa thanh toán',
  `ma_hoa_don` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_nguoi` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_hoa_don`
--

INSERT INTO `qlcvsd_hoa_don` (`id`, `user_id`, `created`, `thang`, `nam`, `phong_khach_id`, `tien_phong`, `chi_phi_dich_vu`, `tong_tien`, `da_thanh_toan`, `chot_hoa_don`, `active`, `trang_thai`, `ma_hoa_don`, `so_nguoi`) VALUES
(1543, 1, '2025-05-05 20:38:50', 5, 2025, 283, '3832258', '475500', '4307758', '4307758', 1, 1, 'Đã thanh toán', 'B001412', 2),
(1544, 1, '2025-05-05 20:38:50', 6, 2025, 283, '4400000', '360000', '4760000', '0', 0, 1, 'Chưa thanh toán', 'B001413', 2),
(1545, 1, '2025-05-05 20:38:50', 7, 2025, 283, '4400000', '360000', '4760000', '0', 0, 1, 'Chưa thanh toán', 'B001414', 2),
(1546, 1, '2025-05-05 20:38:50', 8, 2025, 283, '4400000', '360000', '4760000', '0', 0, 1, 'Chưa thanh toán', 'B001415', 2),
(1547, 1, '2025-05-05 20:38:50', 9, 2025, 283, '4400000', '360000', '4760000', '0', 0, 1, 'Chưa thanh toán', 'B001416', 2),
(1548, 1, '2025-05-05 20:38:50', 10, 2025, 283, '4400000', '360000', '4760000', '0', 0, 1, 'Chưa thanh toán', 'B001417', 2),
(1549, 1, '2025-05-05 20:38:50', 11, 2025, 283, '4400000', '360000', '4760000', '0', 0, 1, 'Chưa thanh toán', 'B001418', 2),
(1550, 1, '2025-05-05 20:38:50', 12, 2025, 283, '4400000', '360000', '4760000', '0', 0, 1, 'Chưa thanh toán', 'B001419', 2),
(1551, 1, '2025-05-05 20:38:50', 1, 2026, 283, '4400000', '360000', '4760000', '0', 0, 1, 'Chưa thanh toán', 'B001420', 2),
(1552, 1, '2025-05-05 20:38:50', 2, 2026, 283, '4400000', '360000', '4760000', '0', 0, 1, 'Chưa thanh toán', 'B001421', 2),
(1553, 1, '2025-05-05 20:38:50', 3, 2026, 283, '4400000', '360000', '4760000', '0', 0, 1, 'Chưa thanh toán', 'B001422', 2),
(1554, 1, '2025-05-05 20:38:50', 4, 2026, 283, '4400000', '360000', '4760000', '0', 0, 1, 'Chưa thanh toán', 'B001423', 2),
(1555, 1, '2025-05-05 20:38:50', 5, 2026, 283, '709677', '360000', '1069677', '0', 0, 1, 'Chưa thanh toán', 'B001424', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_nguoi_o_cung`
--

CREATE TABLE `qlcvsd_nguoi_o_cung` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dien_thoai` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hop_dong_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_nguoi_o_cung`
--

INSERT INTO `qlcvsd_nguoi_o_cung` (`id`, `ho_ten`, `dien_thoai`, `hop_dong_id`) VALUES
(1, 'Phạm An', '0883757473', 123),
(2, 'Phạm Bình', '0948675757', 123),
(3, 'Nguyễn Văn P', '0498675744', 103),
(5, 'Nguyễn Thành Trung', '0438573724', 124),
(9, '', '', 136),
(10, 'Nguyễn văn A', '058847675', 142),
(12, 'Nguyễn Văn B', '0568754777', 145),
(14, 'Nguyễn Văn B', '067857887', 148),
(27, 'Ngô Bảo Khang', '0458765856', 125),
(30, 'Ngô Văn Cường', '056865767', 125),
(34, 'Nguyễn Văn A', '084537463', 157),
(35, 'Nguyeksahò', 'e46757587', 159),
(36, 'Pham van a', '049684576', 160),
(37, 'Nguyễn Văn A', '095687565', 161),
(38, 'A', '', 162),
(39, 'A', '', 163),
(40, 'A', '', 164),
(41, 'A', '', 165),
(42, 'A', '', 166),
(43, 'A', '', 167),
(44, 'A', '', 168),
(45, 'A', '', 169),
(46, 'A', '', 170),
(47, 'A', '', 171),
(48, 'A', '', 172),
(49, 'A', '', 173),
(50, 'A', '', 174),
(51, 'A', '', 175),
(52, 'A', '', 176),
(53, 'A', '', 177),
(54, 'A', '', 178),
(55, 'A', '', 180),
(56, 'A', '', 182),
(57, 'A', '', 183),
(58, 'A', '', 185),
(59, 'A', '', 186),
(60, 'A', '', 187),
(61, 'A', '', 189),
(62, 'A', '', 190),
(63, 'A', '', 191),
(64, 'A', '', 197),
(65, 'A', '', 201),
(66, 'A', '', 202),
(67, 'A', '', 204),
(68, 'A', '', 207),
(69, 'A', '', 208),
(70, 'A', '', 211),
(71, 'A', '', 213),
(72, 'A', '', 214),
(73, 'A', '', 224),
(74, 'A', '', 225),
(75, 'A', '', 226),
(76, 'A', '', 227),
(77, 'A', '', 228),
(78, 'A', '', 231),
(79, 'A', '', 233),
(80, 'A', '', 234),
(82, 'A', '', 241),
(83, 'A', '', 242),
(84, 'A', '', 245),
(85, 'A', '', 246),
(86, 'Nhân', '', 247),
(87, 'Nhân', '', 248),
(88, 'Nhân', '', 249),
(89, 'Nhân', '', 250),
(90, 'A', '', 251),
(91, 'Nhân', '', 253),
(92, 'Nhân', '', 254),
(93, 'A', '', 255),
(94, 'A', '', 256),
(95, 'Nhân', '', 257),
(96, 'Nhân', '', 258),
(97, 'A', '', 259),
(98, 'A', '', 260),
(99, 'A', '', 261),
(100, 'A', '', 262),
(101, 'A', '', 263),
(102, 'A', '', 264),
(103, 'A', '', 265),
(104, 'A', '', 266),
(105, 'A', '', 267),
(106, 'A', '', 268),
(107, 'A', '', 269),
(108, 'A', '', 270),
(109, 'A', '', 271),
(110, 'A', '', 274),
(111, 'A', '', 275),
(112, 'a', '', 273),
(113, 'a', '', 276),
(114, 'a', '', 277),
(115, 'A', '', 278),
(116, 'A', '', 279),
(117, 'A', '', 280),
(118, 'A', '', 188),
(119, 'a', '', 281),
(120, 'a', '', 282),
(121, 'A', '021213123213', 283);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_phan_quyen`
--

CREATE TABLE `qlcvsd_phan_quyen` (
  `id` int(11) NOT NULL,
  `chuc_nang_id` int(11) NOT NULL,
  `vai_tro_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_phan_quyen`
--

INSERT INTO `qlcvsd_phan_quyen` (`id`, `chuc_nang_id`, `vai_tro_id`) VALUES
(1971, 284, 1),
(1972, 284, 2),
(1973, 284, 4),
(1974, 284, 5),
(1975, 284, 6),
(2756, 300, 1),
(2757, 300, 2),
(2758, 300, 4),
(2759, 300, 5),
(2760, 300, 6),
(2761, 301, 1),
(2762, 301, 2),
(2763, 301, 4),
(2764, 301, 5),
(2765, 301, 6),
(2766, 302, 1),
(2767, 302, 2),
(2768, 302, 4),
(2769, 302, 5),
(2770, 302, 6),
(2771, 303, 1),
(2772, 303, 2),
(2773, 303, 4),
(2774, 303, 5),
(2775, 303, 6),
(2776, 304, 1),
(2777, 304, 2),
(2778, 304, 4),
(2779, 304, 5),
(2780, 304, 6),
(2781, 306, 1),
(2782, 306, 2),
(2783, 306, 4),
(2784, 306, 5),
(2785, 306, 6),
(2786, 307, 1),
(2787, 307, 2),
(2788, 307, 4),
(2789, 307, 5),
(2790, 307, 6),
(2791, 308, 1),
(2792, 308, 2),
(2793, 308, 4),
(2794, 308, 5),
(2795, 308, 6),
(3424, 124, 1),
(3425, 125, 1),
(3426, 126, 1),
(3427, 127, 1),
(3437, 61, 1),
(3438, 62, 1),
(3439, 63, 1),
(3440, 64, 1),
(3441, 65, 1),
(3442, 66, 1),
(4581, 286, 1),
(4582, 286, 2),
(4583, 286, 3),
(4584, 286, 5),
(4585, 286, 7),
(4586, 286, 8),
(4587, 309, 1),
(4588, 309, 7),
(4589, 309, 8),
(4590, 310, 1),
(4591, 311, 1),
(4592, 312, 7),
(4593, 312, 8),
(4623, 329, 1),
(4624, 329, 7),
(4625, 329, 8),
(4626, 330, 1),
(4627, 330, 2),
(4628, 330, 3),
(4629, 330, 5),
(4630, 330, 7),
(4631, 330, 8),
(4632, 332, 1),
(4633, 332, 2),
(4634, 332, 3),
(4635, 332, 5),
(4636, 333, 1),
(4637, 333, 2),
(4638, 333, 3),
(4639, 333, 5),
(4640, 333, 7),
(4641, 333, 8),
(4642, 334, 1),
(4643, 334, 7),
(4644, 334, 8),
(4645, 335, 1),
(4646, 335, 2),
(4647, 335, 3),
(4648, 335, 5),
(4649, 335, 7),
(4650, 335, 8),
(4651, 336, 1),
(4652, 336, 2),
(4653, 336, 3),
(4654, 336, 5),
(4655, 336, 7),
(4656, 336, 8),
(4657, 337, 1),
(4658, 337, 2),
(4659, 337, 3),
(4660, 337, 5),
(4661, 337, 7),
(4662, 337, 8),
(4663, 338, 1),
(4664, 338, 2),
(4665, 338, 3),
(4666, 338, 5),
(4667, 339, 1),
(4668, 339, 2),
(4669, 339, 3),
(4670, 339, 5),
(4671, 339, 7),
(4672, 339, 8),
(4673, 350, 1),
(4674, 350, 3),
(4675, 350, 5),
(4676, 247, 1),
(4677, 247, 2),
(4678, 247, 3),
(4679, 247, 5),
(4680, 247, 7),
(4681, 247, 8),
(4682, 248, 1),
(4683, 248, 2),
(4684, 248, 3),
(4685, 248, 5),
(4686, 248, 7),
(4687, 248, 8),
(4688, 249, 1),
(4689, 249, 2),
(4690, 249, 3),
(4691, 249, 5),
(4692, 249, 7),
(4693, 249, 8),
(4694, 250, 1),
(4695, 250, 2),
(4696, 250, 5),
(4697, 251, 1),
(4698, 251, 2),
(4699, 251, 3),
(4700, 251, 5),
(4701, 251, 7),
(4702, 251, 8),
(4703, 252, 1),
(4704, 252, 2),
(4705, 252, 3),
(4706, 252, 5),
(4707, 253, 1),
(4708, 253, 2),
(4709, 253, 3),
(4710, 253, 5),
(4711, 254, 1),
(4712, 254, 7),
(4713, 254, 8),
(4714, 255, 1),
(4715, 255, 7),
(4716, 255, 8),
(4717, 256, 1),
(4718, 256, 7),
(4719, 256, 8),
(4720, 257, 1),
(4721, 257, 7),
(4722, 257, 8),
(4723, 258, 1),
(4724, 258, 7),
(4725, 258, 8),
(4726, 259, 1),
(4727, 259, 7),
(4728, 259, 8),
(4729, 268, 1),
(4730, 268, 2),
(4731, 268, 3),
(4732, 268, 5),
(4733, 268, 7),
(4734, 268, 8),
(4735, 270, 1),
(4736, 270, 2),
(4737, 270, 3),
(4738, 270, 5),
(4739, 270, 7),
(4740, 270, 8),
(4741, 271, 1),
(4742, 271, 2),
(4743, 271, 3),
(4744, 271, 5),
(4745, 271, 7),
(4746, 271, 8),
(4747, 272, 1),
(4748, 272, 2),
(4749, 272, 3),
(4750, 272, 5),
(4751, 272, 7),
(4752, 272, 8),
(4753, 274, 1),
(4754, 274, 2),
(4755, 274, 3),
(4756, 274, 5),
(4757, 275, 1),
(4758, 275, 2),
(4759, 275, 3),
(4760, 275, 5),
(4761, 276, 1),
(4762, 276, 2),
(4763, 276, 3),
(4764, 276, 5),
(4765, 277, 1),
(4766, 277, 2),
(4767, 277, 3),
(4768, 277, 5),
(4769, 278, 1),
(4770, 278, 2),
(4771, 278, 3),
(4772, 278, 5),
(4773, 279, 1),
(4774, 279, 2),
(4775, 279, 3),
(4776, 279, 5),
(4777, 344, 1),
(4778, 344, 2),
(4779, 344, 3),
(4780, 344, 5),
(4781, 344, 7),
(4782, 344, 8),
(4783, 345, 1),
(4784, 345, 2),
(4785, 345, 3),
(4786, 345, 5),
(4787, 345, 7),
(4788, 345, 8),
(4789, 346, 1),
(4790, 346, 2),
(4791, 346, 3),
(4792, 346, 5),
(4793, 346, 7),
(4794, 346, 8),
(4795, 347, 1),
(4796, 347, 2),
(4797, 347, 3),
(4798, 347, 5),
(4799, 347, 7),
(4800, 347, 8),
(4801, 348, 1),
(4802, 348, 2),
(4803, 348, 3),
(4804, 348, 5),
(4805, 348, 7),
(4806, 348, 8),
(4807, 349, 1),
(4808, 349, 2),
(4809, 349, 3),
(4810, 349, 5),
(4811, 349, 7),
(4812, 349, 8),
(4813, 351, 1),
(4814, 351, 2),
(4815, 351, 3),
(4816, 351, 5),
(4817, 351, 7),
(4818, 351, 8),
(4819, 273, 1),
(4820, 273, 2),
(4821, 273, 3),
(4822, 273, 5),
(4823, 273, 7),
(4824, 273, 8),
(4825, 341, 1),
(4826, 341, 2),
(4827, 341, 3),
(4828, 341, 5),
(4829, 341, 7),
(4830, 341, 8),
(4906, 81, 2),
(4907, 99, 1),
(4908, 99, 2),
(4909, 100, 1),
(4910, 100, 2),
(4911, 101, 1),
(4912, 101, 2),
(4913, 102, 1),
(4914, 102, 2),
(4915, 352, 1),
(4916, 352, 2),
(4917, 82, 1),
(4918, 83, 1),
(4919, 138, 1),
(4968, 61, 1),
(4994, 181, 1),
(4995, 181, 2),
(4996, 182, 1),
(4997, 182, 2),
(4998, 183, 1),
(4999, 183, 2),
(5000, 184, 1),
(5001, 184, 2),
(5002, 185, 1),
(5003, 185, 2),
(5004, 186, 1),
(5005, 186, 2),
(5006, 187, 1),
(5007, 187, 2),
(5008, 261, 1),
(5009, 261, 2),
(5010, 261, 7),
(5011, 261, 8),
(5012, 281, 1),
(5013, 281, 2),
(5014, 281, 3),
(5015, 281, 5),
(5016, 281, 7),
(5017, 281, 8),
(5018, 287, 1),
(5019, 287, 2),
(5020, 288, 1),
(5021, 288, 2),
(5022, 289, 1),
(5023, 289, 2),
(5024, 289, 5),
(5025, 290, 1),
(5026, 290, 2),
(5027, 290, 5),
(5028, 291, 1),
(5029, 291, 2),
(5030, 291, 5),
(5031, 292, 1),
(5032, 292, 2),
(5033, 292, 5),
(5034, 293, 1),
(5035, 293, 2),
(5036, 293, 5),
(5037, 342, 1),
(5038, 342, 2),
(5039, 343, 1),
(5040, 343, 2),
(5041, 353, 1),
(5042, 358, 1),
(5736, 262, 1),
(5737, 263, 1),
(5738, 264, 1),
(5739, 265, 1),
(5740, 266, 1),
(5741, 267, 1),
(5742, 280, 1),
(5743, 285, 1),
(5744, 296, 1),
(5745, 297, 1),
(5746, 298, 1),
(5747, 299, 1),
(5748, 319, 1),
(5828, 282, 1),
(5829, 318, 1),
(5830, 354, 1),
(5831, 355, 1),
(5832, 359, 1),
(5833, 360, 1),
(5834, 361, 1),
(5835, 367, 1),
(5836, 368, 1),
(5837, 369, 1),
(5838, 370, 1),
(5839, 373, 1),
(5840, 375, 1),
(5841, 378, 1),
(5842, 380, 1),
(5843, 382, 1),
(5844, 383, 1),
(5845, 388, 1),
(5846, 391, 1),
(5847, 392, 1),
(5848, 393, 1),
(5849, 394, 1),
(5850, 395, 1),
(5851, 396, 1),
(5852, 397, 1),
(5853, 398, 1),
(5854, 399, 1),
(5981, 67, 1),
(5982, 68, 1),
(5983, 69, 1),
(5984, 70, 1),
(5985, 283, 1),
(5986, 313, 1),
(5987, 320, 1),
(5988, 321, 1),
(5989, 322, 1),
(5990, 323, 1),
(5991, 324, 1),
(5992, 325, 1),
(5993, 326, 1),
(5994, 327, 1),
(5995, 340, 1),
(5996, 356, 1),
(5997, 357, 1),
(5998, 374, 1),
(5999, 384, 1),
(6000, 385, 1),
(6001, 386, 1),
(6002, 387, 1),
(6003, 389, 1),
(6004, 390, 1),
(6005, 294, 1),
(6006, 295, 1),
(6007, 314, 1),
(6008, 315, 1),
(6009, 316, 1),
(6010, 317, 1),
(6011, 328, 1),
(6012, 331, 1),
(6013, 362, 1),
(6014, 363, 1),
(6015, 364, 1),
(6016, 365, 1),
(6017, 366, 1),
(6018, 371, 1),
(6019, 372, 1),
(6020, 376, 1),
(6021, 377, 1),
(6022, 379, 1),
(6023, 381, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_phieu_chi`
--

CREATE TABLE `qlcvsd_phieu_chi` (
  `id` int(11) NOT NULL,
  `thang` int(11) DEFAULT NULL,
  `nam` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT 1,
  `tong_tien` decimal(20,0) DEFAULT 0,
  `toa_nha_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_phieu_chi`
--

INSERT INTO `qlcvsd_phieu_chi` (`id`, `thang`, `nam`, `user_id`, `active`, `tong_tien`, `toa_nha_id`, `created`) VALUES
(1, 11, 2024, 1, 1, '105665000', 9, NULL),
(2, 2, 2025, 1, 1, '131627278', 9, '2025-02-16 21:17:24'),
(3, 3, 2025, 1, 1, '23732450', 9, '2025-03-20 07:26:49'),
(4, 1, 2025, 1, 1, '0', 9, '2025-03-20 07:36:17'),
(5, 4, 2025, 1, 1, '23062005', 9, '2025-03-24 11:00:34'),
(6, 5, 2025, 1, 1, '0', 9, '2025-05-05 17:18:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_phong_khach`
--

CREATE TABLE `qlcvsd_phong_khach` (
  `id` int(11) NOT NULL,
  `khach_hang_id` int(11) DEFAULT NULL,
  `phong_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `thoi_gian_hop_dong_tu` datetime DEFAULT NULL,
  `thoi_gian_hop_dong_den` datetime DEFAULT NULL,
  `coc_truoc` decimal(20,0) DEFAULT NULL,
  `trang_thai` enum('Hoàn thành','Chờ duyệt','Đã duyệt','Huỷ hợp đồng') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ma_hop_dong` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_thang_hop_dong` int(11) DEFAULT NULL,
  `don_gia` decimal(20,0) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `phong_cu_id` int(11) DEFAULT NULL,
  `chiet_khau` decimal(20,0) DEFAULT NULL,
  `kieu_chiet_khau` enum('%','số tiền') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_tien_chiet_khau` decimal(20,0) DEFAULT NULL,
  `ghi_chu` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thanh_tien` decimal(20,0) DEFAULT NULL,
  `da_thanh_toan` decimal(20,0) DEFAULT 0,
  `sale_id` int(11) DEFAULT NULL,
  `moi_gioi` decimal(20,0) DEFAULT NULL,
  `kieu_moi_gioi` enum('%','số tiền') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_tien_moi_gioi` decimal(20,0) DEFAULT NULL,
  `da_thanh_toan_moi_gioi` decimal(20,0) DEFAULT NULL,
  `gio_vao` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gio_ra` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loai_hop_dong` enum('3_gio','6_gio','ngay','thang') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_phong_khach`
--

INSERT INTO `qlcvsd_phong_khach` (`id`, `khach_hang_id`, `phong_id`, `user_id`, `created`, `thoi_gian_hop_dong_tu`, `thoi_gian_hop_dong_den`, `coc_truoc`, `trang_thai`, `ma_hop_dong`, `so_thang_hop_dong`, `don_gia`, `active`, `phong_cu_id`, `chiet_khau`, `kieu_chiet_khau`, `so_tien_chiet_khau`, `ghi_chu`, `thanh_tien`, `da_thanh_toan`, `sale_id`, `moi_gioi`, `kieu_moi_gioi`, `so_tien_moi_gioi`, `da_thanh_toan_moi_gioi`, `gio_vao`, `gio_ra`, `loai_hop_dong`) VALUES
(63, 35, 10, 1, '2024-09-20 14:46:10', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '6600000', 'Đã duyệt', 'HD00001', 9, '4400000', 0, NULL, '0', '%', '0', NULL, '45705610', '35385500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(64, 36, 11, 1, '2024-09-20 14:47:23', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '7500000', 'Đã duyệt', 'HD00002', 9, '5000000', 0, NULL, '0', '%', '0', NULL, '53950846', '43743000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(65, 36, 12, 1, '2024-09-20 14:51:59', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '6000000', 'Đã duyệt', 'HD00003', 9, '4300000', 0, NULL, '0', '%', '0', NULL, '41970974', '30372000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(66, 40, 15, 1, '2024-09-20 14:57:53', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '7200000', 'Đã duyệt', 'HD00004', 9, '4800000', 0, NULL, '0', '%', '0', NULL, '47930500', '38330500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(67, 39, 14, 1, '2024-09-20 14:58:52', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '6900000', 'Đã duyệt', 'HD00005', 9, '4600000', 0, NULL, '0', '%', '0', NULL, '46705500', '37505500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(68, 41, 16, 1, '2024-09-20 14:59:50', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '3500000', 'Đã duyệt', 'HD00006', 9, '3500000', 0, NULL, '0', '%', '0', NULL, '35220000', '28220000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(69, 42, 17, 1, '2024-09-20 15:00:59', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '6750000', 'Đã duyệt', 'HD00007', 9, '4500000', 0, NULL, '0', '%', '0', NULL, '45583000', '36583000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(70, 43, 18, 1, '2024-09-20 15:01:49', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '5700000', 'Đã duyệt', 'HD00008', 9, '3800000', 0, NULL, '0', '%', '0', NULL, '38732000', '31132000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(71, 63, 19, 1, '2024-09-20 15:03:36', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '4300000', 'Đã duyệt', 'HD00009', 9, '4400000', 0, NULL, '0', '%', '0', NULL, '45318000', '36518000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(72, 46, 21, 1, '2024-09-20 15:04:25', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '4000000', 'Đã duyệt', 'HD00010', 9, '4000000', 0, NULL, '0', '%', '0', NULL, '39445000', '31445000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(73, 47, 22, 1, '2024-09-20 15:05:13', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '6900000', 'Đã duyệt', 'HD00011', 9, '4600000', 0, NULL, '0', '%', '0', NULL, '46074500', '36874500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(74, 48, 23, 1, '2024-09-20 15:08:25', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '7200000', 'Đã duyệt', 'HD00012', 9, '4800000', 0, NULL, '0', '%', '0', NULL, '51354500', '41754500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(75, 64, 24, 1, '2024-09-20 15:09:38', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '3500000', 'Đã duyệt', 'HD00013', 9, '4100000', 0, NULL, '0', '%', '0', NULL, '39367500', '31167500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(76, 50, 25, 1, '2024-09-20 15:11:10', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '6750000', 'Đã duyệt', 'HD00014', 9, '4500000', 0, NULL, '0', '%', '0', NULL, '44976000', '35976000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(77, 65, 26, 1, '2024-09-20 15:14:48', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '5700000', 'Đã duyệt', 'HD00015', 9, '3900000', 0, NULL, '0', '%', '0', NULL, '35100000', '27300000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(78, 53, 28, 1, '2024-09-20 15:15:43', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '6150000', 'Đã duyệt', 'HD00016', 9, '4100000', 0, NULL, '0', '%', '0', NULL, '40455500', '32255500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(79, 54, 29, 1, '2024-09-20 15:16:24', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '4200000', 'Đã duyệt', 'HD00017', 9, '4200000', 0, NULL, '0', '%', '0', NULL, '42052000', '33652000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(80, 58, 33, 1, '2024-09-20 15:17:47', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '6750000', 'Đã duyệt', 'HD00018', 9, '4500000', 0, NULL, '0', '%', '0', NULL, '44439500', '35439500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(81, 66, 35, 1, '2024-09-20 15:19:31', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '4300000', 'Đã duyệt', 'HD00019', 9, '4300000', 0, NULL, '0', '%', '0', NULL, '40446500', '31846500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(82, 61, 36, 1, '2024-09-20 15:20:25', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '4000000', 'Đã duyệt', 'HD00020', 9, '4000000', 0, NULL, '0', '%', '0', NULL, '41874000', '33874000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(83, 37, 12, 1, '2024-09-20 15:33:12', '2024-06-01 00:00:00', '2024-02-15 00:00:00', '3500000', 'Đã duyệt', 'HD00021', 7, '4300000', 0, NULL, '0', '%', '0', NULL, '31432500', '22832500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(84, 38, 13, 1, '2024-09-20 15:40:22', '2024-06-01 00:00:00', '2024-12-31 00:00:00', '4700000', 'Đã duyệt', 'HD00022', 7, '4100000', 0, NULL, '0', '%', '0', NULL, '31986000', '23786000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(85, 44, 19, 1, '2024-09-20 15:42:45', '2024-06-01 00:00:00', '2025-03-01 00:00:00', '4400000', 'Đã duyệt', 'HD00023', 10, '4400000', 0, NULL, '0', '%', '0', NULL, '44000000', '22000000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(86, 45, 20, 1, '2024-09-20 15:43:56', '2024-06-01 00:00:00', '2024-12-31 00:00:00', '4000000', 'Đã duyệt', 'HD00024', 7, '4000000', 0, NULL, '0', '%', '0', NULL, '31963500', '23963500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(87, 49, 24, 1, '2024-09-20 15:45:59', '2024-06-01 00:00:00', '2025-02-01 00:00:00', '4100000', 'Đã duyệt', 'HD00025', 9, '4100000', 0, NULL, '0', '%', '0', NULL, '38267500', '21867500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(88, 52, 27, 1, '2024-09-20 15:46:59', '2024-06-01 00:00:00', '2024-12-31 00:00:00', '4300000', 'Đã duyệt', 'HD00026', 7, '4300000', 0, NULL, '0', '%', '0', NULL, '32873500', '24273500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(89, 55, 30, 1, '2024-09-20 15:50:21', '2024-06-01 00:00:00', '2025-07-01 00:00:00', '4700000', 'Đã duyệt', 'HD00027', 14, '4700000', 0, NULL, '0', '%', '0', NULL, '68817500', '26517500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(90, 56, 31, 1, '2024-09-20 15:51:52', '2024-06-01 00:00:00', '2025-06-01 00:00:00', '4600000', 'Đã duyệt', 'HD00028', 13, '4600000', 0, NULL, '0', '%', '0', NULL, '62152500', '25352500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(91, 57, 32, 1, '2024-09-20 15:52:42', '2024-06-01 00:00:00', '2025-06-01 00:00:00', '4000000', 'Đã duyệt', 'HD00029', 13, '4000000', 0, NULL, '0', '%', '0', NULL, '53053000', '21053000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(92, 59, 34, 1, '2024-09-20 15:53:46', '2024-06-01 00:00:00', '2024-12-31 00:00:00', '4000000', 'Đã duyệt', 'HD00030', 7, '4000000', 0, NULL, '0', '%', '0', NULL, '29571000', '21571000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(93, 60, 35, 1, '2024-09-20 15:55:01', '2024-06-01 00:00:00', '2024-12-01 00:00:00', '4300000', 'Đã duyệt', 'HD00031', 7, '4300000', 0, NULL, '0', '%', '0', NULL, '33346500', '24746500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(94, 62, 37, 1, '2024-09-20 15:56:01', '2024-06-01 00:00:00', '2024-12-31 00:00:00', '4400000', 'Đã duyệt', 'HD00032', 7, '4400000', 0, NULL, '0', '%', '0', NULL, '34865000', '26065000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(95, 67, 13, 1, '2024-09-20 16:01:02', '2024-05-01 00:00:00', '2024-12-31 00:00:00', '6900000', 'Đã duyệt', 'HD00033', 8, '4100000', 0, NULL, '0', '%', '0', NULL, '33657500', '25457500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(96, 51, 26, 1, '2024-09-22 21:57:12', '2024-06-01 00:00:00', '2024-12-31 00:00:00', '3900000', 'Đã duyệt', 'HD00034', 7, '3900000', 0, NULL, '0', '%', '0', NULL, '30507500', '22707500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(97, 68, 32, 1, '2024-09-22 22:05:59', '2024-09-01 00:00:00', '2025-06-01 00:00:00', '4000000', 'Đã duyệt', 'HD00035', 10, '4000000', 0, NULL, '0', '%', '0', NULL, '40815500', '8815500', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(98, 69, 13, 1, '2024-10-02 16:28:14', '2024-10-02 00:00:00', '2024-10-02 00:00:00', '2000000', 'Đã duyệt', 'HD00036', 1, '4100000', 0, NULL, '0', '%', '0', NULL, '4100000', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(99, 69, 13, 1, '2024-10-02 16:28:26', '2024-10-02 00:00:00', '2024-10-02 00:00:00', '2000000', 'Đã duyệt', 'HD00036', 1, '4100000', 0, NULL, '0', '%', '0', NULL, '4100000', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(100, 67, 10, 1, '2024-10-02 16:44:14', '2024-10-02 00:00:00', '2024-10-02 00:00:00', '0', 'Đã duyệt', 'HD00038', 1, '4400000', 0, NULL, '0', '%', '0', NULL, '5142010', '4400000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(101, 68, 11, 1, '2024-10-02 16:57:18', '2024-10-02 00:00:00', '2024-11-28 00:00:00', '0', 'Đã duyệt', 'HD00038', 2, '5000000', 0, NULL, '0', '%', '0', NULL, '12968974', '5000000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(102, 69, 15, 1, '2024-10-16 16:36:34', '2024-10-01 00:00:00', '2025-01-31 00:00:00', '0', 'Đã duyệt', 'HD00040', 4, '4800000', 0, NULL, '0', '%', '0', NULL, '19200000', '4800000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(103, 71, 10, 1, '2024-10-18 23:48:48', '2024-10-18 00:00:00', '2024-12-18 00:00:00', '0', 'Đã duyệt', 'HD00041', 3, '4400000', 0, NULL, '10', '%', '1320000', NULL, '15084548', '4400000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(104, 69, 31, 1, '2024-10-21 14:12:15', '2024-10-21 00:00:00', '2025-04-09 00:00:00', '10000000', 'Đã duyệt', 'HD00042', 7, '4600000', 0, NULL, '0', '%', '0', NULL, '32200000', '10000000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(105, 64, 12, 1, '2024-10-23 08:42:30', '2024-10-23 00:00:00', '2024-12-28 00:00:00', '0', 'Đã duyệt', 'HD00043', 3, '4300000', 0, NULL, '0', '%', '0', NULL, '12900000', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(106, 64, 12, 1, '2024-10-23 08:43:31', '2024-09-11 00:00:00', '2024-12-28 00:00:00', '0', 'Đã duyệt', 'HD00043', 4, '4300000', 0, 105, '0', '%', '0', NULL, '17200000', '8600000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(107, 63, 14, 1, '2024-10-23 08:48:51', '2024-10-23 00:00:00', '2024-10-23 00:00:00', '0', 'Đã duyệt', 'HD00044', 1, '4600000', 0, NULL, '0', '%', '0', NULL, '4600000', '4600000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(108, 71, 14, 1, '2024-10-30 15:52:28', '2024-10-30 00:00:00', '2025-09-30 00:00:00', '0', 'Đã duyệt', 'HD00045', 12, '4600000', 0, NULL, '10', '%', '5520000', NULL, '49680000', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(109, 71, 14, 1, '2024-10-30 17:32:17', '2024-10-30 00:00:00', '2025-09-30 00:00:00', '0', 'Đã duyệt', 'HD00045', 12, '4600000', 0, 108, '4000000', 'số tiền', '4000000', NULL, '55200000', '4600000', 74, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(110, 73, 12, 1, '2024-10-31 08:11:21', '2024-10-31 00:00:00', '2024-10-31 00:00:00', '0', 'Đã duyệt', 'HD00046', 1, '4300000', 0, NULL, '0', '%', '0', NULL, '4300000', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(111, 73, 12, 1, '2024-10-31 08:11:46', '2024-09-01 00:00:00', '2024-10-31 00:00:00', '0', 'Đã duyệt', 'HD00046', 2, '4300000', 0, 110, '0', '%', '0', NULL, '8600000', '8600000', 74, '1000000', 'số tiền', '1000000', '500000', NULL, NULL, 'thang'),
(112, 73, 12, 1, '2024-11-06 14:42:08', '2024-09-01 00:00:00', '2024-10-31 00:00:00', '0', 'Đã duyệt', 'HD00046', 2, '4300000', 0, 111, '0', '%', '0', NULL, '8600000', '0', 76, NULL, NULL, NULL, NULL, NULL, NULL, 'thang'),
(113, 75, 11, 1, '2024-11-07 14:49:41', '2024-11-07 00:00:00', '2024-11-07 00:00:00', '1000000', 'Đã duyệt', 'HD00047', 1, '5000000', 0, NULL, '10', '%', '500000', NULL, '4500000', '1000000', 76, '10', '%', '450000', '100000', NULL, NULL, 'thang'),
(114, 75, 11, 1, '2024-11-07 15:55:06', '2024-11-07 00:00:00', '2024-11-07 00:00:00', '1000000', 'Đã duyệt', 'HD00047', 1, '5000000', 0, 113, '10', '%', '500000', NULL, '4500000', '1000000', 76, '20', '%', '900000', '100000', NULL, NULL, 'thang'),
(115, 78, 37, 1, '2024-12-11 17:08:50', '2024-12-12 17:08:00', '1970-01-01 08:00:00', '900000', 'Đã duyệt', 'HD00048', NULL, '110000', 0, NULL, NULL, NULL, NULL, NULL, '1430000', '900000', NULL, NULL, NULL, NULL, NULL, '17:08', '06:00', 'thang'),
(116, 79, 36, 1, '2024-12-11 17:10:45', '1970-01-01 08:00:00', '1970-01-01 08:00:00', '100000', 'Đã duyệt', 'HD00049', NULL, '110000', 0, NULL, NULL, NULL, NULL, NULL, '1430000', '100000', NULL, NULL, NULL, NULL, NULL, '17:09', '06:00', 'thang'),
(117, 79, 14, 1, '2024-12-12 15:32:45', '2024-12-12 00:00:00', '2025-02-08 00:00:00', '0', 'Đã duyệt', 'HD00050', 3, '4600000', 0, NULL, '10', '%', '1380000', NULL, '12420000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(118, 78, 14, 1, '2024-12-12 15:57:04', '2024-12-12 00:00:00', '2025-02-13 00:00:00', '0', 'Đã duyệt', 'HD00051', 3, '4600000', 0, NULL, '0', '%', '0', NULL, '13800000', '0', 76, '2000000', 'số tiền', '2000000', '0', NULL, NULL, 'thang'),
(119, 78, 14, 1, '2024-12-12 15:57:06', '2024-12-12 00:00:00', '2025-02-13 00:00:00', '0', 'Đã duyệt', 'HD00052', 3, '4600000', 0, NULL, '0', '%', '0', NULL, '13800000', '0', 76, '2000000', 'số tiền', '2000000', '0', NULL, NULL, 'thang'),
(120, 80, 13, 1, '2024-12-12 16:04:01', '2024-12-12 00:00:00', '2025-01-16 00:00:00', '0', 'Đã duyệt', 'HD00053', 2, '4100000', 0, NULL, '0', '%', '0', NULL, '8200000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(121, 80, 13, 1, '2024-12-12 16:05:22', '2024-11-01 00:00:00', '2025-01-16 00:00:00', '0', 'Đã duyệt', 'HD00053', 3, '4100000', 0, 120, '0', '%', '0', NULL, '18478518', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(122, 73, 13, 1, '2024-12-12 17:10:11', '2024-12-12 00:00:00', '2024-12-12 00:00:00', '0', 'Đã duyệt', 'HD00054', 1, '4100000', 0, NULL, '0', '%', '0', NULL, '4100000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(123, 80, 14, 1, '2024-12-20 15:13:29', '2024-12-20 15:12:00', '2025-02-19 15:12:00', '3000000', 'Đã duyệt', 'HD00055', 3, '4600000', 0, NULL, '0', '%', '0', NULL, '13800000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(124, 35, 10, 1, '2024-12-23 09:34:41', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '6600000', 'Đã duyệt', 'HD00001', 9, '4400000', 0, 63, '0', '%', '0', NULL, '39600000', '6600000', 74, '0', '%', '0', '0', NULL, NULL, 'thang'),
(125, 36, 11, 1, '2024-12-23 11:03:08', '2024-04-01 00:00:00', '2024-12-31 00:00:00', '7500000', 'Đã duyệt', 'HD00002', 9, '5000000', 0, 64, '0', '%', '0', NULL, '46542510', '7500000', 74, '0', '%', '0', '0', NULL, NULL, 'thang'),
(126, 82, 12, 1, '2024-12-23 11:19:21', '2024-06-01 00:00:00', '2025-02-15 00:00:00', '4300000', 'Đã duyệt', 'HD00021', 9, '4300000', 0, 83, '0', '%', '0', NULL, '38700000', '4300000', 74, '0', '%', '0', '0', NULL, NULL, 'thang'),
(127, 83, 13, 1, '2024-12-23 11:52:29', '2024-06-01 00:00:00', '2025-05-01 00:00:00', '4700000', 'Đã duyệt', 'HD00022', 12, '4100000', 0, 84, '0', '%', '0', NULL, '49200000', '4700000', 74, '0', '%', '0', '0', NULL, NULL, 'thang'),
(128, 82, 11, 1, '2024-12-30 15:41:45', '2024-12-30 08:15:00', '2024-12-30 11:15:00', '0', 'Đã duyệt', 'HD00056', NULL, '250000', 0, NULL, '10', '%', '75000', NULL, '675000', '0', 74, '50', '%', '375000', '0', NULL, NULL, '3_gio'),
(129, 82, 11, 1, '2024-12-30 15:41:47', '2024-12-30 08:15:00', '2024-12-30 11:15:00', '0', 'Đã duyệt', 'HD00056', NULL, '250000', 0, NULL, '10', '%', '75000', NULL, '675000', '0', 74, '50', '%', '375000', '0', NULL, NULL, '3_gio'),
(130, 82, 11, 1, '2024-12-30 15:41:50', '2024-12-30 08:15:00', '2024-12-30 11:15:00', '0', 'Đã duyệt', 'HD00056', NULL, '250000', 0, NULL, '10', '%', '75000', NULL, '675000', '0', 74, '50', '%', '375000', '0', NULL, NULL, '3_gio'),
(131, 82, 11, 1, '2024-12-30 15:41:50', '2024-12-30 08:15:00', '2024-12-30 11:15:00', '0', 'Đã duyệt', 'HD00056', NULL, '250000', 0, NULL, '10', '%', '75000', NULL, '675000', '0', 74, '50', '%', '375000', '0', NULL, NULL, '3_gio'),
(132, 82, 11, 1, '2024-12-30 15:41:50', '2024-12-30 08:15:00', '2024-12-30 11:15:00', '0', 'Đã duyệt', 'HD00056', NULL, '250000', 0, NULL, '10', '%', '75000', NULL, '675000', '0', 74, '50', '%', '375000', '0', NULL, NULL, '3_gio'),
(133, 82, 11, 1, '2024-12-30 15:41:53', '2024-12-30 08:15:00', '2024-12-30 11:15:00', '0', 'Đã duyệt', 'HD00056', NULL, '250000', 0, NULL, '10', '%', '75000', NULL, '675000', '0', 74, '50', '%', '375000', '0', NULL, NULL, '3_gio'),
(134, 82, 11, 1, '2024-12-30 15:42:12', '2024-12-30 08:15:00', '2024-12-30 11:15:00', '0', 'Đã duyệt', 'HD00056', 1, '5000000', 0, NULL, '10', '%', '500000', NULL, '4500000', '0', 74, '50', '%', '2500000', '0', NULL, NULL, 'thang'),
(135, 82, 11, 1, '2024-12-30 15:42:16', '2024-12-30 08:15:00', '2024-12-30 11:15:00', '0', 'Đã duyệt', 'HD00056', 1, '5000000', 0, NULL, '10', '%', '500000', NULL, '4500000', '0', 74, '50', '%', '2500000', '0', NULL, NULL, 'thang'),
(136, 82, 11, 1, '2024-12-30 15:44:41', '2024-12-30 08:15:00', '2024-12-30 11:15:00', '0', 'Đã duyệt', 'HD00056', 1, '5000000', 0, NULL, '10', '%', '500000', NULL, '4500000', '0', 74, '50', '%', '2500000', '0', NULL, NULL, 'thang'),
(137, 82, 11, 1, '2024-12-30 15:46:00', '2024-12-30 15:15:00', '2024-12-30 21:15:00', '100000', 'Đã duyệt', 'HD00057', NULL, '350000', 0, NULL, '10', '%', '210000', NULL, '1890000', '0', 74, '10', '%', '210000', '0', NULL, NULL, '6_gio'),
(138, 78, 12, 1, '2024-12-30 15:49:16', '2024-12-30 15:15:00', '2024-12-30 21:15:00', '100000', 'Đã duyệt', 'HD00058', NULL, '350000', 0, NULL, '10', '%', '210000', NULL, '1890000', '0', 74, '50', '%', '1050000', '0', NULL, NULL, '6_gio'),
(139, 78, 12, 1, '2024-12-30 15:49:52', '2024-12-30 15:15:00', '2024-12-30 18:15:00', '100000', 'Đã duyệt', 'HD00058', NULL, '250000', 0, 138, '10', '%', '75000', NULL, '675000', '0', 74, '70', '%', '525000', '0', NULL, NULL, '3_gio'),
(140, 79, 11, 1, '2024-12-30 15:51:40', '2024-12-30 15:15:00', '2024-12-30 21:15:00', '100000', 'Đã duyệt', 'HD00059', NULL, '350000', 0, NULL, '10', '%', '210000', NULL, '1890000', '0', 74, '50', '%', '1050000', '0', NULL, NULL, '6_gio'),
(141, 79, 14, 1, '2024-12-30 15:52:11', '2024-12-30 15:15:00', '2024-12-30 18:15:00', '100000', 'Đã duyệt', 'HD00059', NULL, '250000', 0, 140, '10', '%', '75000', NULL, '675000', '0', 74, '70', '%', '525000', '0', NULL, NULL, '3_gio'),
(142, 81, 12, 1, '2024-12-30 15:53:19', '2024-12-30 15:15:00', '2025-04-29 15:15:00', '4000000', 'Đã duyệt', 'HD00060', 5, '4300000', 0, NULL, '10', '%', '2150000', NULL, '19350000', '0', 76, '70', '%', '15050000', '0', NULL, NULL, 'thang'),
(143, 81, 11, 1, '2024-12-30 16:21:19', '2024-12-30 16:16:00', '2024-12-30 22:16:00', '100000', 'Đã duyệt', 'HD00061', NULL, '350000', 0, NULL, '10', '%', '210000', NULL, '1890000', '0', 74, '50', '%', '1050000', '0', NULL, NULL, '6_gio'),
(144, 81, 13, 1, '2024-12-30 16:21:40', '2024-12-30 16:16:00', '2024-12-30 19:16:00', '100000', 'Đã duyệt', 'HD00061', NULL, '250000', 0, 143, '10', '%', '75000', NULL, '675000', '0', 74, '50', '%', '375000', '0', NULL, NULL, '3_gio'),
(145, 73, 24, 1, '2024-12-30 16:22:49', '2024-12-30 16:16:00', '2025-03-29 16:16:00', '2000000', 'Đã duyệt', 'HD00062', 4, '4100000', 0, NULL, '10', '%', '1640000', NULL, '14760000', '0', 76, '70', '%', '11480000', '0', NULL, NULL, 'thang'),
(146, 80, 12, 1, '2024-12-30 16:26:20', '2024-12-30 16:16:00', '2024-12-30 22:16:00', '100000', 'Đã duyệt', 'HD00063', NULL, '350000', 0, NULL, '10', '%', '210000', NULL, '1890000', '0', 74, '40', '%', '840000', '0', NULL, NULL, '6_gio'),
(147, 80, 26, 1, '2024-12-30 16:26:39', '2024-12-30 16:16:00', '2024-12-30 19:16:00', '100000', 'Đã duyệt', 'HD00063', NULL, '250000', 0, 146, '10', '%', '75000', NULL, '675000', '0', 74, '40', '%', '300000', '0', NULL, NULL, '3_gio'),
(148, 81, 21, 1, '2024-12-30 16:27:26', '2024-12-30 16:16:00', '2025-03-14 16:16:00', '2000000', 'Đã duyệt', 'HD00064', 4, '4000000', 0, NULL, '10', '%', '1600000', NULL, '14400000', '0', 74, '50', '%', '8000000', '0', NULL, NULL, 'thang'),
(149, 73, 12, 1, '2024-12-31 05:22:59', '2024-11-20 05:05:00', '2024-11-30 05:05:00', '0', 'Đã duyệt', 'HD00065', 1, '4300000', 0, NULL, '0', '%', '0', NULL, '6557846', '0', 74, '20', '%', '860000', '0', NULL, NULL, 'thang'),
(150, 82, 12, 1, '2024-12-31 11:06:57', '2024-11-01 11:11:00', '2024-11-30 14:11:00', '0', 'Đã duyệt', 'HD00066', 1, '4300000', 0, NULL, '0', '%', '0', NULL, '5842510', '0', 74, '0', '%', '0', '0', NULL, NULL, 'thang'),
(151, 73, 12, 1, '2024-12-31 14:46:01', '2024-11-20 05:05:00', '2024-11-30 05:05:00', '0', 'Đã duyệt', 'HD00065', 1, '4300000', 0, 149, '0', '%', '0', NULL, '5842510', '0', 74, '20', '%', '860000', '0', NULL, NULL, 'thang'),
(152, 73, 11, 1, '2024-12-31 14:47:16', '2024-11-01 14:14:00', '2024-11-30 14:14:00', '0', 'Đã duyệt', 'HD00067', 1, '5000000', 0, NULL, '0', '%', '0', NULL, '6542510', '2000', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(153, 78, 11, 1, '2024-12-31 16:18:36', '2024-12-31 16:16:00', '2024-12-31 22:16:00', '0', 'Đã duyệt', 'HD00068', NULL, '350000', 0, NULL, '10', '%', '210000', NULL, '1890000', '0', NULL, '0', '%', '0', '0', NULL, NULL, '6_gio'),
(154, 78, 11, 1, '2024-12-31 16:23:53', '2024-12-31 16:16:00', '2024-12-31 19:16:00', '0', 'Đã duyệt', 'HD00068', NULL, '250000', 0, 153, '10', '%', '75000', NULL, '675000', '0', NULL, '0', '%', '0', '0', NULL, NULL, '3_gio'),
(155, 78, 11, 1, '2024-12-31 16:24:52', '2024-12-31 16:16:00', '2025-01-03 19:16:00', '0', 'Đã duyệt', 'HD00068', NULL, '500000', 0, 154, '10', '%', '150000', NULL, '1350000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'ngay'),
(156, 81, 10, 1, '2025-01-02 14:41:10', '2025-01-02 14:14:00', '2025-03-13 14:14:00', '3000000', 'Đã duyệt', 'HD00069', 3, '4400000', 0, NULL, '10', '%', '1320000', NULL, '11880000', '0', 74, '50', '%', '2200000', '0', NULL, NULL, 'thang'),
(157, 82, 11, 1, '2025-01-05 23:03:09', '2024-12-02 23:23:00', '2024-12-03 05:23:00', '1000000', 'Đã duyệt', 'HD00070', 1, '5000000', 0, NULL, '0', '%', '0', NULL, '5000000', '0', 74, '50', '%', '2500000', '0', NULL, NULL, 'thang'),
(158, 81, 11, 1, '2025-01-05 23:20:41', '2024-12-10 23:23:00', '2024-12-11 05:23:00', '1000000', 'Đã duyệt', 'HD00071', 1, '5000000', 0, NULL, '10', '%', '500000', NULL, '4500000', '0', 76, '10', '%', '500000', '0', NULL, NULL, 'thang'),
(159, 81, 13, 1, '2025-01-05 23:45:21', '2024-12-10 23:23:00', '2025-02-19 05:23:00', '1000000', 'Đã duyệt', 'HD00072', 3, '4100000', 0, NULL, '10', '%', '1230000', NULL, '11070000', '0', 74, '10', '%', '410000', '0', NULL, NULL, 'thang'),
(160, 83, 14, 1, '2025-01-05 23:52:22', '2024-12-09 23:23:00', '2025-01-06 05:23:00', '2000000', 'Đã duyệt', 'HD00073', 2, '4600000', 0, NULL, '10', '%', '920000', NULL, '8280000', '0', 74, '10', '%', '460000', '0', NULL, NULL, 'thang'),
(161, 83, 10, 1, '2025-01-06 09:14:57', '2024-12-01 09:09:00', '2025-01-06 15:09:00', '2000000', 'Đã duyệt', 'HD00074', 2, '4400000', 0, NULL, '10', '%', '880000', NULL, '7920000', '0', 76, '50', '%', '2200000', '0', NULL, NULL, 'thang'),
(162, 35, 10, 1, '2025-01-06 10:14:43', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '6600000', 'Đã duyệt', 'HD00075', 6, '4400000', 0, NULL, '0', '%', '0', NULL, '26676500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(163, 35, 10, 1, '2025-01-06 10:35:41', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '6600000', 'Đã duyệt', 'HD00075', 6, '4400000', 0, NULL, '0', '%', '0', NULL, '26400000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(164, 35, 10, 1, '2025-01-06 10:39:19', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '6600000', 'Đã duyệt', 'HD00075', 6, '4400000', 0, 163, '0', '%', '0', NULL, '27100000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(165, 35, 10, 1, '2025-01-07 09:04:13', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '6600000', 'Đã duyệt', 'HD00075', 6, '4400000', 0, NULL, '0', '%', '0', NULL, '26400000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(166, 35, 10, 1, '2025-01-07 09:07:18', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '6600000', 'Đã duyệt', 'HD00075', 6, '4400000', 0, 165, '0', '%', '0', NULL, '26400000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(167, 35, 10, 1, '2025-01-07 09:10:07', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '6600000', 'Đã duyệt', 'HD00075', 6, '4400000', 0, 166, '0', '%', '0', NULL, '26400000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(168, 35, 10, 1, '2025-01-07 09:15:17', '2025-01-01 09:09:00', '2025-01-06 09:09:00', '4200000', 'Đã duyệt', 'HD00076', 1, '4400000', 0, NULL, '0', '%', '0', NULL, '4400000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(169, 35, 10, 1, '2025-01-07 09:41:09', '2025-01-01 09:09:00', '2025-01-06 09:09:00', '4200000', 'Đã duyệt', 'HD00076', 1, '4400000', 0, 168, '0', '%', '0', NULL, '4400000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(170, 35, 10, 1, '2025-01-07 09:44:42', '2025-01-01 09:09:00', '2025-06-01 09:09:00', '4400000', 'Đã duyệt', 'HD00076', 6, '4400000', 0, 169, '0', '%', '0', NULL, '26676500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(171, 35, 10, 1, '2025-01-07 09:51:55', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '6600000', 'Đã duyệt', 'HD00075', 6, '4400000', 0, 162, '0', '%', '0', NULL, '26676500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(172, 35, 10, 1, '2025-01-07 11:25:21', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '6600000', 'Đã duyệt', 'HD00075', 6, '4400000', 0, 171, '0', '%', '0', NULL, '26676500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(173, 35, 10, 1, '2025-01-07 20:51:00', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '6600000', 'Đã duyệt', 'HD00075', 6, '4400000', 0, 172, '0', '%', '0', NULL, '26400000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(174, 35, 10, 1, '2025-01-07 20:51:13', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '6600000', 'Đã duyệt', 'HD00075', 6, '4400000', 0, 173, '0', '%', '0', NULL, '28169000', '-1105000', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(175, 84, 11, 1, '2025-01-13 09:53:59', '2025-01-01 09:09:00', '2025-06-01 09:09:00', '7500000', 'Đã duyệt', 'HD00077', 6, '5000000', 0, NULL, '0', '%', '0', NULL, '35974500', '6479500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(176, 85, 12, 1, '2025-01-13 10:05:25', '2024-09-15 09:09:00', '2025-02-15 09:09:00', '0', 'Đã duyệt', 'HD00078', 6, '4300000', 0, NULL, '0', '%', '0', NULL, '26640000', '24133000', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(177, 86, 13, 1, '2025-01-13 10:09:32', '2025-01-01 10:10:00', '2025-05-01 10:10:00', '4700000', 'Hoàn thành', 'HD00079', 5, '4100000', 1, NULL, '0', '%', '0', NULL, '22719000', '-5419500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(178, 87, 15, 1, '2025-01-13 10:16:13', '2025-01-01 10:10:00', '2025-04-01 10:10:00', '4900000', 'Đã duyệt', 'HD00080', 4, '4900000', 0, NULL, '0', '%', '0', NULL, '19817000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(179, 87, 15, 1, '2025-01-13 10:18:07', '2025-01-01 10:10:00', '2025-04-01 10:10:00', '4900000', 'Đã duyệt', 'HD00080', 4, '4900000', 0, 178, '0', '%', '0', NULL, '20051500', '5447000', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(180, 88, 16, 1, '2025-01-13 10:21:49', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '3500000', 'Đã duyệt', 'HD00081', 6, '3500000', 0, NULL, '0', '%', '0', NULL, '22389500', '4011500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(181, 89, 19, 1, '2025-01-13 10:24:51', '2025-01-01 10:10:00', '2025-03-01 10:10:00', '4400000', 'Đã duyệt', 'HD00082', 3, '4400000', 0, NULL, '0', '%', '0', NULL, '13259500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(182, 89, 19, 1, '2025-01-13 10:25:46', '2025-01-01 10:10:00', '2025-03-01 10:10:00', '4400000', 'Đã duyệt', 'HD00082', 3, '4400000', 0, 181, '0', '%', '0', NULL, '13693500', '5239500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(183, 90, 20, 1, '2025-01-13 10:29:14', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '4000000', 'Đã duyệt', 'HD00083', 6, '4000000', 0, NULL, '0', '%', '0', NULL, '26800000', '5007500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(184, 91, 21, 1, '2025-01-13 10:32:36', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '4000000', 'Đã duyệt', 'HD00084', 6, '4000000', 0, NULL, '0', '%', '0', NULL, '25148500', '4384000', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(185, 92, 22, 1, '2025-01-13 10:37:22', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '6900000', 'Đã duyệt', 'HD00085', 6, '4600000', 0, NULL, '0', '%', '0', NULL, '29080500', '5206000', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(187, 94, 24, 1, '2025-01-13 10:45:39', '2025-01-01 10:10:00', '2025-02-01 10:10:00', '4100000', 'Đã duyệt', 'HD00087', 2, '4100000', 0, NULL, '0', '%', '0', NULL, '8455500', '4785500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(188, 95, 25, 1, '2025-01-13 10:48:24', '2025-01-01 10:10:00', '2025-05-01 10:10:00', '6750000', 'Đã duyệt', 'HD00088', 5, '4500000', 0, NULL, '0', '%', '0', NULL, '25202500', '5144500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(189, 96, 26, 1, '2025-01-13 10:51:12', '2025-01-04 10:10:00', '2025-12-04 10:10:00', '3800000', 'Đã duyệt', 'HD00089', 12, '3900000', 0, NULL, '0', '%', '0', NULL, '47188500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(190, 96, 26, 1, '2025-01-13 10:52:41', '2025-01-04 10:10:00', '2025-12-04 10:10:00', '3800000', 'Đã duyệt', 'HD00089', 12, '3800000', 0, 189, '0', '%', '0', NULL, '47994000', '4618500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(191, 97, 27, 1, '2025-01-13 11:00:47', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '4300000', 'Đã duyệt', 'HD00090', 6, '4300000', 0, NULL, '0', '%', '0', NULL, '27508000', '5069500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(192, 98, 28, 1, '2025-01-13 11:04:55', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '6150000', 'Đã duyệt', 'HD00091', 6, '4100000', 0, NULL, '0', '%', '0', NULL, '26870000', '4716500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(193, 99, 29, 1, '2025-01-13 11:07:41', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '4200000', 'Đã duyệt', 'HD00092', 6, '4200000', 0, NULL, '0', '%', '0', NULL, '25462500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(194, 99, 29, 1, '2025-01-13 11:08:28', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '4200000', 'Đã duyệt', 'HD00092', 6, '4200000', 0, 193, '0', '%', '0', NULL, '26920500', '4662500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(195, 100, 39, 1, '2025-01-13 11:23:27', '2025-01-01 11:11:00', '2025-01-07 11:11:00', '4700000', 'Đã duyệt', 'HD00093', 1, '4700000', 0, NULL, '0', '%', '0', NULL, '4700000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(196, 100, 39, 1, '2025-01-13 11:24:11', '2025-01-01 11:11:00', '2025-01-07 11:11:00', '4700000', 'Đã duyệt', 'HD00093', 1, '4700000', 0, 195, '0', '%', '0', NULL, '4752500', '4982500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(197, 101, 40, 1, '2025-01-13 11:28:53', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '4600000', 'Đã duyệt', 'HD00094', 6, '4600000', 0, NULL, '0', '%', '0', NULL, '28055000', '5271500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(198, 102, 41, 1, '2025-01-13 11:32:21', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '4000000', 'Đã duyệt', 'HD00095', 6, '4000000', 0, NULL, '0', '%', '0', NULL, '26201500', '4587000', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(199, 103, 33, 1, '2025-01-13 11:35:11', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '6750000', 'Đã duyệt', 'HD00096', 6, '4500000', 0, NULL, '0', '%', '0', NULL, '27605500', '5200500', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(201, 106, 36, 1, '2025-01-13 11:47:11', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '4000000', 'Đã duyệt', 'HD00098', 6, '4000000', 0, NULL, '0', '%', '0', NULL, '28413500', '5140000', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(202, 107, 37, 1, '2025-01-13 11:49:46', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '4400000', 'Đã duyệt', 'HD00099', 6, '4400000', 0, NULL, '0', '%', '0', NULL, '29564000', '5390000', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(203, 108, 17, 1, '2025-01-16 09:38:53', '2025-01-03 09:09:00', '2025-01-15 09:09:00', '0', 'Đã duyệt', 'HD00100', 1, '8000000', 0, NULL, '0', '%', '0', NULL, '8000000', '8000000', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(204, 110, 14, 1, '2025-01-26 20:12:38', '2025-01-26 20:20:00', '2025-06-26 20:20:00', '0', 'Đã duyệt', 'HD00101', 6, '4600000', 0, NULL, '0', '%', '0', NULL, '27600000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(205, 100, 42, 1, '2025-02-05 21:46:02', '2025-01-01 21:21:00', '2025-06-01 21:21:00', '0', 'Đã duyệt', 'HD00102', 6, '4700000', 0, NULL, '0', '%', '0', NULL, '28207000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(206, 100, 42, 1, '2025-02-05 21:52:00', '2025-01-02 21:21:00', '2025-06-02 21:21:00', '0', 'Đã duyệt', 'HD00102', 6, '4700000', 0, 205, '0', '%', '0', NULL, '29477500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(207, 101, 40, 1, '2025-02-05 22:02:48', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '4600000', 'Đã duyệt', 'HD00094', 6, '4600000', 0, 197, '0', '%', '0', NULL, '27813500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(208, 101, 40, 1, '2025-02-05 22:05:11', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '4600000', 'Đã duyệt', 'HD00094', 6, '4600000', 0, 207, '0', '%', '0', NULL, '28013000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(209, 103, 33, 1, '2025-02-05 22:11:20', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '6750000', 'Đã duyệt', 'HD00096', 6, '4500000', 0, 199, '0', '%', '0', NULL, '29084500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(210, 111, 15, 1, '2025-02-16 20:06:39', '2025-03-01 20:20:00', '2026-03-01 20:20:00', '4900000', 'Đã duyệt', 'HD00103', 13, '4900000', 0, NULL, '0', '%', '0', NULL, '63700000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(211, 112, 35, 1, '2025-02-16 20:12:39', '2025-03-01 20:20:00', '2026-02-01 20:20:00', '0', 'Đã duyệt', 'HD00104', 12, '4300000', 0, NULL, '0', '%', '0', NULL, '51600000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(212, 113, 14, 1, '2025-02-16 20:14:57', '2025-03-01 20:20:00', '2026-02-01 20:20:00', '4600000', 'Đã duyệt', 'HD00105', 12, '4600000', 0, NULL, '0', '%', '0', NULL, '55200000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(213, 112, 35, 1, '2025-02-16 20:19:15', '2025-03-02 20:20:00', '2026-02-02 20:20:00', '4400000', 'Đã duyệt', 'HD00104', 12, '4300000', 0, 211, '0', '%', '0', NULL, '51600000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(214, 112, 35, 1, '2025-02-16 20:19:23', '2025-03-02 20:20:00', '2026-02-02 20:20:00', '4400000', 'Đã duyệt', 'HD00104', 12, '4300000', 0, 211, '0', '%', '0', NULL, '51600000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(215, 113, 10, 1, '2025-02-16 23:36:03', '2025-02-16 23:23:00', '2025-03-31 23:23:00', '0', 'Đã duyệt', 'HD00106', 2, '4400000', 0, NULL, '0', '%', '0', NULL, '8800000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(216, 113, 10, 1, '2025-02-16 23:36:11', '2025-02-16 23:23:00', '2025-03-31 23:23:00', '0', 'Đã duyệt', 'HD00107', 2, '4400000', 0, NULL, '0', '%', '0', NULL, '8800000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(217, 113, 10, 1, '2025-02-16 23:40:50', '2025-02-16 23:23:00', '2025-03-31 23:23:00', '0', 'Đã duyệt', 'HD00108', 2, '4400000', 0, NULL, '0', '%', '0', NULL, '8800000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(218, 113, 17, 1, '2025-02-16 23:43:12', '2025-02-16 23:23:00', '2025-03-31 23:23:00', '0', 'Đã duyệt', 'HD00109', 2, '8000000', 0, NULL, '0', '%', '0', NULL, '16000000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(219, 112, 17, 1, '2025-02-16 23:46:58', '2025-02-16 23:23:00', '2025-03-31 23:23:00', '0', 'Đã duyệt', 'HD00110', 2, '8000000', 0, NULL, '0', '%', '0', NULL, '16000000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(220, 112, 17, 1, '2025-02-16 23:49:55', '2025-03-13 23:23:00', '2025-04-30 23:23:00', '0', 'Đã duyệt', 'HD00111', 2, '8000000', 0, NULL, '0', '%', '0', NULL, '16000000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(221, 112, 17, 1, '2025-02-16 23:51:32', '2025-03-13 23:23:00', '2025-04-30 23:23:00', '0', 'Đã duyệt', 'HD00112', 2, '8000000', 0, NULL, '0', '%', '0', NULL, '16000000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(222, 112, 17, 1, '2025-02-16 23:52:14', '2025-03-13 23:23:00', '2025-04-30 23:23:00', '0', 'Đã duyệt', 'HD00113', 2, '8000000', 0, NULL, '0', '%', '0', NULL, '16000000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(223, 113, 10, 1, '2025-02-17 14:41:16', '2025-02-17 23:23:00', '2025-04-01 23:23:00', '0', 'Đã duyệt', 'HD00106', 3, '4400000', 0, 215, '0', '%', '0', NULL, '13200000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(224, 112, 35, 1, '2025-02-17 14:41:59', '2025-03-03 20:20:00', '2026-02-03 20:20:00', '4400000', 'Đã duyệt', 'HD00104', 12, '4300000', 0, 213, '0', '%', '0', NULL, '51600000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(225, 111, 15, 1, '2025-02-18 10:46:12', '2025-02-20 20:20:00', '2026-01-20 20:20:00', '4900000', 'Đã duyệt', 'HD00103', 12, '4900000', 0, 210, '0', '%', '0', NULL, '58800000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(226, 112, 35, 1, '2025-02-18 11:10:33', '2025-02-10 20:20:00', '2026-01-10 20:20:00', '4400000', 'Đã duyệt', 'HD00104', 12, '4300000', 0, 224, '0', '%', '0', NULL, '51600000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(227, 112, 35, 1, '2025-02-19 14:41:40', '2025-02-11 20:20:00', '2026-01-11 20:20:00', '4400000', 'Đã duyệt', 'HD00104', 12, '4300000', 0, 226, '0', '%', '0', NULL, '51600000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(228, 111, 15, 1, '2025-02-19 14:41:54', '2025-02-21 20:20:00', '2026-01-21 20:20:00', '4900000', 'Đã duyệt', 'HD00103', 12, '4900000', 0, 225, '0', '%', '0', NULL, '58800000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(229, 113, 14, 1, '2025-02-20 08:31:08', '2025-02-16 20:20:00', '2026-01-16 20:20:00', '4600000', 'Đã duyệt', 'HD00105', 12, '4600000', 0, 212, '0', '%', '0', NULL, '55200000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(230, 113, 14, 1, '2025-02-20 08:50:38', '2025-02-16 20:20:00', '2026-01-16 20:20:00', '4600000', 'Đã duyệt', 'HD00105', 12, '4800000', 0, 229, '200000', 'số tiền', '200000', NULL, '55200000', '0', 74, '3960000', 'số tiền', '3960000', '300000', NULL, NULL, 'thang'),
(231, 111, 15, 1, '2025-02-20 08:57:02', '2025-02-20 20:20:00', '2026-01-20 20:20:00', '4900000', 'Đã duyệt', 'HD00103', 12, '4900000', 0, 228, '0', '%', '0', NULL, '58800000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(232, 113, 14, 1, '2025-02-20 08:58:36', '2025-02-16 20:20:00', '2026-01-16 20:20:00', '4600000', 'Đã duyệt', 'HD00105', 12, '4800000', 0, 230, '200000', 'số tiền', '200000', NULL, '55200000', '0', 74, '3960000', 'số tiền', '3960000', '300000', NULL, NULL, 'thang'),
(233, 111, 15, 1, '2025-02-20 09:04:02', '2025-02-21 20:20:00', '2026-01-21 20:20:00', '4900000', 'Đã duyệt', 'HD00103', 12, '4900000', 0, 231, '0', '%', '0', NULL, '58800000', '0', 116, '3730000', 'số tiền', '3730000', '300000', NULL, NULL, 'thang'),
(234, 111, 15, 1, '2025-02-20 09:05:36', '2025-02-20 20:20:00', '2026-01-20 20:20:00', '4900000', 'Đã duyệt', 'HD00103', 12, '4900000', 0, 233, '0', '%', '0', NULL, '61264000', '0', 116, '3730000', 'số tiền', '3730000', '300000', NULL, NULL, 'thang'),
(235, 113, 14, 1, '2025-02-20 09:06:39', '2025-02-16 20:20:00', '2026-01-16 20:20:00', '4600000', 'Đã duyệt', 'HD00105', 12, '4800000', 0, 232, '200000', 'số tiền', '200000', NULL, '55200000', '0', 116, '3960000', 'số tiền', '3960000', '300000', NULL, NULL, 'thang'),
(236, 113, 14, 1, '2025-02-20 09:13:15', '2025-02-16 20:20:00', '2026-01-16 20:20:00', '4600000', 'Đã duyệt', 'HD00105', 12, '4800000', 0, 235, '200000', 'số tiền', '200000', NULL, '55200000', '0', 116, '3960000', 'số tiền', '3960000', '300000', NULL, NULL, 'thang'),
(237, 113, 14, 1, '2025-02-20 09:16:20', '2025-02-16 00:00:00', '2026-01-16 00:00:00', '4600000', 'Đã duyệt', 'HD00105', 12, '4800000', 0, 236, '200000', 'số tiền', '200000', NULL, '55200000', '0', 116, '3960000', 'số tiền', '3960000', '300000', NULL, NULL, 'thang'),
(238, 112, 35, 1, '2025-02-20 09:30:34', '2025-02-10 20:20:00', '2026-01-10 20:20:00', '4400000', 'Đã duyệt', 'HD00104', 12, '4300000', 0, 227, '0', '%', '0', NULL, '51834500', '0', 117, '3310000', 'số tiền', '3310000', '300000', NULL, NULL, 'thang'),
(239, 113, 14, 1, '2025-02-20 09:36:49', '2025-02-16 09:09:00', '2026-01-16 09:09:00', '0', 'Đã duyệt', 'HD00114', 12, '4600000', 0, NULL, '0', '%', '0', NULL, '55200000', '0', 116, '3520000', 'số tiền', '3520000', '300000', NULL, NULL, 'thang'),
(240, 113, 14, 1, '2025-02-20 09:54:24', '2025-02-16 09:09:00', '2026-01-16 09:09:00', '0', 'Đã duyệt', 'HD00114', 12, '4600000', 0, 239, '600000', 'số tiền', '600000', NULL, '48101500', '0', 116, '3520000', 'số tiền', '3520000', '300000', NULL, NULL, 'thang'),
(241, 85, 12, 1, '2025-02-24 09:08:06', '2024-09-15 09:09:00', '2025-04-15 09:09:00', '0', 'Hoàn thành', 'HD00078', 8, '4300000', 1, 176, '0', '%', '0', NULL, '35103500', '-31806828', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(242, 89, 19, 1, '2025-02-27 10:48:24', '2025-01-01 10:10:00', '2026-03-01 10:10:00', '4400000', 'Đã duyệt', 'HD00082', 15, '4400000', 0, 182, '0', '%', '0', NULL, '67298500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(243, 113, 14, 1, '2025-02-28 10:46:40', '2025-02-16 09:09:00', '2026-01-16 09:09:00', '0', 'Đã duyệt', 'HD00114', 12, '4600000', 0, 240, '0', 'số tiền', '0', NULL, '55200000', '0', 116, '3520000', 'số tiền', '3520000', '300000', NULL, NULL, 'thang'),
(244, 113, 14, 1, '2025-02-28 10:47:28', '2025-02-16 09:09:00', '2026-01-16 09:09:00', '0', 'Đã duyệt', 'HD00114', 12, '4600000', 0, 243, '0', 'số tiền', '0', NULL, '56106500', '0', 116, '3520000', 'số tiền', '3520000', '300000', NULL, NULL, 'thang'),
(245, 112, 35, 1, '2025-02-28 10:59:12', '2025-02-11 20:20:00', '2026-01-11 20:20:00', '4400000', 'Đã duyệt', 'HD00104', 12, '4300000', 0, 238, '300000', 'số tiền', '300000', NULL, '48234500', '0', 117, '3310000', 'số tiền', '3310000', '300000', NULL, NULL, 'thang'),
(246, 101, 40, 1, '2025-02-28 11:02:45', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '4600000', 'Đã duyệt', 'HD00094', 6, '4600000', 0, 208, '0', '%', '0', NULL, '27799500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(247, 118, 18, 1, '2025-03-03 15:47:35', '2025-03-03 15:15:00', '2026-02-03 15:15:00', '4000000', 'Đã duyệt', 'HD00115', 12, '4000000', 0, NULL, '0', '%', '0', NULL, '48000000', '0', 119, '70', '%', '2800000', '0', NULL, NULL, 'thang'),
(248, 118, 18, 1, '2025-03-05 10:22:06', '2025-03-03 15:15:00', '2026-02-03 15:15:00', '4000000', 'Đã duyệt', 'HD00115', 12, '4000000', 0, 247, '0', '%', '0', NULL, '48000000', '0', 119, '70', '%', '2800000', '0', NULL, NULL, 'thang'),
(249, 118, 18, 1, '2025-03-05 10:25:08', '2025-03-03 15:15:00', '2026-02-03 15:15:00', '4000000', 'Đã duyệt', 'HD00115', 12, '4000000', 0, 248, '0', '%', '0', NULL, '48000000', '0', 119, '70', '%', '2800000', '0', NULL, NULL, 'thang'),
(250, 118, 18, 1, '2025-03-05 10:36:25', '2025-03-03 15:15:00', '2026-02-03 15:15:00', '4000000', 'Đã duyệt', 'HD00115', 12, '4000000', 0, 249, '0', '%', '0', NULL, '48000000', '0', 119, '70', '%', '2800000', '0', NULL, NULL, 'thang'),
(251, 101, 40, 1, '2025-03-10 11:28:15', '2025-01-01 11:11:00', '2025-06-01 11:11:00', '4600000', 'Đã duyệt', 'HD00094', 6, '4600000', 0, 246, '0', '%', '0', NULL, '28359500', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(252, 86, 13, 1, '2025-03-12 10:27:53', '2025-03-01 10:10:00', '2025-03-04 10:10:00', '0', 'Hoàn thành', 'HD00116', 1, '4100000', 1, NULL, '0', '%', '0', NULL, '4100000', '-529032', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(253, 118, 24, 1, '2025-03-12 11:03:35', '2025-03-03 15:15:00', '2026-02-03 15:15:00', '4000000', 'Đã duyệt', 'HD00115', 12, '4100000', 0, 250, '0', '%', '0', NULL, '49200000', '0', 119, '70', '%', '2870000', '0', NULL, NULL, 'thang'),
(254, 118, 24, 1, '2025-03-21 11:02:46', '2025-03-03 15:15:00', '2026-02-03 15:15:00', '4000000', 'Đã duyệt', 'HD00115', 12, '4000000', 0, 253, '0', '%', '0', NULL, '48472500', '4802492', 119, '70', '%', '2800000', '0', NULL, NULL, 'thang'),
(255, 112, 35, 1, '2025-03-25 15:59:45', '2025-02-12 20:20:00', '2026-01-12 20:20:00', '4400000', 'Đã duyệt', 'HD00104', 12, '4300000', 0, 245, '300000', 'số tiền', '300000', NULL, '48000000', '0', 117, '3080000', 'số tiền', '3080000', '300000', NULL, NULL, 'thang'),
(256, 112, 35, 1, '2025-03-25 16:03:07', '2025-02-13 20:20:00', '2026-01-13 20:20:00', '4400000', 'Đã duyệt', 'HD00104', 12, '4300000', 0, 255, '300000', 'số tiền', '300000', NULL, '48574000', '0', 117, '3380000', 'số tiền', '3380000', '300000', NULL, NULL, 'thang'),
(257, 118, 24, 1, '2025-04-01 11:00:52', '2025-03-03 15:15:00', '2026-02-03 15:15:00', '4000000', 'Đã duyệt', 'HD00115', 12, '4000000', 0, 254, '0', '%', '0', NULL, '47996500', '0', 119, '70', '%', '2800000', '0', NULL, NULL, 'thang'),
(258, 118, 24, 1, '2025-04-02 10:49:35', '2025-03-03 15:15:00', '2026-02-03 15:15:00', '4000000', 'Đã duyệt', 'HD00115', 12, '4000000', 0, 257, '0', '%', '0', NULL, '48885500', '0', 119, '70', '%', '2800000', '0', NULL, NULL, 'thang'),
(259, 122, 18, 1, '2025-04-09 08:57:25', '2025-04-07 08:08:00', '2026-03-07 08:08:00', '3500000', 'Đã duyệt', 'HD00117', 12, '4000000', 0, NULL, '500000', 'số tiền', '500000', NULL, '44293223', '0', 116, '70', '%', '2800000', '0', NULL, NULL, 'thang'),
(260, 123, 13, 1, '2025-04-09 10:33:29', '2025-04-04 10:10:00', '2026-03-04 10:10:00', '0', 'Đã duyệt', 'HD00118', 12, '4100000', 0, NULL, '600000', '%', '24600000000', NULL, '-245950803223', '0', 124, '0', '%', '0', '0', NULL, NULL, 'thang'),
(261, 125, 12, 1, '2025-04-09 10:38:45', '2025-04-01 10:10:00', '2026-04-01 10:10:00', '0', 'Đã duyệt', 'HD00119', 13, '4300000', 0, NULL, '800000', '%', '34400000000', NULL, '-378348123444', '0', 126, '0', '%', '0', '0', NULL, NULL, 'thang'),
(262, 122, 18, 1, '2025-04-10 16:28:02', '2025-04-07 08:08:00', '2026-03-07 08:08:00', '3500000', 'Đã duyệt', 'HD00117', 12, '4000000', 0, 259, '500000', 'số tiền', '500000', NULL, '42000000', '0', 116, '70', '%', '2450000', '0', NULL, NULL, 'thang'),
(263, 123, 13, 1, '2025-04-17 10:37:18', '2025-04-04 10:10:00', '2026-03-04 10:10:00', '0', 'Đã duyệt', 'HD00118', 12, '4100000', 0, 260, '600000', 'số tiền', '600000', NULL, '42000000', '0', 124, '50', '%', '1750000', '0', NULL, NULL, 'thang'),
(264, 125, 12, 1, '2025-04-17 10:46:07', '2025-04-01 10:10:00', '2026-04-01 10:10:00', '0', 'Đã duyệt', 'HD00119', 13, '4300000', 0, 261, '800000', 'số tiền', '800000', NULL, '45500000', '0', 126, '80', '%', '2800000', '0', NULL, NULL, 'thang'),
(265, 122, 18, 1, '2025-04-17 10:48:06', '2025-04-07 08:08:00', '2026-03-07 08:08:00', '3500000', 'Đã duyệt', 'HD00117', 12, '4000000', 0, 262, '500000', 'số tiền', '500000', NULL, '42000000', '0', 116, '70', '%', '2450000', '0', NULL, NULL, 'thang'),
(266, 122, 18, 1, '2025-04-19 15:34:14', '2025-04-07 15:15:00', '2026-03-07 15:15:00', '3500000', 'Đã duyệt', 'HD00120', 12, '4000000', 0, NULL, '500000', 'số tiền', '500000', NULL, '44293223', '0', 116, '70', '%', '2450000', '0', NULL, NULL, 'thang'),
(267, 122, 18, 1, '2025-04-19 16:00:29', '2025-04-07 15:15:00', '2026-03-07 15:15:00', '3500000', 'Đã duyệt', 'HD00121', 12, '4000000', 0, NULL, '500000', 'số tiền', '500000', NULL, '44293223', '0', 116, '70', '%', '2450000', '0', NULL, NULL, 'thang'),
(268, 122, 18, 1, '2025-04-19 16:19:03', '2025-04-07 16:16:00', '2026-03-07 16:16:00', '3500000', 'Đã duyệt', 'HD00122', 12, '4000000', 0, NULL, '500000', 'số tiền', '500000', NULL, '43750323', '0', 116, '70', '%', '2450000', '0', NULL, NULL, 'thang'),
(269, 123, 13, 1, '2025-04-19 16:26:42', '2025-04-04 16:16:00', '2026-03-04 16:16:00', '0', 'Đã duyệt', 'HD00123', 12, '4100000', 0, NULL, '600000', 'số tiền', '600000', NULL, '43465113', '0', 124, '50', '%', '1750000', '0', NULL, NULL, 'thang'),
(270, 122, 18, 1, '2025-04-22 11:09:17', '2025-04-07 16:16:00', '2026-03-07 16:16:00', '3500000', 'Đã duyệt', 'HD00122', 12, '4000000', 0, 268, '500000', 'số tiền', '500000', NULL, '42392000', '0', 116, '70', '%', '2450000', '0', NULL, NULL, 'thang'),
(271, 125, 12, 1, '2025-04-22 11:24:56', '2025-04-01 10:10:00', '2026-04-01 10:10:00', '0', 'Đã duyệt', 'HD00119', 13, '4300000', 0, 264, '800000', 'số tiền', '800000', NULL, '45500000', '0', 126, '80', '%', '2800000', '0', NULL, NULL, 'thang'),
(272, 127, 34, 1, '2025-04-22 11:41:47', '2025-04-18 11:11:00', '2025-05-01 11:11:00', '0', 'Đã duyệt', 'HD00124', 2, '4000000', 0, NULL, '500000', 'số tiền', '500000', NULL, '2089570', '0', 128, '0', '%', '0', '0', NULL, NULL, 'thang'),
(273, 127, 34, 1, '2025-04-22 11:43:24', '2025-04-17 11:11:00', '2025-05-01 11:11:00', '0', 'Đã duyệt', 'HD00124', 2, '4000000', 0, 272, '500000', 'số tiền', '500000', NULL, '7000000', '0', 128, '0', '%', '0', '0', NULL, NULL, 'thang'),
(274, 125, 12, 1, '2025-04-25 21:54:17', '2025-04-01 21:21:00', '2026-04-01 21:21:00', '0', 'Đã duyệt', 'HD00125', 13, '4300000', 0, NULL, '800000', 'số tiền', '800000', NULL, '43023334', '0', 126, '80', '%', '2800000', '0', NULL, NULL, 'thang'),
(275, 125, 12, 1, '2025-04-25 22:08:43', '2025-04-01 22:22:00', '2026-04-01 22:22:00', '0', 'Đã duyệt', 'HD00126', 13, '4300000', 0, NULL, '800000', 'số tiền', '800000', NULL, '46746167', '0', 126, '80', '%', '2800000', '0', NULL, NULL, 'thang');
INSERT INTO `qlcvsd_phong_khach` (`id`, `khach_hang_id`, `phong_id`, `user_id`, `created`, `thoi_gian_hop_dong_tu`, `thoi_gian_hop_dong_den`, `coc_truoc`, `trang_thai`, `ma_hop_dong`, `so_thang_hop_dong`, `don_gia`, `active`, `phong_cu_id`, `chiet_khau`, `kieu_chiet_khau`, `so_tien_chiet_khau`, `ghi_chu`, `thanh_tien`, `da_thanh_toan`, `sale_id`, `moi_gioi`, `kieu_moi_gioi`, `so_tien_moi_gioi`, `da_thanh_toan_moi_gioi`, `gio_vao`, `gio_ra`, `loai_hop_dong`) VALUES
(276, 127, 34, 1, '2025-04-29 08:59:11', '2025-04-18 11:11:00', '2025-05-18 11:11:00', '0', 'Đã duyệt', 'HD00124', 2, '4000000', 0, 273, '500000', 'số tiền', '500000', NULL, '7000000', '0', 128, '0', '%', '0', '0', NULL, NULL, 'thang'),
(277, 127, 34, 1, '2025-04-29 09:01:54', '2025-04-18 11:11:00', '2025-05-18 11:11:00', '0', 'Đã duyệt', 'HD00124', 2, '4000000', 0, 276, '500000', 'số tiền', '500000', NULL, '7042000', '0', 128, '0', '%', '0', '0', NULL, NULL, 'thang'),
(278, 112, 35, 1, '2025-04-30 09:31:06', '2025-02-14 20:20:00', '2026-01-14 20:20:00', '4400000', 'Đã duyệt', 'HD00104', 12, '4300000', 0, 256, '300000', 'số tiền', '300000', NULL, '48000000', '0', 117, '3380000', 'số tiền', '3380000', '300000', NULL, NULL, 'thang'),
(279, 112, 35, 1, '2025-04-30 09:31:22', '2025-02-15 20:20:00', '2026-01-15 20:20:00', '4400000', 'Đã duyệt', 'HD00104', 12, '4300000', 0, 278, '0', 'số tiền', '0', NULL, '52391000', '0', 117, '3380000', 'số tiền', '3380000', '300000', NULL, NULL, 'thang'),
(280, 35, 10, 1, '2025-04-30 09:43:37', '2025-01-01 10:10:00', '2025-06-01 10:10:00', '6600000', 'Đã duyệt', 'HD00075', 6, '4400000', 0, 174, '0', '%', '0', NULL, '26876000', '0', NULL, '0', '%', '0', '0', NULL, NULL, 'thang'),
(281, 127, 34, 1, '2025-04-30 10:14:22', '2025-04-18 11:11:00', '2025-05-18 11:11:00', '0', 'Đã duyệt', 'HD00124', 2, '4000000', 0, 277, '300000', 'số tiền', '300000', NULL, '7442000', '0', 128, '0', '%', '0', '0', NULL, NULL, 'thang'),
(282, 127, 34, 1, '2025-04-30 10:17:30', '2025-04-18 11:11:00', '2025-05-18 11:11:00', '3700000', 'Đã duyệt', 'HD00124', 2, '4000000', 0, 281, '300000', 'số tiền', '300000', NULL, '7655500', '0', 128, '0', '%', '0', '0', NULL, NULL, 'thang'),
(283, 127, 10, 1, '2025-05-05 20:38:50', '2025-05-05 20:20:00', '2026-05-05 20:20:00', '4400000', 'Đã duyệt', 'HD00127', 13, '4400000', 1, NULL, '0', '%', '0', NULL, '57737435', '0', 116, '10', '%', '440000', '0', NULL, NULL, 'thang');

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `qlcvsd_quan_ly_giao_dich`
-- (See below for the actual view)
--
CREATE TABLE `qlcvsd_quan_ly_giao_dich` (
`id` int(11)
,`khach_hang_id` int(11)
,`trang_thai_giao_dich` enum('Khởi tạo','Hoàn thành','Thành công','Không thành công','Chờ duyệt huỷ','Đã huỷ')
,`phong_khach_id` int(11)
,`active` tinyint(1)
,`so_tien_giao_dich` decimal(20,0)
,`created` datetime
,`user_id` int(11)
,`tong_tien` decimal(20,0)
,`ghi_chu` text
,`giao_dich_old_id` int(11)
,`loai_giao_dich` enum('Thanh toán hợp đồng','Phí môi giới')
,`anh_chuyen_khoan` varchar(300)
,`ma_qr` varchar(300)
,`hoa_don_id` int(11)
,`noi_dung_chuyen_khoan` text
,`ma_id_casso` int(11)
,`ma_hop_dong` varchar(100)
,`thanh_tien` decimal(20,0)
,`ten_phong` varchar(100)
,`ten_toa_nha` varchar(100)
,`hoten` varchar(100)
,`dien_thoai` varchar(20)
,`ma_hoa_don` varchar(100)
,`nguoi_thuc_hien` varchar(100)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `qlcvsd_quan_ly_hoa_don`
-- (See below for the actual view)
--
CREATE TABLE `qlcvsd_quan_ly_hoa_don` (
`id` int(11)
,`phong_khach_id` int(11)
,`active` tinyint(1)
,`chi_phi_dich_vu` decimal(20,0)
,`chot_hoa_don` tinyint(1)
,`da_thanh_toan` decimal(20,0)
,`created` datetime
,`thang` int(11)
,`so_nguoi` int(11)
,`tien_phong` decimal(20,0)
,`user_id` int(11)
,`tong_tien` decimal(20,0)
,`trang_thai` enum('Hoàn thành','Đã thanh toán','Chưa thanh toán')
,`nam` int(11)
,`ma_hoa_don` varchar(100)
,`thanh_tien` decimal(20,0)
,`loai_hop_dong` enum('3_gio','6_gio','ngay','thang')
,`ma_hop_dong` varchar(100)
,`khach_hang_id` int(11)
,`phong_id` int(11)
,`ten_phong` varchar(100)
,`parent_id` int(11)
,`ten_toa_nha` varchar(100)
,`hoten` varchar(100)
,`dien_thoai` varchar(20)
,`nguoi_thuc_hien` varchar(100)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `qlcvsd_quan_ly_khach_hang`
-- (See below for the actual view)
--
CREATE TABLE `qlcvsd_quan_ly_khach_hang` (
`id` int(11)
,`username` varchar(100)
,`password_hash` varchar(100)
,`password_reset_token` varchar(45)
,`email` varchar(100)
,`auth_key` varchar(32)
,`status` int(11)
,`created_at` datetime
,`updated_at` datetime
,`password` varchar(100)
,`hoten` varchar(100)
,`dien_thoai` varchar(20)
,`anhdaidien` varchar(100)
,`VIP` tinyint(1)
,`vi_dien_tu` decimal(20,0)
,`hoat_dong` tinyint(1)
,`birth_day` date
,`kichHoat` tinyint(1)
,`dia_chi` varchar(300)
,`ho_ten_tai_khoan` varchar(100)
,`so_tai_khoan` varchar(100)
,`te_ngan_hang` varchar(400)
,`user_old_id` int(11)
,`nguoi_phu_trach_id` int(11)
,`auth_web` varchar(100)
,`anhcancuoc` varchar(200)
,`so_cccd` varchar(15)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `qlcvsd_quan_ly_o_cung`
-- (See below for the actual view)
--
CREATE TABLE `qlcvsd_quan_ly_o_cung` (
`id` int(11)
,`nguoi_o_cung_id` int(11)
,`hoa_don_id` int(11)
,`ma_hoa_don` varchar(100)
,`thang` int(11)
,`hop_dong_id` int(11)
,`ho_ten` varchar(100)
,`dien_thoai` varchar(20)
,`active` tinyint(1)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `qlcvsd_quan_ly_phan_quyen`
-- (See below for the actual view)
--
CREATE TABLE `qlcvsd_quan_ly_phan_quyen` (
`id` int(11)
,`chuc_nang_id` int(11)
,`vai_tro_id` int(11)
,`name` varchar(100)
,`nhom` varchar(100)
,`controller_action` varchar(100)
,`tenvaitro` varchar(100)
,`user_id` int(11)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `qlcvsd_quan_ly_phong`
-- (See below for the actual view)
--
CREATE TABLE `qlcvsd_quan_ly_phong` (
`id` int(11)
,`selected` tinyint(1)
,`parent_id` int(11)
,`name` varchar(100)
,`active_phong` tinyint(1)
,`hoten` varchar(100)
,`dien_thoai` varchar(20)
,`ma_hop_dong` varchar(100)
,`ten_toa_nha` varchar(100)
,`active` tinyint(1)
,`thoi_gian_hop_dong_tu` datetime
,`thoi_gian_hop_dong_den` datetime
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `qlcvsd_quan_ly_phong_khach`
-- (See below for the actual view)
--
CREATE TABLE `qlcvsd_quan_ly_phong_khach` (
`id` int(11)
,`khach_hang_id` int(11)
,`phong_id` int(11)
,`user_id` int(11)
,`sale_id` int(11)
,`created` datetime
,`thoi_gian_hop_dong_tu` datetime
,`thoi_gian_hop_dong_den` datetime
,`coc_truoc` decimal(20,0)
,`trang_thai` enum('Hoàn thành','Chờ duyệt','Đã duyệt','Huỷ hợp đồng')
,`ma_hop_dong` varchar(100)
,`so_thang_hop_dong` int(11)
,`don_gia` decimal(20,0)
,`moi_gioi` decimal(20,0)
,`active` tinyint(1)
,`phong_cu_id` int(11)
,`chiet_khau` decimal(20,0)
,`kieu_chiet_khau` enum('%','số tiền')
,`kieu_moi_gioi` enum('%','số tiền')
,`ghi_chu` text
,`so_tien_chiet_khau` decimal(20,0)
,`so_tien_moi_gioi` decimal(20,0)
,`thanh_tien` decimal(20,0)
,`da_thanh_toan` decimal(20,0)
,`da_thanh_toan_moi_gioi` decimal(20,0)
,`ten_phong` varchar(100)
,`selected` tinyint(1)
,`ten_toa_nha` varchar(100)
,`toa_nha_id` int(11)
,`hoten` varchar(100)
,`dien_thoai` varchar(20)
,`hoten_sale` varchar(100)
,`dien_thoai_sale` varchar(20)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `qlcvsd_quan_ly_sale`
-- (See below for the actual view)
--
CREATE TABLE `qlcvsd_quan_ly_sale` (
`id` int(11)
,`username` varchar(100)
,`password_hash` varchar(100)
,`password_reset_token` varchar(45)
,`email` varchar(100)
,`auth_key` varchar(32)
,`status` int(11)
,`created_at` datetime
,`updated_at` datetime
,`password` varchar(100)
,`hoten` varchar(100)
,`dien_thoai` varchar(20)
,`anhdaidien` varchar(100)
,`VIP` tinyint(1)
,`vi_dien_tu` decimal(20,0)
,`hoat_dong` tinyint(1)
,`birth_day` date
,`kichHoat` tinyint(1)
,`dia_chi` varchar(300)
,`ho_ten_tai_khoan` varchar(100)
,`so_tai_khoan` varchar(100)
,`te_ngan_hang` varchar(400)
,`user_old_id` int(11)
,`nguoi_phu_trach_id` int(11)
,`auth_web` varchar(100)
,`anhcancuoc` varchar(200)
,`so_cccd` varchar(15)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `qlcvsd_quan_ly_user`
-- (See below for the actual view)
--
CREATE TABLE `qlcvsd_quan_ly_user` (
`id` int(11)
,`username` varchar(100)
,`password_hash` varchar(100)
,`password_reset_token` varchar(45)
,`email` varchar(100)
,`auth_key` varchar(32)
,`status` int(11)
,`created_at` datetime
,`updated_at` datetime
,`password` varchar(100)
,`hoten` varchar(100)
,`dien_thoai` varchar(20)
,`anhdaidien` varchar(100)
,`VIP` tinyint(1)
,`vi_dien_tu` decimal(20,0)
,`hoat_dong` tinyint(1)
,`birth_day` date
,`kichHoat` tinyint(1)
,`dia_chi` varchar(300)
,`ho_ten_tai_khoan` varchar(100)
,`so_tai_khoan` varchar(100)
,`te_ngan_hang` varchar(400)
,`user_old_id` int(11)
,`nguoi_phu_trach_id` int(11)
,`auth_web` varchar(100)
,`anhcancuoc` varchar(200)
,`vai_tro` mediumtext
);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_thiet_lap_gia`
--

CREATE TABLE `qlcvsd_thiet_lap_gia` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `don_gia` decimal(20,0) DEFAULT NULL,
  `don_vi_tinh` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_thiet_lap_gia`
--

INSERT INTO `qlcvsd_thiet_lap_gia` (`id`, `name`, `don_gia`, `don_vi_tinh`) VALUES
(2, 'Điện', '0', 'Số điện'),
(3, 'Nước', '0', 'Số nước'),
(4, 'Rác', '0', NULL),
(5, 'Internet', '0', NULL),
(6, 'Giặt', '0', NULL),
(7, 'Phụ phí', '0', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_trang_thai_giao_dich`
--

CREATE TABLE `qlcvsd_trang_thai_giao_dich` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `giao_dich_id` int(11) DEFAULT NULL,
  `trang_thai` enum('Khởi tạo','Chờ xác minh','Thành công','Không thành công','Chờ duyệt hủy','Đã hủy') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_trang_thai_giao_dich`
--

INSERT INTO `qlcvsd_trang_thai_giao_dich` (`id`, `user_id`, `giao_dich_id`, `trang_thai`, `created`) VALUES
(485, 1, 500, 'Thành công', '2024-11-04 14:40:16'),
(484, 1, 499, 'Thành công', '2024-11-04 14:40:16'),
(502, 1, 517, 'Thành công', '2024-11-04 14:40:16'),
(321, 1, 336, 'Thành công', '2024-11-04 14:40:14'),
(377, 1, 392, 'Thành công', '2024-11-04 14:40:15'),
(329, 1, 344, 'Thành công', '2024-11-04 14:40:14'),
(341, 1, 356, 'Thành công', '2024-11-04 14:40:14'),
(426, 1, 441, 'Thành công', '2024-11-04 14:40:15'),
(433, 1, 448, 'Thành công', '2024-11-04 14:40:15'),
(481, 1, 496, 'Thành công', '2024-11-04 14:40:16'),
(364, 1, 379, 'Thành công', '2024-11-04 14:40:14'),
(437, 1, 452, 'Thành công', '2024-11-04 14:40:15'),
(474, 1, 489, 'Thành công', '2024-11-04 14:40:16'),
(328, 1, 343, 'Thành công', '2024-11-04 14:40:14'),
(365, 1, 380, 'Thành công', '2024-11-04 14:40:14'),
(436, 1, 451, 'Thành công', '2024-11-04 14:40:15'),
(487, 1, 502, 'Thành công', '2024-11-04 14:40:16'),
(383, 1, 398, 'Thành công', '2024-11-04 14:40:15'),
(315, 1, 330, 'Thành công', '2024-11-04 14:40:14'),
(319, 1, 334, 'Thành công', '2024-11-04 14:40:14'),
(400, 1, 415, 'Thành công', '2024-11-04 14:40:15'),
(458, 1, 473, 'Thành công', '2024-11-04 14:40:15'),
(480, 1, 495, 'Thành công', '2024-11-04 14:40:16'),
(444, 1, 459, 'Thành công', '2024-11-04 14:40:15'),
(313, 1, 328, 'Thành công', '2024-11-04 14:40:14'),
(362, 1, 377, 'Thành công', '2024-11-04 14:40:14'),
(435, 1, 450, 'Thành công', '2024-11-04 14:40:15'),
(305, 1, 320, 'Thành công', '2024-11-04 14:40:14'),
(393, 1, 408, 'Thành công', '2024-11-04 14:40:15'),
(427, 1, 442, 'Thành công', '2024-11-04 14:40:15'),
(359, 1, 374, 'Thành công', '2024-11-04 14:40:14'),
(385, 1, 400, 'Thành công', '2024-11-04 14:40:15'),
(361, 1, 376, 'Thành công', '2024-11-04 14:40:14'),
(410, 1, 425, 'Thành công', '2024-11-04 14:40:15'),
(317, 1, 332, 'Thành công', '2024-11-04 14:40:14'),
(312, 1, 327, 'Thành công', '2024-11-04 14:40:14'),
(340, 1, 355, 'Thành công', '2024-11-04 14:40:14'),
(363, 1, 378, 'Thành công', '2024-11-04 14:40:14'),
(505, 1, 520, 'Thành công', '2024-11-04 14:40:16'),
(408, 1, 423, 'Thành công', '2024-11-04 14:40:15'),
(443, 1, 458, 'Thành công', '2024-11-04 14:40:15'),
(384, 1, 399, 'Thành công', '2024-11-04 14:40:15'),
(392, 1, 407, 'Thành công', '2024-11-04 14:40:15'),
(470, 1, 485, 'Thành công', '2024-11-04 14:40:16'),
(310, 1, 325, 'Thành công', '2024-11-04 14:40:14'),
(412, 1, 427, 'Thành công', '2024-11-04 14:40:15'),
(388, 1, 403, 'Thành công', '2024-11-04 14:40:15'),
(439, 1, 454, 'Thành công', '2024-11-04 14:40:15'),
(445, 1, 460, 'Thành công', '2024-11-04 14:40:15'),
(407, 1, 422, 'Thành công', '2024-11-04 14:40:15'),
(366, 1, 381, 'Thành công', '2024-11-04 14:40:14'),
(316, 1, 331, 'Thành công', '2024-11-04 14:40:14'),
(460, 1, 475, 'Thành công', '2024-11-04 14:40:15'),
(404, 1, 419, 'Thành công', '2024-11-04 14:40:15'),
(373, 1, 388, 'Thành công', '2024-11-04 14:40:15'),
(308, 1, 323, 'Thành công', '2024-11-04 14:40:14'),
(332, 1, 347, 'Thành công', '2024-11-04 14:40:14'),
(486, 1, 501, 'Thành công', '2024-11-04 14:40:16'),
(492, 1, 507, 'Thành công', '2024-11-04 14:40:16'),
(380, 1, 395, 'Thành công', '2024-11-04 14:40:15'),
(334, 1, 349, 'Thành công', '2024-11-04 14:40:14'),
(335, 1, 350, 'Thành công', '2024-11-04 14:40:14'),
(430, 1, 445, 'Thành công', '2024-11-04 14:40:15'),
(431, 1, 446, 'Thành công', '2024-11-04 14:40:15'),
(476, 1, 491, 'Thành công', '2024-11-04 14:40:16'),
(309, 1, 324, 'Thành công', '2024-11-04 14:40:14'),
(432, 1, 447, 'Thành công', '2024-11-04 14:40:15'),
(381, 1, 396, 'Thành công', '2024-11-04 14:40:15'),
(429, 1, 444, 'Thành công', '2024-11-04 14:40:15'),
(418, 1, 433, 'Thành công', '2024-11-04 14:40:15'),
(368, 1, 383, 'Thành công', '2024-11-04 14:40:15'),
(372, 1, 387, 'Thành công', '2024-11-04 14:40:15'),
(434, 1, 449, 'Thành công', '2024-11-04 14:40:15'),
(448, 1, 463, 'Thành công', '2024-11-04 14:40:15'),
(338, 1, 353, 'Thành công', '2024-11-04 14:40:14'),
(326, 1, 341, 'Thành công', '2024-11-04 14:40:14'),
(376, 1, 391, 'Thành công', '2024-11-04 14:40:15'),
(417, 1, 432, 'Thành công', '2024-11-04 14:40:15'),
(358, 1, 373, 'Thành công', '2024-11-04 14:40:14'),
(300, 1, 315, 'Thành công', '2024-11-04 14:40:14'),
(375, 1, 390, 'Thành công', '2024-11-04 14:40:15'),
(386, 1, 401, 'Thành công', '2024-11-04 14:40:15'),
(389, 1, 404, 'Thành công', '2024-11-04 14:40:15'),
(491, 1, 506, 'Thành công', '2024-11-04 14:40:16'),
(425, 1, 440, 'Thành công', '2024-11-04 14:40:15'),
(475, 1, 490, 'Thành công', '2024-11-04 14:40:16'),
(489, 1, 504, 'Thành công', '2024-11-04 14:40:16'),
(494, 1, 509, 'Thành công', '2024-11-04 14:40:16'),
(428, 1, 443, 'Thành công', '2024-11-04 14:40:15'),
(451, 1, 466, 'Thành công', '2024-11-04 14:40:15'),
(320, 1, 335, 'Thành công', '2024-11-04 14:40:14'),
(360, 1, 375, 'Thành công', '2024-11-04 14:40:14'),
(488, 1, 503, 'Thành công', '2024-11-04 14:40:16'),
(490, 1, 505, 'Thành công', '2024-11-04 14:40:16'),
(318, 1, 333, 'Thành công', '2024-11-04 14:40:14'),
(325, 1, 340, 'Thành công', '2024-11-04 14:40:14'),
(483, 1, 498, 'Thành công', '2024-11-04 14:40:16'),
(482, 1, 497, 'Thành công', '2024-11-04 14:40:16'),
(479, 1, 494, 'Thành công', '2024-11-04 14:40:16'),
(450, 1, 465, 'Thành công', '2024-11-04 14:40:15'),
(290, 1, 305, 'Thành công', '2024-11-04 14:40:14'),
(356, 1, 371, 'Thành công', '2024-11-04 14:40:14'),
(399, 1, 414, 'Thành công', '2024-11-04 14:40:15'),
(371, 1, 386, 'Thành công', '2024-11-04 14:40:15'),
(289, 1, 304, 'Thành công', '2024-11-04 14:40:14'),
(355, 1, 370, 'Thành công', '2024-11-04 14:40:14'),
(396, 1, 411, 'Thành công', '2024-11-04 14:40:15'),
(495, 1, 510, 'Thành công', '2024-11-04 14:40:16'),
(288, 1, 303, 'Thành công', '2024-11-04 14:40:14'),
(464, 1, 479, 'Thành công', '2024-11-04 14:40:15'),
(397, 1, 412, 'Thành công', '2024-11-04 14:40:15'),
(477, 1, 492, 'Thành công', '2024-11-04 14:40:16'),
(287, 1, 302, 'Thành công', '2024-11-04 14:40:14'),
(343, 1, 358, 'Thành công', '2024-11-04 14:40:14'),
(398, 1, 413, 'Thành công', '2024-11-04 14:40:15'),
(337, 1, 352, 'Thành công', '2024-11-04 14:40:14'),
(498, 1, 513, 'Thành công', '2024-11-04 14:40:16'),
(469, 1, 484, 'Thành công', '2024-11-04 14:40:15'),
(413, 1, 428, 'Thành công', '2024-11-04 14:40:15'),
(467, 1, 482, 'Thành công', '2024-11-04 14:40:15'),
(303, 1, 318, 'Thành công', '2024-11-04 14:40:14'),
(501, 1, 516, 'Thành công', '2024-11-04 14:40:16'),
(500, 1, 515, 'Thành công', '2024-11-04 14:40:16'),
(324, 1, 339, 'Thành công', '2024-11-04 14:40:14'),
(292, 1, 307, 'Thành công', '2024-11-04 14:40:14'),
(354, 1, 369, 'Thành công', '2024-11-04 14:40:14'),
(420, 1, 435, 'Thành công', '2024-11-04 14:40:15'),
(367, 1, 382, 'Thành công', '2024-11-04 14:40:15'),
(304, 1, 319, 'Thành công', '2024-11-04 14:40:14'),
(465, 1, 480, 'Thành công', '2024-11-04 14:40:15'),
(447, 1, 462, 'Thành công', '2024-11-04 14:40:15'),
(345, 1, 360, 'Thành công', '2024-11-04 14:40:14'),
(419, 1, 434, 'Thành công', '2024-11-04 14:40:15'),
(353, 1, 368, 'Thành công', '2024-11-04 14:40:14'),
(293, 1, 308, 'Thành công', '2024-11-04 14:40:14'),
(387, 1, 402, 'Thành công', '2024-11-04 14:40:15'),
(449, 1, 464, 'Thành công', '2024-11-04 14:40:15'),
(333, 1, 348, 'Thành công', '2024-11-04 14:40:14'),
(294, 1, 309, 'Thành công', '2024-11-04 14:40:14'),
(478, 1, 493, 'Thành công', '2024-11-04 14:40:16'),
(424, 1, 439, 'Thành công', '2024-11-04 14:40:15'),
(350, 1, 365, 'Thành công', '2024-11-04 14:40:14'),
(299, 1, 314, 'Thành công', '2024-11-04 14:40:14'),
(349, 1, 364, 'Thành công', '2024-11-04 14:40:14'),
(391, 1, 406, 'Thành công', '2024-11-04 14:40:15'),
(348, 1, 363, 'Thành công', '2024-11-04 14:40:14'),
(296, 1, 311, 'Thành công', '2024-11-04 14:40:14'),
(466, 1, 481, 'Thành công', '2024-11-04 14:40:15'),
(415, 1, 430, 'Thành công', '2024-11-04 14:40:15'),
(493, 1, 508, 'Thành công', '2024-11-04 14:40:16'),
(499, 1, 514, 'Thành công', '2024-11-04 14:40:16'),
(508, 1, 523, 'Thành công', '2024-11-04 14:40:16'),
(446, 1, 461, 'Thành công', '2024-11-04 14:40:15'),
(322, 1, 337, 'Thành công', '2024-11-04 14:40:14'),
(323, 1, 338, 'Thành công', '2024-11-04 14:40:14'),
(423, 1, 438, 'Thành công', '2024-11-04 14:40:15'),
(414, 1, 429, 'Thành công', '2024-11-04 14:40:15'),
(468, 1, 483, 'Thành công', '2024-11-04 14:40:15'),
(331, 1, 346, 'Thành công', '2024-11-04 14:40:14'),
(441, 1, 456, 'Thành công', '2024-11-04 14:40:15'),
(497, 1, 512, 'Thành công', '2024-11-04 14:40:16'),
(496, 1, 511, 'Thành công', '2024-11-04 14:40:16'),
(301, 1, 316, 'Thành công', '2024-11-04 14:40:14'),
(374, 1, 389, 'Thành công', '2024-11-04 14:40:15'),
(411, 1, 426, 'Thành công', '2024-11-04 14:40:15'),
(357, 1, 372, 'Thành công', '2024-11-04 14:40:14'),
(302, 1, 317, 'Thành công', '2024-11-04 14:40:14'),
(378, 1, 393, 'Thành công', '2024-11-04 14:40:15'),
(442, 1, 457, 'Thành công', '2024-11-04 14:40:15'),
(440, 1, 455, 'Thành công', '2024-11-04 14:40:15'),
(330, 1, 345, 'Thành công', '2024-11-04 14:40:14'),
(455, 1, 470, 'Thành công', '2024-11-04 14:40:15'),
(416, 1, 431, 'Thành công', '2024-11-04 14:40:15'),
(370, 1, 385, 'Thành công', '2024-11-04 14:40:15'),
(306, 1, 321, 'Thành công', '2024-11-04 14:40:14'),
(327, 1, 342, 'Thành công', '2024-11-04 14:40:14'),
(382, 1, 397, 'Thành công', '2024-11-04 14:40:15'),
(390, 1, 405, 'Thành công', '2024-11-04 14:40:15'),
(379, 1, 394, 'Thành công', '2024-11-04 14:40:15'),
(457, 1, 472, 'Thành công', '2024-11-04 14:40:15'),
(422, 1, 437, 'Thành công', '2024-11-04 14:40:15'),
(452, 1, 467, 'Thành công', '2024-11-04 14:40:15'),
(297, 1, 312, 'Thành công', '2024-11-04 14:40:14'),
(454, 1, 469, 'Thành công', '2024-11-04 14:40:15'),
(394, 1, 409, 'Thành công', '2024-11-04 14:40:15'),
(456, 1, 471, 'Thành công', '2024-11-04 14:40:15'),
(298, 1, 313, 'Thành công', '2024-11-04 14:40:14'),
(369, 1, 384, 'Thành công', '2024-11-04 14:40:15'),
(421, 1, 436, 'Thành công', '2024-11-04 14:40:15'),
(473, 1, 488, 'Thành công', '2024-11-04 14:40:16'),
(295, 1, 310, 'Thành công', '2024-11-04 14:40:14'),
(463, 1, 478, 'Thành công', '2024-11-04 14:40:15'),
(504, 1, 519, 'Thành công', '2024-11-04 14:40:16'),
(503, 1, 518, 'Thành công', '2024-11-04 14:40:16'),
(291, 1, 306, 'Thành công', '2024-11-04 14:40:14'),
(472, 1, 487, 'Thành công', '2024-11-04 14:40:16'),
(406, 1, 421, 'Thành công', '2024-11-04 14:40:15'),
(347, 1, 362, 'Thành công', '2024-11-04 14:40:14'),
(342, 1, 357, 'Thành công', '2024-11-04 14:40:14'),
(453, 1, 468, 'Thành công', '2024-11-04 14:40:15'),
(395, 1, 410, 'Thành công', '2024-11-04 14:40:15'),
(344, 1, 359, 'Thành công', '2024-11-04 14:40:14'),
(314, 1, 329, 'Thành công', '2024-11-04 14:40:14'),
(461, 1, 476, 'Thành công', '2024-11-04 14:40:15'),
(403, 1, 418, 'Thành công', '2024-11-04 14:40:15'),
(462, 1, 477, 'Thành công', '2024-11-04 14:40:15'),
(506, 1, 521, 'Thành công', '2024-11-04 14:40:16'),
(507, 1, 522, 'Thành công', '2024-11-04 14:40:16'),
(402, 1, 417, 'Thành công', '2024-11-04 14:40:15'),
(459, 1, 474, 'Thành công', '2024-11-04 14:40:15'),
(307, 1, 322, 'Thành công', '2024-11-04 14:40:14'),
(346, 1, 361, 'Thành công', '2024-11-04 14:40:14'),
(401, 1, 416, 'Thành công', '2024-11-04 14:40:15'),
(336, 1, 351, 'Thành công', '2024-11-04 14:40:14'),
(339, 1, 354, 'Thành công', '2024-11-04 14:40:14'),
(352, 1, 367, 'Thành công', '2024-11-04 14:40:14'),
(405, 1, 420, 'Thành công', '2024-11-04 14:40:15'),
(471, 1, 486, 'Thành công', '2024-11-04 14:40:16'),
(311, 1, 326, 'Thành công', '2024-11-04 14:40:14'),
(438, 1, 453, 'Thành công', '2024-11-04 14:40:15'),
(409, 1, 424, 'Thành công', '2024-11-04 14:40:15'),
(351, 1, 366, 'Thành công', '2024-11-04 14:40:14'),
(286, 1, 301, 'Thành công', '2024-11-04 14:40:14'),
(285, 1, 300, 'Thành công', '2024-11-04 14:40:14'),
(509, 1, 524, 'Thành công', '2024-11-05 17:52:10'),
(510, 1, 525, NULL, '2024-11-07 14:49:41'),
(511, 1, 526, NULL, '2024-12-12 15:32:45'),
(512, 1, 527, NULL, '2024-12-12 15:57:04'),
(513, 1, 528, NULL, '2024-12-12 15:57:06'),
(514, 1, 529, 'Khởi tạo', '2024-12-12 16:01:56'),
(515, 1, 530, NULL, '2024-12-12 16:04:02'),
(516, 1, 531, NULL, '2024-12-12 16:05:23'),
(517, 1, 532, 'Khởi tạo', '2024-12-12 16:06:09'),
(518, 1, 533, NULL, '2024-12-12 17:10:11'),
(519, 1, 534, NULL, '2024-12-20 15:13:29'),
(520, 1, 535, NULL, '2024-12-23 09:34:41'),
(521, 1, 536, NULL, '2024-12-23 11:03:08'),
(522, 1, 537, NULL, '2024-12-23 11:19:21'),
(523, 1, 538, NULL, '2024-12-23 11:19:21'),
(524, 1, 539, NULL, '2024-12-23 11:52:30'),
(525, 1, 540, NULL, '2024-12-30 15:46:00'),
(526, 1, 541, NULL, '2024-12-30 15:49:17'),
(527, 1, 542, NULL, '2024-12-30 15:49:52'),
(528, 1, 543, NULL, '2024-12-30 15:51:40'),
(529, 1, 544, NULL, '2024-12-30 15:52:11'),
(530, 1, 545, NULL, '2024-12-30 15:53:19'),
(531, 1, 546, NULL, '2024-12-30 16:21:19'),
(532, 1, 547, NULL, '2024-12-30 16:21:40'),
(533, 1, 548, NULL, '2024-12-30 16:22:49'),
(534, 1, 549, NULL, '2024-12-30 16:26:20'),
(535, 1, 550, NULL, '2024-12-30 16:26:39'),
(536, 1, 551, NULL, '2024-12-30 16:27:26'),
(537, 1, 552, 'Khởi tạo', '2024-12-31 05:25:17'),
(538, 1, 553, 'Khởi tạo', '2024-12-31 05:26:44'),
(539, 1, 554, 'Khởi tạo', '2024-12-31 05:31:16'),
(540, 1, 555, 'Khởi tạo', '2024-12-31 05:33:38'),
(541, 1, 556, 'Khởi tạo', '2024-12-31 05:35:06'),
(542, 1, 557, 'Khởi tạo', '2024-12-31 05:49:56'),
(543, 1, 558, 'Khởi tạo', '2024-12-31 05:51:32'),
(544, 1, 559, 'Khởi tạo', '2024-12-31 05:57:24'),
(545, 1, 560, 'Khởi tạo', '2024-12-31 05:58:36'),
(546, 1, 561, 'Khởi tạo', '2024-12-31 06:01:26'),
(547, 1, 562, 'Khởi tạo', '2024-12-31 06:06:29'),
(548, 1, 563, 'Khởi tạo', '2024-12-31 08:24:26'),
(549, 1, 564, 'Khởi tạo', '2024-12-31 08:31:21'),
(550, 1, 565, 'Khởi tạo', '2024-12-31 08:46:41'),
(551, 1, 566, 'Khởi tạo', '2024-12-31 08:49:47'),
(552, 1, 567, 'Khởi tạo', '2024-12-31 08:51:08'),
(553, 1, 568, 'Khởi tạo', '2024-12-31 08:53:01'),
(554, 1, 569, 'Khởi tạo', '2024-12-31 08:54:14'),
(555, 1, 570, 'Khởi tạo', '2024-12-31 08:54:29'),
(556, 1, 571, 'Khởi tạo', '2024-12-31 08:55:01'),
(557, 1, 572, 'Khởi tạo', '2024-12-31 08:59:37'),
(558, 1, 573, 'Khởi tạo', '2024-12-31 14:50:38'),
(559, 1, 574, 'Khởi tạo', '2024-12-31 17:00:03'),
(560, 1, 575, 'Khởi tạo', '2024-12-31 17:10:56'),
(561, NULL, 575, 'Thành công', '2024-12-31 17:12:36'),
(562, 1, 576, NULL, '2025-01-02 14:41:10'),
(563, NULL, 577, 'Khởi tạo', '2025-01-05 12:35:12'),
(564, 1, 578, NULL, '2025-01-05 23:03:09'),
(565, 1, 579, NULL, '2025-01-05 23:20:41'),
(566, 1, 580, NULL, '2025-01-05 23:45:21'),
(567, 1, 581, NULL, '2025-01-05 23:52:22'),
(568, 1, 582, NULL, '2025-01-06 09:14:57'),
(569, 1, 583, 'Khởi tạo', '2025-01-06 09:16:14'),
(570, 1, 584, NULL, '2025-01-06 10:14:43'),
(571, 1, 585, NULL, '2025-01-06 10:35:41'),
(572, 1, 586, NULL, '2025-01-06 10:39:19'),
(573, 1, 587, NULL, '2025-01-07 09:04:13'),
(574, 1, 588, NULL, '2025-01-07 09:07:18'),
(575, 1, 589, NULL, '2025-01-07 09:10:07'),
(576, 1, 590, NULL, '2025-01-07 09:15:17'),
(577, 1, 591, NULL, '2025-01-07 09:41:09'),
(578, 1, 592, NULL, '2025-01-07 09:44:42'),
(579, 1, 593, NULL, '2025-01-07 09:51:55'),
(580, 1, 594, NULL, '2025-01-07 11:25:21'),
(581, 1, 595, NULL, '2025-01-07 20:51:00'),
(582, 1, 596, NULL, '2025-01-07 20:51:13'),
(583, 1, 597, NULL, '2025-01-13 09:53:59'),
(584, 1, 598, NULL, '2025-01-13 10:09:32'),
(585, 1, 599, NULL, '2025-01-13 10:16:13'),
(586, 1, 600, NULL, '2025-01-13 10:18:07'),
(587, 1, 601, NULL, '2025-01-13 10:21:49'),
(588, 1, 602, NULL, '2025-01-13 10:24:51'),
(589, 1, 603, NULL, '2025-01-13 10:25:46'),
(590, 1, 604, NULL, '2025-01-13 10:29:14'),
(591, 1, 605, NULL, '2025-01-13 10:32:36'),
(592, 1, 606, NULL, '2025-01-13 10:37:22'),
(593, 1, 607, NULL, '2025-01-13 10:42:48'),
(594, 1, 608, NULL, '2025-01-13 10:45:39'),
(595, 1, 609, NULL, '2025-01-13 10:48:24'),
(596, 1, 610, NULL, '2025-01-13 10:51:12'),
(597, 1, 611, NULL, '2025-01-13 10:52:41'),
(598, 1, 612, NULL, '2025-01-13 11:00:47'),
(599, 1, 613, NULL, '2025-01-13 11:04:55'),
(600, 1, 614, NULL, '2025-01-13 11:07:41'),
(601, 1, 615, NULL, '2025-01-13 11:08:28'),
(602, 1, 616, NULL, '2025-01-13 11:23:27'),
(603, 1, 617, NULL, '2025-01-13 11:24:11'),
(604, 1, 618, NULL, '2025-01-13 11:28:54'),
(605, 1, 619, NULL, '2025-01-13 11:32:21'),
(606, 1, 620, NULL, '2025-01-13 11:35:11'),
(607, 1, 621, NULL, '2025-01-13 11:38:00'),
(608, 1, 622, NULL, '2025-01-13 11:47:11'),
(609, 1, 623, NULL, '2025-01-13 11:49:46'),
(610, 1, 624, 'Khởi tạo', '2025-01-26 20:13:04'),
(611, 1, 625, 'Khởi tạo', '2025-02-04 10:17:19'),
(612, 1, 626, 'Khởi tạo', '2025-02-05 20:58:31'),
(613, 1, 627, 'Khởi tạo', '2025-02-05 21:03:48'),
(614, 1, 628, 'Khởi tạo', '2025-02-05 21:04:31'),
(615, 1, 629, 'Khởi tạo', '2025-02-05 21:04:44'),
(616, 1, 630, 'Khởi tạo', '2025-02-05 21:05:23'),
(617, 1, 631, 'Khởi tạo', '2025-02-05 21:06:27'),
(618, 1, 632, 'Khởi tạo', '2025-02-05 21:07:48'),
(619, 1, 633, 'Khởi tạo', '2025-02-05 21:08:34'),
(620, 1, 634, 'Khởi tạo', '2025-02-05 21:09:29'),
(621, 1, 635, 'Khởi tạo', '2025-02-05 21:10:54'),
(622, 1, 636, 'Khởi tạo', '2025-02-05 21:12:46'),
(623, 1, 637, 'Khởi tạo', '2025-02-05 21:13:36'),
(624, 1, 638, 'Khởi tạo', '2025-02-05 21:15:05'),
(625, 1, 639, 'Khởi tạo', '2025-02-05 21:15:53'),
(626, 1, 640, 'Khởi tạo', '2025-02-05 21:16:47'),
(627, 1, 641, NULL, '2025-02-05 22:02:48'),
(628, 1, 642, NULL, '2025-02-05 22:05:11'),
(629, 1, 643, 'Khởi tạo', '2025-02-05 22:09:02'),
(630, 1, 644, NULL, '2025-02-05 22:11:20'),
(631, 1, 645, 'Khởi tạo', '2025-02-05 22:14:22'),
(632, 1, 646, 'Khởi tạo', '2025-02-05 22:15:15'),
(633, 1, 647, 'Khởi tạo', '2025-02-05 22:19:08'),
(634, 1, 648, 'Khởi tạo', '2025-02-06 10:46:32'),
(635, 1, 649, 'Khởi tạo', '2025-02-06 10:46:37'),
(636, 1, 650, 'Khởi tạo', '2025-02-06 10:46:39'),
(637, 1, 651, 'Khởi tạo', '2025-02-06 10:47:22'),
(638, 1, 652, 'Khởi tạo', '2025-02-06 10:48:03'),
(639, 1, 653, 'Khởi tạo', '2025-02-06 10:48:13'),
(640, 1, 626, 'Thành công', '2025-02-13 11:32:26'),
(641, 1, 627, 'Thành công', '2025-02-13 11:32:39'),
(642, 1, 628, 'Thành công', '2025-02-13 11:32:46'),
(643, 1, 629, 'Thành công', '2025-02-13 11:33:04'),
(644, 1, 630, 'Thành công', '2025-02-13 11:33:30'),
(645, 1, 631, 'Thành công', '2025-02-13 11:33:35'),
(646, 1, 632, 'Thành công', '2025-02-13 11:33:41'),
(647, 1, 633, 'Thành công', '2025-02-13 11:33:48'),
(648, 1, 634, 'Thành công', '2025-02-13 11:33:53'),
(649, 1, 635, 'Thành công', '2025-02-13 11:34:00'),
(650, 1, 636, 'Thành công', '2025-02-13 11:34:05'),
(651, 1, 637, 'Thành công', '2025-02-13 11:34:09'),
(652, 1, 638, 'Thành công', '2025-02-13 11:34:13'),
(653, 1, 639, 'Thành công', '2025-02-13 11:34:18'),
(654, 1, 653, 'Thành công', '2025-02-13 11:34:24'),
(655, 1, 651, 'Thành công', '2025-02-13 11:34:28'),
(656, 1, 650, 'Thành công', '2025-02-13 11:34:31'),
(657, 1, 647, 'Thành công', '2025-02-13 11:34:34'),
(658, 1, 646, 'Thành công', '2025-02-13 11:34:36'),
(659, 1, 645, 'Thành công', '2025-02-13 11:34:40'),
(660, 1, 643, 'Thành công', '2025-02-13 11:34:43'),
(661, 1, 640, 'Thành công', '2025-02-13 11:34:46'),
(662, 1, 654, NULL, '2025-02-16 20:06:40'),
(663, 1, 655, NULL, '2025-02-16 20:14:57'),
(664, 1, 656, NULL, '2025-02-16 20:19:15'),
(665, 1, 657, NULL, '2025-02-16 20:19:23'),
(666, 1, 658, NULL, '2025-02-17 14:41:59'),
(667, 1, 659, NULL, '2025-02-18 10:46:12'),
(668, 1, 660, NULL, '2025-02-18 11:10:33'),
(669, 1, 661, NULL, '2025-02-19 14:41:40'),
(670, 1, 662, NULL, '2025-02-19 14:41:54'),
(671, 1, 663, NULL, '2025-02-20 08:31:08'),
(672, 1, 664, NULL, '2025-02-20 08:50:38'),
(673, 1, 665, NULL, '2025-02-20 08:57:02'),
(674, 1, 666, NULL, '2025-02-20 08:58:36'),
(675, 1, 667, NULL, '2025-02-20 09:04:02'),
(676, 1, 668, NULL, '2025-02-20 09:05:36'),
(677, 1, 669, NULL, '2025-02-20 09:06:39'),
(678, 1, 670, NULL, '2025-02-20 09:13:15'),
(679, 1, 671, NULL, '2025-02-20 09:16:20'),
(680, 1, 672, NULL, '2025-02-20 09:30:34'),
(681, 1, 673, 'Khởi tạo', '2025-02-20 09:56:13'),
(682, 1, 674, 'Khởi tạo', '2025-02-20 09:57:02'),
(683, 1, 675, 'Khởi tạo', '2025-02-20 09:57:04'),
(684, 1, 676, 'Khởi tạo', '2025-02-20 09:58:28'),
(685, 1, 675, 'Thành công', '2025-02-20 09:59:05'),
(686, 1, 673, 'Thành công', '2025-02-20 09:59:10'),
(687, 1, 676, 'Thành công', '2025-02-21 09:35:56'),
(688, 1, 677, 'Khởi tạo', '2025-02-24 10:15:44'),
(689, 1, 677, 'Thành công', '2025-02-24 10:39:30'),
(690, 1, 678, NULL, '2025-02-27 10:48:24'),
(691, 1, 679, NULL, '2025-02-28 10:59:12'),
(692, 1, 680, NULL, '2025-02-28 11:02:45'),
(693, 1, 681, 'Khởi tạo', '2025-02-28 16:10:52'),
(694, 1, 682, 'Khởi tạo', '2025-02-28 16:11:16'),
(695, 1, 683, 'Khởi tạo', '2025-02-28 16:11:50'),
(696, 1, 684, 'Khởi tạo', '2025-02-28 16:25:10'),
(697, 1, 685, 'Khởi tạo', '2025-02-28 16:25:46'),
(698, 1, 686, 'Khởi tạo', '2025-02-28 16:26:11'),
(699, 1, 687, 'Khởi tạo', '2025-02-28 16:26:44'),
(700, 1, 688, 'Khởi tạo', '2025-02-28 16:27:11'),
(701, 1, 689, 'Khởi tạo', '2025-02-28 16:27:41'),
(702, 1, 690, 'Khởi tạo', '2025-02-28 16:28:07'),
(703, 1, 691, 'Khởi tạo', '2025-02-28 16:29:22'),
(704, 1, 692, 'Khởi tạo', '2025-02-28 16:29:49'),
(705, 1, 693, 'Khởi tạo', '2025-02-28 16:30:16'),
(706, 1, 694, 'Khởi tạo', '2025-02-28 16:31:01'),
(707, 1, 695, 'Khởi tạo', '2025-02-28 16:31:01'),
(708, 1, 696, 'Khởi tạo', '2025-02-28 16:31:28'),
(709, 1, 697, 'Khởi tạo', '2025-02-28 16:32:07'),
(710, 1, 698, 'Khởi tạo', '2025-02-28 16:32:32'),
(711, 1, 699, 'Khởi tạo', '2025-02-28 16:32:53'),
(712, 1, 700, 'Khởi tạo', '2025-02-28 16:33:10'),
(713, 1, 701, 'Khởi tạo', '2025-02-28 16:33:56'),
(714, 1, 702, 'Khởi tạo', '2025-02-28 16:34:16'),
(715, 1, 703, 'Khởi tạo', '2025-02-28 16:36:05'),
(716, 1, 699, 'Thành công', '2025-03-03 14:42:20'),
(717, 1, 689, 'Thành công', '2025-03-03 14:43:09'),
(718, 1, 698, 'Thành công', '2025-03-03 14:43:25'),
(719, 1, 704, NULL, '2025-03-03 15:47:35'),
(720, 1, 681, 'Thành công', '2025-03-05 08:50:59'),
(721, 1, 693, 'Thành công', '2025-03-05 08:52:17'),
(722, 1, 697, 'Thành công', '2025-03-05 08:52:44'),
(723, 1, 701, 'Thành công', '2025-03-05 08:52:58'),
(724, 1, 702, 'Thành công', '2025-03-05 08:53:12'),
(725, 1, 705, NULL, '2025-03-05 10:22:06'),
(726, 1, 706, NULL, '2025-03-05 10:25:08'),
(727, 1, 707, NULL, '2025-03-05 10:36:25'),
(728, 1, 708, 'Khởi tạo', '2025-03-05 14:36:02'),
(729, 1, 708, 'Thành công', '2025-03-07 09:38:45'),
(730, 1, 692, 'Thành công', '2025-03-07 09:39:16'),
(731, 1, 687, 'Thành công', '2025-03-10 10:54:28'),
(732, 1, 709, NULL, '2025-03-10 11:28:15'),
(733, 1, 710, 'Khởi tạo', '2025-03-10 11:31:55'),
(734, 1, 710, 'Thành công', '2025-03-10 11:32:12'),
(735, 1, 695, 'Thành công', '2025-03-11 08:53:50'),
(736, 1, 711, 'Khởi tạo', '2025-03-11 10:46:48'),
(737, 1, 711, 'Thành công', '2025-03-11 10:47:15'),
(738, 1, 712, 'Khởi tạo', '2025-03-11 10:55:55'),
(739, 1, 712, 'Thành công', '2025-03-11 10:56:09'),
(740, 1, 713, 'Khởi tạo', '2025-03-12 10:22:01'),
(741, 1, 713, 'Thành công', '2025-03-12 10:22:17'),
(742, 1, 714, 'Khởi tạo', '2025-03-12 10:29:19'),
(743, 1, 714, 'Thành công', '2025-03-12 10:30:12'),
(744, 1, 715, NULL, '2025-03-12 11:03:35'),
(745, 1, 716, 'Thành công', '2025-03-12 11:03:35'),
(746, 1, 717, NULL, '2025-03-21 11:02:46'),
(747, 1, 718, 'Thành công', '2025-03-21 11:02:46'),
(748, 1, 683, 'Thành công', '2025-03-23 11:28:19'),
(749, 1, 719, NULL, '2025-03-25 15:59:45'),
(750, 1, 720, 'Thành công', '2025-03-25 15:59:45'),
(751, 1, 721, NULL, '2025-03-25 16:03:07'),
(752, 1, 722, 'Thành công', '2025-03-25 16:03:07'),
(753, 1, 723, 'Khởi tạo', '2025-03-31 09:38:27'),
(754, 1, 724, 'Khởi tạo', '2025-03-31 09:39:24'),
(755, 1, 725, 'Khởi tạo', '2025-03-31 09:40:01'),
(756, 1, 726, 'Khởi tạo', '2025-03-31 09:40:23'),
(757, 1, 727, 'Khởi tạo', '2025-03-31 09:41:00'),
(758, 1, 728, 'Khởi tạo', '2025-03-31 09:41:59'),
(759, 1, 729, 'Khởi tạo', '2025-03-31 09:43:30'),
(760, 1, 730, 'Khởi tạo', '2025-03-31 09:43:30'),
(761, 1, 731, 'Khởi tạo', '2025-03-31 10:14:40'),
(762, 1, 732, 'Khởi tạo', '2025-03-31 10:14:40'),
(763, 1, 733, 'Khởi tạo', '2025-03-31 10:14:40'),
(764, 1, 734, 'Khởi tạo', '2025-03-31 10:14:40'),
(765, 1, 735, 'Khởi tạo', '2025-03-31 10:14:40'),
(766, 1, 736, 'Khởi tạo', '2025-03-31 10:14:40'),
(767, 1, 737, 'Khởi tạo', '2025-03-31 10:19:35'),
(768, 1, 738, 'Khởi tạo', '2025-03-31 10:19:35'),
(769, 1, 739, 'Khởi tạo', '2025-03-31 10:19:35'),
(770, 1, 740, 'Khởi tạo', '2025-03-31 10:19:35'),
(771, 1, 741, 'Khởi tạo', '2025-03-31 10:19:35'),
(772, 1, 742, 'Khởi tạo', '2025-03-31 10:19:35'),
(773, 1, 743, 'Khởi tạo', '2025-03-31 10:19:35'),
(774, NULL, 744, 'Khởi tạo', '2025-04-01 08:31:05'),
(775, 1, 745, NULL, '2025-04-01 11:00:53'),
(776, 1, 746, 'Thành công', '2025-04-01 11:00:53'),
(777, 1, 747, 'Khởi tạo', '2025-04-01 11:00:53'),
(778, 1, 748, NULL, '2025-04-02 10:49:35'),
(779, 1, 749, 'Thành công', '2025-04-02 10:49:36'),
(780, 1, 750, 'Khởi tạo', '2025-04-02 10:49:36'),
(781, 1, 741, 'Thành công', '2025-04-06 20:31:02'),
(782, 1, 739, 'Thành công', '2025-04-06 20:31:14'),
(783, 1, 738, 'Thành công', '2025-04-06 20:33:04'),
(784, 1, 742, 'Thành công', '2025-04-06 20:33:35'),
(785, 1, 733, 'Thành công', '2025-04-06 20:33:56'),
(786, 1, 734, 'Thành công', '2025-04-06 20:34:13'),
(787, 1, 723, 'Thành công', '2025-04-06 20:47:56'),
(788, 1, 743, 'Thành công', '2025-04-06 20:48:25'),
(789, 1, 751, NULL, '2025-04-09 08:57:25'),
(790, 1, 752, NULL, '2025-04-10 16:28:02'),
(791, 1, 752, 'Thành công', '2025-04-17 09:43:03'),
(792, 1, 735, 'Thành công', '2025-04-17 09:43:11'),
(793, 1, 728, 'Thành công', '2025-04-17 09:43:20'),
(794, 1, 753, NULL, '2025-04-17 10:48:06'),
(795, 1, 754, NULL, '2025-04-19 15:34:14'),
(796, 1, 755, NULL, '2025-04-19 16:00:29'),
(797, 1, 756, NULL, '2025-04-19 16:19:03'),
(798, 1, 757, NULL, '2025-04-22 11:09:17'),
(799, 1, 758, 'Khởi tạo', '2025-04-22 11:23:23'),
(800, 1, 758, 'Thành công', '2025-04-22 11:23:38'),
(801, 1, 759, 'Khởi tạo', '2025-04-22 11:30:46'),
(802, 1, 759, 'Thành công', '2025-04-22 11:31:00'),
(803, 1, 760, NULL, '2025-04-30 09:31:06'),
(804, 1, 761, 'Thành công', '2025-04-30 09:31:06'),
(805, 1, 762, 'Thành công', '2025-04-30 09:31:06'),
(806, 1, 763, NULL, '2025-04-30 09:31:22'),
(807, 1, 764, 'Thành công', '2025-04-30 09:31:22'),
(808, 1, 765, 'Thành công', '2025-04-30 09:31:22'),
(809, 1, 766, NULL, '2025-04-30 09:43:37'),
(810, 1, 767, 'Khởi tạo', '2025-04-30 09:43:37'),
(811, 1, 768, 'Thành công', '2025-04-30 09:43:37'),
(812, 1, 769, 'Thành công', '2025-04-30 09:43:37'),
(813, 1, 770, 'Thành công', '2025-04-30 09:43:37'),
(814, 1, 771, NULL, '2025-04-30 10:17:30'),
(815, 1, 772, 'Khởi tạo', '2025-04-30 10:36:52'),
(816, 1, 773, 'Khởi tạo', '2025-04-30 10:36:52'),
(817, 1, 774, 'Khởi tạo', '2025-04-30 10:36:52'),
(818, 1, 775, 'Khởi tạo', '2025-04-30 10:36:52'),
(819, 1, 776, 'Khởi tạo', '2025-04-30 10:36:52'),
(820, 1, 777, 'Khởi tạo', '2025-04-30 10:36:52'),
(821, 1, 778, 'Khởi tạo', '2025-04-30 10:36:52'),
(822, 1, 779, 'Khởi tạo', '2025-04-30 10:36:52'),
(823, 1, 780, 'Khởi tạo', '2025-04-30 10:36:52'),
(824, 1, 781, 'Khởi tạo', '2025-04-30 10:36:52'),
(825, 1, 782, 'Khởi tạo', '2025-04-30 10:36:52'),
(826, 1, 783, 'Khởi tạo', '2025-04-30 10:36:52'),
(827, 1, 784, 'Khởi tạo', '2025-04-30 10:36:52'),
(828, 1, 785, 'Khởi tạo', '2025-04-30 10:36:52'),
(829, 1, 786, 'Khởi tạo', '2025-04-30 10:36:52'),
(830, 1, 787, 'Khởi tạo', '2025-04-30 10:36:52'),
(831, 1, 788, 'Khởi tạo', '2025-04-30 10:36:52'),
(832, 1, 789, 'Khởi tạo', '2025-04-30 10:36:52'),
(833, 1, 790, 'Khởi tạo', '2025-04-30 10:36:52'),
(834, NULL, 791, 'Khởi tạo', '2025-05-01 08:31:04'),
(835, NULL, 792, 'Khởi tạo', '2025-05-01 08:31:05'),
(836, NULL, 793, 'Khởi tạo', '2025-05-01 08:31:05'),
(837, NULL, 794, 'Khởi tạo', '2025-05-01 08:31:06'),
(838, NULL, 795, 'Khởi tạo', '2025-05-01 08:31:06'),
(839, NULL, 796, 'Khởi tạo', '2025-05-01 08:31:07'),
(840, NULL, 797, 'Khởi tạo', '2025-05-01 08:31:07'),
(841, 1, 797, 'Không thành công', '2025-05-05 20:04:47'),
(842, 1, 796, 'Không thành công', '2025-05-05 20:04:49'),
(843, 1, 798, 'Khởi tạo', '2025-05-05 20:06:08'),
(844, 1, 799, 'Khởi tạo', '2025-05-05 20:06:40'),
(845, 1, 799, 'Thành công', '2025-05-05 20:07:38'),
(846, 1, 798, 'Thành công', '2025-05-05 20:07:40'),
(847, 1, 790, 'Thành công', '2025-05-05 20:07:43'),
(848, 1, 789, 'Thành công', '2025-05-05 20:07:45'),
(849, 1, 788, 'Thành công', '2025-05-05 20:07:47'),
(850, 1, 787, 'Thành công', '2025-05-05 20:07:50'),
(851, 1, 786, 'Thành công', '2025-05-05 20:07:51'),
(852, 1, 785, 'Thành công', '2025-05-05 20:07:53'),
(853, 1, 784, 'Thành công', '2025-05-05 20:07:55'),
(854, 1, 783, 'Thành công', '2025-05-05 20:07:57'),
(855, 1, 782, 'Thành công', '2025-05-05 20:07:59'),
(856, 1, 781, 'Thành công', '2025-05-05 20:08:00'),
(857, 1, 780, 'Thành công', '2025-05-05 20:08:02'),
(858, 1, 779, 'Thành công', '2025-05-05 20:08:04'),
(859, 1, 778, 'Thành công', '2025-05-05 20:08:07'),
(860, 1, 777, 'Thành công', '2025-05-05 20:08:09'),
(861, 1, 776, 'Thành công', '2025-05-05 20:08:10'),
(862, 1, 775, 'Thành công', '2025-05-05 20:08:13'),
(863, 1, 774, 'Thành công', '2025-05-05 20:08:17'),
(864, 1, 773, 'Thành công', '2025-05-05 20:08:23'),
(865, 1, 772, 'Thành công', '2025-05-05 20:08:30'),
(866, 1, 771, 'Thành công', '2025-05-05 20:08:35'),
(867, 1, 800, 'Khởi tạo', '2025-05-05 20:09:32'),
(868, 1, 801, 'Khởi tạo', '2025-05-05 20:09:42'),
(869, 1, 802, 'Khởi tạo', '2025-05-05 20:10:04'),
(870, 1, 803, 'Khởi tạo', '2025-05-05 20:10:21'),
(871, 1, 803, 'Thành công', '2025-05-05 20:10:40'),
(872, 1, 802, 'Thành công', '2025-05-05 20:10:43'),
(873, 1, 801, 'Thành công', '2025-05-05 20:10:44'),
(874, 1, 800, 'Thành công', '2025-05-05 20:10:46'),
(875, 1, 804, 'Khởi tạo', '2025-05-05 20:14:40'),
(876, 1, 804, 'Thành công', '2025-05-05 20:14:48'),
(877, 1, 805, 'Khởi tạo', '2025-05-05 20:15:19'),
(878, 1, 806, 'Khởi tạo', '2025-05-05 20:15:30'),
(879, 1, 807, 'Khởi tạo', '2025-05-05 20:15:50'),
(880, 1, 808, 'Khởi tạo', '2025-05-05 20:16:02'),
(881, 1, 808, 'Thành công', '2025-05-05 20:16:07'),
(882, 1, 807, 'Thành công', '2025-05-05 20:16:09'),
(883, 1, 806, 'Thành công', '2025-05-05 20:16:10'),
(884, 1, 805, 'Thành công', '2025-05-05 20:16:11'),
(885, 1, 809, 'Khởi tạo', '2025-05-05 20:16:42'),
(886, 1, 809, 'Thành công', '2025-05-05 20:16:48'),
(887, 1, 810, 'Khởi tạo', '2025-05-05 20:19:33'),
(888, 1, 811, 'Khởi tạo', '2025-05-05 20:19:34'),
(889, 1, 811, 'Thành công', '2025-05-05 20:19:42'),
(890, 1, 810, 'Không thành công', '2025-05-05 20:19:45'),
(891, 1, 812, 'Khởi tạo', '2025-05-05 20:20:22'),
(892, 1, 813, 'Khởi tạo', '2025-05-05 20:20:22'),
(893, 1, 813, 'Thành công', '2025-05-05 20:20:28'),
(894, 1, 814, 'Thành công', '2025-05-05 20:39:25'),
(895, 1, 815, 'Khởi tạo', '2025-05-05 20:40:23'),
(896, 1, 815, 'Thành công', '2025-05-05 20:41:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_trang_thai_hoa_don`
--

CREATE TABLE `qlcvsd_trang_thai_hoa_don` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `hoa_don_id` int(11) NOT NULL,
  `trang_thai` enum('Chưa thanh toán','Đã thanh toán','Hoàn thành') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_trang_thai_hoa_don`
--

INSERT INTO `qlcvsd_trang_thai_hoa_don` (`id`, `user_id`, `created`, `hoa_don_id`, `trang_thai`) VALUES
(2665, 1, '2025-05-05 20:38:50', 1543, 'Chưa thanh toán'),
(2666, 1, '2025-05-05 20:38:50', 1544, 'Chưa thanh toán'),
(2667, 1, '2025-05-05 20:38:50', 1545, 'Chưa thanh toán'),
(2668, 1, '2025-05-05 20:38:50', 1546, 'Chưa thanh toán'),
(2669, 1, '2025-05-05 20:38:50', 1547, 'Chưa thanh toán'),
(2670, 1, '2025-05-05 20:38:50', 1548, 'Chưa thanh toán'),
(2671, 1, '2025-05-05 20:38:50', 1549, 'Chưa thanh toán'),
(2672, 1, '2025-05-05 20:38:50', 1550, 'Chưa thanh toán'),
(2673, 1, '2025-05-05 20:38:50', 1551, 'Chưa thanh toán'),
(2674, 1, '2025-05-05 20:38:50', 1552, 'Chưa thanh toán'),
(2675, 1, '2025-05-05 20:38:50', 1553, 'Chưa thanh toán'),
(2676, 1, '2025-05-05 20:38:50', 1554, 'Chưa thanh toán'),
(2677, 1, '2025-05-05 20:38:50', 1555, 'Chưa thanh toán'),
(2678, 1, '2025-05-05 20:41:18', 1543, 'Đã thanh toán');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_trang_thai_phong`
--

CREATE TABLE `qlcvsd_trang_thai_phong` (
  `id` int(11) NOT NULL,
  `khach_hang_id` int(11) DEFAULT NULL,
  `trang_thai` enum('Đang có khách','Phòng trống') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phong_id` int(11) DEFAULT NULL,
  `thoi_gian_tu` datetime DEFAULT NULL,
  `thoi_gian_den` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_trang_thai_phong`
--

INSERT INTO `qlcvsd_trang_thai_phong` (`id`, `khach_hang_id`, `trang_thai`, `phong_id`, `thoi_gian_tu`, `thoi_gian_den`) VALUES
(1, 82, 'Đang có khách', 11, '2024-12-30 08:15:00', '2024-12-30 11:15:00'),
(2, 82, 'Đang có khách', 11, '2024-12-30 15:15:00', '2024-12-30 21:15:00'),
(3, 78, 'Đang có khách', 12, '2024-12-30 15:15:00', '2024-12-30 21:15:00'),
(4, 78, 'Đang có khách', 12, '2024-12-30 15:15:00', '2024-12-30 18:15:00'),
(5, 79, 'Đang có khách', 11, '2024-12-30 15:15:00', '2024-12-30 21:15:00'),
(6, 79, 'Đang có khách', 14, '2024-12-30 15:15:00', '2024-12-30 18:15:00'),
(7, 81, 'Đang có khách', 12, '2024-12-30 15:15:00', '2025-04-29 15:15:00'),
(8, 81, 'Đang có khách', 11, '2024-12-30 16:16:00', '2024-12-30 22:16:00'),
(9, 81, 'Đang có khách', 13, '2024-12-30 16:16:00', '2024-12-30 19:16:00'),
(10, 73, 'Đang có khách', 24, '2024-12-30 16:16:00', '2025-03-29 16:16:00'),
(11, 80, 'Đang có khách', 12, '2024-12-30 16:16:00', '2024-12-30 22:16:00'),
(12, 80, 'Đang có khách', 26, '2024-12-30 16:16:00', '2024-12-30 19:16:00'),
(13, 81, 'Đang có khách', 21, '2024-12-30 16:16:00', '2025-03-14 16:16:00'),
(14, 73, 'Đang có khách', 12, '2024-11-20 05:05:00', '2024-11-30 05:05:00'),
(15, 82, 'Đang có khách', 12, '2024-11-01 11:11:00', '2024-11-30 14:11:00'),
(16, 73, 'Đang có khách', 12, '2024-11-20 05:05:00', '2024-11-30 05:05:00'),
(17, 73, 'Đang có khách', 11, '2024-11-01 14:14:00', '2024-11-30 14:14:00'),
(18, 78, 'Đang có khách', 11, '2024-12-31 16:16:00', '2024-12-31 22:16:00'),
(19, 78, 'Đang có khách', 11, '2024-12-31 16:16:00', '2024-12-31 19:16:00'),
(20, 78, 'Đang có khách', 11, '2024-12-31 16:16:00', '2025-01-03 19:16:00'),
(21, 81, 'Đang có khách', 10, '2025-01-02 14:14:00', '2025-03-13 14:14:00'),
(22, 82, 'Đang có khách', 11, '2024-12-02 23:23:00', '2024-12-03 05:23:00'),
(23, 81, 'Đang có khách', 11, '2024-12-10 23:23:00', '2024-12-11 05:23:00'),
(24, 81, 'Đang có khách', 13, '2024-12-10 23:23:00', '2025-02-19 05:23:00'),
(25, 83, 'Đang có khách', 14, '2024-12-09 23:23:00', '2025-01-06 05:23:00'),
(26, 83, 'Đang có khách', 10, '2024-12-01 09:09:00', '2025-01-06 15:09:00'),
(27, 35, 'Đang có khách', 10, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(28, 35, 'Đang có khách', 10, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(29, 35, 'Đang có khách', 10, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(30, 35, 'Đang có khách', 10, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(31, 35, 'Đang có khách', 10, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(32, 35, 'Đang có khách', 10, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(33, 35, 'Đang có khách', 10, '2025-01-01 09:09:00', '2025-01-06 09:09:00'),
(34, 35, 'Đang có khách', 10, '2025-01-01 09:09:00', '2025-01-06 09:09:00'),
(35, 35, 'Đang có khách', 10, '2025-01-01 09:09:00', '2025-06-01 09:09:00'),
(36, 35, 'Đang có khách', 10, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(37, 35, 'Đang có khách', 10, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(38, 35, 'Đang có khách', 10, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(39, 35, 'Đang có khách', 10, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(40, 84, 'Đang có khách', 11, '2025-01-01 09:09:00', '2025-06-01 09:09:00'),
(41, 85, 'Đang có khách', 12, '2024-09-15 09:09:00', '2025-02-15 09:09:00'),
(42, 86, 'Đang có khách', 13, '2025-01-01 10:10:00', '2025-05-01 10:10:00'),
(43, 87, 'Đang có khách', 15, '2025-01-01 10:10:00', '2025-04-01 10:10:00'),
(44, 87, 'Đang có khách', 15, '2025-01-01 10:10:00', '2025-04-01 10:10:00'),
(45, 88, 'Đang có khách', 16, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(46, 89, 'Đang có khách', 19, '2025-01-01 10:10:00', '2025-03-01 10:10:00'),
(47, 89, 'Đang có khách', 19, '2025-01-01 10:10:00', '2025-03-01 10:10:00'),
(48, 90, 'Đang có khách', 20, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(49, 91, 'Đang có khách', 21, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(50, 92, 'Đang có khách', 22, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(51, 93, 'Đang có khách', 23, '2025-01-01 10:10:00', '2025-11-01 10:10:00'),
(52, 94, 'Đang có khách', 24, '2025-01-01 10:10:00', '2025-02-01 10:10:00'),
(53, 95, 'Đang có khách', 25, '2025-01-01 10:10:00', '2025-05-01 10:10:00'),
(54, 96, 'Đang có khách', 26, '2025-01-04 10:10:00', '2025-12-04 10:10:00'),
(55, 96, 'Đang có khách', 26, '2025-01-04 10:10:00', '2025-12-04 10:10:00'),
(56, 97, 'Đang có khách', 27, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(57, 98, 'Đang có khách', 28, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(58, 99, 'Đang có khách', 29, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(59, 99, 'Đang có khách', 29, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(60, 100, 'Đang có khách', 39, '2025-01-01 11:11:00', '2025-01-07 11:11:00'),
(61, 100, 'Đang có khách', 39, '2025-01-01 11:11:00', '2025-01-07 11:11:00'),
(62, 101, 'Đang có khách', 40, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(63, 102, 'Đang có khách', 41, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(64, 103, 'Đang có khách', 33, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(65, 104, 'Đang có khách', 34, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(66, 106, 'Đang có khách', 36, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(67, 107, 'Đang có khách', 37, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(68, 108, 'Đang có khách', 17, '2025-01-03 09:09:00', '2025-01-15 09:09:00'),
(69, 110, 'Đang có khách', 14, '2025-01-26 20:20:00', '2025-06-26 20:20:00'),
(70, 100, 'Đang có khách', 42, '2025-01-01 21:21:00', '2025-06-01 21:21:00'),
(71, 100, 'Đang có khách', 42, '2025-01-02 21:21:00', '2025-06-02 21:21:00'),
(72, 101, 'Đang có khách', 40, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(73, 101, 'Đang có khách', 40, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(74, 103, 'Đang có khách', 33, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(75, 111, 'Đang có khách', 15, '2025-03-01 20:20:00', '2026-03-01 20:20:00'),
(76, 112, 'Đang có khách', 35, '2025-03-01 20:20:00', '2026-02-01 20:20:00'),
(77, 113, 'Đang có khách', 14, '2025-03-01 20:20:00', '2026-02-01 20:20:00'),
(78, 112, 'Đang có khách', 35, '2025-03-02 20:20:00', '2026-02-02 20:20:00'),
(79, 112, 'Đang có khách', 35, '2025-03-02 20:20:00', '2026-02-02 20:20:00'),
(80, 113, 'Đang có khách', 10, '2025-02-16 23:23:00', '2025-03-31 23:23:00'),
(81, 113, 'Đang có khách', 10, '2025-02-16 23:23:00', '2025-03-31 23:23:00'),
(82, 113, 'Đang có khách', 10, '2025-02-16 23:23:00', '2025-03-31 23:23:00'),
(83, 113, 'Đang có khách', 17, '2025-02-16 23:23:00', '2025-03-31 23:23:00'),
(84, 112, 'Đang có khách', 17, '2025-02-16 23:23:00', '2025-03-31 23:23:00'),
(85, 112, 'Đang có khách', 17, '2025-03-13 23:23:00', '2025-04-30 23:23:00'),
(86, 112, 'Đang có khách', 17, '2025-03-13 23:23:00', '2025-04-30 23:23:00'),
(87, 112, 'Đang có khách', 17, '2025-03-13 23:23:00', '2025-04-30 23:23:00'),
(88, 113, 'Đang có khách', 10, '2025-02-17 23:23:00', '2025-04-01 23:23:00'),
(89, 112, 'Đang có khách', 35, '2025-03-03 20:20:00', '2026-02-03 20:20:00'),
(90, 111, 'Đang có khách', 15, '2025-02-20 20:20:00', '2026-01-20 20:20:00'),
(91, 112, 'Đang có khách', 35, '2025-02-10 20:20:00', '2026-01-10 20:20:00'),
(92, 112, 'Đang có khách', 35, '2025-02-11 20:20:00', '2026-01-11 20:20:00'),
(93, 111, 'Đang có khách', 15, '2025-02-21 20:20:00', '2026-01-21 20:20:00'),
(94, 113, 'Đang có khách', 14, '2025-02-16 20:20:00', '2026-01-16 20:20:00'),
(95, 113, 'Đang có khách', 14, '2025-02-16 20:20:00', '2026-01-16 20:20:00'),
(96, 111, 'Đang có khách', 15, '2025-02-20 20:20:00', '2026-01-20 20:20:00'),
(97, 113, 'Đang có khách', 14, '2025-02-16 20:20:00', '2026-01-16 20:20:00'),
(98, 111, 'Đang có khách', 15, '2025-02-21 20:20:00', '2026-01-21 20:20:00'),
(99, 111, 'Đang có khách', 15, '2025-02-20 20:20:00', '2026-01-20 20:20:00'),
(100, 113, 'Đang có khách', 14, '2025-02-16 20:20:00', '2026-01-16 20:20:00'),
(101, 113, 'Đang có khách', 14, '2025-02-16 20:20:00', '2026-01-16 20:20:00'),
(102, 113, 'Đang có khách', 14, '2025-02-16 00:00:00', '2026-01-16 00:00:00'),
(103, 112, 'Đang có khách', 35, '2025-02-10 20:20:00', '2026-01-10 20:20:00'),
(104, 113, 'Đang có khách', 14, '2025-02-16 09:09:00', '2026-01-16 09:09:00'),
(105, 113, 'Đang có khách', 14, '2025-02-16 09:09:00', '2026-01-16 09:09:00'),
(106, 85, 'Đang có khách', 12, '2024-09-15 09:09:00', '2025-04-15 09:09:00'),
(107, 89, 'Đang có khách', 19, '2025-01-01 10:10:00', '2026-03-01 10:10:00'),
(108, 113, 'Đang có khách', 14, '2025-02-16 09:09:00', '2026-01-16 09:09:00'),
(109, 113, 'Đang có khách', 14, '2025-02-16 09:09:00', '2026-01-16 09:09:00'),
(110, 112, 'Đang có khách', 35, '2025-02-11 20:20:00', '2026-01-11 20:20:00'),
(111, 101, 'Đang có khách', 40, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(112, 118, 'Đang có khách', 18, '2025-03-03 15:15:00', '2026-02-03 15:15:00'),
(113, 118, 'Đang có khách', 18, '2025-03-03 15:15:00', '2026-02-03 15:15:00'),
(114, 118, 'Đang có khách', 18, '2025-03-03 15:15:00', '2026-02-03 15:15:00'),
(115, 118, 'Đang có khách', 18, '2025-03-03 15:15:00', '2026-02-03 15:15:00'),
(116, 101, 'Đang có khách', 40, '2025-01-01 11:11:00', '2025-06-01 11:11:00'),
(117, 86, 'Đang có khách', 13, '2025-03-01 10:10:00', '2025-03-04 10:10:00'),
(118, 118, 'Đang có khách', 24, '2025-03-03 15:15:00', '2026-02-03 15:15:00'),
(119, 118, 'Đang có khách', 24, '2025-03-03 15:15:00', '2026-02-03 15:15:00'),
(120, 112, 'Đang có khách', 35, '2025-02-12 20:20:00', '2026-01-12 20:20:00'),
(121, 112, 'Đang có khách', 35, '2025-02-13 20:20:00', '2026-01-13 20:20:00'),
(122, 118, 'Đang có khách', 24, '2025-03-03 15:15:00', '2026-02-03 15:15:00'),
(123, 118, 'Đang có khách', 24, '2025-03-03 15:15:00', '2026-02-03 15:15:00'),
(124, 122, 'Đang có khách', 18, '2025-04-07 08:08:00', '2026-03-07 08:08:00'),
(125, 123, 'Đang có khách', 13, '2025-04-04 10:10:00', '2026-03-04 10:10:00'),
(126, 125, 'Đang có khách', 12, '2025-04-01 10:10:00', '2026-04-01 10:10:00'),
(127, 122, 'Đang có khách', 18, '2025-04-07 08:08:00', '2026-03-07 08:08:00'),
(128, 123, 'Đang có khách', 13, '2025-04-04 10:10:00', '2026-03-04 10:10:00'),
(129, 125, 'Đang có khách', 12, '2025-04-01 10:10:00', '2026-04-01 10:10:00'),
(130, 122, 'Đang có khách', 18, '2025-04-07 08:08:00', '2026-03-07 08:08:00'),
(131, 122, 'Đang có khách', 18, '2025-04-07 15:15:00', '2026-03-07 15:15:00'),
(132, 122, 'Đang có khách', 18, '2025-04-07 15:15:00', '2026-03-07 15:15:00'),
(133, 122, 'Đang có khách', 18, '2025-04-07 16:16:00', '2026-03-07 16:16:00'),
(134, 123, 'Đang có khách', 13, '2025-04-04 16:16:00', '2026-03-04 16:16:00'),
(135, 122, 'Đang có khách', 18, '2025-04-07 16:16:00', '2026-03-07 16:16:00'),
(136, 125, 'Đang có khách', 12, '2025-04-01 10:10:00', '2026-04-01 10:10:00'),
(137, 127, 'Đang có khách', 34, '2025-04-18 11:11:00', '2025-05-01 11:11:00'),
(138, 127, 'Đang có khách', 34, '2025-04-17 11:11:00', '2025-05-01 11:11:00'),
(139, 125, 'Đang có khách', 12, '2025-04-01 21:21:00', '2026-04-01 21:21:00'),
(140, 125, 'Đang có khách', 12, '2025-04-01 22:22:00', '2026-04-01 22:22:00'),
(141, 127, 'Đang có khách', 34, '2025-04-18 11:11:00', '2025-05-18 11:11:00'),
(142, 127, 'Đang có khách', 34, '2025-04-18 11:11:00', '2025-05-18 11:11:00'),
(143, 112, 'Đang có khách', 35, '2025-02-14 20:20:00', '2026-01-14 20:20:00'),
(144, 112, 'Đang có khách', 35, '2025-02-15 20:20:00', '2026-01-15 20:20:00'),
(145, 35, 'Đang có khách', 10, '2025-01-01 10:10:00', '2025-06-01 10:10:00'),
(146, 127, 'Đang có khách', 34, '2025-04-18 11:11:00', '2025-05-18 11:11:00'),
(147, 127, 'Đang có khách', 34, '2025-04-18 11:11:00', '2025-05-18 11:11:00'),
(148, 127, 'Đang có khách', 10, '2025-05-05 20:20:00', '2026-05-05 20:20:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_trang_thai_phong_khach`
--

CREATE TABLE `qlcvsd_trang_thai_phong_khach` (
  `id` int(11) NOT NULL,
  `phong_khach_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `trang_thai` enum('Hoàn thành','Chờ duyệt','Đã duyệt','Hủy hợp đồng') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_trang_thai_phong_khach`
--

INSERT INTO `qlcvsd_trang_thai_phong_khach` (`id`, `phong_khach_id`, `created`, `user_id`, `trang_thai`) VALUES
(8, 63, '2024-09-20 14:46:10', 1, 'Đã duyệt'),
(9, 64, '2024-09-20 14:47:23', 1, 'Đã duyệt'),
(10, 65, '2024-09-20 14:51:59', 1, 'Đã duyệt'),
(11, 66, '2024-09-20 14:57:53', 1, 'Đã duyệt'),
(12, 67, '2024-09-20 14:58:52', 1, 'Đã duyệt'),
(13, 68, '2024-09-20 14:59:50', 1, 'Đã duyệt'),
(14, 69, '2024-09-20 15:00:59', 1, 'Đã duyệt'),
(15, 70, '2024-09-20 15:01:49', 1, 'Đã duyệt'),
(16, 71, '2024-09-20 15:03:36', 1, 'Đã duyệt'),
(17, 72, '2024-09-20 15:04:25', 1, 'Đã duyệt'),
(18, 73, '2024-09-20 15:05:13', 1, 'Đã duyệt'),
(19, 74, '2024-09-20 15:08:25', 1, 'Đã duyệt'),
(20, 75, '2024-09-20 15:09:38', 1, 'Đã duyệt'),
(21, 76, '2024-09-20 15:11:10', 1, 'Đã duyệt'),
(22, 77, '2024-09-20 15:14:48', 1, 'Đã duyệt'),
(23, 78, '2024-09-20 15:15:43', 1, 'Đã duyệt'),
(24, 79, '2024-09-20 15:16:24', 1, 'Đã duyệt'),
(25, 80, '2024-09-20 15:17:47', 1, 'Đã duyệt'),
(26, 81, '2024-09-20 15:19:32', 1, 'Đã duyệt'),
(27, 82, '2024-09-20 15:20:25', 1, 'Đã duyệt'),
(28, 83, '2024-09-20 15:33:12', 1, 'Đã duyệt'),
(29, 84, '2024-09-20 15:40:22', 1, 'Đã duyệt'),
(30, 85, '2024-09-20 15:42:45', 1, 'Đã duyệt'),
(31, 86, '2024-09-20 15:43:56', 1, 'Đã duyệt'),
(32, 87, '2024-09-20 15:46:00', 1, 'Đã duyệt'),
(33, 88, '2024-09-20 15:46:59', 1, 'Đã duyệt'),
(34, 89, '2024-09-20 15:50:21', 1, 'Đã duyệt'),
(35, 90, '2024-09-20 15:51:52', 1, 'Đã duyệt'),
(36, 91, '2024-09-20 15:52:42', 1, 'Đã duyệt'),
(37, 92, '2024-09-20 15:53:46', 1, 'Đã duyệt'),
(38, 93, '2024-09-20 15:55:01', 1, 'Đã duyệt'),
(39, 94, '2024-09-20 15:56:01', 1, 'Đã duyệt'),
(40, 95, '2024-09-20 16:01:02', 1, 'Đã duyệt'),
(41, 96, '2024-09-22 21:57:12', 1, 'Đã duyệt'),
(42, 97, '2024-09-22 22:05:59', 1, 'Đã duyệt'),
(43, 98, '2024-10-02 16:28:14', 1, 'Đã duyệt'),
(44, 99, '2024-10-02 16:28:26', 1, 'Đã duyệt'),
(45, 100, '2024-10-02 16:44:14', 1, 'Đã duyệt'),
(46, 101, '2024-10-02 16:57:18', 1, 'Đã duyệt'),
(47, 102, '2024-10-16 16:36:34', 1, 'Đã duyệt'),
(48, 103, '2024-10-18 23:48:48', 1, 'Đã duyệt'),
(49, 104, '2024-10-21 14:12:15', 1, 'Đã duyệt'),
(50, 105, '2024-10-23 08:42:30', 1, 'Đã duyệt'),
(51, 106, '2024-10-23 08:43:31', 1, 'Đã duyệt'),
(52, 107, '2024-10-23 08:48:51', 1, 'Đã duyệt'),
(53, 108, '2024-10-30 15:52:28', 1, 'Đã duyệt'),
(54, 109, '2024-10-30 17:32:17', 1, 'Đã duyệt'),
(55, 110, '2024-10-31 08:11:21', 1, 'Đã duyệt'),
(56, 111, '2024-10-31 08:11:46', 1, 'Đã duyệt'),
(57, 112, '2024-11-06 14:42:08', 1, 'Đã duyệt'),
(58, 113, '2024-11-07 14:49:41', 1, 'Đã duyệt'),
(59, 114, '2024-11-07 15:55:06', 1, 'Đã duyệt'),
(60, 115, '2024-12-11 17:08:50', 1, 'Đã duyệt'),
(61, 116, '2024-12-11 17:10:45', 1, 'Đã duyệt'),
(62, 117, '2024-12-12 15:32:45', 1, 'Đã duyệt'),
(63, 118, '2024-12-12 15:57:04', 1, 'Đã duyệt'),
(64, 119, '2024-12-12 15:57:06', 1, 'Đã duyệt'),
(65, 120, '2024-12-12 16:04:02', 1, 'Đã duyệt'),
(66, 121, '2024-12-12 16:05:22', 1, 'Đã duyệt'),
(67, 122, '2024-12-12 17:10:11', 1, 'Đã duyệt'),
(68, 124, '2024-12-23 09:34:41', 1, 'Đã duyệt'),
(69, 125, '2024-12-23 11:03:08', 1, 'Đã duyệt'),
(70, 126, '2024-12-23 11:19:21', 1, 'Đã duyệt'),
(71, 127, '2024-12-23 11:52:29', 1, 'Đã duyệt'),
(72, 177, '2025-03-11 08:55:51', 1, 'Hoàn thành'),
(73, 177, '2025-03-11 08:56:09', 1, 'Hoàn thành'),
(74, 186, '2025-03-11 10:42:34', 1, 'Hoàn thành'),
(75, 186, '2025-03-11 10:45:13', 1, 'Hoàn thành'),
(76, 200, '2025-03-11 10:49:19', 1, 'Hoàn thành'),
(77, 177, '2025-03-11 17:35:12', 1, 'Hoàn thành'),
(78, 252, '2025-03-12 10:31:31', 1, 'Hoàn thành'),
(79, 241, '2025-03-26 09:22:07', 1, 'Hoàn thành');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_user`
--

CREATE TABLE `qlcvsd_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_hash` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_reset_token` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT 10,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hoten` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dien_thoai` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anhdaidien` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `VIP` tinyint(1) DEFAULT 0,
  `vi_dien_tu` decimal(20,0) DEFAULT 0,
  `hoat_dong` tinyint(1) DEFAULT 1,
  `birth_day` date DEFAULT NULL,
  `kichHoat` tinyint(1) DEFAULT 1,
  `dia_chi` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ho_ten_tai_khoan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_tai_khoan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `te_ngan_hang` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_old_id` int(11) DEFAULT NULL,
  `nguoi_phu_trach_id` int(11) DEFAULT NULL,
  `auth_web` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anhcancuoc` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `so_cccd` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_user`
--

INSERT INTO `qlcvsd_user` (`id`, `username`, `password_hash`, `password_reset_token`, `email`, `auth_key`, `status`, `created_at`, `updated_at`, `password`, `hoten`, `dien_thoai`, `anhdaidien`, `VIP`, `vi_dien_tu`, `hoat_dong`, `birth_day`, `kichHoat`, `dia_chi`, `ho_ten_tai_khoan`, `so_tai_khoan`, `te_ngan_hang`, `user_old_id`, `nguoi_phu_trach_id`, `auth_web`, `anhcancuoc`, `so_cccd`) VALUES
(1, 'admin', '$2y$13$k0CS4CJKwnxKBlfp4XDk3eZlBeg/.9eXPD59.y211ZU15DOK61oMa', NULL, 'andinjsc@gmai.com', 'SutQwruVprkMfT8dpxx79LPAIefot5Oy', 10, NULL, NULL, '', 'Admin', '20966867186', 'no-image.jpg', 0, '0', 1, '2024-10-23', 1, '', 'LE ANH TUAN', '3131990666', 'BIDV', 1, NULL, 'wsx2ZG0DcvAmsqCwk2MfDqm8mlCDuC_e', '', NULL),
(35, 'K1 VoQuocPhuc', '$2y$13$Z/dGLkda8wVq3rAMLZOiOeA87yMm4ybjNIGo9poAf19RYh0rQ3tUa', NULL, '', NULL, 10, '2024-09-19 16:12:51', NULL, NULL, 'K1 Võ Quốc Phục', '0934189460', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(36, 'nguyenvulong', '$2y$13$OPedjl/hZ9a/mzYBjkiTwePXqdCDfE48MqzeLp2VRi/ox.0A3HO5S', NULL, '', 'test_key_huy_tai_khoan', 0, '2024-09-19 16:57:05', NULL, NULL, 'Nguyễn Vũ Lộng', '0982278063', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(37, 'vudoanhaiduong', '$2y$13$jBVxwlKThqQGYgTOuHhl2OZY2A1.xwd6YofGizy/QR8jks5tm/oVe', NULL, '', NULL, 0, '2024-09-19 16:57:45', NULL, NULL, 'Vũ Đoàn Hải Dương', '0934730671', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '070202000686'),
(38, 'phantanthanh', '$2y$13$zgvvtkCuFl5Ec05GdqAbPeqIRvOZemaDOf.alNzsRxEmhu3mdJ8CK', NULL, '', NULL, 0, '2024-09-19 17:04:19', NULL, NULL, 'Phan Tấn Thành', '0937776919', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '079203033928'),
(39, 'nguyenngocnhuy', '$2y$13$QYolltX/ZnBOfYWukd7mNuIrQdh.FwizsMMnifRoeo7r46ZEHYjTW', NULL, '', NULL, 0, '2024-09-19 17:08:32', NULL, NULL, 'Nguyễn Ngọc Như Ý', '0915543405', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(40, 'nguyenngocphuongvi', '$2y$13$bvR6o4YxFBkQxVo9GEv8peOTF2bliTj65rzRwgrF71nwueN0EoFZ2', NULL, '', NULL, 0, '2024-09-19 17:09:07', NULL, NULL, 'Nguyễn Ngọc Phương vi', '0914479577', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(41, 'nguyenthithuduyen', '$2y$13$QYq6kPzqMe7xrn/eJeIHGOuM5WJ9..DnZ5Rigy90UZqXI7N6w4XHy', NULL, '', NULL, 0, '2024-09-19 17:09:37', NULL, NULL, 'Nguyễn Thị Thu Duyên', '0964057214', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(42, 'tranminhtien', '$2y$13$zmcr1FrzMLCAY5Wx2NCflOLcv5DrwooE2hpjFjgH6gngU/t2wwE9i', NULL, '', NULL, 0, '2024-09-19 17:10:01', NULL, NULL, 'Trần Minh Tiến', '0823808804', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(43, 'buiquydon', '$2y$13$F1o2G4JJtcjUlsE568h93OYB.W.kUckshL4GjZfIpHOAUHFOH3q9S', NULL, '', NULL, 0, '2024-09-19 17:10:27', NULL, NULL, 'Bùi Quý Đôn', '0886797756', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(44, 'voquangchien', '$2y$13$Uw8aPuq6itPEjqvEXU3aDeyvcNgqrBV2VDwl2EGd5z8LKq.GKQ2Xe', NULL, '', NULL, 0, '2024-09-19 17:11:59', NULL, NULL, 'Võ Quang Chiến', '0563792999', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '084206007261'),
(45, 'trantuanloc', '$2y$13$dl8P0r7fFZappo3MvVB4EuyZk.sGDCc2wADL67W0ioVa5dnvwPRw.', NULL, '', NULL, 0, '2024-09-19 17:12:26', NULL, NULL, 'Trần Tuấn Lộc', '0949557818', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '095205000390'),
(46, 'truongminhtan', '$2y$13$3jVDnto8FXZ.xbn7O0EKneCfNPgGq.KfvYyszmFU8goSusbN25KiC', NULL, '', NULL, 0, '2024-09-19 17:13:03', NULL, NULL, 'Trương Minh Tân', '0943776176', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(47, 'truongkiman', '$2y$13$fUJliSckPKMfdk8DeEJ9HeMijon7hKvhwNQk.M4haHAaSe.b1bUl.', NULL, '', NULL, 0, '2024-09-19 17:13:30', NULL, NULL, 'Trương Kim Ấn', '0379614007', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(48, 'phungthiquynhnhu', '$2y$13$3hGrrlTxlXgbupOHhp6EGuBCOQkSPpwadYjoBtQ8hIVY.xCsAsniO', NULL, '', NULL, 0, '2024-09-19 17:13:59', NULL, NULL, 'Phùng Thị Quỳnh Như', '0933837508', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(49, 'hamanhphat', '$2y$13$3tBa/FTiSogJW8kcJ.HxNuL7Jhwdwi5CuxYrS6OLqMiAZMmZYHKjC', NULL, '', NULL, 0, '2024-09-19 17:14:36', NULL, NULL, 'Hà Mạnh Phát', '0913693173', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '068205009099'),
(50, 'ngoduykhanh', '$2y$13$trfR1YcPY2OvUejsCv1XReyfREkP0CMhYSlamgAOxkEgfACGtTupe', NULL, '', NULL, 0, '2024-09-19 17:15:02', NULL, NULL, 'Ngô Duy Khánh', '0928858567', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(51, 'maingockhanh', '$2y$13$rrPnP15cEHUc10zhp7DTjesrgLoTrSJaC2ol3XPvXV6aMpg1In9D.', NULL, '', NULL, 0, '2024-09-19 17:15:35', NULL, NULL, 'Mai Ngọc Khanh', '0776699416', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '079300008837'),
(52, 'buitandat', '$2y$13$2dt97KFm/pMz0IOq8wOKeud8qNtooGTM51MaxtcVOYj.9Nluk7bDG', NULL, '', NULL, 0, '2024-09-19 17:16:06', NULL, NULL, 'Bùi Tấn Đạt', '0969507030', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '072204007001'),
(53, 'vothanhtruong', '$2y$13$5nwy3.RTUJT5OBVlJLmTWehv/ifVtopAnGUaRDiS8bzWIKGt9OquW', NULL, '', NULL, 0, '2024-09-19 17:16:30', NULL, NULL, 'Võ Thanh Trường', '0931865654', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(54, 'huynhthikimphuong', '$2y$13$Qlc2zse0Bw62worVGSdQWeFHq5/Ly9Gcad0U82.OaUJA/wvfc/7hq', NULL, '', NULL, 0, '2024-09-19 17:16:56', NULL, NULL, 'Huỳnh Thị Kim Phượng', '0388856056', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(55, 'daotuongvi', '$2y$13$8VC.v6HWavgU5qa4BgJX3.rXa0TdC5i8brxhptGyxdvwCt/jGixrG', NULL, '', NULL, 0, '2024-09-19 17:17:26', NULL, NULL, 'Đào Tường Vĩ', '0814946407', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '082203007024'),
(56, 'nguyenthingoclinh', '$2y$13$2qRFizy2.00cJCoRPXKTaOtOJpnOmmHUEkcwT2OmISYe4h72nA5JO', NULL, '', NULL, 0, '2024-09-19 17:17:59', NULL, NULL, 'Nguyễn Thị Ngọc Linh', '0364429312', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '060300005749'),
(57, 'ngotrandiemmy', '$2y$13$tITiE06kwTYqyT4nhZjH5e9tLRq4mJWai1W3pLkS8rwYszdVR9Tsq', NULL, '', NULL, 0, '2024-09-19 17:18:29', NULL, NULL, 'Ngô Trần Diễm My', '0941207393', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '084306008470'),
(58, 'levokhacminhnhat', '$2y$13$4I9EJJ0/YZAzStlh.Ijfwup4VcuECzzwx3/3hwr/uGwVnOve9rAI2', NULL, '', NULL, 0, '2024-09-19 17:18:57', NULL, NULL, 'Lê Võ Khắc Minh Nhật', '0971688861', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(59, 'giapthiyenvy', '$2y$13$eFxF.d3kvV1xRPPCuDNTwevvHi6yfeW21P.Yfw6SLvHTIsuKooi2q', NULL, '', NULL, 0, '2024-09-19 17:19:24', NULL, NULL, 'Giáp Thị Yến Vy', '0326342390', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(60, 'huynhkimnga', '$2y$13$vGYMrhKaKmnMYF4d1HBdTeGBSfeeIzaKfNgyCstRgbXDdlBoaImEe', NULL, '', NULL, 0, '2024-09-19 17:19:51', NULL, NULL, 'Huỳnh Kim Nga', '0363845201', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '072306006484'),
(61, 'nguyenthithanhtrang', '$2y$13$DgeUGmzrVOAf5VMDmfbtNemfyl5gEvudMluuFWmA1YsBg2rnbUpzq', NULL, '', NULL, 0, '2024-09-19 17:20:27', NULL, NULL, 'Nguyễn Thị Thanh Trang', '0868768175', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(62, 'lethithuphuong', '$2y$13$Ma17jhpIyZEG9JB0Rq/wBe4JVuQhBRzKdwImoz.iwRhsRpURGpWEq', NULL, '', NULL, 0, '2024-09-19 17:20:54', NULL, NULL, 'Lê Thị Thu Phương', '0961830841', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(63, 'tranquoctrung', '$2y$13$JeqKUswhYQZW3Bj2y8rpNOdcQGkgAJxyQjc3boooNqZEzNCGA/lAS', NULL, '', NULL, 0, '2024-09-20 15:02:52', NULL, NULL, 'Trần Quốc Trung', '0563792999', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(64, 'nguyenhoangbaongoc', '$2y$13$NbPLG9ve3DXaCsZhUDeJTeLdaTIbdgSvgpje8H84PbQjA0JZbq4Hm', NULL, '', NULL, 0, '2024-09-20 15:09:11', NULL, NULL, 'Nguyễn Hoàng Bảo Ngọc', '0915129915', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(65, 'huynhphihoang', '$2y$13$qzNG21ZhYAvFvBreJPijJuSGBk5VsRTJuSJQS8nEuwqBdc8Yjrbzi', NULL, '', NULL, 0, '2024-09-20 15:14:07', NULL, NULL, 'Huỳnh Phi Hoàng', '0916716071', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(66, 'trananhthu', '$2y$13$KNxQE2XwVOYmtB9DLrfTA.8Vh3OovrYA6.hVeHRTGYg47ajd91M/6', NULL, '', NULL, 0, '2024-09-20 15:18:23', NULL, NULL, 'Trần Anh Thư', '0346832172', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(67, 'nguyentanluan', '$2y$13$uliVDBlhNiesnT6L6gaE6u9r.SRdrMehrDf0iIiClSdjupeQhUFe2', NULL, '', NULL, 0, '2024-09-20 16:00:17', NULL, NULL, 'Nguyễn Tấn Luân', '0773091058', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(68, 'tranthimai', '$2y$13$ZVAmjkswFg2UDVyFOh/VuOxLEhTcZZiGWOq1FJSYtjWjDdlBotjHC', NULL, '', NULL, 0, '2024-09-22 22:05:15', NULL, NULL, 'Trần Thị Mai', '0941207393', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(69, 'khachmoi@1231', '$2y$13$aQIWHSo6V8eTjlnYimaCuO7quFGC2Z2QgFFVsxLj23PURqywrgi0C', NULL, '', NULL, 10, '2024-10-02 16:21:24', NULL, NULL, 'khachmoi', 'khachmoi', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(70, 'tenModiy', '$2y$13$7uYQGJ0Xh/CYjCt4C.gVBOsMPOHoWFVy3hl4SvppGYfv7Q0JYmNP2', NULL, 'tenmodify@gmail.com', 'test_key_huy_tai_khoan', 0, '2024-10-09 17:48:52', NULL, NULL, 'Ten Modify', '0000111122', NULL, 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '010101010101'),
(71, 'khach1', '$2y$13$1B/c2VV2FxUcvtZD5eU.M.E0OLgK84LLrA/K20KqP8XvudWMpEQC2', NULL, 'abcd@c.com', NULL, 10, '2024-10-18 23:46:18', NULL, NULL, 'Khach1', '0933999333', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '02934029304'),
(73, 'tin_nhan', '$2y$13$fryVnxOk8K/RYRMEE0fcjOFM3Sd3u.FT6VqXhBJJwGKg.Ut0C2PPe', NULL, '', NULL, 0, '2024-10-31 08:11:09', NULL, NULL, 'Test tin nhắn', '0398151271', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(74, 'thu_phuong', '$2y$13$e06J2NMJHrfc6ECbe.faru71Qs84MkUbh6ZOz33a95FIjTMMmxbVu', NULL, '', NULL, 10, '2024-11-04 17:37:34', NULL, NULL, 'Tống Thu Phương', '04857627463', '', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'duc_hai', '$2y$13$9QOyNW7xrEyQcLzhkrgFdufITkC8wPrl3W/A67khd9QJTdqCaMHtO', NULL, '', NULL, 0, '2024-11-06 14:29:50', NULL, NULL, 'Đỗ Đức Hải', '0487273853', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(76, 'phuong_mai', '$2y$13$2EvlB6MQnNfBIFYOfRIaFumKDohAt5OgJTQYAUsknsihsO9RaX0.q', NULL, '', NULL, 10, '2024-11-06 14:30:27', NULL, NULL, 'Trần Phương Mai', '0985354361', '', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, '0475755776', '$2y$13$IwLGU4FaXx4SL.DYjJPQs.5FkH7ww53XN5tqfkSHWxhX3bsHKi3Gy', NULL, NULL, NULL, 0, '2024-12-11 17:00:32', NULL, NULL, 'Phạm Dung', '0475755776', NULL, 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '048674775734'),
(78, '0938564644', '$2y$13$vKlOFt3.66UsY3YYDNo51unoQsJ8zHgoH7yKvtVZxD70NNrl6A/FC', NULL, NULL, NULL, 0, '2024-12-11 17:08:49', NULL, NULL, 'Phạm Cường', '0938564644', NULL, 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '0486776565464'),
(79, '0486774562', '$2y$13$3n45sG3QIPrkMemu7dJ0julLZb2Jh.uHEmpHVb3Skb9/Azfo7BSKy', NULL, NULL, NULL, 0, '2024-12-11 17:10:44', NULL, NULL, 'Phạm Thanh', '0486774562', NULL, 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '094867487757'),
(80, 'anh_tuan', '$2y$13$QnVRxbgj0uAGjY4rMLOeQeJ3RzHwOT7zC6kYWk6NJp0qMNWHwx0EC', NULL, '', NULL, 0, '2024-12-12 16:03:38', NULL, NULL, 'Anh Tuấn', '0815111666', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(81, 'Nguyễn Mai Chi 306', '$2y$13$jPERQp3NNCf8ghtBMbrPoOySrkVrqkpkF0ezXPt5bUomlO/L2jV2u', NULL, '', NULL, 0, '2024-12-18 15:52:13', NULL, NULL, 'Nguyễn Mai Chi', '0909842383', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '079189032554'),
(82, 'Vũ Đoàn Hải Dương', '$2y$13$WMAqLpXcM4iHD.Y/rLqKiO/Rt.wNUYx11KuF/TVk7AJ1f5Tlq2x2G', NULL, '', NULL, 0, '2024-12-23 11:06:51', NULL, NULL, 'Vũ Đoàn Hải Dương', '0847799100', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '070202000686'),
(83, 'Phan Tấn Thành', '$2y$13$u9/I7Qe99TtHkUBz2KtzlOLCCPAOtCAA0VOQw205MStThOE8uYrA2', NULL, '', NULL, 0, '2024-12-23 11:21:21', NULL, NULL, 'Phan Tấn Thành', '0937776919', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '079203033928'),
(84, 'L2 Nguyễn Vũ Lộng', '$2y$13$9jtiw4eWX/CjRFnJPvrxgeznswyTZuq4D0Cbx2W8RF5FWM.R36U8i', NULL, '', NULL, 10, '2025-01-07 16:01:25', NULL, NULL, 'K2 Nguyễn Vũ Lộng', '0982278063', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(85, 'K3 Vũ Đoàn Hải Dương ', '$2y$13$3RtAQFF6AmcvAWfu2e5prOUPfK7syJZBNuGDBkAUj31oUKVua.HFS', NULL, '', NULL, 0, '2025-01-13 09:57:56', NULL, NULL, 'K3 Vũ Đoàn Hải Dương', '0847799100', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '070202000686'),
(86, 'K4 Phan Tấn Thành', '$2y$13$VF3W3wnyMXUXcMzZrp37Q.aVftrk9eisxumcYJMTXls5uh1604WXm', NULL, '', NULL, 0, '2025-01-13 10:07:35', NULL, NULL, 'K4 Phan Tấn Thành', '0937776919', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '079203033928'),
(87, '102 Lâm Lan Vũ', '$2y$13$H/3LP4vHf0MEdnnz.JPtcu2hx3HgDtYNW/kce1F4fu8lo0OI06s36', NULL, '', NULL, 0, '2025-01-13 10:13:20', NULL, NULL, '102 Lâm Lan Vũ', '0367215561', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '089104001657'),
(88, '103 Nguyễn Thị Thu Duyên', '$2y$13$U/llxp/ALK2yxReCYwufD.IHQWXNiMewHeECxi/c.t4dsExTv8fQa', NULL, '', NULL, 10, '2025-01-13 10:20:18', NULL, NULL, '103 Nguyễn Thị Thu Duyên', '0964057214', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(89, '106 Võ Quang Chiến', '$2y$13$t0zUMf28OlgVI8fl13kg9esvwXkMUhieGRdmAPB/rbwVGANy5g7zW', NULL, '', NULL, 10, '2025-01-13 10:23:32', NULL, NULL, '106 Võ Quang Chiến', '0908911917', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '084206007261'),
(90, '107 Trần Tuấn Lộc', '$2y$13$B0M04ZJp0SClUP7JCJsM/.Ikng9fnpTdpU68aAvI5yJNlrO/2B0C.', NULL, '', NULL, 10, '2025-01-13 10:27:39', NULL, NULL, '107 Trần Tuấn Lộc', '0949557818', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '095205000390'),
(91, '108 Trương Minh Tân', '$2y$13$deGEpchFftYg.vkZVx0jXu3karijz1V84k5co6ljU1C.JIRn46cl.', NULL, '', NULL, 10, '2025-01-13 10:30:33', NULL, NULL, '108 Trương Minh Tân', '0943776176', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(92, '201 Trương Kim Ấn', '$2y$13$aMu5NghvqURxIkSMkAnxMezoWuoKhWfQ9aqCJyLdUCRXiTxu4qvHS', NULL, '', NULL, 10, '2025-01-13 10:34:42', NULL, NULL, '201 Trương Kim Ấn', '0379614007', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(93, '202 Phạm Hồng Nhung', '$2y$13$8Z9jQFEzQscbCDXZHgBxFu.qvb47byQH.72yNXUceoRuC8vvBbtL2', NULL, '', NULL, 10, '2025-01-13 10:39:13', NULL, NULL, '202 Phạm Hồng Nhung', '0349321020', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '054304001877 '),
(94, '203 Hà Mạnh Phát', '$2y$13$xFi8nPqYCJpmo2FvCaQr8O3AL3vcNOouoau4fGWpKRTA8AiiKslD6', NULL, '', NULL, 0, '2025-01-13 10:44:23', NULL, NULL, '203 Hà Mạnh Phát', '0913693173', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '068205009099 '),
(95, '204 Ngô Duy Khánh', '$2y$13$rRbbsTevrjNeMk9wPU1t6OB0RGSYOg7cEfXiGhOKz0vVrSAniJu/O', NULL, '', NULL, 10, '2025-01-13 10:47:10', NULL, NULL, '204 Ngô Duy Khánh', '0928858567', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(96, '205 Trần Kim Ngân', '$2y$13$BpMc9EcQJdYx4nGGYF/A2.iV9aFQCRCOT/Fu4Y7QD0KqkG/HKWVA.', NULL, '', NULL, 10, '2025-01-13 10:49:35', NULL, NULL, '205 Trần Kim Ngân', '0345619531', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '087306011714'),
(97, '206 Bùi Tấn Đạt', '$2y$13$vnAzc/8K1ZPuLhF7CynyT.u2FCqmhouVY8kSBySv93a9wjANaAKC2', NULL, '', NULL, 10, '2025-01-13 10:55:46', NULL, NULL, '206 Bùi Tấn Đạt', '0969507080', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '072204007001'),
(98, '207 Võ Thanh Trường', '$2y$13$ieFSS629CssdIjbuCuoj.OYzbBkARph/1YOQLTrrFgU82s4bqNbMC', NULL, '', NULL, 10, '2025-01-13 11:02:09', NULL, NULL, '207 Võ Thanh Trường', '0931865654', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(99, '208 Huỳnh Thị Kim Phượng', '$2y$13$rJFZJ/XEkzf2jakNuwW1Pe1AtmQKmwKRbk2T8pty9QEOXBp5gBV4y', NULL, '', NULL, 10, '2025-01-13 11:06:24', NULL, NULL, '208 Huỳnh Thị Kim Phượng', '0388856056', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(100, '301 Đào Tường Vĩ', '$2y$13$Hzdn6d50H8PcYvXxSUB1i.KnKXCFGNCbcP4h5rMojn0DpncYdctSC', NULL, '', NULL, 10, '2025-01-13 11:11:09', NULL, NULL, '301 Đào Tường Vĩ', '0814946407', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '082203007024'),
(101, '302 Nguyễn Thị Ngọc Linh', '$2y$13$iU7iTTGDLs8n1nKxUvOG5.fgBctKxQssjs2XhyVoFEeFikA8rp6ja', NULL, '', NULL, 10, '2025-01-13 11:26:59', NULL, NULL, '302 Nguyễn Thị Ngọc Linh', '0364429312', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '060300005749'),
(102, '303 Ngô Trần Diễm My', '$2y$13$fvQrYNhKPimjZXaCUuWLzOQ23b7wE1kzOY4t7padz9S3V0IX4ViFC', NULL, '', NULL, 10, '2025-01-13 11:30:11', NULL, NULL, '303 Ngô Trần Diễm My', '0947559199', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '084306008470'),
(103, '304 Lê Võ Khắc Minh Nhật', '$2y$13$p5EmKXJkauPGWT/7vUgFwO.3eonOie821MoIAKXKTfb3S9SXorrla', NULL, '', NULL, 10, '2025-01-13 11:33:41', NULL, NULL, '304 Lê Võ Khắc Minh Nhật', '0971688861', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(104, '305 Giáp Thị Yến Vy', '$2y$13$LjgDxuS/5.MZJsqV8ud1QupR7BJ5NkBHSm89HcZA81k2X7CR45i76', NULL, '', NULL, 0, '2025-01-13 11:36:35', NULL, NULL, '305 Giáp Thị Yến Vy', '0326342390', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(105, '306 Nguyễn Mai Chi', '$2y$13$j7aom9csRZ/IxJanHsVZU.lIAwh3kAqof99LkrNbceP5t/WxiOzcy', NULL, '', NULL, 0, '2025-01-13 11:40:21', NULL, NULL, '306 Nguyễn Mai Chi', '0909842383', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(106, '307 Nguyễn Thị Thanh Trang', '$2y$13$wYYj50xwTA5/RkaAlEVAG.IwXXR//.S0691p75ZN9pXdWweoMB5PS', NULL, '', NULL, 10, '2025-01-13 11:45:10', NULL, NULL, '307 Nguyễn Thị Thanh Trang', '0868768175', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(107, '308 Lê Thị Thu Phương', '$2y$13$26UxFiHXzW65IXptUxBk2eVVnwVeUNB4rM59GUmQ8UyfXLDjVGBZa', NULL, '', NULL, 10, '2025-01-13 11:48:41', NULL, NULL, '308 Lê Thị Thu Phương', '0779761026', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(108, '104 Bùi Thị Oanh', '$2y$13$HXqlMu3REYV1ItIBfcvP9.0DgLni2TXJse9dhmweQCw.jc3TcVTgq', NULL, '', 'test_gui_anh', 0, '2025-01-16 09:31:15', NULL, NULL, '104 Bùi Thị Oanh', '0333056078', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(109, 'Test gửi ảnh', '$2y$13$HXqlMu3REYV1ItIBfcvP9.0DgLni2TXJse9dhmweQCw.jc3TcVTgq', NULL, NULL, 'test_gui_anh', 0, '2025-01-16 09:31:15', NULL, NULL, 'Ten Modify', '0333056078', 'no-image.jpg', 0, '0', 1, '2003-12-12', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1737022273truoc.jpg,1737022273sau.jpg', NULL),
(110, 'Ngọc Ánh', '$2y$13$9lFu8OWTVB6PUn07OUeObO7CgqOob/L0KIchfAPEV238AAIY9E1zW', NULL, '', NULL, 0, '2025-01-26 20:10:52', NULL, NULL, 'Ngọc Ánh', '0333056078', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', ''),
(111, 'Trần Ngô Bảo Duy', '$2y$13$1wQBMYba37UnDkgSeozZVuwo15UqDJ/s3q1GqjhEVh0naZF.Rznz.', NULL, '', NULL, 10, '2025-02-16 19:57:19', NULL, NULL, '102 Trần Ngô Bảo Duy', '0364972537', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '079203020132'),
(112, 'Nguyễn Đắc Hồng Quang', '$2y$13$XgwLxYnZQQE/A.B7eFBL4.UsQB.X1g8zSx8.LEWmOmAWIsnERahF2', NULL, '', NULL, 10, '2025-02-16 19:59:29', NULL, NULL, 'Nguyễn Đắc Hồng Quang', '0935003031', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '048206000292'),
(113, 'Trần La Nhật Phương', '$2y$13$EdPSey1fhsf.ArPyl6LM7eEhhpXPSTUDR.CNEPxqDKu3IIVza78XW', NULL, '', NULL, 10, '2025-02-16 20:01:43', NULL, NULL, 'Trần La Nhật Phương', '0366036314', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '068300004920'),
(114, 'huuphu', '$2y$13$MdODem0rdvN5gqBlfvGE0.7OVgcBdwS4ORmDLBt09sOJsn39tiize', NULL, '', NULL, 10, '2025-02-20 08:48:54', NULL, NULL, 'Hữu Phú', '0398664609', '', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 'Huuphusale', '$2y$13$RfM.NyAaaDHLyZHJDPzXt.YDaU3dY2soElrkamj3PjBT6uPOmaVrS', NULL, '', NULL, 10, '2025-02-20 08:50:12', NULL, NULL, 'Nguyễn Hữu Phú', '0398664609', '', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 'huuphusale11111', '$2y$13$u6mA2arHJ2bppFiogKJqTOG7oMWG7FQHwv.E/RMVlcHkJbz8fQS52', NULL, '', NULL, 10, '2025-02-20 09:03:36', NULL, NULL, 'Nguyễn Hữu Phú', '0398664608', '', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 'buinguyennhuy', '$2y$13$NalQqDfpDM1rIUlhEmeagewbgbXtK03LDOa0oRdi8hRORozsHa1CC', NULL, '', NULL, 10, '2025-02-20 09:29:14', NULL, NULL, 'Bùi Nguyễn Như Ý', '0334730671', '', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 'Duy Vũ', '$2y$13$iujg19YwPC/80GdonKXdauJiWVH3XXQAre9VrhsBLEVLpWA5NBCAG', NULL, '', NULL, 10, '2025-03-03 15:39:53', NULL, NULL, 'Duy Vũ', '0343968326', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11740993974105-vu.jpg,11740993974vu.jpg', '628206005919'),
(119, 'Minh Đăng', '$2y$13$UmHr9gea4Wk1PYYE7ZLEkO0OOmkzoa9chjlS8xcUz1qNobsUUBlc6', NULL, '', NULL, 10, '2025-03-03 15:42:03', NULL, NULL, 'Minh Đăng ', '0765738827', '', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 'Minh Hưng', '$2y$13$i/qLVx.b2ldYgwX90NNLMOdZ3NwBpIEAy9XHVChMS.rdZtslGVnNu', NULL, '', NULL, 10, '2025-03-03 15:45:05', NULL, NULL, 'Minh Hưng', '0765738827', '', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, 'dươngquanglinh', '$2y$13$OYbzZ1QBgoGerCpECjdwK.WBFNOQKC5kU9jMTZeAOjj4szO51fzHm', NULL, '', NULL, 10, '2025-04-04 11:35:23', NULL, NULL, 'Dương Quang Linh', '0365966952', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '075200001222'),
(122, 'Hoangnhuy', '$2y$13$mJB37BgSswp6X46hPfFQ9.klQl08YodDOC0v7/lhoszc7tT3qKPCm', NULL, '', NULL, 10, '2025-04-09 08:49:56', NULL, NULL, 'Hoàng Như Ý', '0522207086', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '075300007635'),
(123, 'phamthithao', '$2y$13$AJoQgqVOOo7dJXC5.HN.CuWMOGnHfCr0jsNSeiqk5SjG70WT6F.Lu', NULL, '', NULL, 10, '2025-04-09 10:22:09', NULL, NULL, 'Phạm Thị Thảo', '0349239155', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '075197001703'),
(124, 'lethehoang', '$2y$13$CQXlbCYWtVP.qhMC3ybeNevhcbhwF.DbmxGHRrbbPExX5/Hj0/f6.', NULL, '', NULL, 10, '2025-04-09 10:26:48', NULL, NULL, 'Lê Thế Hoàng', '0981138662', '', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 'dươngquanglinhk3', '$2y$13$aCC03GGs5DUis5ubalSFS.hDZX3Td0PzRLd3IpIrjgKGG6Fx5II2.', NULL, '', NULL, 10, '2025-04-09 10:35:19', NULL, NULL, 'Dương Quang Linh', '075200001222', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '075200001222'),
(126, 'nguyenleanhnhat', '$2y$13$6MlFHbLQeP3ATfIhXR0Q1O0UgwVFenPVpzG1DgSPKrhiur9SlPlDC', NULL, '', NULL, 10, '2025-04-09 10:36:40', NULL, NULL, 'Nguyễn Lê Anh Nhật', '0932123159', '', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(127, 'lethikieuoanh', '$2y$13$vQdSxj.9c3sqbkvOJpIxeuQtaxo2rpY7Yfv8l1KJraLstog89QBnG', NULL, '', NULL, 10, '2025-04-22 11:36:51', NULL, NULL, 'Lê Thị Kiều Oanh', '0346800194', 'no-image.jpg', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'no-image.jpg,no-image.jpg', '077302005722'),
(128, 'phamthithuyuyen', '$2y$13$QyRZ266.8TPLUkXoRBXAIO3Jv3.dB7JkO9DEByXbrD50bN4ovTMSu', NULL, '', NULL, 10, '2025-04-22 11:39:11', NULL, NULL, 'Phạm Thị Thùy Uyên', '0383526474', '', 0, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `qlcvsd_user_vai_tro`
-- (See below for the actual view)
--
CREATE TABLE `qlcvsd_user_vai_tro` (
`id` int(11)
,`username` varchar(100)
,`password_hash` varchar(100)
,`password_reset_token` varchar(45)
,`email` varchar(100)
,`auth_key` varchar(32)
,`status` int(11)
,`created_at` datetime
,`updated_at` datetime
,`password` varchar(100)
,`hoten` varchar(100)
,`dien_thoai` varchar(20)
,`anhdaidien` varchar(100)
,`VIP` tinyint(1)
,`vi_dien_tu` decimal(20,0)
,`hoat_dong` tinyint(1)
,`birth_day` date
,`kichHoat` tinyint(1)
,`dia_chi` varchar(300)
,`ho_ten_tai_khoan` varchar(100)
,`so_tai_khoan` varchar(100)
,`te_ngan_hang` varchar(400)
,`user_old_id` int(11)
,`nguoi_phu_trach_id` int(11)
,`auth_web` varchar(100)
,`anhcancuoc` varchar(200)
,`vai_tro_id` int(11)
,`vai_tro` varchar(100)
);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_vaitro_user`
--

CREATE TABLE `qlcvsd_vaitro_user` (
  `id` int(11) NOT NULL,
  `vai_tro_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_vaitro_user`
--

INSERT INTO `qlcvsd_vaitro_user` (`id`, `vai_tro_id`, `user_id`) VALUES
(172, 1, 1),
(184, 7, 45),
(199, 7, 60),
(200, 7, 61),
(201, 7, 62),
(203, 7, 36),
(204, 7, 37),
(207, 7, 39),
(208, 7, 40),
(209, 7, 41),
(210, 7, 42),
(211, 7, 52),
(212, 7, 51),
(213, 7, 50),
(215, 7, 49),
(217, 7, 48),
(218, 7, 47),
(219, 7, 46),
(221, 7, 44),
(222, 7, 43),
(223, 7, 53),
(224, 7, 54),
(225, 7, 55),
(226, 7, 56),
(227, 7, 57),
(228, 7, 58),
(229, 7, 59),
(230, 7, 63),
(231, 7, 64),
(232, 7, 65),
(233, 7, 66),
(234, 7, 67),
(235, 7, 68),
(243, 7, 73),
(244, 8, 74),
(245, 7, 75),
(246, 8, 76),
(247, 7, 77),
(248, 7, 78),
(249, 7, 79),
(250, 7, 80),
(251, 7, 81),
(252, 7, 82),
(253, 7, 83),
(255, 7, 38),
(259, 7, 85),
(260, 7, 84),
(261, 7, 35),
(262, 7, 86),
(263, 7, 87),
(264, 7, 88),
(266, 7, 90),
(267, 7, 91),
(268, 7, 92),
(270, 7, 94),
(271, 7, 95),
(272, 7, 96),
(274, 7, 98),
(276, 7, 100),
(277, 7, 101),
(279, 7, 103),
(280, 7, 104),
(281, 7, 105),
(282, 7, 106),
(284, 7, 108),
(285, 7, 110),
(286, 7, 93),
(289, 7, 111),
(293, 8, 116),
(294, 8, 117),
(296, 7, 89),
(297, 7, 97),
(298, 7, 99),
(299, 7, 102),
(300, 7, 107),
(302, 8, 119),
(309, 8, 124),
(312, 8, 126),
(314, 8, 128),
(316, 7, 127),
(317, 7, 125),
(318, 7, 123),
(319, 7, 122),
(320, 7, 121),
(321, 7, 118),
(322, 7, 113),
(323, 7, 112);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qlcvsd_vai_tro`
--

CREATE TABLE `qlcvsd_vai_tro` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `luong` decimal(20,0) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `qlcvsd_vai_tro`
--

INSERT INTO `qlcvsd_vai_tro` (`id`, `name`, `code`, `active`, `luong`) VALUES
(1, 'Quản lý hệ thống', NULL, 1, '0'),
(2, 'Trưởng phòng', NULL, 1, '0'),
(3, 'Nhân viên', NULL, 1, '0'),
(4, 'Quản lý', NULL, 1, '0'),
(5, 'Trưởng nhóm', NULL, 1, '0'),
(6, 'Chủ Tịch', NULL, 1, '0'),
(7, 'Khách hàng', NULL, 1, '0'),
(8, 'Sale', NULL, 1, '0');

-- --------------------------------------------------------

--
-- Cấu trúc cho view `qlcvsd_quan_ly_giao_dich`
--
DROP TABLE IF EXISTS `qlcvsd_quan_ly_giao_dich`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qlcvsd_quan_ly_giao_dich`  AS SELECT `t`.`id` AS `id`, `t`.`khach_hang_id` AS `khach_hang_id`, `t`.`trang_thai_giao_dich` AS `trang_thai_giao_dich`, `t`.`phong_khach_id` AS `phong_khach_id`, `t`.`active` AS `active`, `t`.`so_tien_giao_dich` AS `so_tien_giao_dich`, `t`.`created` AS `created`, `t`.`user_id` AS `user_id`, `t`.`tong_tien` AS `tong_tien`, `t`.`ghi_chu` AS `ghi_chu`, `t`.`giao_dich_old_id` AS `giao_dich_old_id`, `t`.`loai_giao_dich` AS `loai_giao_dich`, `t`.`anh_chuyen_khoan` AS `anh_chuyen_khoan`, `t`.`ma_qr` AS `ma_qr`, `t`.`hoa_don_id` AS `hoa_don_id`, `t`.`noi_dung_chuyen_khoan` AS `noi_dung_chuyen_khoan`, `t`.`ma_id_casso` AS `ma_id_casso`, `rv`.`ma_hop_dong` AS `ma_hop_dong`, `rv`.`thanh_tien` AS `thanh_tien`, `rvt`.`name` AS `ten_phong`, `rvtt`.`name` AS `ten_toa_nha`, `khach`.`hoten` AS `hoten`, `khach`.`dien_thoai` AS `dien_thoai`, `hoadon`.`ma_hoa_don` AS `ma_hoa_don`, `thuchien`.`hoten` AS `nguoi_thuc_hien` FROM ((((((`qlcvsd_giao_dich` `t` left join `qlcvsd_phong_khach` `rv` on(`t`.`phong_khach_id` = `rv`.`id`)) left join `qlcvsd_danh_muc` `rvt` on(`rvt`.`id` = `rv`.`phong_id`)) left join `qlcvsd_danh_muc` `rvtt` on(`rvtt`.`id` = `rvt`.`parent_id`)) left join `qlcvsd_user` `khach` on(`khach`.`id` = `rv`.`khach_hang_id`)) left join `qlcvsd_hoa_don` `hoadon` on(`t`.`hoa_don_id` = `hoadon`.`id`)) left join `qlcvsd_user` `thuchien` on(`t`.`user_id` = `thuchien`.`id`)) ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `qlcvsd_quan_ly_hoa_don`
--
DROP TABLE IF EXISTS `qlcvsd_quan_ly_hoa_don`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qlcvsd_quan_ly_hoa_don`  AS SELECT `t`.`id` AS `id`, `t`.`phong_khach_id` AS `phong_khach_id`, `t`.`active` AS `active`, `t`.`chi_phi_dich_vu` AS `chi_phi_dich_vu`, `t`.`chot_hoa_don` AS `chot_hoa_don`, `t`.`da_thanh_toan` AS `da_thanh_toan`, `t`.`created` AS `created`, `t`.`thang` AS `thang`, `t`.`so_nguoi` AS `so_nguoi`, `t`.`tien_phong` AS `tien_phong`, `t`.`user_id` AS `user_id`, `t`.`tong_tien` AS `tong_tien`, `t`.`trang_thai` AS `trang_thai`, `t`.`nam` AS `nam`, `t`.`ma_hoa_don` AS `ma_hoa_don`, `rv`.`thanh_tien` AS `thanh_tien`, `rv`.`loai_hop_dong` AS `loai_hop_dong`, `rv`.`ma_hop_dong` AS `ma_hop_dong`, `rv`.`khach_hang_id` AS `khach_hang_id`, `rv`.`phong_id` AS `phong_id`, `rvt`.`name` AS `ten_phong`, `rvt`.`parent_id` AS `parent_id`, `rvtt`.`name` AS `ten_toa_nha`, `khach`.`hoten` AS `hoten`, `khach`.`dien_thoai` AS `dien_thoai`, `thuchien`.`hoten` AS `nguoi_thuc_hien` FROM (((((`qlcvsd_hoa_don` `t` left join `qlcvsd_phong_khach` `rv` on(`t`.`phong_khach_id` = `rv`.`id`)) left join `qlcvsd_danh_muc` `rvt` on(`rvt`.`id` = `rv`.`phong_id`)) left join `qlcvsd_danh_muc` `rvtt` on(`rvtt`.`id` = `rvt`.`parent_id`)) left join `qlcvsd_user` `khach` on(`khach`.`id` = `rv`.`khach_hang_id`)) left join `qlcvsd_user` `thuchien` on(`thuchien`.`id` = `t`.`user_id`)) ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `qlcvsd_quan_ly_khach_hang`
--
DROP TABLE IF EXISTS `qlcvsd_quan_ly_khach_hang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qlcvsd_quan_ly_khach_hang`  AS SELECT `t`.`id` AS `id`, `t`.`username` AS `username`, `t`.`password_hash` AS `password_hash`, `t`.`password_reset_token` AS `password_reset_token`, `t`.`email` AS `email`, `t`.`auth_key` AS `auth_key`, `t`.`status` AS `status`, `t`.`created_at` AS `created_at`, `t`.`updated_at` AS `updated_at`, `t`.`password` AS `password`, `t`.`hoten` AS `hoten`, `t`.`dien_thoai` AS `dien_thoai`, `t`.`anhdaidien` AS `anhdaidien`, `t`.`VIP` AS `VIP`, `t`.`vi_dien_tu` AS `vi_dien_tu`, `t`.`hoat_dong` AS `hoat_dong`, `t`.`birth_day` AS `birth_day`, `t`.`kichHoat` AS `kichHoat`, `t`.`dia_chi` AS `dia_chi`, `t`.`ho_ten_tai_khoan` AS `ho_ten_tai_khoan`, `t`.`so_tai_khoan` AS `so_tai_khoan`, `t`.`te_ngan_hang` AS `te_ngan_hang`, `t`.`user_old_id` AS `user_old_id`, `t`.`nguoi_phu_trach_id` AS `nguoi_phu_trach_id`, `t`.`auth_web` AS `auth_web`, `t`.`anhcancuoc` AS `anhcancuoc`, `t`.`so_cccd` AS `so_cccd` FROM ((`qlcvsd_user` `t` left join `qlcvsd_vaitro_user` `rv` on(`t`.`id` = `rv`.`user_id`)) left join `qlcvsd_vai_tro` `rvt` on(`rvt`.`id` = `rv`.`vai_tro_id`)) WHERE `rvt`.`id` = 7 GROUP BY `t`.`id` ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `qlcvsd_quan_ly_o_cung`
--
DROP TABLE IF EXISTS `qlcvsd_quan_ly_o_cung`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qlcvsd_quan_ly_o_cung`  AS SELECT `t`.`id` AS `id`, `t`.`nguoi_o_cung_id` AS `nguoi_o_cung_id`, `t`.`hoa_don_id` AS `hoa_don_id`, `rv`.`ma_hoa_don` AS `ma_hoa_don`, `rv`.`thang` AS `thang`, `rv`.`phong_khach_id` AS `hop_dong_id`, `rvt`.`ho_ten` AS `ho_ten`, `rvt`.`dien_thoai` AS `dien_thoai`, `rv`.`active` AS `active` FROM ((`qlcvsd_chi_tiet_o_cung` `t` left join `qlcvsd_hoa_don` `rv` on(`t`.`hoa_don_id` = `rv`.`id`)) left join `qlcvsd_nguoi_o_cung` `rvt` on(`t`.`nguoi_o_cung_id` = `rvt`.`id`)) ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `qlcvsd_quan_ly_phan_quyen`
--
DROP TABLE IF EXISTS `qlcvsd_quan_ly_phan_quyen`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qlcvsd_quan_ly_phan_quyen`  AS SELECT `t`.`id` AS `id`, `t`.`chuc_nang_id` AS `chuc_nang_id`, `t`.`vai_tro_id` AS `vai_tro_id`, `t2`.`name` AS `name`, `t2`.`nhom` AS `nhom`, `t2`.`controller_action` AS `controller_action`, `a`.`name` AS `tenvaitro`, `b`.`user_id` AS `user_id` FROM (((`qlcvsd_phan_quyen` `t` left join `qlcvsd_chuc_nang` `t2` on(`t`.`chuc_nang_id` = `t2`.`id`)) join `qlcvsd_vai_tro` `a` on(`t`.`vai_tro_id` = `a`.`id`)) left join `qlcvsd_vaitro_user` `b` on(`a`.`id` = `b`.`vai_tro_id`)) ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `qlcvsd_quan_ly_phong`
--
DROP TABLE IF EXISTS `qlcvsd_quan_ly_phong`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qlcvsd_quan_ly_phong`  AS SELECT `t`.`id` AS `id`, `t`.`selected` AS `selected`, `t`.`parent_id` AS `parent_id`, `t`.`name` AS `name`, `t`.`active` AS `active_phong`, `rv`.`hoten` AS `hoten`, `rv`.`dien_thoai` AS `dien_thoai`, `rv`.`ma_hop_dong` AS `ma_hop_dong`, `rvt`.`name` AS `ten_toa_nha`, `rv`.`active` AS `active`, `rv`.`thoi_gian_hop_dong_tu` AS `thoi_gian_hop_dong_tu`, `rv`.`thoi_gian_hop_dong_den` AS `thoi_gian_hop_dong_den` FROM ((`qlcvsd_danh_muc` `t` left join `qlcvsd_quan_ly_phong_khach` `rv` on(`t`.`id` = `rv`.`phong_id` and `rv`.`active` = 1 and current_timestamp() between `rv`.`thoi_gian_hop_dong_tu` and `rv`.`thoi_gian_hop_dong_den`)) left join `qlcvsd_danh_muc` `rvt` on(`t`.`parent_id` = `rvt`.`id`)) ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `qlcvsd_quan_ly_phong_khach`
--
DROP TABLE IF EXISTS `qlcvsd_quan_ly_phong_khach`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qlcvsd_quan_ly_phong_khach`  AS SELECT `t`.`id` AS `id`, `t`.`khach_hang_id` AS `khach_hang_id`, `t`.`phong_id` AS `phong_id`, `t`.`user_id` AS `user_id`, `t`.`sale_id` AS `sale_id`, `t`.`created` AS `created`, `t`.`thoi_gian_hop_dong_tu` AS `thoi_gian_hop_dong_tu`, `t`.`thoi_gian_hop_dong_den` AS `thoi_gian_hop_dong_den`, `t`.`coc_truoc` AS `coc_truoc`, `t`.`trang_thai` AS `trang_thai`, `t`.`ma_hop_dong` AS `ma_hop_dong`, `t`.`so_thang_hop_dong` AS `so_thang_hop_dong`, `t`.`don_gia` AS `don_gia`, `t`.`moi_gioi` AS `moi_gioi`, `t`.`active` AS `active`, `t`.`phong_cu_id` AS `phong_cu_id`, `t`.`chiet_khau` AS `chiet_khau`, `t`.`kieu_chiet_khau` AS `kieu_chiet_khau`, `t`.`kieu_moi_gioi` AS `kieu_moi_gioi`, `t`.`ghi_chu` AS `ghi_chu`, `t`.`so_tien_chiet_khau` AS `so_tien_chiet_khau`, `t`.`so_tien_moi_gioi` AS `so_tien_moi_gioi`, `t`.`thanh_tien` AS `thanh_tien`, `t`.`da_thanh_toan` AS `da_thanh_toan`, `t`.`da_thanh_toan_moi_gioi` AS `da_thanh_toan_moi_gioi`, `rv`.`name` AS `ten_phong`, `rv`.`selected` AS `selected`, `rvt`.`name` AS `ten_toa_nha`, `rvt`.`id` AS `toa_nha_id`, `khach`.`hoten` AS `hoten`, `khach`.`dien_thoai` AS `dien_thoai`, `sale`.`hoten` AS `hoten_sale`, `sale`.`dien_thoai` AS `dien_thoai_sale` FROM ((((`qlcvsd_phong_khach` `t` left join `qlcvsd_danh_muc` `rv` on(`t`.`phong_id` = `rv`.`id`)) left join `qlcvsd_danh_muc` `rvt` on(`rv`.`parent_id` = `rvt`.`id`)) left join `qlcvsd_user` `khach` on(`khach`.`id` = `t`.`khach_hang_id`)) left join `qlcvsd_user` `sale` on(`sale`.`id` = `t`.`sale_id`)) ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `qlcvsd_quan_ly_sale`
--
DROP TABLE IF EXISTS `qlcvsd_quan_ly_sale`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qlcvsd_quan_ly_sale`  AS SELECT `t`.`id` AS `id`, `t`.`username` AS `username`, `t`.`password_hash` AS `password_hash`, `t`.`password_reset_token` AS `password_reset_token`, `t`.`email` AS `email`, `t`.`auth_key` AS `auth_key`, `t`.`status` AS `status`, `t`.`created_at` AS `created_at`, `t`.`updated_at` AS `updated_at`, `t`.`password` AS `password`, `t`.`hoten` AS `hoten`, `t`.`dien_thoai` AS `dien_thoai`, `t`.`anhdaidien` AS `anhdaidien`, `t`.`VIP` AS `VIP`, `t`.`vi_dien_tu` AS `vi_dien_tu`, `t`.`hoat_dong` AS `hoat_dong`, `t`.`birth_day` AS `birth_day`, `t`.`kichHoat` AS `kichHoat`, `t`.`dia_chi` AS `dia_chi`, `t`.`ho_ten_tai_khoan` AS `ho_ten_tai_khoan`, `t`.`so_tai_khoan` AS `so_tai_khoan`, `t`.`te_ngan_hang` AS `te_ngan_hang`, `t`.`user_old_id` AS `user_old_id`, `t`.`nguoi_phu_trach_id` AS `nguoi_phu_trach_id`, `t`.`auth_web` AS `auth_web`, `t`.`anhcancuoc` AS `anhcancuoc`, `t`.`so_cccd` AS `so_cccd` FROM ((`qlcvsd_user` `t` left join `qlcvsd_vaitro_user` `rv` on(`t`.`id` = `rv`.`user_id`)) left join `qlcvsd_vai_tro` `rvt` on(`rvt`.`id` = `rv`.`vai_tro_id`)) WHERE `rvt`.`id` = 8 GROUP BY `t`.`id` ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `qlcvsd_quan_ly_user`
--
DROP TABLE IF EXISTS `qlcvsd_quan_ly_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qlcvsd_quan_ly_user`  AS SELECT `t`.`id` AS `id`, `t`.`username` AS `username`, `t`.`password_hash` AS `password_hash`, `t`.`password_reset_token` AS `password_reset_token`, `t`.`email` AS `email`, `t`.`auth_key` AS `auth_key`, `t`.`status` AS `status`, `t`.`created_at` AS `created_at`, `t`.`updated_at` AS `updated_at`, `t`.`password` AS `password`, `t`.`hoten` AS `hoten`, `t`.`dien_thoai` AS `dien_thoai`, `t`.`anhdaidien` AS `anhdaidien`, `t`.`VIP` AS `VIP`, `t`.`vi_dien_tu` AS `vi_dien_tu`, `t`.`hoat_dong` AS `hoat_dong`, `t`.`birth_day` AS `birth_day`, `t`.`kichHoat` AS `kichHoat`, `t`.`dia_chi` AS `dia_chi`, `t`.`ho_ten_tai_khoan` AS `ho_ten_tai_khoan`, `t`.`so_tai_khoan` AS `so_tai_khoan`, `t`.`te_ngan_hang` AS `te_ngan_hang`, `t`.`user_old_id` AS `user_old_id`, `t`.`nguoi_phu_trach_id` AS `nguoi_phu_trach_id`, `t`.`auth_web` AS `auth_web`, `t`.`anhcancuoc` AS `anhcancuoc`, group_concat(distinct `rvt`.`name` separator ',') AS `vai_tro` FROM ((`qlcvsd_user` `t` left join `qlcvsd_vaitro_user` `rv` on(`t`.`id` = `rv`.`user_id`)) left join `qlcvsd_vai_tro` `rvt` on(`rvt`.`id` = `rv`.`vai_tro_id`)) GROUP BY `t`.`id` ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `qlcvsd_user_vai_tro`
--
DROP TABLE IF EXISTS `qlcvsd_user_vai_tro`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qlcvsd_user_vai_tro`  AS SELECT `t`.`id` AS `id`, `t`.`username` AS `username`, `t`.`password_hash` AS `password_hash`, `t`.`password_reset_token` AS `password_reset_token`, `t`.`email` AS `email`, `t`.`auth_key` AS `auth_key`, `t`.`status` AS `status`, `t`.`created_at` AS `created_at`, `t`.`updated_at` AS `updated_at`, `t`.`password` AS `password`, `t`.`hoten` AS `hoten`, `t`.`dien_thoai` AS `dien_thoai`, `t`.`anhdaidien` AS `anhdaidien`, `t`.`VIP` AS `VIP`, `t`.`vi_dien_tu` AS `vi_dien_tu`, `t`.`hoat_dong` AS `hoat_dong`, `t`.`birth_day` AS `birth_day`, `t`.`kichHoat` AS `kichHoat`, `t`.`dia_chi` AS `dia_chi`, `t`.`ho_ten_tai_khoan` AS `ho_ten_tai_khoan`, `t`.`so_tai_khoan` AS `so_tai_khoan`, `t`.`te_ngan_hang` AS `te_ngan_hang`, `t`.`user_old_id` AS `user_old_id`, `t`.`nguoi_phu_trach_id` AS `nguoi_phu_trach_id`, `t`.`auth_web` AS `auth_web`, `t`.`anhcancuoc` AS `anhcancuoc`, `qvu`.`vai_tro_id` AS `vai_tro_id`, `qvt`.`name` AS `vai_tro` FROM ((`qlcvsd_user` `t` left join `qlcvsd_vaitro_user` `qvu` on(`t`.`id` = `qvu`.`user_id`)) left join `qlcvsd_vai_tro` `qvt` on(`qvu`.`vai_tro_id` = `qvt`.`id`)) ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `qlcvsd_cauhinh`
--
ALTER TABLE `qlcvsd_cauhinh`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `qlcvsd_chi_phi`
--
ALTER TABLE `qlcvsd_chi_phi`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `qlcvsd_chi_tiet_chi_phi`
--
ALTER TABLE `qlcvsd_chi_tiet_chi_phi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_chi_tiet_chi_phi_qlcvsd_chi_phi_id_fk` (`chi_phi_id`),
  ADD KEY `qlcvsd_chi_tiet_chi_phi_qlcvsd_phieu_chi_id_fk` (`phieu_chi_id`);

--
-- Chỉ mục cho bảng `qlcvsd_chi_tiet_hoa_don`
--
ALTER TABLE `qlcvsd_chi_tiet_hoa_don`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_chi_tiet_hoa_don_qlcvsd_hoa_don_id_fk` (`hoa_don_id`),
  ADD KEY `qlcvsd_chi_tiet_hoa_don_qlcvsd_thiet_lap_gia_id_fk` (`dich_vu_id`),
  ADD KEY `qlcvsd_chi_tiet_hoa_don_qlcvsd_user_id_fk` (`user_id`);

--
-- Chỉ mục cho bảng `qlcvsd_chi_tiet_o_cung`
--
ALTER TABLE `qlcvsd_chi_tiet_o_cung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_chi_tiet_o_cung_qlcvsd_hoa_don_id_fk` (`hoa_don_id`),
  ADD KEY `qlcvsd_chi_tiet_o_cung_qlcvsd_nguoi_o_cung_id_fk` (`nguoi_o_cung_id`);

--
-- Chỉ mục cho bảng `qlcvsd_chuc_nang`
--
ALTER TABLE `qlcvsd_chuc_nang`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `qlcvsd_danh_muc`
--
ALTER TABLE `qlcvsd_danh_muc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_danh_muc_qlcvsd_danh_muc_id_fk` (`parent_id`);

--
-- Chỉ mục cho bảng `qlcvsd_file_hop_dong`
--
ALTER TABLE `qlcvsd_file_hop_dong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_file_hop_dong_qlcvsd_phong_khach_id_fk` (`phong_khach_id`),
  ADD KEY `qlcvsd_file_hop_dong_qlcvsd_user_id_fk` (`user_id`);

--
-- Chỉ mục cho bảng `qlcvsd_giao_dich`
--
ALTER TABLE `qlcvsd_giao_dich`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_giao_dich_qlcvsd_user_id_fk` (`user_id`),
  ADD KEY `qlcvsd_giao_dich_qlcvsd_user_id_fk_2` (`khach_hang_id`),
  ADD KEY `qlcvsd_giao_dich_qlcvsd_phong_khach_id_fk` (`phong_khach_id`),
  ADD KEY `qlcvsd_giao_dich_qlcvsd_hoa_don_id_fk` (`hoa_don_id`);

--
-- Chỉ mục cho bảng `qlcvsd_gia_dien`
--
ALTER TABLE `qlcvsd_gia_dien`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `qlcvsd_gia_nuoc`
--
ALTER TABLE `qlcvsd_gia_nuoc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `qlcvsd_hoa_don`
--
ALTER TABLE `qlcvsd_hoa_don`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_hoa_don_qlcvsd_user_id_fk` (`user_id`),
  ADD KEY `qlcvsd_hoa_don_qlcvsd_danh_muc_id_fk` (`phong_khach_id`);

--
-- Chỉ mục cho bảng `qlcvsd_nguoi_o_cung`
--
ALTER TABLE `qlcvsd_nguoi_o_cung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_nguoi_o_cung_qlcvsd_phong_khach_id_fk` (`hop_dong_id`);

--
-- Chỉ mục cho bảng `qlcvsd_phan_quyen`
--
ALTER TABLE `qlcvsd_phan_quyen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_phan_quyen_qlcvsd_chuc_nang_id_fk` (`chuc_nang_id`),
  ADD KEY `qlcvsd_phan_quyen_qlcvsd_vai_tro_id_fk` (`vai_tro_id`);

--
-- Chỉ mục cho bảng `qlcvsd_phieu_chi`
--
ALTER TABLE `qlcvsd_phieu_chi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_phieu_chi_qlcvsd_danh_muc_id_fk` (`toa_nha_id`),
  ADD KEY `qlcvsd_phieu_chi_qlcvsd_user_id_fk` (`user_id`);

--
-- Chỉ mục cho bảng `qlcvsd_phong_khach`
--
ALTER TABLE `qlcvsd_phong_khach`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_phong_khach_qlcvsd_danh_muc_id_fk_2` (`phong_id`),
  ADD KEY `qlcvsd_phong_khach_qlcvsd_user_id_fk` (`khach_hang_id`),
  ADD KEY `qlcvsd_phong_khach_qlcvsd_user_id_fk_2` (`user_id`),
  ADD KEY `qlcvsd_phong_khach_qlcvsd_danh_muc_id_fk` (`phong_cu_id`),
  ADD KEY `qlcvsd_phong_khach_qlcvsd_user_id_fk_3` (`sale_id`);

--
-- Chỉ mục cho bảng `qlcvsd_thiet_lap_gia`
--
ALTER TABLE `qlcvsd_thiet_lap_gia`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `qlcvsd_trang_thai_giao_dich`
--
ALTER TABLE `qlcvsd_trang_thai_giao_dich`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_trang_thai_giao_dich_qlcvsd_giao_dich_id_fk` (`giao_dich_id`),
  ADD KEY `qlcvsd_trang_thai_giao_dich_qlcvsd_user_id_fk` (`user_id`);

--
-- Chỉ mục cho bảng `qlcvsd_trang_thai_hoa_don`
--
ALTER TABLE `qlcvsd_trang_thai_hoa_don`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_trang_thai_hoa_don_qlcvsd_user_id_fk` (`user_id`),
  ADD KEY `qlcvsd_trang_thai_hoa_don_qlcvsd_hoa_don_id_fk` (`hoa_don_id`);

--
-- Chỉ mục cho bảng `qlcvsd_trang_thai_phong`
--
ALTER TABLE `qlcvsd_trang_thai_phong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_trang_thai_phong_qlcvsd_user_id_fk` (`khach_hang_id`),
  ADD KEY `qlcvsd_trang_thai_phong_qlcvsd_danh_muc_id_fk` (`phong_id`);

--
-- Chỉ mục cho bảng `qlcvsd_trang_thai_phong_khach`
--
ALTER TABLE `qlcvsd_trang_thai_phong_khach`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_trang_thai_phong_khach_qlcvsd_phong_khach_id_fk` (`phong_khach_id`),
  ADD KEY `qlcvsd_trang_thai_phong_khach_qlcvsd_user_id_fk` (`user_id`);

--
-- Chỉ mục cho bảng `qlcvsd_user`
--
ALTER TABLE `qlcvsd_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_user_qlcvsd_user_id_fk` (`nguoi_phu_trach_id`);

--
-- Chỉ mục cho bảng `qlcvsd_vaitro_user`
--
ALTER TABLE `qlcvsd_vaitro_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qlcvsd_vaitro_user_qlcvsd_user_id_fk` (`user_id`),
  ADD KEY `qlcvsd_vaitro_user_qlcvsd_vai_tro_id_fk` (`vai_tro_id`);

--
-- Chỉ mục cho bảng `qlcvsd_vai_tro`
--
ALTER TABLE `qlcvsd_vai_tro`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `qlcvsd_cauhinh`
--
ALTER TABLE `qlcvsd_cauhinh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_chi_phi`
--
ALTER TABLE `qlcvsd_chi_phi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_chi_tiet_chi_phi`
--
ALTER TABLE `qlcvsd_chi_tiet_chi_phi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_chi_tiet_hoa_don`
--
ALTER TABLE `qlcvsd_chi_tiet_hoa_don`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7536;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_chi_tiet_o_cung`
--
ALTER TABLE `qlcvsd_chi_tiet_o_cung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=824;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_chuc_nang`
--
ALTER TABLE `qlcvsd_chuc_nang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_danh_muc`
--
ALTER TABLE `qlcvsd_danh_muc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_file_hop_dong`
--
ALTER TABLE `qlcvsd_file_hop_dong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_giao_dich`
--
ALTER TABLE `qlcvsd_giao_dich`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=816;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_gia_dien`
--
ALTER TABLE `qlcvsd_gia_dien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_gia_nuoc`
--
ALTER TABLE `qlcvsd_gia_nuoc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_hoa_don`
--
ALTER TABLE `qlcvsd_hoa_don`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1556;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_nguoi_o_cung`
--
ALTER TABLE `qlcvsd_nguoi_o_cung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_phan_quyen`
--
ALTER TABLE `qlcvsd_phan_quyen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6024;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_phieu_chi`
--
ALTER TABLE `qlcvsd_phieu_chi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_phong_khach`
--
ALTER TABLE `qlcvsd_phong_khach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=284;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_thiet_lap_gia`
--
ALTER TABLE `qlcvsd_thiet_lap_gia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_trang_thai_giao_dich`
--
ALTER TABLE `qlcvsd_trang_thai_giao_dich`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=897;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_trang_thai_hoa_don`
--
ALTER TABLE `qlcvsd_trang_thai_hoa_don`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2679;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_trang_thai_phong`
--
ALTER TABLE `qlcvsd_trang_thai_phong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_trang_thai_phong_khach`
--
ALTER TABLE `qlcvsd_trang_thai_phong_khach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_user`
--
ALTER TABLE `qlcvsd_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_vaitro_user`
--
ALTER TABLE `qlcvsd_vaitro_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=324;

--
-- AUTO_INCREMENT cho bảng `qlcvsd_vai_tro`
--
ALTER TABLE `qlcvsd_vai_tro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `qlcvsd_chi_tiet_chi_phi`
--
ALTER TABLE `qlcvsd_chi_tiet_chi_phi`
  ADD CONSTRAINT `qlcvsd_chi_tiet_chi_phi_qlcvsd_chi_phi_id_fk` FOREIGN KEY (`chi_phi_id`) REFERENCES `qlcvsd_chi_phi` (`id`),
  ADD CONSTRAINT `qlcvsd_chi_tiet_chi_phi_qlcvsd_phieu_chi_id_fk` FOREIGN KEY (`phieu_chi_id`) REFERENCES `qlcvsd_phieu_chi` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_chi_tiet_hoa_don`
--
ALTER TABLE `qlcvsd_chi_tiet_hoa_don`
  ADD CONSTRAINT `qlcvsd_chi_tiet_hoa_don_qlcvsd_hoa_don_id_fk` FOREIGN KEY (`hoa_don_id`) REFERENCES `qlcvsd_hoa_don` (`id`),
  ADD CONSTRAINT `qlcvsd_chi_tiet_hoa_don_qlcvsd_thiet_lap_gia_id_fk` FOREIGN KEY (`dich_vu_id`) REFERENCES `qlcvsd_thiet_lap_gia` (`id`),
  ADD CONSTRAINT `qlcvsd_chi_tiet_hoa_don_qlcvsd_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `qlcvsd_user` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_chi_tiet_o_cung`
--
ALTER TABLE `qlcvsd_chi_tiet_o_cung`
  ADD CONSTRAINT `qlcvsd_chi_tiet_o_cung_qlcvsd_hoa_don_id_fk` FOREIGN KEY (`hoa_don_id`) REFERENCES `qlcvsd_hoa_don` (`id`),
  ADD CONSTRAINT `qlcvsd_chi_tiet_o_cung_qlcvsd_nguoi_o_cung_id_fk` FOREIGN KEY (`nguoi_o_cung_id`) REFERENCES `qlcvsd_nguoi_o_cung` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_danh_muc`
--
ALTER TABLE `qlcvsd_danh_muc`
  ADD CONSTRAINT `qlcvsd_danh_muc_qlcvsd_danh_muc_id_fk` FOREIGN KEY (`parent_id`) REFERENCES `qlcvsd_danh_muc` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_file_hop_dong`
--
ALTER TABLE `qlcvsd_file_hop_dong`
  ADD CONSTRAINT `qlcvsd_file_hop_dong_qlcvsd_phong_khach_id_fk` FOREIGN KEY (`phong_khach_id`) REFERENCES `qlcvsd_phong_khach` (`id`),
  ADD CONSTRAINT `qlcvsd_file_hop_dong_qlcvsd_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `qlcvsd_user` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_giao_dich`
--
ALTER TABLE `qlcvsd_giao_dich`
  ADD CONSTRAINT `qlcvsd_giao_dich_qlcvsd_hoa_don_id_fk` FOREIGN KEY (`hoa_don_id`) REFERENCES `qlcvsd_hoa_don` (`id`),
  ADD CONSTRAINT `qlcvsd_giao_dich_qlcvsd_phong_khach_id_fk` FOREIGN KEY (`phong_khach_id`) REFERENCES `qlcvsd_phong_khach` (`id`),
  ADD CONSTRAINT `qlcvsd_giao_dich_qlcvsd_user_id_fk` FOREIGN KEY (`khach_hang_id`) REFERENCES `qlcvsd_user` (`id`),
  ADD CONSTRAINT `qlcvsd_giao_dich_qlcvsd_user_id_fk_2` FOREIGN KEY (`user_id`) REFERENCES `qlcvsd_user` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_hoa_don`
--
ALTER TABLE `qlcvsd_hoa_don`
  ADD CONSTRAINT `qlcvsd_hoa_don_qlcvsd_danh_muc_id_fk` FOREIGN KEY (`phong_khach_id`) REFERENCES `qlcvsd_phong_khach` (`id`),
  ADD CONSTRAINT `qlcvsd_hoa_don_qlcvsd_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `qlcvsd_user` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_nguoi_o_cung`
--
ALTER TABLE `qlcvsd_nguoi_o_cung`
  ADD CONSTRAINT `qlcvsd_nguoi_o_cung_qlcvsd_phong_khach_id_fk` FOREIGN KEY (`hop_dong_id`) REFERENCES `qlcvsd_phong_khach` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_phan_quyen`
--
ALTER TABLE `qlcvsd_phan_quyen`
  ADD CONSTRAINT `qlcvsd_phan_quyen_qlcvsd_chuc_nang_id_fk` FOREIGN KEY (`chuc_nang_id`) REFERENCES `qlcvsd_chuc_nang` (`id`),
  ADD CONSTRAINT `qlcvsd_phan_quyen_qlcvsd_vai_tro_id_fk` FOREIGN KEY (`vai_tro_id`) REFERENCES `qlcvsd_vai_tro` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_phieu_chi`
--
ALTER TABLE `qlcvsd_phieu_chi`
  ADD CONSTRAINT `qlcvsd_phieu_chi_qlcvsd_danh_muc_id_fk` FOREIGN KEY (`toa_nha_id`) REFERENCES `qlcvsd_danh_muc` (`id`),
  ADD CONSTRAINT `qlcvsd_phieu_chi_qlcvsd_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `qlcvsd_user` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_phong_khach`
--
ALTER TABLE `qlcvsd_phong_khach`
  ADD CONSTRAINT `qlcvsd_phong_khach_qlcvsd_danh_muc_id_fk` FOREIGN KEY (`phong_cu_id`) REFERENCES `qlcvsd_phong_khach` (`id`),
  ADD CONSTRAINT `qlcvsd_phong_khach_qlcvsd_danh_muc_id_fk_2` FOREIGN KEY (`phong_id`) REFERENCES `qlcvsd_danh_muc` (`id`),
  ADD CONSTRAINT `qlcvsd_phong_khach_qlcvsd_user_id_fk` FOREIGN KEY (`khach_hang_id`) REFERENCES `qlcvsd_user` (`id`),
  ADD CONSTRAINT `qlcvsd_phong_khach_qlcvsd_user_id_fk_2` FOREIGN KEY (`user_id`) REFERENCES `qlcvsd_user` (`id`),
  ADD CONSTRAINT `qlcvsd_phong_khach_qlcvsd_user_id_fk_3` FOREIGN KEY (`sale_id`) REFERENCES `qlcvsd_user` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_trang_thai_hoa_don`
--
ALTER TABLE `qlcvsd_trang_thai_hoa_don`
  ADD CONSTRAINT `qlcvsd_trang_thai_hoa_don_qlcvsd_hoa_don_id_fk` FOREIGN KEY (`hoa_don_id`) REFERENCES `qlcvsd_hoa_don` (`id`),
  ADD CONSTRAINT `qlcvsd_trang_thai_hoa_don_qlcvsd_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `qlcvsd_user` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_trang_thai_phong`
--
ALTER TABLE `qlcvsd_trang_thai_phong`
  ADD CONSTRAINT `qlcvsd_trang_thai_phong_qlcvsd_danh_muc_id_fk` FOREIGN KEY (`phong_id`) REFERENCES `qlcvsd_danh_muc` (`id`),
  ADD CONSTRAINT `qlcvsd_trang_thai_phong_qlcvsd_user_id_fk` FOREIGN KEY (`khach_hang_id`) REFERENCES `qlcvsd_user` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_trang_thai_phong_khach`
--
ALTER TABLE `qlcvsd_trang_thai_phong_khach`
  ADD CONSTRAINT `qlcvsd_trang_thai_phong_khach_qlcvsd_phong_khach_id_fk` FOREIGN KEY (`phong_khach_id`) REFERENCES `qlcvsd_phong_khach` (`id`),
  ADD CONSTRAINT `qlcvsd_trang_thai_phong_khach_qlcvsd_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `qlcvsd_user` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_user`
--
ALTER TABLE `qlcvsd_user`
  ADD CONSTRAINT `qlcvsd_user_qlcvsd_user_id_fk` FOREIGN KEY (`nguoi_phu_trach_id`) REFERENCES `qlcvsd_user` (`id`);

--
-- Các ràng buộc cho bảng `qlcvsd_vaitro_user`
--
ALTER TABLE `qlcvsd_vaitro_user`
  ADD CONSTRAINT `qlcvsd_vaitro_user_qlcvsd_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `qlcvsd_user` (`id`),
  ADD CONSTRAINT `qlcvsd_vaitro_user_qlcvsd_vai_tro_id_fk` FOREIGN KEY (`vai_tro_id`) REFERENCES `qlcvsd_vai_tro` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
