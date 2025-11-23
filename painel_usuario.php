<?php session_start();
if(!isset($_SESSION['logado'])||$_SESSION['nivel']  !='usuario') {
    header("Location: index.php");
    exit;
}
?> 

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário - Star Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #000000;
            --secondary: #dc2626;
            --accent: #b91c1c;
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
        
        .navbar-brand::before {
            content: "";
            color: var(--secondary);
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
            border-left: 4px solid var(--secondary);
        }
        
        .welcome-card h3 {
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .welcome-card p {
            color: var(--gray-300);
            margin-bottom: 0;
        }
        
        .section-title {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 24px;
            text-align: center;
            font-size: 1.5rem;
            position: relative;
        }
        
        .section-title::after {
            content: "";
            display: block;
            width: 60px;
            height: 3px;
            background: var(--secondary);
            margin: 10px auto;
            border-radius: 2px;
        }
        
        .benefit-item {
            padding: 25px 15px;
            text-align: center;
            transition: all 0.3s;
            border-radius: 10px;
        }
        
        .benefit-item:hover {
            background-color: rgba(220, 38, 38, 0.05);
            transform: translateY(-5px);
        }
        
        .benefit-item h1 {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        
        .benefit-item h6 {
            font-weight: 600;
            color: var(--gray-700);
        }
        
        .plano-card {
            background: white;
            border-radius: 10px;
            padding: 25px 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            height: 100%;
            border: 2px solid var(--gray-200);
            position: relative;
        }
        
        .plano-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        
        .plano-card.destaque {
            border-color: var(--secondary);
            transform: scale(1.05);
            z-index: 1;
        }
        
        .plano-card.destaque::before {
            content: "MAIS POPULAR";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--secondary);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        
        .plano-card h5 {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
        }
        
        .plano-card p {
            color: var(--gray-600);
            margin-bottom: 15px;
        }
        
        .plano-card h4 {
            font-weight: 800;
            color: var(--secondary);
        }
        
        .imagem-academia {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .imagem-academia img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .imagem-academia:hover img {
            transform: scale(1.03);
        }
        
        .container-main {
            padding: 30px 0;
        }
        
        @media (max-width: 768px) {
            .plano-card.destaque {
                transform: none;
                margin: 10px 0;
            }
            
            .benefit-item {
                margin-bottom: 15px;
            }
            
            .navbar-brand {
                font-size: 1.2rem;
            }
        }
        
        .user-badge {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-left: 10px;
        }
        
        .stats-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--gray-800) 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 5px;
            color: var(--secondary);
        }
        
        .stats-label {
            font-size: 0.9rem;
            color: var(--gray-300);
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
               <img src="img/logo.png" alt="">
                STAR GYM
            </a>
            <div class="d-flex align-items-center">
                <span class="text-light me-3 d-none d-md-block">Olá, <?=$_SESSION['nome']; ?></span>
                <a href="planos.php" class="btn btn-danger me-2">
                    <i class="fas fa-user-plus me-1"></i>Planos
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
                        <h3>Bem-vindo, <?=$_SESSION['nome']; ?>! <span class="user-badge">USUÁRIO</span></h3>
                        <p>Você faz parte da nossa comunidade fitness. Aproveite todos os benefícios da Star Gym!</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="stats-number">30+</div>
                    <div class="stats-label">Exercícios</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="stats-number">7</div>
                    <div class="stats-label">Dias/Semana</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="stats-number">24h</div>
                    <div class="stats-label">Acesso</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-card">
                    <div class="stats-number">5</div>
                    <div class="stats-label">Instrutores</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="section-title">NOSSOS BENEFÍCIOS</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="benefit-item">
                            <h1><i class="fas fa-dumbbell" style="color: var(--secondary);"></i></h1>
                            <h6>Treinos Personalizados</h6>
                            <p class="text-muted small">Planos de exercícios adaptados ao seu objetivo</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="benefit-item">
                            <h1><i class="fas fa-apple-alt" style="color: var(--secondary);"></i></h1>
                            <h6>Planos Alimentares</h6>
                            <p class="text-muted small">Dietas específicas para maximizar seus resultados</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="benefit-item">
                            <h1><i class="fas fa-chart-line" style="color: var(--secondary);"></i></h1>
                            <h6>Acompanhamento de Resultados</h6>
                            <p class="text-muted small">Monitoramento constante do seu progresso</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="section-title">NOSSOS PLANOS</h4>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="plano-card">
                            <h5>Plano Básico</h5>
                            <p>Acesso completo à academia</p>
                            <h4>R$ 79,90</h4>
                            <ul class="list-unstyled mt-3">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Acesso ilimitado</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Área de musculação</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Área de cardio</li>
                                <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Acompanhamento nutricional</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="plano-card destaque">
                            <h5>Plano Completo</h5>
                            <p>Academia + Nutrição + Acompanhamento</p>
                            <h4>R$ 129,90</h4>
                            <ul class="list-unstyled mt-3">
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Acesso ilimitado</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Área de musculação</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Área de cardio</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Acompanhamento nutricional</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Treino personalizado</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="plano-card">
                            <h5>Plano Nutrição</h5>
                            <p>Apenas acompanhamento nutricional</p>
                            <h4>R$ 59,90</h4>
                            <ul class="list-unstyled mt-3">
                                <li class="mb-2"><i class="fas fa-times text-danger me-2"></i>Acesso à academia</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Plano alimentar personalizado</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Acompanhamento semanal</li>
                                <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Consultas mensais</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- GALERIA -->
        <div class="card">
            <div class="card-body">
                <h4 class="section-title">NOSSA ESTRUTURA</h4>
                <div class="imagem-academia">
                    <img src="img/academia1.png" class="img-fluid" alt="Nossa Academia">
                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <div class="imagem-academia" style="height: 200px;">
                            <img src="img/academia2.jpg" class="img-fluid" alt="Área de Musculação">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="imagem-academia" style="height: 200px;">
                            <img src="img/academia4.jpg" class="img-fluid" alt="Área de Cardio">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="imagem-academia" style="height: 200px;">
                            <img src="img/academia3.png" class="img-fluid" alt="Máquinas Modernas">
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
                    <h5 class="fw-bold">STAR GYM</h5>
                    <p class="mb-0">Transformando vidas através da musculação.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; 2025 Star Gym. Todos os direitos reservados.
                        <br> Cauã Mauricio Ronchi e Pedro Renato Giassi Carpes.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>