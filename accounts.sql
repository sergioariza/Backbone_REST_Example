--
-- Base de datos: `accounts`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `outgoings`
--

CREATE TABLE IF NOT EXISTS `outgoings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `outgoings`
--

INSERT INTO `outgoings` (`id`, `description`, `quantity`) VALUES
(1, 'Gasto de prueba', 100),
(2, 'Otro gasto de prueba', 200);
(2, 'Más gastos de prueba', 300);
