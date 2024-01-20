-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-10-2023 a las 21:32:52
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_thbroker`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiry_date` varchar(50) NOT NULL,
  `created_at` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auth_tokens`
--

INSERT INTO `auth_tokens` (`id`, `user_id`, `token`, `expiry_date`, `created_at`) VALUES
(20, 1, '405d840b05935bbfeff98a3d34dcd52de1f331382efae427d99f486443dfbf9d', '2023-10-10 20:11:33', '2023-10-09 20:11'),
(21, 3, '534c7bf17290da2ba67455c4a0c0f392f6a27f7f4aae2478425fa255e6eaaeaf', '2023-10-11 02:18:52', '2023-10-10 02:18'),
(22, 8, '7ffa0fd8c342a068ea7fa82e68c71a423e68be9c927f9ba0df74e08affe4355f', '2023-10-11 21:56:47', '2023-10-10 21:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `id` int(11) NOT NULL,
  `id_pais` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`id`, `id_pais`, `nombre`) VALUES
(1, 10, 'Caracas'),
(2, 10, 'Maracaibo'),
(3, 10, 'Valencia'),
(4, 10, 'Barquisimeto'),
(5, 10, 'Maracay'),
(6, 10, 'Ciudad Guayana'),
(7, 10, 'San Cristóbal'),
(8, 10, 'Maturín'),
(9, 10, 'Barcelona'),
(10, 10, 'Puerto La Cruz'),
(11, 10, 'Los Teques'),
(12, 10, 'Guarenas'),
(13, 10, 'Guatire'),
(14, 10, 'Punto Fijo'),
(15, 10, 'Acarigua'),
(16, 10, 'Cabimas'),
(17, 10, 'Coro'),
(18, 10, 'Cumaná'),
(19, 10, 'Porlamar'),
(20, 10, 'Santa Teresa del Tuy'),
(21, 10, 'Margarita'),
(22, 10, 'Merida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facilidades_hab`
--

