-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-04-2022 a las 07:18:50
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `registros`
--


-- Volcando estructura de base de datos para registros
CREATE DATABASE IF NOT EXISTS `registros` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `registros`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asientos`
--

CREATE TABLE `asientos` (
  `ID_asiento` int(9) UNSIGNED NOT NULL,
  `nombre_usuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `membresia` enum('Bronze','Silver','Gold') NOT NULL,
  `No_ticket` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ID_usuario_FOR` int(9) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `asientos`
--

INSERT INTO `asientos` (`ID_asiento`, `nombre_usuario`, `membresia`, `No_ticket`, `ID_usuario_FOR`) VALUES
(26, 'Juan Perez', 'Bronze', '11 _tk13', 11),
(27, 'Manuel Herrera', 'Silver', '11_tk22', 11),
(28, 'Pedro Salas', 'Bronze', '11_tk36', 11),
(29, 'Francisco Yasser', 'Bronze', '11_tk27', 11),
(30, 'Giovanny Garcia', 'Bronze', '11_tk41', 11),
(31, 'Mamá de Yasser', 'Silver', '10_tk02', 10),
(32, 'Papá de Yasser', 'Silver', '10_tk11', 10),
(34, 'Juan Perez Lopez', 'Silver', '13_tk02', 13),
(35, 'Marin Lopez Jores', 'Bronze', '13_tk11', 13),
(36, 'Martin Peres Venaz', 'Bronze', '13_tk24', 13),
(37, 'pepe lopez', 'Bronze', '13_tk32', 13),
(38, 'Pablo Juliet', 'Silver', '15_tk02', 15),
(39, 'Maria Juliet', 'Silver', '15_tk11', 15),
(40, 'JUan', 'Bronze', '15_tk212', 15),
(41, 'dsadasdasdasd', 'Gold', '16_tk021', 16),
(42, '123123', 'Bronze', '16_tk120', 16),
(43, 'Juanito Hernandez', 'Gold', '6_tk02', 6),
(44, 'Solesitoa', 'Bronze', '14_tk02', 14),
(45, 'No lo se', 'Bronze', '14_tk11', 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_usuario` int(5) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `contrasena` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `correo` varchar(100) NOT NULL,
  `edad` int(3) UNSIGNED NOT NULL,
  `asientos_reservados` int(255) UNSIGNED DEFAULT '0',
  `asientos_agregar` int(255) UNSIGNED NOT NULL,
  `creditos` int(255) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_usuario`, `nombre`, `apellido_paterno`, `apellido_materno`, `contrasena`, `correo`, `edad`, `asientos_reservados`, `asientos_agregar`, `creditos`) VALUES
(1, 'Juan', 'Perez', 'Lopez', '1234567890', 'juan.is@unipolidgo.edu.mx', 18, 0, 0, 10000),
(2, 'David', 'Diaz', 'Martinez', '1111111111', 'david.is@unipolidgo.edu.mx', 19, 0, 0, 10000),
(3, 'Erik', 'Vargaz', 'Gutierrez', '1234567890', 'erik.is@unipolidgo.edu.mx', 19, 0, 0, 10000),
(4, 'Valeria', 'Celis', 'Ortega', '2222222222', 'valeria.is@unipolidgo.edu.mx', 18, 0, 0, 10000),
(5, 'Francisco', 'Norton', 'Vega', '3333333333', 'norton.is@unipolidgo.edu.mx', 91, 0, 0, 10000),
(6, 'Pedro', 'Martinez', '', '1212121212', 'pedrito.is@unipolidgo.edu.mx', 21, 1, 0, 0),
(7, 'Octavio', 'Ortiz', 'Gutierrez', '11111111111', 'octavio.is@unipolidgo.edu.mx', 21, 0, 0, 10000),
(8, 'Javier Manuel', 'Velazquez', 'Rivera', '2222222222', 'javier.is@unipolidgo.edu.mx', 23, 0, 0, 10000),
(9, 'Francisco Javier', 'Rivera', '', 'thekatforever', 'javier.rivera.is@unipolidgo.edu.mx', 26, 0, 0, 10000),
(10, 'Yasser', 'Alvarez', 'Esqueda', '1234567770', 'yasser.is@unipolidgo.edu.mx', 21, 2, 0, 6000),
(11, 'Arturoasdasd', 'Hernandez', 'Bueno', '2222222222', 'hernandez.is@unipolidgo.edu.mx', 34, 5, 0, 1023),
(12, 'Victor', 'Santos', 'Maciz', 'manoloesmalojaja', 'visctor.is@unipolidgo.edu.mx', 23, 0, 0, 10000),
(13, 'Erik Guapo', 'Vargas', 'Murillo', 'erikesgodsisi', 'vargas.gutierrez.is@unipolidgo.edu.mx', 19, 4, 0, 6000),
(14, 'Guadalupe', 'Onteres', '', 'onteresporsiempre', 'onteres.guadalupe.is@unipolidgo.edu.mx', 18, 2, 0, 8000),
(15, 'Juan pabla', 'Meraza', 'Julieta', 'holacomoestas', 'pablo.juliet.is@unipolidgo.edu.mx', 20, 3, 0, 10000),
(16, 'Francisco Javier', 'Perez', 'Rivera', '111111111111', 'rivera.is@unipolidgo.edu.mx', 21, 2, 0, 11332);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asientos`
--
ALTER TABLE `asientos`
  ADD PRIMARY KEY (`ID_asiento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asientos`
--
ALTER TABLE `asientos`
  MODIFY `ID_asiento` int(9) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_usuario` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
