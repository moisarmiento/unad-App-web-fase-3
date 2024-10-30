-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 30-10-2024 a las 02:53:48
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `unad_app_web_fase3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `Id_Producto` int NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Nombre` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `Descripción` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `Categoria` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `Disponibilidad` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `Precio` int NOT NULL,
  `Imagen` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`Id_Producto`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Id_Producto`, `Codigo`, `Nombre`, `Descripción`, `Categoria`, `Disponibilidad`, `Precio`, `Imagen`) VALUES
(1, '1', 'taladro', 'taladro percutor', 'construcción', 'si', 500000, '../IMAGENES/taladro_1.PNG'),
(2, '2', 'Pintura Vinilo Blanco', 'Pintura Vinilo Tipo 1 Interior - Exterior Blanco Cuñete udu', 'pintura', 'si', 50000, '../IMAGENES/P_V_Blanco.PNG'),
(3, '3', '1 kl soldadura', 'Lincoln Ferretero E-6013 Ho 3/32 5kg', 'ornamentación ', 'si', 70000, '../IMAGENES/soldadura_1k.PNG'),
(4, '4', 'pintura Aerosol negro', 'Pintura Alta Temperatura En Aerosol 400ml Waltek Color Negro', 'pintura', 'si', 10000, '../IMAGENES/pintura_ess.PNG'),
(5, '5', 'pintura esmalte  Amarillo', 'Pintura Esmalte Doméstico Amarillo P-18 1 Gal Pintuco', 'pintura', 'si', 95000, '../IMAGENES/pintura_esmalte.PNG'),
(6, '6', 'pintura blanca baños', 'Pintura Viniltex Baños Y Cocinas Blanco', 'pintura', 'si', 100000, '../IMAGENES/Pintura_Viniltex_Blan.PNG'),
(7, '7', 'palustre', 'palustre eee', 'construcción', 'si', 9000, '../IMAGENES/palustre.PNG'),
(8, '8', 'cemento', '5 kl de cemento', 'construcción', 'si', 20000, '../IMAGENES/cemento.PNG'),
(9, '9', 'bloque', 'bloque lijero', 'construcción', 'si', 1500, '../IMAGENES/ladrillo.PNG'),
(10, '10', 'ladrillo', 'ladrillo contundente ', 'construcción', 'si', 800, '../IMAGENES/ladrillo__1.PNG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `Id_usuario` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `contraseña` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Num_compras` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id_usuario`, `Nombre`, `contraseña`, `Num_compras`) VALUES
(1, 'control_maestro', '987654321', 0),
(2, 'juanito1', '123', 10),
(3, 'pepito1', 'moises', 5),
(4, 'juanito2', '222', 2),
(5, 'lokus', 'lll', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
