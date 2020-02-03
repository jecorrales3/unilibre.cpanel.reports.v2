-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-02-2020 a las 16:15:21
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.2.19

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
  `id_facultad_configuracion_reporte` int(11) NOT NULL,
  `id_resultado_configuracion_reporte` int(11) NOT NULL,
  `id_usuario_configuracion_reporte` int(11) NOT NULL,
  `id_funcionalidad_configuracion_reporte` int(11) NOT NULL,
  `id_consecutivo_configuracion_reporte` int(11) DEFAULT NULL,
  `id_facultad_final_configuracion_reporte` int(11) NOT NULL,
  `id_tipo_reporte_configuracion_reporte` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `configuracion_reporte`
--

INSERT INTO `configuracion_reporte` (`id_configuracion_reporte`, `titulo_configuracion_reporte`, `fecha_generacion_configuracion_reporte`, `fecha_sustentacion_configuracion_reporte`, `fecha_iniciacion_configuracion_reporte`, `fecha_finalizacion_configuracion_reporte`, `hora_sustentacion_configuracion_reporte`, `codigo_configuracion_reporte`, `presupuesto_configuracion_reporte`, `nombre_grupo_investigacion_configuracion_reporte`, `id_facultad_configuracion_reporte`, `id_resultado_configuracion_reporte`, `id_usuario_configuracion_reporte`, `id_funcionalidad_configuracion_reporte`, `id_consecutivo_configuracion_reporte`, `id_facultad_final_configuracion_reporte`, `id_tipo_reporte_configuracion_reporte`) VALUES
(43, 'DISEÑO DE UN PLAN ESTRATÉGICO DE COMPETITIVIDAD PARA LA UNIDAD PRODUCTIVA CAFETERA EL PRADO PARA LA PRODUCCIÓN DE CAFÉ ESPECIAL', '2020-02-03', NULL, NULL, NULL, NULL, 4, NULL, NULL, 45, 1, 1, 1, 3, 3, 1),
(44, 'MARKETING TURÍSTICO EN EL PAISAJE CULTURAL CAFETERO: CASO DE ESTUDIO DEMANDA TURÍSTICA EN SALENTO, QUINDÍO', '2020-02-03', '2019-02-28', NULL, NULL, '10:00:00', 3, NULL, NULL, 46, 1, 1, 1, 4, 3, 2),
(45, 'Plan de Mejoramiento para la Gestión del Proceso de Devolución y Faltantes de Productos de Baños y Cocinas', '2020-02-03', NULL, NULL, NULL, NULL, 4, NULL, NULL, 47, 1, 1, 1, 2, 3, 3),
(46, 'IMPORTANCIA DEL PAPEL FEMENINO EN EL DESARROLLO DE LA PROFESION CONTABLE Y SU NIVEL DE RECONOCMIENTO EN LA CIUDAD DE PEREIRA', '2020-02-03', '2020-02-12', '2020-02-20', '2020-05-22', NULL, 5, '0', 'GRICFAS', 48, 1, 1, 1, 5, 3, 4),
(47, 'DISEÑO DE UN PLAN ESTRATÉGICO DE COMPETITIVIDAD PARA LA UNIDAD PRODUCTIVA CAFETERA EL PRADO PARA LA PRODUCCIÓN DE CAFÉ ESPECIAL', '2020-02-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 49, 1, 1, 1, NULL, 3, 5),
(48, 'ESTUDIO DE MERCADO POR PARTE DE LA EMPRESA RASCACATS PARA IDENTIFICAR LOS HÁBITOS DE COMPRA DE PRODUCTOS PARA GATOS POR PARTE DE SUS PROPIETARIOS EN LA CIUDAD DE PEREIRA', '2020-02-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 50, 1, 1, 1, NULL, 3, 5),
(49, 'MARKETING TURÍSTICO EN EL PAISAJE CULTURAL CAFETERO: CASO DE ESTUDIO DEMANDA TURÍSTICA EN SALENTO, QUINDÍO', '2020-02-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 51, 1, 1, 1, NULL, 3, 6);

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
(1, '2019-01-01', '2019-12-31', 2019, 0, 15, 1000, 1000, 2, 3, 1),
(2, '2020-01-01', '2020-12-31', 2020, 0, 4, 1000, 996, 1, 3, 3),
(3, '2020-01-01', '2020-12-31', 2020, 0, 4, 1000, 996, 1, 1, 3),
(4, '2020-01-01', '2020-12-31', 2020, 0, 3, 1000, 997, 1, 2, 3),
(5, '2020-01-01', '2020-12-31', 2020, 0, 5, 1000, 995, 1, 4, 3);

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
(2, 'Finalizado');

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
  `id_ciudad_estudiante_reporte` int(11) DEFAULT NULL,
  `id_configuracion_estudiante_reporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estudiante_reporte`
--

INSERT INTO `estudiante_reporte` (`id_estudiante_reporte`, `nombre_estudiante_reporte`, `apellido_estudiante_reporte`, `documento_estudiante_reporte`, `nota_numero_estudiante_reporte`, `nota_letras_estudiante_reporte`, `id_ciudad_estudiante_reporte`, `id_configuracion_estudiante_reporte`) VALUES
(65, 'Estefanía', 'Echeverri Guerrero', '1088025071', '4.6', 'Cuatro punto seis', NULL, 43),
(66, 'Jheimy Ibeth', 'Taborda López', '1088025072', NULL, NULL, NULL, 44),
(67, 'Luisa Fernanda', 'Morales Yepes', '1088025073', NULL, NULL, NULL, 44),
(68, 'Maira Alejandra', 'Ríos Betancurth', '1088025074', NULL, NULL, NULL, 44),
(69, 'Andrés ', 'Mosquera Quintero', '1088025075', NULL, NULL, NULL, 45),
(70, 'Sonia María', 'Palomino Zapata', '1088025077', NULL, NULL, NULL, 45),
(71, 'Leidy Johanna', 'Trejos Pinzón', '1088025078', NULL, NULL, NULL, 45),
(72, 'Estefanía', 'Echeverri Guerrero', '1088025071', NULL, NULL, 1, 47),
(73, 'Juan Sebastian', 'Soto Díaz', '1088025079', NULL, NULL, 1, 48),
(74, 'Jheimy Ibeth', 'Taborda López', '1088025072', NULL, NULL, 1, 49),
(75, 'Luisa Fernanda', 'Morales Yepes', '1088025073', NULL, NULL, 1, 49),
(76, 'Maira Alejandra', 'Ríos Betancurth', '1088025074', NULL, NULL, 1, 49);

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
(1, 'Facultad de Ingenierías', 'FDI', '2020-01-09', 1, 1),
(2, 'Facultad de Salud', 'FDS', '2020-01-10', 1, 1),
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
  `apellido_director_facultad_reporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `facultad_reporte`
--

INSERT INTO `facultad_reporte` (`id_facultad_reporte`, `nombre_facultad_reporte`, `siglas_facultad_reporte`, `nombre_programa_facultad_reporte`, `titulo_programa_facultad_reporte`, `nombre_decano_facultad_reporte`, `apellido_decano_facultad_reporte`, `nombre_director_facultad_reporte`, `apellido_director_facultad_reporte`) VALUES
(45, 'Facultad de Ciencias Económicas, Administrativas y Contables', 'FCEAC', 'Administración de Empresas', NULL, 'Luz Andrea', 'Bedoya Parra', 'Marlen Isabel', 'Redondo Ramírez'),
(46, 'Facultad de Ciencias Económicas, Administrativas y Contables', 'FCEAC', 'Administración de Empresas', NULL, 'Luz Andrea', 'Bedoya Parra', 'Marlen Isabel', 'Redondo Ramírez'),
(47, 'Facultad de Ciencias Económicas, Administrativas y Contables', 'FCEAC', 'Especialización en Alta Gerencia', NULL, 'Luz Andrea', 'Bedoya Parra', 'Marlen Isabel', 'Redondo Ramírez'),
(48, 'Facultad de Ciencias Económicas, Administrativas y Contables', 'FCEAC', NULL, NULL, 'Luz Andrea', 'Bedoya Parra', 'Marlen Isabel', 'Redondo Ramírez'),
(49, 'Facultad de Ciencias Económicas, Administrativas y Contables', 'FCEAC', 'Administración de Empresas', 'Administrador de Empresas', 'Luz Andrea', 'Bedoya Parra', 'Marlen Isabel', 'Redondo Ramírez'),
(50, 'Facultad de Ciencias Económicas, Administrativas y Contables', 'FCEAC', 'Administración de Empresas', 'Administrador de Empresas', 'Luz Andrea', 'Bedoya Parra', 'Marlen Isabel', 'Redondo Ramírez'),
(51, 'Facultad de Ciencias Económicas, Administrativas y Contables', 'FCEAC', 'Administración de Empresas', 'Administrador de Empresas', 'Luz Andrea', 'Bedoya Parra', 'Marlen Isabel', 'Redondo Ramírez');

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
(2, 'Eliminado');

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
  `id_tipo_integrante` int(11) NOT NULL,
  `id_facultad_integrante` int(11) NOT NULL,
  `id_funcionalidad_integrante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `integrante`
--

INSERT INTO `integrante` (`id_integrante`, `nombre_integrante`, `apellido_integrante`, `correo_integrante`, `cedula_integrante`, `fecha_registro_integrante`, `id_tipo_integrante`, `id_facultad_integrante`, `id_funcionalidad_integrante`) VALUES
(5, 'Lindy Neth', 'Perea Mosquera', NULL, '42003444', '2020-01-09', 3, 3, 1),
(6, 'Ana María', 'Barrera Rodríguez', NULL, '42004321', '2020-01-10', 3, 3, 1),
(7, 'Orlando', 'Rodríguez García', 'orlando-garcia@uniblire.edu.co', '32334553', '2020-01-10', 3, 3, 1),
(8, 'Leidy Johanna', 'Hernández Ramírez', NULL, '1098332333', '2020-01-10', 3, 3, 1),
(9, 'Rafael', 'Molano', 'rfml@unilibre.edu.co', '43493939', '2020-01-10', 2, 2, 1),
(10, 'Pedro', 'Ramírez', NULL, '109933232', '2020-01-10', 3, 1, 1),
(11, 'Fernando', 'Alzate', 'feralzate@unilibre.edu.co', '42330343', '2020-01-15', 3, 2, 1),
(12, 'Juan', 'Ramírez', NULL, '4200339288', '2020-01-15', 3, 1, 1),
(13, 'Raúl', 'Pelaéz', NULL, '1098332333', '2020-01-15', 3, 2, 1),
(14, 'Luis Alberto', ' Arteaga Casas', NULL, '42303399', '2020-01-15', 3, 3, 1),
(15, 'Valentina', 'Rayo', NULL, '1088023443', '2020-01-15', 2, 3, 2),
(16, 'Marlen Isabel', 'Redondo Ramírez', 'isabel.redondo@unilibre.edu.co', '00000000', '2020-01-22', 2, 3, 1),
(17, 'Luz Andrea', 'Bedoya Parra', 'luza-bedoyap@unilibre.edu.co', '42015455', '2020-01-22', 1, 3, 1);

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
(25, 'Leidy Johanna', 'Hernández Ramírez', '1098332333', 3, 2, 43),
(26, 'Orlando', 'Rodríguez García', '32334553', 3, 2, 43),
(27, 'Orlando', 'Rodríguez García', '32334553', 3, 3, 44),
(28, 'Ana María', 'Barrera Rodríguez', '42004321', 3, 3, 44),
(29, 'Lindy Neth', 'Perea Mosquera', '42003444', 3, 4, 44),
(30, 'Leidy Johanna', 'Hernández Ramírez', '1098332333', 3, 1, 45),
(31, 'Luz Andrea', 'Bedoya Parra', '42015455', 1, 3, 46),
(32, 'Ana María', 'Barrera Rodríguez', '42004321', 3, 1, 47),
(33, 'Orlando', 'Rodríguez García', '32334553', 3, 1, 48),
(34, 'Lindy Neth', 'Perea Mosquera', '42003444', 3, 1, 49);

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
(1, 'Ingeniería de Sistemas', '', '2020-01-11', 1, 1),
(2, 'Ingeniería Comercial', '', '2020-01-11', 1, 1),
(3, 'Ingeniería Financiera', '', '2020-01-11', 1, 1),
(4, 'Contabilidad', '', '2020-01-11', 3, 1),
(5, 'Especialización en Alta Gerencia', '', '2020-01-20', 3, 1),
(6, 'Maestría en Administración de Empresas', '', '2020-01-23', 3, 1),
(7, 'Administración de Empresas', 'Administrador de Empresas', '2020-01-24', 3, 1),
(8, 'Economía', 'Economista', '2020-02-01', 3, 1);

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
(1, 'Acta de Sustentación'),
(2, 'Homologación Auxiliar'),
(3, 'Acta de Aprobación'),
(4, 'Acta de Inicio');

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
(1, 'Acta de Sustentación'),
(2, 'Homologación Auxiliar'),
(3, 'Acta de Aprobación'),
(4, 'Acta de Inicio'),
(5, 'Paz y Salvo'),
(6, 'Paz y Salvo (Auxiliares de Investigación)'),
(7, 'Paz y Salvo (Seminario Internacional)');

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
(1, 'Johan', 'Corrales', 'jecorrales@bisont.co', '$2y$10$Eos.J.NcjQbJrGjQMuYzL.0b49yiIs3aB0qJrVeMmna3Z.mGfh9K2', '83b0d175aac9cc0143ad81dbb14f92511bd37813ca9e9ce6516c8fccfd92bf4a', '2019-12-24', 3, 1, 1, 1),
(2, 'Juan', 'Castaño', 'jdcastano@bisont.co', '$2y$10$mBwNh.6kWmOz8Wr.gu30jOvRPytoWe69aRnbcgU36HRN1tug5Ac9.', '46481ee32073327093ebf0607132e789c7d79d310cb2de79880263ab674f5050', '2019-12-31', 2, 1, 2, 2),
(3, 'Felipe', 'Ríos', 'farios@testing.co', '$2y$10$AWOAJW58GXjJ1vU7eC4FbOqhfN2JRdc2j2H6Xb7TkLONNsUyexLRu', '1452bb41611bac8b0b51f3c99987314e0b54ea437bfb814d036555ff4e4cc907', '2020-01-02', 1, 2, 1, 1),
(4, 'Juan Diego', 'Castaño Franco', 'jdcastano@bisont.co', '$2y$10$pteFqGYHEsiYqwf9Ixvvx.Qu/gB0.UUbrsmy0.ncYqQsijeqm1w4S', '9fc287daef1c2517a59f825288d9b2fd769397d051d68ea919efb809fe5004ca', '2020-01-11', 2, 1, 1, 1);

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
  ADD KEY `idTipoReporteConfiguracionReporte_idx` (`id_tipo_reporte_configuracion_reporte`);

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
  ADD KEY `idConfiguracionEstudianteReporte_idx` (`id_configuracion_estudiante_reporte`),
  ADD KEY `idCiudadEstudianteReporte_idx` (`id_ciudad_estudiante_reporte`);

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
  MODIFY `id_configuracion_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `consecutivo_reporte`
--
ALTER TABLE `consecutivo_reporte`
  MODIFY `id_consecutivo_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estado_consecutivo_reporte`
--
ALTER TABLE `estado_consecutivo_reporte`
  MODIFY `id_estado_consecutivo_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_usuario`
--
ALTER TABLE `estado_usuario`
  MODIFY `id_estado_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estudiante_reporte`
--
ALTER TABLE `estudiante_reporte`
  MODIFY `id_estudiante_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `facultad`
--
ALTER TABLE `facultad`
  MODIFY `id_facultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `facultad_reporte`
--
ALTER TABLE `facultad_reporte`
  MODIFY `id_facultad_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `funcionalidad`
--
ALTER TABLE `funcionalidad`
  MODIFY `id_funcionalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `grupo_investigacion`
--
ALTER TABLE `grupo_investigacion`
  MODIFY `id_grupo_investigacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `integrante`
--
ALTER TABLE `integrante`
  MODIFY `id_integrante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `integrante_reporte`
--
ALTER TABLE `integrante_reporte`
  MODIFY `id_integrante_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `jurado_reporte`
--
ALTER TABLE `jurado_reporte`
  MODIFY `id_jurado_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `programa_facultad`
--
ALTER TABLE `programa_facultad`
  MODIFY `id_programa_facultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id_tipo_consecutivo_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_integrante`
--
ALTER TABLE `tipo_integrante`
  MODIFY `id_tipo_integrante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_reporte`
--
ALTER TABLE `tipo_reporte`
  MODIFY `id_tipo_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `idCiudadEstudianteReporte` FOREIGN KEY (`id_ciudad_estudiante_reporte`) REFERENCES `ciudad` (`id_ciudad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
