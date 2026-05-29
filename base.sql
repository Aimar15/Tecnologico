SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Estructura de tabla para la tabla `usuarios`
--
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','docente') NOT NULL,
  `token_recuperacion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--
INSERT INTO `usuarios` (`id`, `usuario`, `email`, `password`, `rol`, `token_recuperacion`) VALUES
(1, 'admin', '22690327@tecvalles.mx', '1234', 'admin', '0ffe6c6926a68793e1dd35ab5e2103c5'),
(2, 'docente1', 'alcatel1287@gmail.com', '1234', 'docente', NULL);

--
-- Estructura de tabla para la tabla `docentes`
--
CREATE TABLE `docentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `docentes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Estructura de tabla para la tabla `materiales`
--
CREATE TABLE `materiales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materiales`
--
INSERT INTO `materiales` (`id`, `nombre`, `cantidad`) VALUES
(2, 'IA', 11);

--
-- Estructura de tabla para la tabla `prestamos`
--
CREATE TABLE `prestamos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `fecha_prestamo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_devolucion` datetime DEFAULT NULL,
  `fecha_reserva` datetime DEFAULT NULL,
  `estado` enum('prestado','devuelto','reservado') DEFAULT 'prestado',
  `material` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamos`
--
INSERT INTO `prestamos` (`id`, `usuario_id`, `material_id`, `fecha_prestamo`, `fecha_devolucion`, `fecha_reserva`, `estado`, `material`, `cantidad`) VALUES
(3, 2, 2, '2026-05-22 01:56:00', NULL, NULL, 'devuelto', 'IA', 2);

--
-- Estructura de tabla para la tabla `reportes`
--
CREATE TABLE `reportes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `material` varchar(100) NOT NULL,
  `tipo` enum('Material dañado','Material perdido') NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Ajustar valores de AUTO_INCREMENT remanentes
--
ALTER TABLE `usuarios` AUTO_INCREMENT = 10;
ALTER TABLE `materiales` AUTO_INCREMENT = 3;
ALTER TABLE `prestamos` AUTO_INCREMENT = 5;
ALTER TABLE `reportes` AUTO_INCREMENT = 3;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;