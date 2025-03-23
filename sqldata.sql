--      CORRECCIONES      -- 
-- Tabla para almacenar información de cuentas de streaming
CREATE TABLE `accounts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name_account` VARCHAR(255) NOT NULL,
  `email_account` VARCHAR(255) NOT NULL,
  `pass_account` VARCHAR(255) NOT NULL, -- Encriptar en la aplicación
  `price` DECIMAL(10, 2) NOT NULL,
  `total_profiles` INT NOT NULL,
  `date_pay` DATE NOT NULL,
  `status` VARCHAR(20) NOT NULL,
  `description` VARCHAR(255),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla para almacenar información de clientes
CREATE TABLE `clients` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `type_client` VARCHAR(255) NOT NULL,
  `name_client` VARCHAR(255) NOT NULL,
  `phone_client` VARCHAR(20) NOT NULL, -- Cambiado a VARCHAR para soportar formatos internacionales
  `email_client` VARCHAR(255),
  `description` VARCHAR(255),
  `address` VARCHAR(255),
  `status` VARCHAR(50) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME
);

-- Tabla de unión para relación muchos a muchos entre cuentas y clientes
CREATE TABLE `accounts_clients` (
  `accounts_id` INT NOT NULL,
  `clients_id` INT NOT NULL,
  PRIMARY KEY (`accounts_id`, `clients_id`), -- Clave primaria compuesta
  CONSTRAINT `accounts_id_fk` FOREIGN KEY (`accounts_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `clients_id_fk` FOREIGN KEY (`clients_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
);

-- Tabla para almacenar información de pagos
CREATE TABLE `pays` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `accounts_id` INT NOT NULL, -- Relación con la tabla `accounts`
  `type_notification` VARCHAR(20) NOT NULL,
  `igv` DECIMAL(18, 2) NOT NULL,
  `pay` DECIMAL(18, 2) NOT NULL,
  `total_pay` DECIMAL(18, 2) NOT NULL,
  `date_pay` DATE NOT NULL,
  `status` VARCHAR(20) NOT NULL,
  `description` VARCHAR(255),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `pays_accounts_fk` FOREIGN KEY (`accounts_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE
);

-- Tabla para almacenar información de perfiles dentro de una cuenta
CREATE TABLE `profiles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `profile_number` INT(10) NOT NULL,
  `profile_name` VARCHAR(255) NOT NULL,
  `profile_pin` VARCHAR(10), -- Cambiado a VARCHAR para soportar PINs alfanuméricos
  `price` DECIMAL(10, 2) NOT NULL,
  `date_pay` DATE NOT NULL,
  `status` VARCHAR(20) NOT NULL,
  `description` VARCHAR(255),
  `accounts_id` INT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `profile_account_fk` FOREIGN KEY (`accounts_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE
);

-- Tabla para almacenar información de servicios de streaming
CREATE TABLE `services` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(15, 2) NOT NULL,
  `profiles` INT NOT NULL,
  `link` VARCHAR(255),
  `description` VARCHAR(255),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME
);

-- Tabla para almacenar información de usuarios del sistema
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL, -- Encriptar en la aplicación
  `locale` VARCHAR(255),
  `phone_number` VARCHAR(20), -- Cambiado a VARCHAR para soportar formatos internacionales
  `document_number` VARCHAR(20), -- Cambiado a VARCHAR para soportar diferentes formatos
  `remember_token` VARCHAR(255),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME
);

-- Tabla para almacenar roles de usuarios
CREATE TABLE `roles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME
);

-- Tabla para almacenar permisos
CREATE TABLE `permissions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` DATETIME
);

-- Tabla de unión para relación muchos a muchos entre roles y permisos
CREATE TABLE `permission_role` (
  `role_id` INT NOT NULL,
  `permission_id` INT NOT NULL,
  PRIMARY KEY (`role_id`, `permission_id`), -- Clave primaria compuesta
  CONSTRAINT `role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_id_fk` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
);

-- Tabla de unión para relación muchos a muchos entre usuarios y roles
CREATE TABLE `role_user` (
  `user_id` INT NOT NULL,
  `role_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `role_id`), -- Clave primaria compuesta
  CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_id_fk_user` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
);