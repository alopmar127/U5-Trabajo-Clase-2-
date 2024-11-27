INSERT INTO
    `productos` (`id`, `nombre`, `precio`)
VALUES
    -- Ropa
    ('P001', 'Camiseta', 15.99),
    ('P002', 'Pantalón', 30.50),
    ('P003', 'Sudadera', 25.00),
    ('P004', 'Chaqueta', 50.00),
    ('P005', 'Zapatos', 65.00),
    -- Electrónico
    ('P006', 'Laptop', 899.99),
    ('P007', 'Teléfono Móvil', 499.00),
    ('P008', 'Tablet', 299.99),
    ('P009', 'Smartwatch', 199.99),
    ('P010', 'Auriculares', 129.99),
    -- Comida
    ('P011', 'Pizza', 9.99),
    ('P012', 'Hamburguesa', 5.00),
    ('P013', 'Ensalada', 4.50),
    ('P014', 'Tacos', 3.00),
    ('P015', 'Paella', 22.50);

-- ROPA
-- Insertamos los productos de ropa
INSERT INTO `ropa` (`talla`, `id_p`) VALUES
('M', 'P001'),  -- Camiseta
('L', 'P002'),  -- Pantalón
('S', 'P003'),  -- Sudadera
('XL', 'P004'), -- Chaqueta
('M', 'P005');  -- Zapatos

-- ELECTRÓNICA
-- Insertamos los productos electrónicos
INSERT INTO `electronico` (`modelo`, `id_p`) VALUES
('MacBook Pro', 'P006'),   -- Laptop
('iPhone 13', 'P007'),     -- Teléfono Móvil
('Samsung Galaxy S21', 'P008'), -- Tablet
('Sony Smartwatch', 'P009'),   -- Smartwatch
('Sony WH-1000XM4', 'P010'); -- Auriculares

-- COMIDA
-- Insertamos productos en orden por categoría
-- Insertamos los productos de comida rápida
INSERT INTO `comida` (`id_p`, `categoria`) VALUES
('P011', 'Rápida'),  -- Pizza
('P012', 'Rápida'),  -- Hamburguesa
('P014', 'Rápida');  -- Tacos

-- Insertamos los productos de comida mediterránea
INSERT INTO `comida` (`id_p`, `categoria`) VALUES
('P013', 'Mediterránea'), -- Ensalada
('P015', 'Mediterránea'); -- Paella