<?php session_start();
if(!isset($_SESSION['logado'])||$_SESSION['nivel']  !='admin') {
    header("Location: index.php");
    exit;
}
?> 

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Star Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #000000;
            --secondary: #dc2626;
            --accent: #b91c1c;
            --success: #16a34a;
            --warning: #d97706;
            --info: #0ea5e9;
            --light: #f8fafc;
            --dark: #0f172a;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
        }
        
        body {
            background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--gray-800);
            min-height: 100vh;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--gray-900) 100%);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-bottom: 3px solid var(--secondary);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, var(--accent) 0%, #7f1d1d 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(220, 38, 38, 0.4);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, var(--warning) 0%, #b45309 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, var(--gray-500) 0%, var(--gray-600) 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3);
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 24px;
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: white;
            border-left: 4px solid var(--secondary);
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        
        .welcome-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--gray-800) 100%);
            color: white;
            border-left: 4px solid var(--warning);
        }
        
        .welcome-card h3 {
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .welcome-card p {
            color: var(--gray-300);
            margin-bottom: 0;
        }
        
        .admin-badge {
            background: linear-gradient(135deg, var(--warning) 0%, #b45309 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-left: 10px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border-left: 4px solid var(--secondary);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--secondary);
        }
        
        .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: var(--gray-600);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .action-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border: 2px solid var(--gray-200);
            cursor: pointer;
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            border-color: var(--secondary);
        }
        
        .action-icon {
            font-size: 2.2rem;
            margin-bottom: 15px;
            color: var(--secondary);
            background: rgba(220, 38, 38, 0.1);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        
        .action-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
        }
        
        .action-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        
        .section-title {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 24px;
            font-size: 1.5rem;
            position: relative;
            padding-bottom: 10px;
        }
        
        .section-title::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: var(--secondary);
            position: absolute;
            bottom: 0;
            left: 0;
            border-radius: 2px;
        }
        
        .recent-activity {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(220, 38, 38, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--secondary);
        }
        
        .activity-content {
            flex: 1;
        }
        
        .activity-title {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 5px;
        }
        
        .activity-time {
            color: var(--gray-500);
            font-size: 0.85rem;
        }
        
        .container-main {
            padding: 30px 0;
        }
        
        .admin-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .feature-admin {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            border-left: 4px solid var(--info);
        }
        
        .feature-admin:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        
        .feature-admin h5 {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .feature-admin p {
            color: var(--gray-600);
            margin-bottom: 0;
        }
        
        @media (max-width: 768px) {
            .stats-grid,
            .quick-actions,
            .admin-features {
                grid-template-columns: 1fr;
            }
            
            .navbar-brand {
                font-size: 1.2rem;
            }
        }
        
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand">STAR GYM ADMIN</a>
            <div class="d-flex align-items-center">
                <span class="text-light me-3 d-none d-md-block">Olá, <?=$_SESSION['nome']; ?></span>
                <a href="cadastro.php" class="btn btn-danger me-2">
                    <i class="fas fa-user-plus me-1"></i>Cadastrar Usuário
                </a>
                <a href="gerenciar_usuarios.php" class="btn btn-warning me-2">
                    <i class="fas fa-users me-1"></i>Gerenciar Usuários
                </a>
                <a href="logout.php" class="btn btn-secondary">
                    <i class="fas fa-sign-out-alt me-1"></i>Sair
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container container-main">
        <div class="card welcome-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h3>Bem-vindo, <?=$_SESSION['nome']; ?>! <span class="admin-badge">ADMINISTRADOR</span></h3>
                        <p>Você tem acesso completo ao sistema administrativo da Star Gym.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <i class="fas fa-crown" style="font-size: 4rem; color: var(--warning);"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">156</div>
                <div class="stat-label">Alunos Ativos</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-number">R$ 12.540</div>
                <div class="stat-label">Faturamento Mensal</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-number">87%</div>
                <div class="stat-label">Ocupação</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-number">24</div>
                <div class="stat-label">Novos Este Mês</div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="recent-activity">
                    <h4 class="section-title">Atividade Recente</h4>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Novo aluno cadastrado</div>
                            <div class="activity-time">João Silva - Há 2 minutos</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Pagamento confirmado</div>
                            <div class="activity-time">Cauã Mauricio - Plano Completo - Há 15 minutos</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Treino atualizado</div>
                            <div class="activity-time">Pedro Renato - Há 1 hora</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-comment"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Nova mensagem</div>
                            <div class="activity-time">João Vitor - Há 2 horas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold">STAR GYM ADMIN</h5>
                    <p class="mb-0">Sistema administrativo - Painel de controle</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; 2025 Star Gym. Todos os direitos reservados.
                        <br> Cauã Mauricio Ronchi e Pedro Renato Giassi Carpes</p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>