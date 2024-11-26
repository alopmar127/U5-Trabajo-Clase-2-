-- BBDD: Tarea2U5
CREATE TABLE `productos` (
  `id` VARCHAR(255) PRIMARY KEY,
  `nombre` VARCHAR(255),
  `precio` FLOAT
);

CREATE TABLE `ropa` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `talla` VARCHAR(255),
  `id_p` VARCHAR(255) UNIQUE
);

CREATE TABLE `electronico` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `modelo` VARCHAR(255),
  `id_p` VARCHAR(255) UNIQUE
);

CREATE TABLE `comida` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `categoria` VARCHAR(255),
  `id_p` VARCHAR(255) UNIQUE
);

ALTER TABLE `ropa` ADD FOREIGN KEY (`id_p`) REFERENCES `productos` (`id`);

ALTER TABLE `electronico` ADD FOREIGN KEY (`id_p`) REFERENCES `productos` (`id`);

ALTER TABLE `comida` ADD FOREIGN KEY (`id_p`) REFERENCES `productos` (`id`);