CREATE TABLE `facilidades_hab` (
  `id` int(11) NOT NULL,
  `id_hotel` varchar(50) NOT NULL,
  `id_facilidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facilidades_hot`
--

CREATE TABLE `facilidades_hot` (
  `id` int(11) NOT NULL,
  `id_hotel` varchar(50) NOT NULL,
  `id_facilidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion_facilidades`
--

CREATE TABLE `habitacion_facilidades` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `habitacion_facilidades`
--

INSERT INTO `habitacion_facilidades` (`id`, `descripcion`) VALUES
(1, 'Accesible en sillas de ruedas'),
(2, 'Acceso a internet'),
(3, 'Aire acondicionado central'),
(4, 'Aire acondicionado individual'),
(5, ' Balcon'),
(6, 'Bañera'),
(7, 'Baño'),
(8, 'Baño Minusvalido'),
(9, 'Cafetera / Tetera'),
(10, 'Caja de seguridad'),
(11, 'Calefaccion Central'),
(12, 'Calefaccion Individual'),
(13, 'Cama Doble'),
(14, 'Camas king size'),
(15, 'Cocina'),
(16, 'Cocina Pequeña'),
(17, 'Ducha'),
(18, 'Enmoquetado/a'),
(19, 'Estéreo'),
(20, 'Habitación con Jacuzzi'),
(21, 'Habitaciones Comunicadas'),
(22, 'Horno'),
(23, 'Lavadora'),
(24, 'Microondas'),
(25, 'Mini Nevera'),
(26, 'Minibar'),
(27, 'Nevera'),
(28, 'Placha con tabla'),
(29, 'Radio'),
(30, 'Regadera'),
(31, 'Sala de estar'),
(32, 'Secador'),
(33, 'Teléfono de linea directa'),
(34, 'Terraza'),
(35, 'Tina'),
(36, 'TV'),
(37, 'TV via satelite/TV por cable'),
(38, 'Ventilador'),
(39, 'Vista al Mar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel`
--

CREATE TABLE `hotel` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `categoria` varchar(150) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `id_ciudad` int(11) DEFAULT NULL,
  `id_pais` int(11) NOT NULL,
  `codigopostal` varchar(50) DEFAULT NULL,
  `telefono` varchar(150) DEFAULT NULL,
  `fax` varchar(200) DEFAULT NULL,
  `emailreservas` varchar(200) DEFAULT NULL,
  `emailpublico` varchar(200) DEFAULT NULL,
  `hentrada` varchar(5) DEFAULT NULL,
  `hsalida` varchar(5) DEFAULT NULL,
  `descripcion_hotel` text DEFAULT NULL,
  `habitacion` text DEFAULT NULL,
  `restaurante` text DEFAULT NULL,
  `direccion_mapa` varchar(255) DEFAULT NULL,
  `latitud` varchar(100) DEFAULT NULL,
  `longitud` varchar(100) DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `hotel`
--

INSERT INTO `hotel` (`id`, `nombre`, `categoria`, `direccion`, `id_ciudad`, `id_pais`, `codigopostal`, `telefono`, `fax`, `emailreservas`, `emailpublico`, `hentrada`, `hsalida`, `descripcion_hotel`, `habitacion`, `restaurante`, `direccion_mapa`, `latitud`, `longitud`, `fecha`) VALUES
(110, 'Riu Palace', '5', 'Av. Colon Nro. 76 ', 2, 1, '97302', '9991234567', '999343212', 'reservas@riupalace.com', 'info@riupalace.com', '15:00', '12:00', 'Hotel Riu Palace, en la Riviera Maya', 'Deluxe, Premiun, Single, Triples', '15', 'Cancun, Mexico, AV. Colon Nro 76', ' 20.61095', ' -87.08561', '2023-10-11 19:05:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel_facilidades`
--

CREATE TABLE `hotel_facilidades` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `hotel_facilidades`
--

INSERT INTO `hotel_facilidades` (`id`, `descripcion`) VALUES
(1, 'Accesible en sillas de ruedas'),
(2, 'Acceso a internet'),
(3, 'Acepta mascotas'),
(4, 'Aire acondicionado en zonas comunes'),
(5, 'Alquiler de Bicicleta'),
(6, 'Aparcamiento'),
(7, 'Aqua Bar'),
(8, 'Área de Juegos'),
(9, 'Acensores'),
(10, 'Bañera de Hidromasaje'),
(11, 'Baño de Vapor'),
(12, 'Bares'),
(13, 'Bebidas Internacionales'),
(14, 'Bebidas Nacionales'),
(15, 'Bebidas Premium'),
(16, 'Cafeteria'),
(17, 'Caja de Seguridad'),
(18, 'Camas extras'),
(19, 'Cambio de Moneda'),
(20, 'Campo de Golf'),
(21, 'Canchas de Tennis'),
(22, 'Casino'),
(23, 'Chiringuito de picsina'),
(24, 'Club de playas'),
(25, 'Comedor'),
(26, 'Cunas'),
(27, 'Discoteca / Club nocturno'),
(28, 'Disponibilidad de cobertura para telefonos moviles'),
(29, 'Estudio solarium / Radio UVA'),
(30, 'Garaje'),
(31, 'Gimnasio'),
(32, 'Guardaropa'),
(33, 'Internet en alberca ($)'),
(34, 'Internet en alberca sin costo'),
(35, 'Internet en habitaciones ($)'),
(36, 'Internet en habitaciones sin costo'),
(37, ' Internet en Lobby($)'),
(38, 'Internet en Lobby sin costo'),
(39, 'Internet en Playa ($)'),
(40, 'Internet Inalambrico'),
(41, 'Kids Club'),
(42, 'Lavanderia'),
(43, 'Lavanderia ($)	'),
(44, 'Masaje'),
(45, 'Minibar ($)'),
(46, 'Minibar incluido'),
(47, 'Mini Club'),
(48, 'Ofertas especiales de SPA'),
(49, 'Peluqueria'),
(50, 'Picsina al aire libre'),
(51, 'Picsina Climatizada'),
(52, 'Picsina cubierta'),
(53, 'Picsina de agua dulce'),
(54, 'Picina para adultos'),
(55, 'Picsina de niños'),
(56, 'Playa'),
(57, 'Pub-s'),
(58, 'Quiosco'),
(59, 'Restaurante -s'),
(60, 'Restaurante climatizado'),
(61, 'Restaurante de Especialidades Asiatico'),
(62, 'Restaurante de Especialidades Carnes'),
(63, 'Restaurante de Especialidades Chino'),
(64, 'Restaurante de Especialidades Frances'),
(65, 'Restaurante de Especialidades Gourmet'),
(66, 'Restaurante de Especialidades Italiano'),
(67, 'Restaurante de Especialidades Japones'),
(68, 'Restaurante de Especialidades Mariscos'),
(69, 'Restaurante de Especialidades Meditarraneo'),
(70, 'Restaurante de Especialidades Mexicano'),
(71, 'Sala de conferencias'),
(72, 'Sala de juegos'),
(73, 'Sala de TV'),
(74, 'Sala para desayunos'),
(75, 'Sauna'),
(76, 'Sala de facturación 24h'),
(77, 'Servicio de habitaciónes'),
(78, 'Servicio de lavanderia'),
(79, 'Servicio de recepcion 24hrs'),
(80, 'Servicio Medico'),
(81, 'Servicio Nocturno'),
(82, 'Snacks'),
(83, 'Sombrilla'),
(84, 'Spa'),
(85, 'Spa ($)'),
(86, 'Supermercado'),
(87, 'Teatro / Auditorio'),
(88, 'Terraza Solarium'),
(89, 'Tienda-s'),
(90, 'Trastero de bicicletas'),
(91, 'Tronas'),
(92, 'Tombonas'),
(93, 'Vestibulo recepción'),
(94, 'Zona no fumador en restaurante'),
(95, 'Zona para fumadores en restaurante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotel_imagenes`
--

CREATE TABLE `hotel_imagenes` (
  `id` int(11) NOT NULL,
  `id_hotel` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `abreviatura` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id`, `nombre`, `abreviatura`) VALUES
(1, 'Brasil', 'BRA'),
(2, 'Argentina', 'ARG'),
(3, 'Chile', 'CHL'),
(4, 'Colombia', 'COL'),
(5, 'Costa Rica', 'CRI'),
(6, 'Cuba', 'CUB'),
(7, 'Ecuador', 'ECU'),
(8, 'El Salvador', 'SLV'),
(9, 'Guatemala', 'GTM'),
(10, 'Honduras', 'HND'),
(11, 'México', 'MEX'),
(12, 'Nicaragua', 'NIC'),
(13, 'Panamá', 'PAN'),
(14, 'Paraguay', 'PRY'),
(15, 'Perú', 'PER'),
(16, 'Puerto Rico', 'PRI'),
(17, 'República Dominicana', 'DOM'),
(18, 'Uruguay', 'URY'),
(19, 'Venezuela', 'VEN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `nivel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `username`, `password`, `status`, `nivel`) VALUES
(1, 'test', '123', 1, NULL),
(2, 'admin', '111', 1, 1),
(8, 'juan', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_tipo`
--

CREATE TABLE `usuario_tipo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facilidades_hab`
--
ALTER TABLE `facilidades_hab`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facilidades_hot`
--
ALTER TABLE `facilidades_hot`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `habitacion_facilidades`
--
ALTER TABLE `habitacion_facilidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hotel_facilidades`
--
ALTER TABLE `hotel_facilidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hotel_imagenes`
--
ALTER TABLE `hotel_imagenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_tipo`
--
ALTER TABLE `usuario_tipo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `facilidades_hab`
--
ALTER TABLE `facilidades_hab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `facilidades_hot`
--
ALTER TABLE `facilidades_hot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `habitacion_facilidades`
--
ALTER TABLE `habitacion_facilidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `hotel_facilidades`
--
ALTER TABLE `hotel_facilidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `hotel_imagenes`
--
ALTER TABLE `hotel_imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario_tipo`
--
ALTER TABLE `usuario_tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
