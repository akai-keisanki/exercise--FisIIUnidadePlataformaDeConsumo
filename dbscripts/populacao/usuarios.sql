INSERT
    INTO Usuario(matricula, nome, email, hash_senha, perfil, data_cadastro)
    VALUES
        ('TEC001001001', 'Markito Técnico', 'markito.tec@ifba.edu.br', '$2y$10$KOkG8COFtHssPp0stQIcC.eIpyKoiZVxX1eklYn5wFdDgm00qw0ce', 'TEC', '2026-01-01'),
        ('TEC001001002', 'Maurício Técnico', 'mauricio.tec@ifba.edu.br', '$2y$10$KOkG8COFtHssPp0stQIcC.eIpyKoiZVxX1eklYn5wFdDgm00qw0ce', 'TEC', '2026-01-01'),
        ('TEC001001003', 'Ciro Técnico', 'ciro.tec@ifba.edu.br', '$2y$10$KOkG8COFtHssPp0stQIcC.eIpyKoiZVxX1eklYn5wFdDgm00qw0ce', 'TEC', '2026-01-01'),
        ('ADM001001001', 'Administrador Geral', 'admin.geral@ifba.edu.br', '$2y$10$KOkG8COFtHssPp0stQIcC.eIpyKoiZVxX1eklYn5wFdDgm00qw0ce', 'ADM', '2026-01-01');

INSERT
    INTO UsuarioTecnico(matricula_usuario)
    VALUES
        ('TEC001001001'),
        ('TEC001001002'),
        ('TEC001001003');

INSERT
    INTO UsuarioAdmin(matricula_usuario)
    VALUES
        ('ADM001001001');
