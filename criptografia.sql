/* SQL Manager Lite for MySQL                              5.6.3.49012 */
/* ------------------------------------------------------------------- */
/* Host     : 192.168.254.250                                          */
/* Port     : 3306                                                     */
/* Database : criptografia                                             */


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES 'latin1' */;

SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE `criptografia`
  CHARACTER SET 'utf8mb4'
  COLLATE 'utf8mb4_general_ci';

USE `criptografia`;

/* Structure for the `usuario` table : */

CREATE TABLE `usuario` (
  `usu_codigo` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `usu_email` VARCHAR(200) COLLATE utf8_unicode_ci NOT NULL,
  `usu_senha` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL,
  `usu_hash` VARCHAR(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY USING BTREE (`usu_codigo`),
  UNIQUE KEY `usu_email_UNIQUE` USING BTREE (`usu_email`)
) ENGINE=InnoDB
  AUTO_INCREMENT=9 CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci'
;

/* Structure for the `arquivo` table : */

CREATE TABLE `arquivo` (
  `arq_codigo` INTEGER(11) NOT NULL AUTO_INCREMENT,
  `arq_nome` VARCHAR(200) COLLATE utf8mb4_general_ci NOT NULL,
  `arq_arquivo` VARCHAR(200) COLLATE utf8mb4_general_ci NOT NULL,
  `arq_chave` VARCHAR(200) COLLATE utf8mb4_general_ci NOT NULL,
  `usu_codigo` INTEGER(11) NOT NULL,
  `arq_data` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY USING BTREE (`arq_codigo`),
  KEY `usu_codigo` USING BTREE (`usu_codigo`),
  CONSTRAINT `arquivo_usuario` FOREIGN KEY (`usu_codigo`) REFERENCES `usuario` (`usu_codigo`) ON UPDATE CASCADE
) ENGINE=InnoDB
  AUTO_INCREMENT=12 CHARACTER SET 'utf8mb4' COLLATE 'utf8mb4_general_ci'
;

/* Data for the `usuario` table  (LIMIT 0,500) */

INSERT INTO `usuario` (`usu_codigo`, `usu_email`, `usu_senha`, `usu_hash`) VALUES
  (8,'jhcb007@gmail.com','$2y$10$l5ArxIkoSoLl/aN8o4ijreyGYA1r3ZnsUjKw9wPoXYU.Ek.qSsb3i','b0b38fc300c1b828a456c021e9c6bd3bf1f723cf');
COMMIT;

/* Data for the `arquivo` table  (LIMIT 0,500) */

INSERT INTO `arquivo` (`arq_codigo`, `arq_nome`, `arq_arquivo`, `arq_chave`, `usu_codigo`, `arq_data`) VALUES
  (10,'DA_IPTU_CERTIDAO.pdf','faafd9f046a10faea8fbd928d9f32596e9e433ec.pdf','999f731b1f569f04913e2ef1b6ad33a7',8,'2017-10-13 12:15:24'),
  (11,'novo arquivo.txt','5a967eb9eb660f55845ff4402944b142af46a54f.txt','6d95ac2a732bc188841b2fe16e95da37',8,'2017-10-13 15:36:25');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;