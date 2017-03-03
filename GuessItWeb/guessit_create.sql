-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-09-2016 a las 01:06:43
-- Versión del servidor: 5.5.47-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `guessit`
--
CREATE DATABASE IF NOT EXISTS `guessit` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `guessit`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `debug_msg`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `debug_msg`(enabled INTEGER, msg VARCHAR(255))
BEGIN
  IF enabled THEN BEGIN
    select concat("** ", msg) AS '** DEBUG:';
  END; END IF;
END$$

DROP PROCEDURE IF EXISTS `prc_generar_tabla`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `prc_generar_tabla`()
BEGIN
	
	DECLARE id_palabra_actual INT;
	DECLARE puntuacion_final FLOAT;
	DECLARE puntuacion_antigua FLOAT;
	DECLARE puntuacion_nueva FLOAT;
	DECLARE intervalo INT DEFAULT 15;
	DECLARE no_more_rows INT DEFAULT 0;
	DECLARE done BOOLEAN DEFAULT 0;
	DECLARE var1 INT;
	DECLARE var2 INT;
	DECLARE var3 INT;
	

	
	-- Obtenemos las medias antes de X días y después
	DECLARE medias_cursor CURSOR FOR
	SELECT definiciones.id, viejas, nuevas
	FROM definiciones LEFT JOIN
	(
		SELECT id_palabra, AVG(puntuacion)-1 AS nuevas
		FROM puntuaciones
		WHERE fecha > DATE_SUB(CURDATE(), INTERVAL intervalo DAY)
		GROUP BY id_palabra
	) AS t1 ON definiciones.id = t1.id_palabra
	LEFT JOIN
	(
		SELECT id_palabra, AVG(puntuacion)-1 as viejas
		FROM puntuaciones
		WHERE fecha <= DATE_SUB(CURDATE(), INTERVAL intervalo DAY)
		GROUP BY id_palabra
	) AS t2 ON definiciones.id = t2.id_palabra
	GROUP BY definiciones.id;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
	
	-- Borra la tabla tabla que contiene la las bolas que representan
	-- las definiciones
	DROP TABLE IF EXISTS tablaestatica;
	
	CREATE TABLE tablaestatica
	(
		id_palabra INT NOT NULL,
		id_categoria INT NOT NULL,
		dificultad INT NOT NULL
	);


	-- Recorre la selección y establece antigua*0.4 + nueva*0.6
	-- Teniendo en cuenta casos especiales donde no se haya jugado en
	-- dicho período
	OPEN medias_cursor;
	
	-- Comienza el bucle
	REPEAT
	
		FETCH medias_cursor INTO id_palabra_actual, puntuacion_antigua, puntuacion_nueva;

		/*-- Si no hay resultados sal de aquí
		IF no_more_rows THEN
			CLOSE medias_cursor;
			LEAVE actualiza_medias;
		END IF;*/
		
		-- Calcula la puntuacion final
		IF puntuacion_antigua IS NULL AND puntuacion_nueva IS NULL THEN
			SET puntuacion_final = 3;
		ELSEIF puntuacion_antigua IS NULL THEN
			SET puntuacion_final = puntuacion_nueva;
		ELSEIF puntuacion_nueva IS NULL THEN
			SET puntuacion_final = puntuacion_antigua;
		ELSE
			SET puntuacion_final = puntuacion_antigua*0.4 + puntuacion_nueva*0.6;
		END IF;
		
		-- Para hacer más representativa la diferencia dada por los decimales,
		-- multiplicamos la puntuacion final por 8 (por ejemplo)
		SET puntuacion_final = ROUND(puntuacion_final * 8);
		
		-- Cache the data to store
		SELECT definiciones.id, definiciones.id_categoria, definiciones.nivel
		INTO var1, var2, var3
		FROM definiciones
		WHERE id = id_palabra_actual;
		
		-- Actualiza la tabla de bolas según la información anterior
		WHILE puntuacion_final > 0 DO
		-- Insertamos la fila tantas veces como el redondeo de
		-- puntuacion_final indique
			INSERT INTO tablaestatica(id_palabra, id_categoria, dificultad)
			VALUES(var1,var2,var3);
			SET puntuacion_final = puntuacion_final - 1;
		END WHILE;

	-- Fin del bucle
	UNTIL done END REPEAT;
	
	
	CLOSE medias_cursor;
	
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula`
--

DROP TABLE IF EXISTS `aula`;
CREATE TABLE IF NOT EXISTS `aula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(128) NOT NULL,
  `id_docente` int(11) NOT NULL,
  `activa` int(11) NOT NULL,
  `id_idioma` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `id_aula` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `definiciones`
--

DROP TABLE IF EXISTS `definiciones`;
CREATE TABLE IF NOT EXISTS `definiciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` int(11) NOT NULL,
  `palabra` varchar(32) NOT NULL,
  `articulo` varchar(16) DEFAULT NULL,
  `frase` text NOT NULL,
  `pista` text NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `validar` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2359 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `idiomas`
--

DROP TABLE IF EXISTS `idiomas`;
CREATE TABLE IF NOT EXISTS `idiomas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logros`
--

DROP TABLE IF EXISTS `logros`;
CREATE TABLE IF NOT EXISTS `logros` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `palabras_jugadas` int(11) NOT NULL,
  `palabras_acertadas` int(11) NOT NULL,
  `reportes_correctos` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuaciones`
--

DROP TABLE IF EXISTS `puntuaciones`;
CREATE TABLE IF NOT EXISTS `puntuaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_palabra` int(11) NOT NULL,
  `puntuacion` int(11) NOT NULL,
  `acierto` int(8) NOT NULL,
  `pista` int(8) NOT NULL,
  `intentos` int(8) NOT NULL,
  `reporte` int(8) NOT NULL,
  `motivo` varchar(128) DEFAULT NULL,
  `fecha` date NOT NULL,
  `revision` varchar(24) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=142625 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablaestatica`
--

DROP TABLE IF EXISTS `tablaestatica`;
CREATE TABLE IF NOT EXISTS `tablaestatica` (
  `id_palabra` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `dificultad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `apellidos` varchar(128) NOT NULL,
  `email` varchar(256) NOT NULL,
  `usuario` varchar(64) DEFAULT NULL,
  `password` text NOT NULL,
  `alta` datetime NOT NULL,
  `validar` int(11) NOT NULL,
  `centro` text,
  `tipo` int(8) NOT NULL COMMENT '0 = alumno, 1 = docente',
  `test` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=123 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_aula`
--

DROP TABLE IF EXISTS `usuarios_aula`;
CREATE TABLE IF NOT EXISTS `usuarios_aula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `validar` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=226 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
