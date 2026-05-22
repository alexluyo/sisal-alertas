-- Convertir tu usuario actual en ADMIN_FULL
UPDATE users
SET rol = 'ADMIN_FULL', estado = 1
WHERE email = 'admin@alerta.com';

-- Si tu correo es otro, cambia admin@alerta.com por tu email real.

-- Insertar módulos base si no usas el seeder:
INSERT INTO modulos (nombre, clave, estado, fechacrea)
VALUES
('Dashboard', 'dashboard', 1, NOW()),
('Anexos', 'anexos', 1, NOW()),
('Vecinos', 'vecinos', 1, NOW()),
('Alertas', 'alertas', 1, NOW()),
('Historial', 'historial', 1, NOW()),
('Usuarios', 'usuarios', 1, NOW()),
('Permisos', 'permisos', 1, NOW()),
('Reportes', 'reportes', 1, NOW())
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), estado = 1;
