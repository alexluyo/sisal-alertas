-- Ejecutar en phpMyAdmin o MySQL si quieres que el catálogo diga "Incendios" y no "Incendios forestales".
UPDATE tipo_alertas
SET nombre = 'Incendios'
WHERE id_tipo_alerta = 8;
