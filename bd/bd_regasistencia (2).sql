-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-11-2019 a las 17:27:33
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_regasistencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `idAsistencia` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `dFecha` date NOT NULL,
  `dHora` time NOT NULL,
  `cTurno` varchar(12) DEFAULT NULL,
  `ubicacion_x` float DEFAULT NULL,
  `ubicacion_y` float DEFAULT NULL,
  `ubicacion_nombre` varchar(200) NOT NULL,
  `foto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `asistencia`
--

INSERT INTO `asistencia` (`idAsistencia`, `idPersona`, `dFecha`, `dHora`, `cTurno`, `ubicacion_x`, `ubicacion_y`, `ubicacion_nombre`, `foto`) VALUES
(1, 3, '2019-11-22', '00:00:00', 'MAÑANA', 3.3333, 3.3333, 'Casa Jaimito 256 ', 'media/asistencia/1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `idDocente` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `cNivel` varchar(25) NOT NULL,
  `cTurno` varchar(15) DEFAULT NULL,
  `cEstado` varchar(4) NOT NULL,
  `dFecReg` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`idDocente`, `idPersona`, `cNivel`, `cTurno`, `cEstado`, `dFecReg`) VALUES
(1, 1, 'SECUNDARIA', NULL, 'A', '2019-04-01 13:07:26'),
(2, 3, 'PRIMARIA', 'MAÑANA', '1', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `justificacion`
--

CREATE TABLE `justificacion` (
  `idJustifica` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `fecha_justificacion` date NOT NULL,
  `dFecha` datetime NOT NULL,
  `cTipo` varchar(25) NOT NULL,
  `cDetalle` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `justificacion`
--

INSERT INTO `justificacion` (`idJustifica`, `idPersona`, `fecha_justificacion`, `dFecha`, `cTipo`, `cDetalle`) VALUES
(2, 3, '2019-11-21', '2019-11-23 22:22:22', 'DORMICION', 'Se quedó hasta tarde llorando por ella');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idPersona` int(100) NOT NULL,
  `cNombres` varchar(100) NOT NULL,
  `cApellidos` varchar(100) NOT NULL,
  `cDNI` varchar(11) NOT NULL,
  `cDireccion` varchar(200) NOT NULL,
  `cTipo` varchar(4) NOT NULL,
  `cEmail` varchar(200) DEFAULT NULL,
  `cTelefono` varchar(15) DEFAULT NULL,
  `cSexo` varchar(4) NOT NULL,
  `nEstado` int(2) NOT NULL,
  `dFechaReg` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idPersona`, `cNombres`, `cApellidos`, `cDNI`, `cDireccion`, `cTipo`, `cEmail`, `cTelefono`, `cSexo`, `nEstado`, `dFechaReg`) VALUES
(1, 'GINO PAOLO', 'TUESTA VILLACORTA', '43107866', 'MAYNAS 555', 'DOCE', 'ronalgino1085@gmail.com', '910863468', 'M', 1, '2019-04-01 13:01:46'),
(2, 'ALAN JOHN', 'TUESTA VILLACORTA', '41321546', 'MAYNAS 555', 'D', 'aljotuvi82@gmail.com', '910863468', 'M', 1, '2019-04-01 13:06:10'),
(3, 'Angelo', 'Tapullima', '12345678', 'Calle Estado de Israel 256', 'D', 'cesar@cesar.com', '969902084', 'M', 1, '2019-11-22 09:23:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `idPersona` int(11) NOT NULL,
  `cUsuario` varchar(12) NOT NULL,
  `cPassword` varchar(25) NOT NULL,
  `cEstado` varchar(4) NOT NULL,
  `dFecReg` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `idPersona`, `cUsuario`, `cPassword`, `cEstado`, `dFecReg`) VALUES
(1, 1, 'GINO', '123456', 'A', '2019-04-01 13:04:52');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`idAsistencia`),
  ADD KEY `idPersona` (`idPersona`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`idDocente`),
  ADD KEY `idPersona` (`idPersona`);

--
-- Indices de la tabla `justificacion`
--
ALTER TABLE `justificacion`
  ADD PRIMARY KEY (`idJustifica`),
  ADD KEY `idPersona` (`idPersona`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idPersona`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idPersona` (`idPersona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `idAsistencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `idDocente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `justificacion`
--
ALTER TABLE `justificacion`
  MODIFY `idJustifica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idPersona` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `asistencia_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`);

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `docentes_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`);

--
-- Filtros para la tabla `justificacion`
--
ALTER TABLE `justificacion`
  ADD CONSTRAINT `justificacion_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idPersona`) REFERENCES `persona` (`idPersona`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
