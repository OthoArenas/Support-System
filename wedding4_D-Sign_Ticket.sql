-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 12-09-2019 a las 00:49:38
-- Versión del servidor: 5.7.26
-- Versión de PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ticketly`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Falla CFEmático'),
(2, 'Servicio'),
(3, 'Mantenimiento'),
(10, 'Prueba Categoría Mod');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `division`
--

CREATE TABLE `division` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `division`
--

INSERT INTO `division` (`id`, `name`) VALUES
(1, 'General'),
(2, 'Sureste'),
(3, 'Oriente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kind`
--

CREATE TABLE `kind` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `kind`
--

INSERT INTO `kind` (`id`, `name`) VALUES
(1, 'Ticket'),
(2, 'Sugerencia'),
(3, 'Reporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `priority`
--

CREATE TABLE `priority` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `priority`
--

INSERT INTO `priority` (`id`, `name`) VALUES
(1, 'Baja'),
(2, 'Media'),
(3, 'Alta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `project`
--

INSERT INTO `project` (`id`, `name`, `description`) VALUES
(1, 'Reparación', 'CFEmático'),
(2, 'Servicio', 'Servicio a Equipo electrónico'),
(3, 'Servicios y Atención al Cliente', 'Servicios y Atención al Cliente'),
(4, 'Prueba Departamento', 'Prueba Departamento Mod');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pwdReset`
--

CREATE TABLE `pwdReset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `name`) VALUES
(1, 'Cliente'),
(2, 'Agente'),
(3, 'Administrador'),
(4, 'Demo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Pendiente'),
(2, 'En Atención'),
(3, 'Terminado'),
(4, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `ticket_id` text CHARACTER SET utf8 NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `closed_comments` text,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `attended_at` datetime DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  `isupdated` smallint(1) DEFAULT '1',
  `kind_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `asigned_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `priority_id` int(11) NOT NULL DEFAULT '3',
  `status_id` int(11) NOT NULL DEFAULT '1',
  `division_id` tinyint(4) DEFAULT NULL,
  `zona_id` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ticket`
--

INSERT INTO `ticket` (`id`, `ticket_id`, `title`, `description`, `closed_comments`, `updated_at`, `created_at`, `attended_at`, `closed_at`, `isupdated`, `kind_id`, `user_id`, `asigned_id`, `project_id`, `category_id`, `priority_id`, `status_id`, `division_id`, `zona_id`) VALUES
(4, 'GT00000004', 'Falla CFEmático', 'Prueba Fallo', '', '2019-09-09 10:23:35', '2019-08-27 16:40:50', '2019-09-09 10:27:14', NULL, 2, 1, 1, NULL, 1, 3, 2, 2, 1, 1),
(5, 'GT00000005', 'Prueba de Título', 'Prueba de Título Ticket', '', '2019-09-09 10:22:47', '2019-08-27 20:51:26', NULL, NULL, 2, 1, 1, NULL, 2, 2, 3, 1, 2, 1),
(6, 'GT00000006', 'Numerado', 'asd', '', '2019-08-28 16:08:34', '2019-08-28 09:36:17', NULL, NULL, 2, 1, 1, NULL, 1, 1, 1, 4, 2, 2),
(7, 'GT00000007', 'Numerado', 'asd', '', '2019-09-02 14:54:28', '2019-08-28 09:37:35', '2019-09-02 15:04:22', '2019-09-02 15:02:40', 2, 1, 1, NULL, 1, 1, 1, 2, 1, 1),
(8, 'GT00000008', 'Numerado', 'asd', '', NULL, '2019-08-28 09:41:13', NULL, NULL, 1, 1, 1, NULL, 1, 1, 1, 1, 2, 2),
(9, 'GT00000009', 'Numerado Uno', 'asd Uno', '', '2019-09-06 10:42:13', '2019-08-28 09:41:21', NULL, NULL, 2, 1, 1, NULL, 1, 1, 1, 1, 2, 1),
(25, 'GT00000025', 'Prueba', 'Prueba', NULL, NULL, '2019-09-10 22:43:52', NULL, NULL, 1, 1, 1, NULL, 1, 3, 1, 1, 2, 1),
(27, 'GT00000026', 'Prueba Ticket', 'Prueba', NULL, NULL, '2019-09-11 17:08:26', NULL, NULL, 1, 1, 41, NULL, 3, 3, 3, 1, 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `updated`
--

CREATE TABLE `updated` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `updated`
--

INSERT INTO `updated` (`id`, `name`) VALUES
(1, 'No Actualizado'),
(2, 'Actualizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `lastname` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `profile_pic` varchar(250) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `rol` tinyint(4) NOT NULL DEFAULT '1',
  `kind` int(11) NOT NULL DEFAULT '1',
  `division_id` tinyint(4) DEFAULT NULL,
  `zona_id` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `token` varchar(100) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `lastname`, `email`, `password`, `profile_pic`, `is_active`, `rol`, `kind`, `division_id`, `zona_id`, `created_at`, `updated_at`, `token`) VALUES
(1, 'admin', 'Othoniel Eduardo', 'Salazar Arenas', 'othoniel.salazar@dsignstudio.com.mx', '$2y$10$lwb23D7RNrhva21RUINf.u8ZjB0iNL2apWtf2fhX4sSoiXvV2yE2O', 'Copia de PHOTO-2019-05-17-21-14-09 2.png', 1, 3, 1, 1, 1, '2017-07-15 12:05:45', NULL, NULL),
(2, 'D-Sign Studio', 'D-Sign Studio', NULL, 'dsign.studio.solutions@gmail.com', '$2y$10$3MLALiJQ6x8Gs3G0fjfvsuufVp9zy5R.Dnxm7mwOHBRkEn9KA2saS', 'Copia de PHOTO-2019-05-17-21-14-09 2.png', 1, 2, 1, 1, 1, '2019-08-27 19:24:06', NULL, NULL),
(3, 'Alejandra', 'Mariana', '', 'mariana.vidal@cfe.mx', '$2y$10$w4x/kRdeKvuWkUfiqifrguJpJ96xne071Cb.m3x3T9nYTwrEx2rLu', 'Copia de PHOTO-2019-05-17-21-14-09 2.png', 1, 1, 1, 2, 1, '2019-08-27 21:41:33', NULL, ''),
(23, 'MariV', 'Mariana', 'Vidal Loyda', 'mariana@cfe.mx', '$2y$10$uhIJf5Kcmus4Iq0u6sT.OO0Pb2FjXaMvqXCZtelCR/f995bxBeeu6', 'Copia de PHOTO-2019-05-17-21-14-09 2.png', 1, 1, 1, 1, 2, '2019-09-03 15:34:11', NULL, NULL),
(24, 'Eduardo', 'Eduardo', 'Salazar', 'otho@gmail.com', '$2y$10$/98jPjx.JW/ClLfpprrxDuStubme/UbE6fmiZARSTF8sh4QDa8NPK', 'Copia de PHOTO-2019-05-17-21-14-09 2.png', 1, 3, 1, 1, 1, '2019-09-03 15:49:34', NULL, NULL),
(41, 'Prueba Nombre', 'Othoniel Eduardo', 'Salazar', 'prueba@prueba.com', '$2y$10$Q8zE2AOzkBRwA9Af9P/cFea5NFlBcQ0TykDTTUFWd3QDAClAQNSG6', 'Copia de PHOTO-2019-05-17-21-14-09 2.png', 1, 1, 1, 2, 3, '2019-09-05 16:24:17', '2019-09-11 00:15:09', ''),
(42, 'Prueba Zona', 'Prueba', 'División', 'test@test.com', '$2y$10$JMT1p0QEZ2lZFvrbmv6D2.sUYNIPk8Q.SGfd0eGji6fuFss.4fcpy', 'default.png', 0, 1, 1, 2, 2, '2019-09-11 18:41:19', NULL, 'ROjeH0rzB8'),
(43, 'Prueba División', 'Prueba', 'Zona', 'test@gmail.com', '$2y$10$JsneJjx7.fwi0c09FsCcoOH.XQzWmC9dpx9bY6pLjPT0QgwUpRkMO', 'default.png', 0, 1, 1, 1, 2, '2019-09-11 18:49:33', '2019-09-11 13:54:51', 'g@pHg477tt');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona`
--

CREATE TABLE `zona` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `division_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zona`
--

INSERT INTO `zona` (`id`, `name`, `division_id`) VALUES
(1, 'General', 2),
(2, 'Xalapa', 1),
(3, 'Huatulco', 1),
(4, 'Oaxaca', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `kind`
--
ALTER TABLE `kind`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `priority`
--
ALTER TABLE `priority`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pwdReset`
--
ALTER TABLE `pwdReset`
  ADD PRIMARY KEY (`pwdResetId`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `priority_id` (`priority_id`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `kind_id` (`kind_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `isupdated` (`isupdated`);

--
-- Indices de la tabla `updated`
--
ALTER TABLE `updated`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rol` (`rol`);

--
-- Indices de la tabla `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `kind`
--
ALTER TABLE `kind`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `priority`
--
ALTER TABLE `priority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pwdReset`
--
ALTER TABLE `pwdReset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `updated`
--
ALTER TABLE `updated`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `zona`
--
ALTER TABLE `zona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`priority_id`) REFERENCES `priority` (`id`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  ADD CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `ticket_ibfk_4` FOREIGN KEY (`kind_id`) REFERENCES `kind` (`id`),
  ADD CONSTRAINT `ticket_ibfk_5` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `ticket_ibfk_6` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
