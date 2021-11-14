-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2016 a las 01:32:37
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `codeoptica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE IF NOT EXISTS `administrador` (
  `id_administrador` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuarios` int(11) NOT NULL,
  PRIMARY KEY (`id_administrador`),
  KEY `fk_administrador_usuarios_idx` (`id_usuarios`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id_administrador`, `id_usuarios`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_pacientes`
--

CREATE TABLE IF NOT EXISTS `datos_pacientes` (
  `id_datos_pacientes` int(11) NOT NULL AUTO_INCREMENT,
  `id_pacientes` int(11) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` varchar(45) NOT NULL,
  `ciudad` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  PRIMARY KEY (`id_datos_pacientes`),
  KEY `fk_datos_pacientes_pacientes1_idx` (`id_pacientes`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `datos_pacientes`
--

INSERT INTO `datos_pacientes` (`id_datos_pacientes`, `id_pacientes`, `cedula`, `fecha_nacimiento`, `sexo`, `ciudad`, `direccion`, `correo`) VALUES
(1, 1, '1313248013', '1992-11-10', 'Hombre', 'Manta', 'Ceibo renacer', 'cristhianl2010@hotmail.com'),
(2, 2, '1313568014', '1994-03-03', 'Hombre', 'Manta', 'Av. 19 entre calles 7 y 8', 'jersonl2010@hotmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `general`
--

CREATE TABLE IF NOT EXISTS `general` (
  `id_general` int(11) NOT NULL AUTO_INCREMENT,
  `id_histo_clinicas` int(11) NOT NULL,
  `vl_od` varchar(300) NOT NULL,
  `vl_oi` varchar(300) NOT NULL,
  `cc_od` varchar(300) NOT NULL,
  `cc_oi` varchar(300) NOT NULL,
  `vp_od` varchar(300) NOT NULL,
  `vp_oi` varchar(300) NOT NULL,
  `cc2_od` varchar(300) NOT NULL,
  `cc2_oi` varchar(300) NOT NULL,
  `ph_od` varchar(300) NOT NULL,
  `ph_oi` varchar(300) NOT NULL,
  `dp` varchar(300) NOT NULL,
  `ppc` varchar(300) NOT NULL,
  `foria` varchar(300) NOT NULL,
  `motivo_consulta` varchar(300) NOT NULL,
  `signos_sintomas` varchar(300) NOT NULL,
  `examen_externo_od` varchar(300) NOT NULL,
  `examen_externo_oi` varchar(300) NOT NULL,
  `antecedentes` varchar(300) NOT NULL,
  `antecedentes_p` varchar(300) NOT NULL,
  `fondo_ojo_od` varchar(300) NOT NULL,
  `fondo_ojo_oi` varchar(300) NOT NULL,
  `queratoneria_od` varchar(300) NOT NULL,
  `queratoneria_oi` varchar(300) NOT NULL,
  `retinoscopia_od` varchar(300) NOT NULL,
  `retinoscopia_oi` varchar(300) NOT NULL,
  `subjetivo_od` varchar(300) NOT NULL,
  `subjetivo_oi` varchar(300) NOT NULL,
  PRIMARY KEY (`id_general`),
  KEY `fk_general_historias_clinicas1_idx` (`id_histo_clinicas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `general`
--

INSERT INTO `general` (`id_general`, `id_histo_clinicas`, `vl_od`, `vl_oi`, `cc_od`, `cc_oi`, `vp_od`, `vp_oi`, `cc2_od`, `cc2_oi`, `ph_od`, `ph_oi`, `dp`, `ppc`, `foria`, `motivo_consulta`, `signos_sintomas`, `examen_externo_od`, `examen_externo_oi`, `antecedentes`, `antecedentes_p`, `fondo_ojo_od`, `fondo_ojo_oi`, `queratoneria_od`, `queratoneria_oi`, `retinoscopia_od`, `retinoscopia_oi`, `subjetivo_od`, `subjetivo_oi`) VALUES
(1, 1, '10/10', '10/10', '10/10', '10/10', '10/10', '10/10', '10/10', '10/10', '10/10', '10/10', '10/10', '10/10', '10/10', 'Chequeos de la vista.', 'Ninguna anormalidad.', '10/10', '10/10', 'Derrame facial no afecto el nervio de la vista.', 'Ninguno.', '10/10', '10/10', '10/10', '10/10', '10/10', '10/10', '10/10', '10/10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historias_clinicas`
--

CREATE TABLE IF NOT EXISTS `historias_clinicas` (
  `id_historias_clinicas` int(11) NOT NULL AUTO_INCREMENT,
  `id_medicos` int(11) NOT NULL,
  `id_reservaciones` int(11) NOT NULL,
  PRIMARY KEY (`id_historias_clinicas`),
  KEY `fk_historias_clinicas_medico1_idx` (`id_medicos`),
  KEY `fk_historias_clinicas_reservaciones1_idx` (`id_reservaciones`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `historias_clinicas`
--

INSERT INTO `historias_clinicas` (`id_historias_clinicas`, `id_medicos`, `id_reservaciones`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE IF NOT EXISTS `horarios` (
  `id_horarios` int(11) NOT NULL AUTO_INCREMENT,
  `id_medicos` int(11) NOT NULL,
  `fecha_horarios` date NOT NULL,
  PRIMARY KEY (`id_horarios`),
  KEY `fk_horarios_medicos1_idx` (`id_medicos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id_horarios`, `id_medicos`, `fecha_horarios`) VALUES
(1, 1, '2016-10-20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE IF NOT EXISTS `medicos` (
  `id_medicos` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuarios` int(11) NOT NULL,
  PRIMARY KEY (`id_medicos`),
  KEY `fk_medico_usuarios1_idx` (`id_usuarios`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`id_medicos`, `id_usuarios`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ocupacional`
--

CREATE TABLE IF NOT EXISTS `ocupacional` (
  `id_ocupacional` int(11) NOT NULL AUTO_INCREMENT,
  `id_histo_clinicas` int(11) NOT NULL,
  `lentes` varchar(300) NOT NULL,
  `agudeza_vision_lejana_od` varchar(300) NOT NULL,
  `agudeza_vision_lejana_oi` varchar(300) NOT NULL,
  `agudeza_vision_cercana_od` varchar(300) NOT NULL,
  `agudeza_vision_cercana_oi` varchar(300) NOT NULL,
  `agudeza_perimetria_od` varchar(300) NOT NULL,
  `agudeza_perimetria_oi` varchar(300) NOT NULL,
  `agudeza_tonometria_od` varchar(300) NOT NULL,
  `agudeza_tonometria_oi` varchar(300) NOT NULL,
  `agudeza_fondo_ojo_od` varchar(300) NOT NULL,
  `agudeza_fondo_ojo_oi` varchar(300) NOT NULL,
  `agudeza_examen_externo_od` varchar(300) NOT NULL,
  `agudeza_examen_externo_oi` varchar(300) NOT NULL,
  `forias_vision_lejana` varchar(300) NOT NULL,
  `forias_vision_proxima` varchar(300) NOT NULL,
  `forias_test_color` varchar(300) NOT NULL,
  `forias_test_esteriopsis` varchar(300) NOT NULL,
  `forias_diagnostico` varchar(300) NOT NULL,
  PRIMARY KEY (`id_ocupacional`),
  KEY `fk_ocupacional_historias_clinicas1_idx` (`id_histo_clinicas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `ocupacional`
--

INSERT INTO `ocupacional` (`id_ocupacional`, `id_histo_clinicas`, `lentes`, `agudeza_vision_lejana_od`, `agudeza_vision_lejana_oi`, `agudeza_vision_cercana_od`, `agudeza_vision_cercana_oi`, `agudeza_perimetria_od`, `agudeza_perimetria_oi`, `agudeza_tonometria_od`, `agudeza_tonometria_oi`, `agudeza_fondo_ojo_od`, `agudeza_fondo_ojo_oi`, `agudeza_examen_externo_od`, `agudeza_examen_externo_oi`, `forias_vision_lejana`, `forias_vision_proxima`, `forias_test_color`, `forias_test_esteriopsis`, `forias_diagnostico`) VALUES
(1, 2, 'Nuevos', '9/10', '9/10', '9/10', '9/10', '9/10', '9/10', '9/10', '9/10', '9/10', '9/10', '9/10', '9/10', '8/10', '8/10', '9/10', '9/10', 'La vision ha ido mejorando.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE IF NOT EXISTS `pacientes` (
  `id_pacientes` int(11) NOT NULL AUTO_INCREMENT,
  `id_recepcionistas` int(11) NOT NULL,
  `nombresPaci` varchar(45) NOT NULL,
  `apellidosPaci` varchar(45) NOT NULL,
  `celularPaci` varchar(10) NOT NULL,
  `convencionalPaci` varchar(6) NOT NULL,
  `estadoPaci` int(11) NOT NULL,
  PRIMARY KEY (`id_pacientes`),
  KEY `fk_pacientes_recepcionista1_idx` (`id_recepcionistas`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id_pacientes`, `id_recepcionistas`, `nombresPaci`, `apellidosPaci`, `celularPaci`, `convencionalPaci`, `estadoPaci`) VALUES
(1, 1, 'Cristhian Adrian', 'Lopez Mora', '0993069198', '622524', 1),
(2, 1, 'Jerson Manuel', 'Lopez Delgado', '0983623568', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `id_permisos` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuarios` int(11) NOT NULL,
  `agregar` varchar(2) NOT NULL,
  `buscar` varchar(2) NOT NULL,
  `editar` varchar(2) NOT NULL,
  `eliminar` varchar(2) NOT NULL,
  `word` varchar(2) NOT NULL,
  `excel` varchar(2) NOT NULL,
  `pdf` varchar(2) NOT NULL,
  PRIMARY KEY (`id_permisos`),
  KEY `fk_permisos_usuarios1_idx` (`id_usuarios`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permisos`, `id_usuarios`, `agregar`, `buscar`, `editar`, `eliminar`, `word`, `excel`, `pdf`) VALUES
(2, 1, 'Si', 'Si', 'Si', 'Si', 'Si', 'Si', 'Si'),
(3, 2, 'Si', 'Si', 'Si', 'Si', 'Si', 'Si', 'Si'),
(4, 3, 'Si', 'Si', 'Si', 'Si', 'Si', 'Si', 'Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepcionistas`
--

CREATE TABLE IF NOT EXISTS `recepcionistas` (
  `id_recepcionistas` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuarios` int(11) NOT NULL,
  PRIMARY KEY (`id_recepcionistas`),
  KEY `fk_recepcionista_usuarios1_idx` (`id_usuarios`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `recepcionistas`
--

INSERT INTO `recepcionistas` (`id_recepcionistas`, `id_usuarios`) VALUES
(1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservaciones`
--

CREATE TABLE IF NOT EXISTS `reservaciones` (
  `id_reservaciones` int(11) NOT NULL AUTO_INCREMENT,
  `id_pacientes` int(11) NOT NULL,
  `id_horarios` int(11) NOT NULL,
  `id_turnos` int(11) NOT NULL,
  `estadoReser` varchar(1) NOT NULL,
  PRIMARY KEY (`id_reservaciones`),
  KEY `fk_citas_medicas_pacientes1_idx` (`id_pacientes`),
  KEY `fk_reservaciones_horarios1_idx` (`id_horarios`),
  KEY `fk_reservaciones_turnos1_idx` (`id_turnos`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `reservaciones`
--

INSERT INTO `reservaciones` (`id_reservaciones`, `id_pacientes`, `id_horarios`, `id_turnos`, `estadoReser`) VALUES
(1, 1, 1, 12, '1'),
(2, 2, 1, 6, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turnos`
--

CREATE TABLE IF NOT EXISTS `turnos` (
  `id_turnos` int(11) NOT NULL AUTO_INCREMENT,
  `id_horarios` int(11) NOT NULL,
  `hora_inicio` varchar(45) NOT NULL,
  `hora_fin` varchar(45) NOT NULL,
  `laborar` varchar(2) NOT NULL,
  `estado_turnos` int(11) NOT NULL,
  PRIMARY KEY (`id_turnos`),
  KEY `fk_turnos_horarios1_idx` (`id_horarios`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `turnos`
--

INSERT INTO `turnos` (`id_turnos`, `id_horarios`, `hora_inicio`, `hora_fin`, `laborar`, `estado_turnos`) VALUES
(1, 1, '08:30', '09:00', 'Si', 0),
(2, 1, '09:00', '09:30', 'Si', 0),
(3, 1, '09:30', '10:00', 'Si', 0),
(4, 1, '10:00', '10:30', 'Si', 0),
(5, 1, '10:30', '11:00', 'Si', 0),
(6, 1, '11:00', '11:30', 'Si', 0),
(7, 1, '11:30', '12:00', 'Si', 0),
(8, 1, '12:00', '12:30', 'Si', 0),
(9, 1, '14:30', '15:00', 'Si', 0),
(10, 1, '15:00', '15:30', 'Si', 0),
(11, 1, '15:30', '16:00', 'Si', 0),
(12, 1, '16:00', '16:30', 'Si', 0),
(13, 1, '16:30', '17:00', 'Si', 0),
(14, 1, '17:00', '17:30', 'Si', 0),
(15, 1, '17:30', '18:00', 'Si', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuarios` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(45) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` varchar(45) NOT NULL,
  `celular` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `estado` int(11) NOT NULL,
  PRIMARY KEY (`id_usuarios`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `nombres`, `apellidos`, `username`, `password`, `fecha_nacimiento`, `sexo`, `celular`, `correo`, `estado`) VALUES
(1, 'Armando', 'Rugel', 'armaru', 'armaru2016', '1970-08-06', 'Hombre', '0979750174', 'armaru70@hotmail.com', 1),
(2, 'Katherine', 'Gonzales', 'kather', 'kather2016', '1970-07-07', 'Mujer', '0976549810', 'kather0770@hotmail.com', 2),
(3, 'Yuni Lili', 'Orozco Betancurt', 'yunoro', 'yunoro2016', '1990-09-09', 'Mujer', '0980750223', 'yuni_lili@hotmail.com', 3);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `fk_administrador_usuarios` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `datos_pacientes`
--
ALTER TABLE `datos_pacientes`
  ADD CONSTRAINT `fk_datos_pacientes_pacientes1` FOREIGN KEY (`id_pacientes`) REFERENCES `pacientes` (`id_pacientes`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `general`
--
ALTER TABLE `general`
  ADD CONSTRAINT `fk_general_historias_clinicas1` FOREIGN KEY (`id_histo_clinicas`) REFERENCES `historias_clinicas` (`id_historias_clinicas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historias_clinicas`
--
ALTER TABLE `historias_clinicas`
  ADD CONSTRAINT `fk_historias_clinicas_medico1` FOREIGN KEY (`id_medicos`) REFERENCES `medicos` (`id_medicos`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_historias_clinicas_reservaciones1` FOREIGN KEY (`id_reservaciones`) REFERENCES `reservaciones` (`id_reservaciones`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `fk_horarios_medicos1` FOREIGN KEY (`id_medicos`) REFERENCES `medicos` (`id_medicos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD CONSTRAINT `fk_medico_usuarios1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ocupacional`
--
ALTER TABLE `ocupacional`
  ADD CONSTRAINT `fk_ocupacional_historias_clinicas1` FOREIGN KEY (`id_histo_clinicas`) REFERENCES `historias_clinicas` (`id_historias_clinicas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `fk_pacientes_recepcionista1` FOREIGN KEY (`id_recepcionistas`) REFERENCES `recepcionistas` (`id_recepcionistas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `fk_permisos_usuarios1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `recepcionistas`
--
ALTER TABLE `recepcionistas`
  ADD CONSTRAINT `fk_recepcionista_usuarios1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `reservaciones`
--
ALTER TABLE `reservaciones`
  ADD CONSTRAINT `fk_citas_medicas_pacientes1` FOREIGN KEY (`id_pacientes`) REFERENCES `pacientes` (`id_pacientes`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reservaciones_horarios1` FOREIGN KEY (`id_horarios`) REFERENCES `horarios` (`id_horarios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_reservaciones_turnos1` FOREIGN KEY (`id_turnos`) REFERENCES `turnos` (`id_turnos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `turnos`
--
ALTER TABLE `turnos`
  ADD CONSTRAINT `fk_turnos_horarios1` FOREIGN KEY (`id_horarios`) REFERENCES `horarios` (`id_horarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
