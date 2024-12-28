-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Des 2024 pada 12.39
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kopikita`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `deskripsi`, `harga`, `gambar`) VALUES
(1, 'Pizza', 'Pizza medium dengan toping keju.', 75000, 'pizza.jpeg'),
(2, 'Sop Iga', 'Sop dengan iga sapi premium', 65000, 'sop buntut.jpeg'),
(3, 'Burger', 'Burger patty daging sapi, sayur, dan keju.', 45000, 'burger.jpeg'),
(4, 'Pasta', 'Mie pasta dengan toping daging, ala Italia.', 55000, 'spageti.jpeg'),
(5, 'Jus Mangga', 'Jus mangga pilihan yang manis dan sehat.', 20000, 'jus mangga.jpeg'),
(6, 'Jus Alpukat', 'Jus alpukat premium manis dan sehat.', 25000, 'jus alpukat.jpeg'),
(7, 'Coffe Latte', 'Coffe cappuccino dengan krim di atasnya.', 30000, 'kopi late.jpeg'),
(8, 'Wedang Jahe', 'Wedang jahe dengan jahe pilihan.', 15000, 'koyone jahe.jpeg'),
(9, 'Waffel Es Krim', 'Waffel dengan es krim di atasnya.', 35000, 'es.jpeg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `tanggal_pesanan` datetime DEFAULT current_timestamp(),
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `id_menu`, `jumlah`, `total_harga`, `tanggal_pesanan`, `keterangan`) VALUES
(7, 9, 5, 3, 60000, '2024-12-28 15:37:31', 'kurangi gula'),
(8, 9, 3, 5, 225000, '2024-12-28 15:38:43', 'daging nya banyakin'),
(9, 12, 4, 4, 220000, '2024-12-28 15:44:43', 'yang pedes'),
(10, 14, 8, 18, 270000, '2024-12-28 16:50:40', 'jahe nya banyakin ya'),
(11, 9, 2, 4, 260000, '2024-12-28 17:05:43', 'daging nya banyakin'),
(12, 9, 9, 4, 140000, '2024-12-28 17:06:22', 'aku mau banyakin cokelat nya wir'),
(13, 15, 1, 7, 525000, '2024-12-28 17:21:49', 'aku mau pizza'),
(14, 16, 8, 70, 1050000, '2024-12-28 17:32:04', 'gula nya banyakin'),
(15, 9, 3, 3, 135000, '2024-12-28 17:39:19', 'banyakin sayur');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('kasir','customer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(7, 'admin', '$2y$10$WERI3NAIgR.fomWo9sY.fOchnGijNhSwFJFpX8N6ee8RdbT6WaisC', 'kasir'),
(8, 'customer123', 'customerpass', 'customer'),
(9, 'akbar', '$2y$10$tQWdLqffG3TiQyWyEfkGkuiIPAQGcMnGSBHrgWIVaanG/Xw4N0B2C', 'customer'),
(10, 'marsel', '$2y$10$7sQTxNoSQTPAtgqlOKfVRuIDmOq2iWZ0Ejk2CbWEIKoPy3RJSyBSy', 'customer'),
(11, 'trinil', '$2y$10$nAijr2xvTSgUTuwqPWFDUuRAkr0JG8Ti0iuoXFvgXH1qv1g.w0wZm', 'customer'),
(12, 'sela', '$2y$10$TMWkfMXY8SHfOskZaePK6.hxyUIHtb/d746A8QAbaFgsHYISNkDkK', 'customer'),
(13, 'dudul', '$2y$10$c/9JcznjcKHKofuxvEzs3eGCJGJTgL1p1CEPwWT0ZTGFCTAKgOZy6', 'customer'),
(14, 'macel', '$2y$10$moNS6ZUfTs.Ywy3PPqpRSuATbtOnrF2141SuIzywolIFVcZEeO56a', 'customer'),
(15, 'upin', '$2y$10$enCCmPWlSYEQNwKSNxEgLeNS77QFbYZn4zs84yQsw320dzAiUE2EG', 'customer'),
(16, 'dico', '$2y$10$m4JTr7XCk5pFBDi0ob3aWeK3V6wT2N9oc7N.pvfNv8nGlxvtfQPzO', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
