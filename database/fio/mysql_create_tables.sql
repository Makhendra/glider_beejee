CREATE TABLE `russian_names` (
	`ID` INT NOT NULL,
	`Name` VARCHAR(100) NOT NULL,
	`Sex` VARCHAR(1) NULL,
	`PeoplesCount` INT NULL,
	`WhenPeoplesCount` DATETIME NULL,
	`Source` VARCHAR(10) NULL
);

CREATE TABLE `russian_surnames` (
	`ID` INT NOT NULL,
	`Surname` VARCHAR(100) NOT NULL,
	`Sex` VARCHAR(1) NULL,
	`PeoplesCount` INT NULL,
	`WhenPeoplesCount` DATETIME NULL,
	`Source` VARCHAR(50) NULL
);

