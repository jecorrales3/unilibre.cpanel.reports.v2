-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-09-2020 a las 09:31:49
-- Versión del servidor: 10.2.33-MariaDB
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `unilibre_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asesor_reporte`
--

CREATE TABLE `asesor_reporte` (
  `id_asesor_reporte` int(11) NOT NULL,
  `nombre_asesor_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_asesor_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `cedula_asesor_reporte` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `id_tipo_integrante_asesor_reporte` int(11) NOT NULL,
  `id_configuracion_asesor_reporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id_ciudad` int(11) NOT NULL,
  `nombre_ciudad` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `id_departamento_ciudad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id_ciudad`, `nombre_ciudad`, `id_departamento_ciudad`) VALUES
(1, 'Pereira', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_reporte`
--

CREATE TABLE `configuracion_reporte` (
  `id_configuracion_reporte` int(11) NOT NULL,
  `titulo_configuracion_reporte` varchar(310) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_generacion_configuracion_reporte` date NOT NULL,
  `fecha_sustentacion_configuracion_reporte` date DEFAULT NULL,
  `fecha_iniciacion_configuracion_reporte` date DEFAULT NULL,
  `fecha_finalizacion_configuracion_reporte` date DEFAULT NULL,
  `hora_sustentacion_configuracion_reporte` time DEFAULT NULL,
  `codigo_configuracion_reporte` int(11) DEFAULT NULL,
  `presupuesto_configuracion_reporte` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_grupo_investigacion_configuracion_reporte` varchar(120) COLLATE utf8_spanish_ci DEFAULT NULL,
  `codigo_convocatoria_configuracion_reporte` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `marco_seminario_configuracion_reporte` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `universidad_seminario_configuracion_reporte` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_facultad_configuracion_reporte` int(11) NOT NULL,
  `id_resultado_configuracion_reporte` int(11) NOT NULL,
  `id_usuario_configuracion_reporte` int(11) NOT NULL,
  `id_funcionalidad_configuracion_reporte` int(11) NOT NULL,
  `id_consecutivo_configuracion_reporte` int(11) DEFAULT NULL,
  `id_facultad_final_configuracion_reporte` int(11) NOT NULL,
  `id_tipo_reporte_configuracion_reporte` int(11) NOT NULL,
  `id_tipo_convocatoria_configuracion_reporte` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `configuracion_reporte`
--

INSERT INTO `configuracion_reporte` (`id_configuracion_reporte`, `titulo_configuracion_reporte`, `fecha_generacion_configuracion_reporte`, `fecha_sustentacion_configuracion_reporte`, `fecha_iniciacion_configuracion_reporte`, `fecha_finalizacion_configuracion_reporte`, `hora_sustentacion_configuracion_reporte`, `codigo_configuracion_reporte`, `presupuesto_configuracion_reporte`, `nombre_grupo_investigacion_configuracion_reporte`, `codigo_convocatoria_configuracion_reporte`, `marco_seminario_configuracion_reporte`, `universidad_seminario_configuracion_reporte`, `id_facultad_configuracion_reporte`, `id_resultado_configuracion_reporte`, `id_usuario_configuracion_reporte`, `id_funcionalidad_configuracion_reporte`, `id_consecutivo_configuracion_reporte`, `id_facultad_final_configuracion_reporte`, `id_tipo_reporte_configuracion_reporte`, `id_tipo_convocatoria_configuracion_reporte`) VALUES
(100, 'proyecto prueba', '2020-08-06', '2020-08-20', '2020-08-06', '0000-00-00', NULL, 1, '22110', 'MICROBIOTEC', '1', NULL, NULL, 105, 1, 4, 1, 12, 2, 1, 1),
(101, 'proyecto prueba', '2020-08-06', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 106, 1, 4, 1, 13, 2, 2, NULL),
(102, 'prueba', '2020-08-06', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 107, 1, 4, 1, 14, 2, 3, NULL),
(103, 'prueba', '2020-08-06', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 108, 1, 4, 3, 15, 2, 4, NULL),
(104, 'prueba', '2020-08-06', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, 109, 1, 4, 1, 15, 2, 4, NULL),
(105, 'APLICATIVO PARA LA GENERACIÓN DE REPORTES', '2020-08-20', '2020-08-20', '2019-07-01', '2020-08-20', NULL, 2, '0', 'OBELIX, TEM', 'ISS017', NULL, NULL, 110, 1, 1, 1, 12, 2, 1, 2),
(106, 'APLICATIVO  PARA  LA  GENERACIÓN  DEREPORTES', '2020-08-20', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, 111, 1, 1, 1, 13, 2, 2, NULL),
(107, 'APLICATIVO  PARA  LA  GENERACIÓN  DEREPORTES', '2020-08-20', NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, 112, 1, 1, 1, 14, 2, 3, NULL),
(108, 'APLICATIVO PARA LA GENERACIÓN DEREPORTES', '2020-08-20', NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, 113, 1, 1, 1, 15, 2, 4, NULL),
(109, 'APLICATIVO  PARA  LA  GENERACIÓN DE REPORTES', '2020-08-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 114, 1, 1, 1, NULL, 2, 6, NULL),
(110, 'APLICATIVO PARA LA GENERACIÓN DE REPORTES', '2020-08-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tendencia Económica', 'Universidad de Chile', 115, 1, 1, 1, NULL, 2, 7, NULL),
(111, 'APLICATIVO PARA LA GENERACIÓN DE REPORTES', '2020-08-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 116, 1, 1, 1, NULL, 2, 5, NULL),
(112, 'PAZ Y SALVO DE PRUEBA', '2020-08-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Objetivos de Desarrollo', 'San Martín', 117, 1, 1, 1, NULL, 2, 7, NULL),
(113, 'Reporte sin título (N/A)', '2020-08-20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 118, 1, 1, 1, NULL, 2, 8, NULL),
(114, 'PRUEBA', '2020-08-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 119, 1, 1, 1, NULL, 2, 5, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consecutivo_reporte`
--

CREATE TABLE `consecutivo_reporte` (
  `id_consecutivo_reporte` int(11) NOT NULL,
  `vigencia_desde_consecutivo_reporte` date NOT NULL,
  `vigencia_hasta_consecutivo_reporte` date NOT NULL,
  `year_consecutivo_reporte` year(4) NOT NULL,
  `consecutivo_desde_reporte` int(11) NOT NULL,
  `consecutivo_actual_reporte` int(11) NOT NULL,
  `consecutivo_hasta_reporte` int(11) NOT NULL,
  `consecutivo_restante_reporte` int(11) NOT NULL,
  `id_estado_consecutivo_reporte` int(11) NOT NULL,
  `id_tipo_consecutivo_reporte` int(11) NOT NULL,
  `id_facultad_consecutivo_reporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `consecutivo_reporte`
--

INSERT INTO `consecutivo_reporte` (`id_consecutivo_reporte`, `vigencia_desde_consecutivo_reporte`, `vigencia_hasta_consecutivo_reporte`, `year_consecutivo_reporte`, `consecutivo_desde_reporte`, `consecutivo_actual_reporte`, `consecutivo_hasta_reporte`, `consecutivo_restante_reporte`, `id_estado_consecutivo_reporte`, `id_tipo_consecutivo_reporte`, `id_facultad_consecutivo_reporte`) VALUES
(1, '2019-01-01', '2019-12-31', 2019, 0, 15, 1000, 1000, 3, 3, 1),
(2, '2020-01-01', '2020-12-31', 2020, 0, 9, 1000, 991, 1, 3, 3),
(3, '2020-01-01', '2020-12-31', 2020, 0, 15, 1000, 985, 1, 1, 3),
(4, '2020-01-01', '2020-12-31', 2020, 0, 7, 1000, 993, 1, 2, 3),
(5, '2020-01-01', '2020-12-31', 2020, 0, 8, 1000, 992, 1, 4, 3),
(6, '2020-01-01', '2020-12-31', 2020, 0, 0, 1000, 1000, 3, 1, 1),
(7, '2020-01-01', '2020-12-31', 2020, 0, 1, 1000, 999, 1, 1, 1),
(8, '2020-01-01', '2020-12-31', 2020, 0, 0, 1000, 1000, 3, 1, 1),
(9, '2020-01-01', '2020-12-31', 2020, 0, 0, 1000, 1000, 3, 2, 3),
(10, '2020-01-01', '2020-12-31', 2020, 0, 1, 1000, 999, 1, 3, 1),
(11, '2020-01-01', '2020-12-31', 2020, 0, 1000, 1000, 0, 3, 1, 2),
(12, '2020-01-01', '2020-12-31', 2020, 0, 2, 1000, 998, 1, 1, 2),
(13, '2020-01-01', '2020-12-31', 2020, 0, 2, 1000, 998, 1, 2, 2),
(14, '2020-01-01', '2020-12-31', 2020, 0, 2, 1000, 998, 1, 3, 2),
(15, '2020-01-01', '2020-12-31', 2020, 0, 3, 1000, 997, 1, 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `nombre_departamento` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `nombre_departamento`) VALUES
(1, 'Risaralda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_consecutivo_reporte`
--

CREATE TABLE `estado_consecutivo_reporte` (
  `id_estado_consecutivo_reporte` int(11) NOT NULL,
  `nombre_estado_consecutivo_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estado_consecutivo_reporte`
--

INSERT INTO `estado_consecutivo_reporte` (`id_estado_consecutivo_reporte`, `nombre_estado_consecutivo_reporte`) VALUES
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'Finalizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_usuario`
--

CREATE TABLE `estado_usuario` (
  `id_estado_usuario` int(11) NOT NULL,
  `nombre_estado_usuario` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estado_usuario`
--

INSERT INTO `estado_usuario` (`id_estado_usuario`, `nombre_estado_usuario`) VALUES
(1, 'Activo'),
(2, 'Suspendido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante_reporte`
--

CREATE TABLE `estudiante_reporte` (
  `id_estudiante_reporte` int(11) NOT NULL,
  `nombre_estudiante_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_estudiante_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `documento_estudiante_reporte` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `nota_numero_estudiante_reporte` varchar(3) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nota_letras_estudiante_reporte` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_configuracion_estudiante_reporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estudiante_reporte`
--

INSERT INTO `estudiante_reporte` (`id_estudiante_reporte`, `nombre_estudiante_reporte`, `apellido_estudiante_reporte`, `documento_estudiante_reporte`, `nota_numero_estudiante_reporte`, `nota_letras_estudiante_reporte`, `id_configuracion_estudiante_reporte`) VALUES
(128, 'Juan Diego', 'Castaño Franco', '1225088503', NULL, NULL, 101),
(129, 'Johan Esteban ', 'Corrales Aguirre', '1088025076', NULL, NULL, 101),
(130, 'Juan Diego', 'Castaño Franco', '1225088503', NULL, NULL, 102),
(131, 'Juan Diego', 'Castaño Franco', '1225088503', '5', 'cinco', 103),
(132, 'Juan Diego ', 'Castaño Franco', '1225088503', '4', 'cuatro', 104),
(133, 'Juan Diego', 'Castaño Franco', '1225088503', NULL, NULL, 106),
(134, 'Johan Esteban', 'Corrales Aguirre', '1088025076', NULL, NULL, 106),
(135, 'Johan Esteban', 'Corrales Aguirre', '1088025076', NULL, NULL, 107),
(136, 'Juan Diego', 'Castaño Franco', '1225088503', NULL, NULL, 107),
(137, 'Juan Diego', 'Castaño Franco', '1225088503', '4.4', 'Cuatro coma cuatro', 108),
(138, 'Johan Esteban', 'Corrales Aguirre', '1088025076', '4.4', 'Cuatro coma cuatro', 108),
(139, 'Juan Diego', 'Castaño Franco', '1225088503', NULL, NULL, 109),
(140, 'Johan Esteban', 'Corrales Aguirre', '1088025076', NULL, NULL, 109),
(141, 'Juan Diego', 'Castaño Franco', '1225088503', NULL, NULL, 110),
(142, 'Johan Esteban ', 'Corrales Aguirre', '1088025076', NULL, NULL, 110),
(143, 'Juan Diego', 'Castaño Franco', '1225088503', NULL, NULL, 111),
(144, 'Johan Esteban', 'Corrales Aguirre', '1088025076', NULL, NULL, 111),
(145, 'Pedro Alfonso', 'Arias', '1088257415', NULL, NULL, 112),
(146, 'Raul', 'Hernandez', '42009784', NULL, NULL, 113),
(147, 'PRUEBA', 'PRUEBA', '00000000', NULL, NULL, 114);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultad`
--

CREATE TABLE `facultad` (
  `id_facultad` int(11) NOT NULL,
  `nombre_facultad` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `siglas_facultad` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_registro_facultad` date NOT NULL,
  `id_ciudad_facultad` int(11) NOT NULL,
  `id_funcionalidad_facultad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `facultad`
--

INSERT INTO `facultad` (`id_facultad`, `nombre_facultad`, `siglas_facultad`, `fecha_registro_facultad`, `id_ciudad_facultad`, `id_funcionalidad_facultad`) VALUES
(1, 'Facultad de Ingeniería', 'FING', '2020-01-09', 1, 1),
(2, 'Facultad de Ciencias de la Salud', 'FCS', '2020-01-10', 1, 1),
(3, 'Facultad de Ciencias Económicas, Administrativas y Contables', 'FCEAC', '2020-01-10', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultad_reporte`
--

CREATE TABLE `facultad_reporte` (
  `id_facultad_reporte` int(11) NOT NULL,
  `nombre_facultad_reporte` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `siglas_facultad_reporte` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_programa_facultad_reporte` varchar(130) COLLATE utf8_spanish_ci DEFAULT NULL,
  `titulo_programa_facultad_reporte` varchar(130) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_decano_facultad_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_decano_facultad_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_director_facultad_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_director_facultad_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `https_firma_director_facultad_reporte` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `facultad_reporte`
--

INSERT INTO `facultad_reporte` (`id_facultad_reporte`, `nombre_facultad_reporte`, `siglas_facultad_reporte`, `nombre_programa_facultad_reporte`, `titulo_programa_facultad_reporte`, `nombre_decano_facultad_reporte`, `apellido_decano_facultad_reporte`, `nombre_director_facultad_reporte`, `apellido_director_facultad_reporte`, `https_firma_director_facultad_reporte`) VALUES
(105, 'Facultad de Ciencias de la Salud', 'FCS', NULL, NULL, 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(106, 'Facultad de Ciencias de la Salud', 'FCS', 'Enfermería', NULL, 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(107, 'Facultad de Ciencias de la Salud', 'FCS', 'Especialización en Seguridad y Salud en Trabajo Gerencia y Control de Riesgos', NULL, 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(108, 'Facultad de Ciencias de la Salud', 'FCS', 'Maestría en Gestión de la Seguridad y Salud en el Trabajo', NULL, 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(109, 'Facultad de Ciencias de la Salud', 'FCS', 'Especialización en Seguridad y Salud en Trabajo Gerencia y Control de Riesgos', NULL, 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(110, 'Facultad de Ciencias de la Salud', 'FCS', NULL, NULL, 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(111, 'Facultad de Ciencias de la Salud', 'FCS', 'Microbiología', NULL, 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(112, 'Facultad de Ciencias de la Salud', 'FCS', 'Microbiología', NULL, 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(113, 'Facultad de Ciencias de la Salud', 'FCS', 'Microbiología', NULL, 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(114, 'Facultad de Ciencias de la Salud', 'FCS', 'Microbiología', 'Microbiólogo', 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(115, 'Facultad de Ciencias de la Salud', 'FCS', 'Microbiología', 'Microbiólogo', 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(116, 'Facultad de Ciencias de la Salud', 'FCS', 'Microbiología', 'Microbiólogo', 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(117, 'Facultad de Ciencias de la Salud', 'FCS', 'Enfermería', 'Enfermero', 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(118, 'Facultad de Ciencias de la Salud', 'FCS', 'Enfermería', 'Enfermero', 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL),
(119, 'Facultad de Ciencias de la Salud', 'FCS', 'Enfermería', 'Enfermero', 'Maria Teresa', 'Rodriguez Lugo', 'Olga Maria ', 'Henao Trujillo ', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `funcionalidad`
--

CREATE TABLE `funcionalidad` (
  `id_funcionalidad` int(11) NOT NULL,
  `nombre_funcionalidad` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `funcionalidad`
--

INSERT INTO `funcionalidad` (`id_funcionalidad`, `nombre_funcionalidad`) VALUES
(1, 'Activo'),
(2, 'Eliminado'),
(3, 'Anulado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_investigacion`
--

CREATE TABLE `grupo_investigacion` (
  `id_grupo_investigacion` int(11) NOT NULL,
  `nombre_grupo_investigacion` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `id_facultad_grupo_investigacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `grupo_investigacion`
--

INSERT INTO `grupo_investigacion` (`id_grupo_investigacion`, `nombre_grupo_investigacion`, `id_facultad_grupo_investigacion`) VALUES
(1, 'TEM', 3),
(2, 'AIO', 3),
(3, 'GRICFAS', 3),
(4, 'GICIVIL', 1),
(5, 'INAP', 1),
(6, 'TRUEQUE', 1),
(7, 'DRACMA', 1),
(8, 'OBELIX', 1),
(9, 'MICROBIOTEC', 2),
(10, 'GERENCIA DEL CUIDADO', 2),
(11, 'NUTRIOMA', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `integrante`
--

CREATE TABLE `integrante` (
  `id_integrante` int(11) NOT NULL,
  `nombre_integrante` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_integrante` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `correo_integrante` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cedula_integrante` varchar(12) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha_registro_integrante` date NOT NULL,
  `fecha_firma_integrante` date DEFAULT NULL,
  `https_firma_integrante` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `imagen_firma_integrante` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_tipo_integrante` int(11) NOT NULL,
  `id_facultad_integrante` int(11) NOT NULL,
  `id_funcionalidad_integrante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `integrante`
--

INSERT INTO `integrante` (`id_integrante`, `nombre_integrante`, `apellido_integrante`, `correo_integrante`, `cedula_integrante`, `fecha_registro_integrante`, `fecha_firma_integrante`, `https_firma_integrante`, `imagen_firma_integrante`, `id_tipo_integrante`, `id_facultad_integrante`, `id_funcionalidad_integrante`) VALUES
(20, 'Adalucy', 'Álvarez Aldana', 'adalucy.alvareza@unilibre.edu.co', '43638422', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(21, 'Daniel Arturo', 'León Rodriguez', 'daniel.leonr@unilibre.edu.co', '80205774', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(22, 'Duverney', 'Gaviria Arias', 'duverney.gaviria@unilibre.edu.co', '94379943', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(23, 'Victor Hugo', 'Grisales Díaz', 'victorh.grisalesd@unilibre.edu.co', '1053764433', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(24, 'Sandra Yolanda', ' Valencia Castillo', 'sandray.valenciac@unilibre.edu.co', '30391588', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(25, 'Mercy', 'Soto Chaquir', 'mercy.sotoc@unilibre.edu.co', '34998073', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(26, 'Lilia Andrea', 'Buitrago Malaver ', 'liliaa.buitragom@unilibre.edu.co', '46450610', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(27, 'Luis Evelio ', 'Aristizábal Franco', 'luise.aristizabalf@unilibre.edu.co', '10270434', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(28, 'Elcy Yaned ', 'Astudillo Muñoz ', 'elcyy.astudillom@unilibre.edu.co', '55180632', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(29, 'Jheimy Jackeline ', ' García Castañeda', 'jheimyj.garciac@unilibre.edu.co', '30231856', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(30, 'Jaime', 'Alvarez Chica', 'jaime.alvarezc@unilibre.edu.co', '75030566', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(31, 'Héctor Mario', 'Buriticá', 'hectorm.buriticah@unilibre.edu.co', '10280329', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(32, 'Rodolfo', 'López Franco', 'rodolfo.lopezf@unilibre.edu.co', '10228378', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(33, 'Olga Luz', ' Espinel', 'olgal.espinalg@unilibre.edu.co', '43872103', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(34, 'Doricela ', 'Granados Díaz', 'doricela.diazgranadosc@unilibre.edu.co', '52087214', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(35, 'Diana María', 'Muñoz Pérez ', 'dianam.munozp@unilibre.edu.co', '42071578', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(36, 'Luz Adriana', ' López González', 'luza.lopezg@unilibre.edu.co', '30321407', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(37, 'Aleyda', 'Restrepo Vásquez', 'aleyda.restrepov@unilibre.edu.co', '34050177', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(38, 'Ana María', 'Hernández Betancur', 'anam.hernandezb@unilibre.edu.co', '30294550', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(39, 'Carolina', 'Pava Laguna', 'carolina.paval@unilibre.edu.co', '39568057', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(40, 'Eliana', 'Agudelo García', 'eliana.agudelog@unilibre.edu.co', '30272556', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(41, 'María Lucidia', 'Román Montoya', 'marial.romanm@unilibre.edu.co', '42091536', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(42, 'Tatiana', 'Mejía Valencia', 'tatiana.mejiav@unilibre.edu.co', '24766817', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(43, 'Olga Maria', 'Henao Trujillo', 'olga.henao@unilibre.edu.co', '24780433', '2020-07-29', NULL, NULL, NULL, 3, 2, 2),
(44, 'María Ibeth', 'Orozco Duque ', 'mariai.morozcod@unilibre.edu.co', '30305910', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(45, 'Paulo Cesar', 'Gonzalez Sepúlveda', 'pauloc.gonzalezs@unilibre.edu.co', '94416120', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(46, 'Claudia Maria', 'Lope Ortiz ', 'claudia.lopez@unilibre.edu.co', '25161527', '2020-07-29', NULL, NULL, NULL, 3, 2, 1),
(47, 'PRUEBA', 'PRUEBA', 'PRUEBA@PRUEBA.COM', '00000002', '2020-07-29', NULL, NULL, NULL, 2, 3, 2),
(48, 'Olga Maria ', 'Henao Trujillo ', 'olga.henao@unilibre.edu.co', '24780433', '2020-08-06', NULL, NULL, NULL, 2, 2, 1),
(49, 'Maria Teresa', 'Rodriguez Lugo', 'maria.rodriguez@unilibre.edu.co', '24941148', '2020-08-06', NULL, NULL, NULL, 1, 2, 1),
(50, 'Luz Andrea', ' Bedoya Parra', NULL, '42015455', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(51, 'Lindy Neth', 'Perea Mosquera', NULL, '1088294731', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(52, 'Ana María', 'Barrera Rodriguez', NULL, '42158568', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(53, 'Leidy Johanna', 'Hernandez Ramirez', NULL, '1088275033', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(54, 'Gerardo Antonio', 'Buchelli Lozano', NULL, '10134478', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(55, 'Hector Fabio', 'Ramos Gonzalez', NULL, '10138476', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(56, 'Luis Alberto', 'Arteaga Casas', NULL, '10128184', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(57, 'Carlos Andrés', 'Díaz Restrepo', NULL, '18615883', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(58, 'Walter', 'García Morales', NULL, '71589532', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(59, 'Jorge Humberto ', 'Zapata Arango', NULL, '10118500', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(60, 'Jorge Eduardo', 'Carreño Bustamante ', NULL, '10248699', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(61, 'Jhonier', 'Cardona Salazar', NULL, '10115641', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(62, 'Javier Alexander', 'Luna Ramirez', NULL, '93376546', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(63, 'Carlos Alberto', 'Cano Plata', NULL, '10283129', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(64, 'Angelica', 'Morales Córtes ', NULL, '1112762486', '2020-08-21', NULL, NULL, NULL, 3, 3, 1),
(65, 'Isabel ', 'Redondo Ramirez ', NULL, '42123425', '2020-08-21', '2020-08-29', 'https://unilibre.bisont.co/app/backend/production/file/static/images/signature/signature_member_65.png', '/app/backend/production/file/static/images/signature/signature_member_65.png', 2, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `integrante_reporte`
--

CREATE TABLE `integrante_reporte` (
  `id_integrante_reporte` int(11) NOT NULL,
  `nombre_integrante_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_integrante_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `cedula_integrante_reporte` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `id_tipo_integrante_reporte` int(11) NOT NULL,
  `id_tipo_cargo_integrante_reporte` int(11) NOT NULL,
  `id_configuracion_integrante_reporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `integrante_reporte`
--

INSERT INTO `integrante_reporte` (`id_integrante_reporte`, `nombre_integrante_reporte`, `apellido_integrante_reporte`, `cedula_integrante_reporte`, `id_tipo_integrante_reporte`, `id_tipo_cargo_integrante_reporte`, `id_configuracion_integrante_reporte`) VALUES
(86, 'Luz Adriana', ' López González', '30321407', 3, 3, 100),
(87, 'Olga Luz', ' Espinel', '43872103', 3, 4, 100),
(88, 'Duverney', 'Gaviria Arias', '94379943', 3, 1, 101),
(89, 'Elcy Yaned ', 'Astudillo Muñoz ', '55180632', 3, 2, 102),
(90, 'Héctor Mario', 'Buriticá', '10280329', 3, 1, 103),
(91, 'Olga Maria', 'Henao Trujillo', '24780433', 3, 2, 103),
(92, 'Paulo Cesar', 'Gonzalez Sepúlveda', '94416120', 3, 1, 104),
(93, 'Jaime', 'Alvarez Chica', '75030566', 3, 3, 105),
(94, 'Héctor Mario', 'Buriticá', '10280329', 3, 5, 105),
(95, 'Jheimy Jackeline ', ' García Castañeda', '30231856', 3, 1, 106),
(96, 'Adalucy', 'Álvarez Aldana', '43638422', 3, 2, 106),
(97, 'Adalucy', 'Álvarez Aldana', '43638422', 3, 1, 107),
(98, 'Ana María', 'Hernández Betancur', '30294550', 3, 2, 107),
(99, 'Sandra Yolanda', ' Valencia Castillo', '30391588', 3, 1, 108),
(100, 'Héctor Mario', 'Buriticá', '10280329', 3, 2, 108),
(101, 'Olga Luz', ' Espinel', '43872103', 3, 1, 109),
(102, 'Elcy Yaned ', 'Astudillo Muñoz ', '55180632', 3, 2, 109),
(103, 'Sandra Yolanda', ' Valencia Castillo', '30391588', 3, 1, 110),
(104, 'Olga Maria', 'Henao Trujillo', '24780433', 3, 2, 110),
(105, 'Luz Adriana', ' López González', '30321407', 3, 1, 111),
(106, 'Duverney', 'Gaviria Arias', '94379943', 3, 2, 111),
(107, 'Olga Luz', ' Espinel', '43872103', 3, 1, 112),
(108, 'Luis Evelio ', 'Aristizábal Franco', '10270434', 3, 2, 112),
(109, 'Jaime', 'Alvarez Chica', '75030566', 3, 1, 113),
(110, 'Adalucy', 'Álvarez Aldana', '43638422', 3, 2, 113),
(111, 'Olga Luz', ' Espinel', '43872103', 3, 1, 114),
(112, 'Héctor Mario', 'Buriticá', '10280329', 3, 1, 114);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jurado_reporte`
--

CREATE TABLE `jurado_reporte` (
  `id_jurado_reporte` int(11) NOT NULL,
  `nombre_jurado_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_jurado_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `cedula_jurado_reporte` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `id_tipo_integrante_jurado_reporte` int(11) NOT NULL,
  `id_configuracion_jurado_reporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa_facultad`
--

CREATE TABLE `programa_facultad` (
  `id_programa_facultad` int(11) NOT NULL,
  `nombre_programa_facultad` varchar(130) COLLATE utf8_spanish_ci NOT NULL,
  `titulo_programa_facultad` varchar(130) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_registro_programa_facultad` date NOT NULL,
  `id_facultad_programa_facultad` int(11) NOT NULL,
  `id_funcionalidad_programa_facultad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `programa_facultad`
--

INSERT INTO `programa_facultad` (`id_programa_facultad`, `nombre_programa_facultad`, `titulo_programa_facultad`, `fecha_registro_programa_facultad`, `id_facultad_programa_facultad`, `id_funcionalidad_programa_facultad`) VALUES
(9, 'Microbiología', 'Microbiólogo', '2020-07-28', 2, 1),
(10, 'Nutrición y dietética', 'Nutricionista y dietista ', '2020-07-28', 2, 1),
(11, 'Enfermería', 'Enfermero', '2020-07-28', 2, 1),
(12, 'Especialización en Seguridad y Salud en Trabajo Gerencia y Control de Riesgos', 'Especialista en seguridad y salud en el trabajo gerencia y control de riesgos', '2020-07-28', 2, 1),
(13, 'Maestría en Gestión de la Seguridad y Salud en el Trabajo', 'Magister en seguridad y salud en el trabajo', '2020-07-28', 2, 1),
(14, 'Administración de empresas', 'Administrador de Empresas', '2020-07-28', 3, 1),
(15, 'Contaduría Pública', 'Contador Público', '2020-07-28', 3, 1),
(16, 'Economía', 'Economista', '2020-07-28', 3, 1),
(17, 'Especialización en Administración Financiera', 'Especialista en Administración Financiera', '2020-07-28', 3, 1),
(18, 'Especialización en Planeación y Gestión Estratégica', 'Especialista en Planeación y Gestión Estratégica', '2020-07-28', 3, 1),
(19, 'Especialización en Gestión Tributaria y Aduanera', 'Especialista en Gestión Tributaria y Aduanera', '2020-07-28', 3, 1),
(20, 'Especialización en Revisoría Fiscal', 'Especialista en Revisoría Fiscal', '2020-07-28', 3, 1),
(21, 'Especialización en Alta Gerencia', 'Especialista en Alta Gerencia', '2020-07-28', 3, 1),
(22, 'Especialización en Contabilidad Financiera Internacional', 'Especialista en Contabilidad Financiera Internacional', '2020-07-28', 3, 1),
(23, 'Especialización en Gerencia de Negocios y Comercio Internacional', 'Especialista en Gerencia de Negocios y Comercio Internacional', '2020-07-28', 3, 1),
(24, 'Maestría en Administración de Empresas', 'Magíster en Administración de Empresas', '2020-07-28', 3, 1),
(25, 'Ingeniería Civil', 'Ingeniero Civil', '2020-07-28', 1, 1),
(26, 'Ingeniería Comercial', 'Ingeniero Comercial', '2020-07-28', 1, 1),
(27, 'Ingeniería de Sistemas', 'Ingeniero de Sistemas', '2020-07-28', 1, 1),
(28, 'Ingeniería Financiera', 'Ingeniero Financiero', '2020-07-28', 1, 1),
(29, 'Especialización en Gerencia Logística', 'Especialista en Gerencia Logística', '2020-07-28', 1, 1),
(30, 'Especialización en Movilidad y Transporte', 'Especialista en Movilidad y Transporte', '2020-07-28', 1, 1),
(31, 'Maestría en Mercadeo', 'Magíster en Mercadeo', '2020-07-28', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado_reporte`
--

CREATE TABLE `resultado_reporte` (
  `id_resultado_reporte` int(11) NOT NULL,
  `nombre_resultado_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `resultado_reporte`
--

INSERT INTO `resultado_reporte` (`id_resultado_reporte`, `nombre_resultado_reporte`) VALUES
(1, 'Aprobado'),
(2, 'Desaprobado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cargo_reporte`
--

CREATE TABLE `tipo_cargo_reporte` (
  `id_tipo_cargo_reporte` int(11) NOT NULL,
  `nombre_tipo_cargo_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_cargo_reporte`
--

INSERT INTO `tipo_cargo_reporte` (`id_tipo_cargo_reporte`, `nombre_tipo_cargo_reporte`) VALUES
(1, 'Asesor'),
(2, 'Jurado'),
(3, 'Investigador Principal'),
(4, 'Par Evaluador'),
(5, 'Co-investigador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_consecutivo_reporte`
--

CREATE TABLE `tipo_consecutivo_reporte` (
  `id_tipo_consecutivo_reporte` int(11) NOT NULL,
  `nombre_tipo_consecutivo_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_consecutivo_reporte`
--

INSERT INTO `tipo_consecutivo_reporte` (`id_tipo_consecutivo_reporte`, `nombre_tipo_consecutivo_reporte`) VALUES
(1, 'Acta de Inicio'),
(2, 'Nombramiento de Asesor'),
(3, 'Acta de Aprobación (Posgrados)'),
(4, 'Acta de Sustentación'),
(6, 'Homologación Auxiliar (out)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_convocatoria_reporte`
--

CREATE TABLE `tipo_convocatoria_reporte` (
  `id_tipo_convocatoria_reporte` int(11) NOT NULL,
  `nombre_tipo_convocatoria_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_convocatoria_reporte`
--

INSERT INTO `tipo_convocatoria_reporte` (`id_tipo_convocatoria_reporte`, `nombre_tipo_convocatoria_reporte`) VALUES
(1, 'Convocatoria'),
(2, 'No Convocatoria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_integrante`
--

CREATE TABLE `tipo_integrante` (
  `id_tipo_integrante` int(11) NOT NULL,
  `nombre_tipo_integrante` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_integrante`
--

INSERT INTO `tipo_integrante` (`id_tipo_integrante`, `nombre_tipo_integrante`) VALUES
(1, 'Decano'),
(2, 'Director(a) de Investigaciones'),
(3, 'Docente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_reporte`
--

CREATE TABLE `tipo_reporte` (
  `id_tipo_reporte` int(11) NOT NULL,
  `nombre_tipo_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_reporte`
--

INSERT INTO `tipo_reporte` (`id_tipo_reporte`, `nombre_tipo_reporte`) VALUES
(1, 'Acta de Inicio'),
(2, 'Nombramiento de Asesor'),
(3, 'Acta de Aprobación (Posgrados)'),
(4, 'Acta de Sustentación'),
(5, 'Paz y Salvo (Asesorado)'),
(6, 'Paz y Salvo (Auxiliares de Investigación)'),
(7, ' Paz y Salvo (Seminario Internacional)'),
(8, 'Paz y Salvo (Semillero de Investigación)'),
(9, 'Homologación Auxiliar (out)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL,
  `nombre_tipo_usuario` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id_tipo_usuario`, `nombre_tipo_usuario`) VALUES
(1, 'Administrador'),
(2, 'Generador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_usuario` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `correo_usuario` varchar(70) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena_hash_usuario` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  `salt_usuario` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_registro_usuario` date NOT NULL,
  `id_facultad_usuario` int(11) NOT NULL,
  `id_tipo_usuario` int(11) NOT NULL,
  `id_estado_usuario` int(11) NOT NULL,
  `id_funcionalidad_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `apellido_usuario`, `correo_usuario`, `contrasena_hash_usuario`, `salt_usuario`, `fecha_registro_usuario`, `id_facultad_usuario`, `id_tipo_usuario`, `id_estado_usuario`, `id_funcionalidad_usuario`) VALUES
(1, 'Johan', 'Corrales', 'jecorrales@bisont.co', '$2y$10$eDbEDLRMtxp243jwEBRcT.FruI8LWlLzVy2QyAm8phZXCVCARzKdC', '4366ea6d1c1d6fc99c3025caa9375b68258b38a357dfd27b74e8d7100442fc43', '2019-12-24', 2, 1, 1, 1),
(2, 'Juan', 'Castaño', 'jdcastano@bisont.co', '$2y$10$mBwNh.6kWmOz8Wr.gu30jOvRPytoWe69aRnbcgU36HRN1tug5Ac9.', '46481ee32073327093ebf0607132e789c7d79d310cb2de79880263ab674f5050', '2019-12-31', 2, 1, 2, 2),
(4, 'Juan Diego', 'Castaño Franco', 'jdcastano@bisont.co', '$2y$10$5vH/QeDf4qsAC6vS.43C2e.vpzE6aoTShFgvBMpuiuKraplcLAOum', 'bf689b7e54cb20c138c8da883e6702f2b013542425fd1b5b1538c8c54d7d1e46', '2020-01-11', 2, 2, 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asesor_reporte`
--
ALTER TABLE `asesor_reporte`
  ADD PRIMARY KEY (`id_asesor_reporte`),
  ADD KEY `idTipoIntegranteAsesorReporte_idx` (`id_tipo_integrante_asesor_reporte`),
  ADD KEY `idConfiguracionAsesorReporte_idx` (`id_configuracion_asesor_reporte`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id_ciudad`),
  ADD KEY `idDepartamentoCiudad_idx` (`id_departamento_ciudad`);

--
-- Indices de la tabla `configuracion_reporte`
--
ALTER TABLE `configuracion_reporte`
  ADD PRIMARY KEY (`id_configuracion_reporte`),
  ADD KEY `idFacultadConfiguracionReporte_idx` (`id_facultad_configuracion_reporte`),
  ADD KEY `idResultadoConfiguracionReporte_idx` (`id_resultado_configuracion_reporte`),
  ADD KEY `idUsuarioConfiguracionReporte_idx` (`id_usuario_configuracion_reporte`),
  ADD KEY `idFuncionalidadConfiguracionReporte_idx` (`id_funcionalidad_configuracion_reporte`),
  ADD KEY `idConsecutivoConfiguracionReporte_idx` (`id_consecutivo_configuracion_reporte`),
  ADD KEY `idFacultadFinalConfiguracionReporte_idx` (`id_facultad_final_configuracion_reporte`),
  ADD KEY `idTipoReporteConfiguracionReporte_idx` (`id_tipo_reporte_configuracion_reporte`),
  ADD KEY `idTipoConvocatoriaConfiguracionReporte_idx` (`id_tipo_convocatoria_configuracion_reporte`);

--
-- Indices de la tabla `consecutivo_reporte`
--
ALTER TABLE `consecutivo_reporte`
  ADD PRIMARY KEY (`id_consecutivo_reporte`),
  ADD KEY `idEstadoConsecutivoReporte_idx` (`id_estado_consecutivo_reporte`),
  ADD KEY `idTipoConsecutivoReporte_idx` (`id_tipo_consecutivo_reporte`),
  ADD KEY `idFacultadConsecutivoReporte_idx` (`id_facultad_consecutivo_reporte`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `estado_consecutivo_reporte`
--
ALTER TABLE `estado_consecutivo_reporte`
  ADD PRIMARY KEY (`id_estado_consecutivo_reporte`);

--
-- Indices de la tabla `estado_usuario`
--
ALTER TABLE `estado_usuario`
  ADD PRIMARY KEY (`id_estado_usuario`);

--
-- Indices de la tabla `estudiante_reporte`
--
ALTER TABLE `estudiante_reporte`
  ADD PRIMARY KEY (`id_estudiante_reporte`),
  ADD KEY `idConfiguracionEstudianteReporte_idx` (`id_configuracion_estudiante_reporte`);

--
-- Indices de la tabla `facultad`
--
ALTER TABLE `facultad`
  ADD PRIMARY KEY (`id_facultad`),
  ADD KEY `idCiudadFacultad_idx` (`id_ciudad_facultad`),
  ADD KEY `idFuncionalidadFacultad_idx` (`id_funcionalidad_facultad`);

--
-- Indices de la tabla `facultad_reporte`
--
ALTER TABLE `facultad_reporte`
  ADD PRIMARY KEY (`id_facultad_reporte`);

--
-- Indices de la tabla `funcionalidad`
--
ALTER TABLE `funcionalidad`
  ADD PRIMARY KEY (`id_funcionalidad`);

--
-- Indices de la tabla `grupo_investigacion`
--
ALTER TABLE `grupo_investigacion`
  ADD PRIMARY KEY (`id_grupo_investigacion`),
  ADD KEY `idFacultadGrupoInvestigacion_idx` (`id_facultad_grupo_investigacion`);

--
-- Indices de la tabla `integrante`
--
ALTER TABLE `integrante`
  ADD PRIMARY KEY (`id_integrante`),
  ADD KEY `idTipoIntegrante_idx` (`id_tipo_integrante`),
  ADD KEY `idFacultadIntegrante_idx` (`id_facultad_integrante`),
  ADD KEY `idFuncionalidadIntegrante_idx` (`id_funcionalidad_integrante`);

--
-- Indices de la tabla `integrante_reporte`
--
ALTER TABLE `integrante_reporte`
  ADD PRIMARY KEY (`id_integrante_reporte`),
  ADD KEY `idTipoIntegranteReporte_idx` (`id_tipo_integrante_reporte`),
  ADD KEY `idTipoCargoIntegranteReporte_idx` (`id_tipo_cargo_integrante_reporte`),
  ADD KEY `idConfiguracionIntegranteReporte_idx` (`id_configuracion_integrante_reporte`);

--
-- Indices de la tabla `jurado_reporte`
--
ALTER TABLE `jurado_reporte`
  ADD PRIMARY KEY (`id_jurado_reporte`),
  ADD KEY `idTipoIntegranteJuradoReporte_idx` (`id_tipo_integrante_jurado_reporte`),
  ADD KEY `idConfiguracionJuradoReporte_idx` (`id_configuracion_jurado_reporte`);

--
-- Indices de la tabla `programa_facultad`
--
ALTER TABLE `programa_facultad`
  ADD PRIMARY KEY (`id_programa_facultad`),
  ADD KEY `idFacultadProgramaFacultad_idx` (`id_facultad_programa_facultad`),
  ADD KEY `idFuncionalidadProgramaFacultad_idx` (`id_funcionalidad_programa_facultad`);

--
-- Indices de la tabla `resultado_reporte`
--
ALTER TABLE `resultado_reporte`
  ADD PRIMARY KEY (`id_resultado_reporte`);

--
-- Indices de la tabla `tipo_cargo_reporte`
--
ALTER TABLE `tipo_cargo_reporte`
  ADD PRIMARY KEY (`id_tipo_cargo_reporte`);

--
-- Indices de la tabla `tipo_consecutivo_reporte`
--
ALTER TABLE `tipo_consecutivo_reporte`
  ADD PRIMARY KEY (`id_tipo_consecutivo_reporte`);

--
-- Indices de la tabla `tipo_convocatoria_reporte`
--
ALTER TABLE `tipo_convocatoria_reporte`
  ADD PRIMARY KEY (`id_tipo_convocatoria_reporte`);

--
-- Indices de la tabla `tipo_integrante`
--
ALTER TABLE `tipo_integrante`
  ADD PRIMARY KEY (`id_tipo_integrante`);

--
-- Indices de la tabla `tipo_reporte`
--
ALTER TABLE `tipo_reporte`
  ADD PRIMARY KEY (`id_tipo_reporte`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id_tipo_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `idFacultadUsuario_idx` (`id_facultad_usuario`),
  ADD KEY `idTipoUsuario_idx` (`id_tipo_usuario`),
  ADD KEY `idEstadoUsuario_idx` (`id_estado_usuario`),
  ADD KEY `idFuncionalidadUsuario_idx` (`id_funcionalidad_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asesor_reporte`
--
ALTER TABLE `asesor_reporte`
  MODIFY `id_asesor_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `configuracion_reporte`
--
ALTER TABLE `configuracion_reporte`
  MODIFY `id_configuracion_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de la tabla `consecutivo_reporte`
--
ALTER TABLE `consecutivo_reporte`
  MODIFY `id_consecutivo_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estado_consecutivo_reporte`
--
ALTER TABLE `estado_consecutivo_reporte`
  MODIFY `id_estado_consecutivo_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estado_usuario`
--
ALTER TABLE `estado_usuario`
  MODIFY `id_estado_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiante_reporte`
--
ALTER TABLE `estudiante_reporte`
  MODIFY `id_estudiante_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT de la tabla `facultad`
--
ALTER TABLE `facultad`
  MODIFY `id_facultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `facultad_reporte`
--
ALTER TABLE `facultad_reporte`
  MODIFY `id_facultad_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT de la tabla `funcionalidad`
--
ALTER TABLE `funcionalidad`
  MODIFY `id_funcionalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `grupo_investigacion`
--
ALTER TABLE `grupo_investigacion`
  MODIFY `id_grupo_investigacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `integrante`
--
ALTER TABLE `integrante`
  MODIFY `id_integrante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `integrante_reporte`
--
ALTER TABLE `integrante_reporte`
  MODIFY `id_integrante_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `jurado_reporte`
--
ALTER TABLE `jurado_reporte`
  MODIFY `id_jurado_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `programa_facultad`
--
ALTER TABLE `programa_facultad`
  MODIFY `id_programa_facultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `resultado_reporte`
--
ALTER TABLE `resultado_reporte`
  MODIFY `id_resultado_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_cargo_reporte`
--
ALTER TABLE `tipo_cargo_reporte`
  MODIFY `id_tipo_cargo_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo_consecutivo_reporte`
--
ALTER TABLE `tipo_consecutivo_reporte`
  MODIFY `id_tipo_consecutivo_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo_convocatoria_reporte`
--
ALTER TABLE `tipo_convocatoria_reporte`
  MODIFY `id_tipo_convocatoria_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_integrante`
--
ALTER TABLE `tipo_integrante`
  MODIFY `id_tipo_integrante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_reporte`
--
ALTER TABLE `tipo_reporte`
  MODIFY `id_tipo_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asesor_reporte`
--
ALTER TABLE `asesor_reporte`
  ADD CONSTRAINT `idConfiguracionAsesorReporte` FOREIGN KEY (`id_configuracion_asesor_reporte`) REFERENCES `configuracion_reporte` (`id_configuracion_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTipoIntegranteAsesorReporte` FOREIGN KEY (`id_tipo_integrante_asesor_reporte`) REFERENCES `tipo_integrante` (`id_tipo_integrante`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `idDepartamentoCiudad` FOREIGN KEY (`id_departamento_ciudad`) REFERENCES `departamento` (`id_departamento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `configuracion_reporte`
--
ALTER TABLE `configuracion_reporte`
  ADD CONSTRAINT `idConsecutivoConfiguracionReporte` FOREIGN KEY (`id_consecutivo_configuracion_reporte`) REFERENCES `consecutivo_reporte` (`id_consecutivo_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idFacultadConfiguracionReporte` FOREIGN KEY (`id_facultad_configuracion_reporte`) REFERENCES `facultad_reporte` (`id_facultad_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idFacultadFinalConfiguracionReporte` FOREIGN KEY (`id_facultad_final_configuracion_reporte`) REFERENCES `facultad` (`id_facultad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idFuncionalidadConfiguracionReporte` FOREIGN KEY (`id_funcionalidad_configuracion_reporte`) REFERENCES `funcionalidad` (`id_funcionalidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idResultadoConfiguracionReporte` FOREIGN KEY (`id_resultado_configuracion_reporte`) REFERENCES `resultado_reporte` (`id_resultado_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTipoConvocatoriaConfiguracionReporte` FOREIGN KEY (`id_tipo_convocatoria_configuracion_reporte`) REFERENCES `tipo_convocatoria_reporte` (`id_tipo_convocatoria_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTipoReporteConfiguracionReporte` FOREIGN KEY (`id_tipo_reporte_configuracion_reporte`) REFERENCES `tipo_reporte` (`id_tipo_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idUsuarioConfiguracionReporte` FOREIGN KEY (`id_usuario_configuracion_reporte`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `consecutivo_reporte`
--
ALTER TABLE `consecutivo_reporte`
  ADD CONSTRAINT `idEstadoConsecutivoReporte` FOREIGN KEY (`id_estado_consecutivo_reporte`) REFERENCES `estado_consecutivo_reporte` (`id_estado_consecutivo_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idFacultadConsecutivoReporte` FOREIGN KEY (`id_facultad_consecutivo_reporte`) REFERENCES `facultad` (`id_facultad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTipoConsecutivoReporte` FOREIGN KEY (`id_tipo_consecutivo_reporte`) REFERENCES `tipo_consecutivo_reporte` (`id_tipo_consecutivo_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `estudiante_reporte`
--
ALTER TABLE `estudiante_reporte`
  ADD CONSTRAINT `idConfiguracionEstudianteReporte` FOREIGN KEY (`id_configuracion_estudiante_reporte`) REFERENCES `configuracion_reporte` (`id_configuracion_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `facultad`
--
ALTER TABLE `facultad`
  ADD CONSTRAINT `idCiudadFacultad` FOREIGN KEY (`id_ciudad_facultad`) REFERENCES `ciudad` (`id_ciudad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idFuncionalidadFacultad` FOREIGN KEY (`id_funcionalidad_facultad`) REFERENCES `funcionalidad` (`id_funcionalidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `grupo_investigacion`
--
ALTER TABLE `grupo_investigacion`
  ADD CONSTRAINT `idFacultadGrupoInvestigacion` FOREIGN KEY (`id_facultad_grupo_investigacion`) REFERENCES `facultad` (`id_facultad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `integrante`
--
ALTER TABLE `integrante`
  ADD CONSTRAINT `idFacultadIntegrante` FOREIGN KEY (`id_facultad_integrante`) REFERENCES `facultad` (`id_facultad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idFuncionalidadIntegrante` FOREIGN KEY (`id_funcionalidad_integrante`) REFERENCES `funcionalidad` (`id_funcionalidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTipoIntegrante` FOREIGN KEY (`id_tipo_integrante`) REFERENCES `tipo_integrante` (`id_tipo_integrante`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `integrante_reporte`
--
ALTER TABLE `integrante_reporte`
  ADD CONSTRAINT `idConfiguracionIntegranteReporte` FOREIGN KEY (`id_configuracion_integrante_reporte`) REFERENCES `configuracion_reporte` (`id_configuracion_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTipoCargoIntegranteReporte` FOREIGN KEY (`id_tipo_cargo_integrante_reporte`) REFERENCES `tipo_cargo_reporte` (`id_tipo_cargo_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTipoIntegranteReporte` FOREIGN KEY (`id_tipo_integrante_reporte`) REFERENCES `tipo_integrante` (`id_tipo_integrante`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `jurado_reporte`
--
ALTER TABLE `jurado_reporte`
  ADD CONSTRAINT `idConfiguracionJuradoReporte` FOREIGN KEY (`id_configuracion_jurado_reporte`) REFERENCES `configuracion_reporte` (`id_configuracion_reporte`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTipoIntegranteJuradoReporte` FOREIGN KEY (`id_tipo_integrante_jurado_reporte`) REFERENCES `tipo_integrante` (`id_tipo_integrante`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `programa_facultad`
--
ALTER TABLE `programa_facultad`
  ADD CONSTRAINT `idFacultadProgramaFacultad` FOREIGN KEY (`id_facultad_programa_facultad`) REFERENCES `facultad` (`id_facultad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idFuncionalidadProgramaFacultad` FOREIGN KEY (`id_funcionalidad_programa_facultad`) REFERENCES `funcionalidad` (`id_funcionalidad`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `idEstadoUsuario` FOREIGN KEY (`id_estado_usuario`) REFERENCES `estado_usuario` (`id_estado_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idFacultadUsuario` FOREIGN KEY (`id_facultad_usuario`) REFERENCES `facultad` (`id_facultad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idFuncionalidadUsuario` FOREIGN KEY (`id_funcionalidad_usuario`) REFERENCES `funcionalidad` (`id_funcionalidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idTipoUsuario` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
