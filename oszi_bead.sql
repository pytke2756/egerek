-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2021. Nov 14. 14:57
-- Kiszolgáló verziója: 10.4.21-MariaDB
-- PHP verzió: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `oszi_bead`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `egerek`
--

CREATE TABLE `egerek` (
  `id` int(11) NOT NULL,
  `nev` varchar(64) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `szin` varchar(32) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `erzekelo` varchar(32) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `gombok_szama` int(11) NOT NULL,
  `bluetooth` tinyint(1) NOT NULL,
  `vezetek_nelkuli` tinyint(1) NOT NULL,
  `usb_csatlakozo` tinyint(1) NOT NULL,
  `utoljara_vasaroltak` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `egerek`
--

INSERT INTO `egerek` (`id`, `nev`, `szin`, `erzekelo`, `gombok_szama`, `bluetooth`, `vezetek_nelkuli`, `usb_csatlakozo`, `utoljara_vasaroltak`) VALUES
(1, 'LOGITECH G703 Lightspeed', 'fekete', 'optikai', 6, 0, 1, 1, '2021-10-03'),
(2, 'LOGITECH G Pro X Superlight', 'fekete', 'optikai', 6, 0, 1, 1, '2021-10-13'),
(3, 'LOGITECH G Pro Wireless', 'fekete', 'optikai', 6, 1, 1, 1, '2021-10-09'),
(4, 'STEELSERIES Rival 3', 'fekete', 'optikai', 5, 0, 1, 1, '2014-10-14'),
(17, 'GENIUS DX-120', 'kék', 'optikai', 4, 1, 1, 1, '2021-11-01');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `egerek`
--
ALTER TABLE `egerek`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `egerek`
--
ALTER TABLE `egerek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
