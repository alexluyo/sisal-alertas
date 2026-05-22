CREATE TABLE device_tokens (
    id_device_token BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT UNSIGNED NULL,
    token TEXT NOT NULL,
    plataforma VARCHAR(100) NULL,
    navegador TEXT NULL,
    estado TINYINT DEFAULT 1,
    fechacrea TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fechaedita TIMESTAMP NULL,
    fechaelimina TIMESTAMP NULL
);
