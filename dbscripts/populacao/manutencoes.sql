INSERT
    INTO Manutencao(descricao_servico, tipo, data_manutencao, custo_reais, proxima_manutencao, matricula_requisitante, id_dispositivo)
    VALUES
        ('Isolamento e troca de tomadas defeituosas e substituição de 3 lâmpadas queimadas', 'corretiva', '2026-10-16', 150.00, TRUE, 'TEC001001001', 2),
        ('Correção de ponto de vazamento e revisão do ar-condicionado Gree de 24.000 BTU', 'corretiva', '2026-10-16', 300.00, TRUE, 'TEC001001002', 7),
        ('Inspeção de segurança e substituição de tomada com descarga elétrica', 'corretiva', '2026-10-16', 80.00, TRUE, 'TEC001001003', 10),
        ('Reparo na porta do laboratório para otimizar vedação do ar-condicionado', 'corretiva', '2026-10-16', 200.00, FALSE, 'TEC001001001', 52);
