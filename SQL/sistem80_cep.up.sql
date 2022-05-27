CREATE SCHEMA `sistem80_cep`;

CREATE TABLE `sistem80_cep`.`uf` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uf_codigo` VARCHAR(45) NULL,
  `uf_descricao` VARCHAR(45) NULL,
  PRIMARY KEY (`id`));


INSERT INTO `sistem80_cep`.`uf` (`uf_codigo`, `uf_descricao`) VALUES ('RJ', 'Rio de Janeiro');
