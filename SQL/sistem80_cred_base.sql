CREATE SCHEMA `sistem80_cred_base` ;

ALTER TABLE `sistem80_cred_base`.`client` 
ADD COLUMN `MATRICULA` VARCHAR(45) NULL AFTER `id`,
ADD COLUMN `CPF` VARCHAR(45) NULL AFTER `MATRICULA`,
ADD COLUMN `NOME` VARCHAR(45) NULL AFTER `CPF`;
