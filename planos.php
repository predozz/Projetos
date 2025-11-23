<?php 
//CONECTA NO BANCO 
require "conexao.php";
session_start();

// Verifica se é admin
$is_admin = isset($_SESSION['nivel']) && $_SESSION['nivel'] == 'admin';

// Dados fictícios dos planos
$planos = [
    [
        'id' => 1,
        'nome' => 'Plano Básico',
        'descricao' => 'Acesso completo à academia',
        'preco' => 79.90,
        'duracao' => 'Mensal',
        'beneficios' => ['Acesso ilimitado', 'Área de musculação', 'Área de cardio', 'Vestiários'],
        'destaque' => false,
        'cor' => 'primary'
    ],
    [
        'id' => 2,
        'nome' => 'Plano Completo',
        'descricao' => 'Academia + Nutrição + Acompanhamento',
        'preco' => 129.90,
        'duracao' => 'Mensal',
        'beneficios' => ['Acesso ilimitado', 'Área de musculação', 'Área de cardio', 'Acompanhamento nutricional', 'Treino personalizado', 'Avaliação física'],
        'destaque' => true,
        'cor' => 'secondary'
    ],
    [
        'id' => 3,
        'nome' => 'Plano Premium',
        'descricao' => 'Experiência completa fitness',
        'preco' => 199.90,
        'duracao' => 'Mensal',
        'beneficios' => ['Todos os benefícios do Plano Completo', 'Acesso à área VIP', 'Massagem relaxante mensal', 'Personal trainer dedicado', 'Suplementação básica'],
        'destaque' => false,
        'cor' => 'warning'
    ],
    [
        'id' => 4,
        'nome' => 'Plano Nutrição',
        'descricao' => 'Apenas acompanhamento nutricional',
        'preco' => 59.90,
        'duracao' => 'Mensal',
        'beneficios' => ['Plano alimentar personalizado', 'Acompanhamento semanal', 'Consultas mensais', 'App de nutrição'],
        'destaque' => false,
        'cor' => 'success'
    ],
    [
        'id' => 5,
        'nome' => 'Plano Anual Básico',
        'descricao' => 'Acesso anual com desconto',
        'preco' => 799.90,
        'duracao' => 'Anual',
        'beneficios' => ['12 meses de acesso', 'Área de musculação', 'Área de cardio', 'Desconto de 15%'],
        'destaque' => false,
        'cor' => 'info'
    ],
    [
        'id' => 6,
        'nome' => 'Plano Casal',
        'descricao' => 'Para casais que treinam juntos',
        'preco' => 229.90,
        'duracao' => 'Mensal',
        'beneficios' => ['2 acessos simultâneos', 'Aulas em dupla', 'Desconto em suplementos', 'Área de musculação e cardio'],
        'destaque' => false,
        'cor' => 'danger'
    ]
];
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Star Gym - Planos e Assinaturas</title>
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
      --border: #e2e8f0;
      --card-bg: #ffffff;
    }
    
    body { 
      background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
      color: var(--gray-800);
      line-height: 1.6;
      min-height: 100vh;
    }
    
    .navbar { 
      background: linear-gradient(135deg, var(--primary) 0%, var(--gray-900) 100%);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      border-bottom: 3px solid var(--secondary);
    }
    
    .navbar-brand {
      font-weight: 800;
      font-size: 1.5rem;
      color: white;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    
    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      margin-bottom: 24px;
      transition: transform 0.3s, box-shadow 0.3s;
      background-color: var(--card-bg);
      border-left: 4px solid var(--secondary);
      overflow: hidden;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .card-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--gray-800) 100%);
      border-bottom: 2px solid var(--secondary);
      font-weight: 700;
      padding: 20px;
      color: white;
      font-size: 1.1rem;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
      border: none;
      border-radius: 8px;
      padding: 12px 24px;
      font-weight: 600;
      transition: all 0.3s;
      box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }
    
    .btn-primary:hover {
      background: linear-gradient(135deg, var(--accent) 0%, var(--accent) 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(220, 38, 38, 0.4);
    }
    
    .btn-warning {
      background: linear-gradient(135deg, var(--warning) 0%, #b45309 100%);
      border: none;
      border-radius: 6px;
      color: white;
      font-weight: 600;
      transition: all 0.2s;
    }
    
    .btn-warning:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
    }
    
    .btn-danger {
      background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
      border: none;
      border-radius: 6px;
      font-weight: 600;
      transition: all 0.2s;
    }
    
    .btn-danger:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }
    
    .btn-secondary {
      background: linear-gradient(135deg, var(--gray-500) 0%, var(--gray-600) 100%);
      border: none;
      border-radius: 6px;
      font-weight: 600;
      transition: all 0.2s;
    }
    
    .btn-secondary:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3);
    }
    
    .btn-home {
      background: linear-gradient(135deg, white 0%, var(--gray-100) 100%);
      border: 2px solid var(--gray-300);
      border-radius: 8px;
      color: var(--primary);
      font-weight: 600;
      padding: 10px 18px;
      transition: all 0.3s;
    }
    
    .btn-home:hover {
      background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border-color: var(--secondary);
    }
    
    .page-title {
      color: var(--primary);
      font-weight: 800;
      margin-bottom: 30px;
      font-size: 2.2rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    
    .page-title i {
      color: var(--secondary);
      text-shadow: 0 0 8px rgba(220, 38, 38, 0.3);
    }
    
    .container-main {
      padding: 40px 0;
    }
    
    .admin-badge {
      background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
      color: white;
      padding: 8px 16px;
      border-radius: 6px;
      font-weight: 700;
      font-size: 0.85rem;
      box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
    }
    
    .navbar-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
    }
    
    .navbar-right {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .plano-card {
      height: 100%;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
      background: white;
      border: 2px solid var(--gray-200);
      position: relative;
    }
    
    .plano-card.destaque {
      border-color: var(--secondary);
      transform: scale(1.05);
      z-index: 2;
    }
    
    .plano-card.destaque::before {
      content: "MAIS POPULAR";
      position: absolute;
      top: -12px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--secondary);
      color: white;
      padding: 6px 20px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 700;
      z-index: 3;
      box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
    }
    
    .plano-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }
    
    .plano-card.destaque:hover {
      transform: scale(1.05) translateY(-8px);
    }
    
    .plano-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--gray-800) 100%);
      color: white;
      padding: 25px 20px;
      text-align: center;
      border-bottom: 3px solid var(--secondary);
    }
    
    .plano-nome {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 5px;
    }
    
    .plano-descricao {
      font-size: 0.9rem;
      opacity: 0.9;
      margin-bottom: 15px;
    }
    
    .plano-preco {
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--secondary);
      margin-bottom: 5px;
    }
    
    .plano-duracao {
      font-size: 0.9rem;
      opacity: 0.8;
    }
    
    .plano-body {
      padding: 25px 20px;
    }
    
    .beneficios-list {
      list-style: none;
      padding: 0;
      margin: 0 0 25px 0;
    }
    
    .beneficios-list li {
      padding: 8px 0;
      border-bottom: 1px solid var(--gray-200);
      display: flex;
      align-items: center;
    }
    
    .beneficios-list li:last-child {
      border-bottom: none;
    }
    
    .beneficios-list li i {
      color: var(--success);
      margin-right: 10px;
      font-size: 1.1rem;
    }
    
    .btn-assinar {
      width: 100%;
      padding: 12px;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s;
    }
    
    .stats-card {
      background: linear-gradient(135deg, var(--primary) 0%, var(--gray-800) 100%);
      color: white;
      border-radius: 10px;
      padding: 25px;
      text-align: center;
      margin-bottom: 20px;
      border-left: 4px solid var(--secondary);
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
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    
    .filtros-container {
      background: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
      border-left: 4px solid var(--secondary);
    }
    
    .filtro-titulo {
      font-weight: 600;
      color: var(--primary);
      margin-bottom: 15px;
      font-size: 1.1rem;
    }
    
    .badge-plano {
      padding: 6px 12px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 0.75rem;
    }
    
    .badge-destaque {
      background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
      color: white;
    }
    
    @media (max-width: 768px) {
      .plano-card.destaque {
        transform: none;
        margin: 10px 0;
      }
      
      .navbar-brand {
        font-size: 1.2rem;
      }
      
      .page-title {
        font-size: 1.8rem;
      }
    }
    
    .empty-state {
      padding: 50px 20px;
      text-align: center;
      color: var(--gray-500);
      background-color: white;
      border-radius: 10px;
    }
    
    .empty-state i {
      font-size: 3.5rem;
      margin-bottom: 20px;
      color: var(--gray-400);
    }
    
    .empty-state h5 {
      color: var(--gray-600);
      font-weight: 600;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <div class="navbar-content">
      <a class="navbar-brand">STAR GYM</a>
      <div class="navbar-right">
        <?php if ($is_admin): ?>
          <div class="admin-badge">
            <i class="fas fa-shield-alt me-1"></i> ADMIN
          </div>
        <?php endif; ?>
        <a href="index.php" class="btn btn-home">
          <i class="fas fa-home me-1"></i> Página Inicial
        </a>
        <?php if ($is_admin): ?>
          <a href="gerenciar_usuarios.php" class="btn btn-home">
            <i class="fas fa-users me-1"></i> Gerenciar Usuários
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<div class="container container-main">
  <?php if (isset($mensagem)): ?>
    <div class="alert alert-<?= $tipo_mensagem ?> alert-dismissible fade show" role="alert">
      <i class="fas fa-<?= $tipo_mensagem == 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
      <?= $mensagem ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
  
  <h1 class="page-title text-center">
    <i class="fas fa-crown me-3"></i>
    Nossos Planos
  </h1>

  <div class="row">
    <div class="col-md-3 col-6">
      <div class="stats-card">
        <div class="stats-number">6</div>
        <div class="stats-label">Planos Disponíveis</div>
      </div>
    </div>
    <div class="col-md-3 col-6">
      <div class="stats-card">
        <div class="stats-number">500+</div>
        <div class="stats-label">Clientes Ativos</div>
      </div>
    </div>
    <div class="col-md-3 col-6">
      <div class="stats-card">
        <div class="stats-number">98%</div>
        <div class="stats-label">Satisfação</div>
      </div>
    </div>
    <div class="col-md-3 col-6">
      <div class="stats-card">
        <div class="stats-number">24/7</div>
        <div class="stats-label">Suporte</div>
      </div>
    </div>
  </div>

  <div class="filtros-container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h5 class="filtro-titulo mb-0">Encontre o plano perfeito para você</h5>
        <p class="text-muted mb-0">Compare nossos planos e escolha o que melhor se adapta aos seus objetivos</p>
      </div>
      <div class="col-md-6 text-md-end">
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-outline-secondary active">Todos</button>
          <button type="button" class="btn btn-outline-secondary">Mensais</button>
          <button type="button" class="btn btn-outline-secondary">Anuais</button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <?php foreach ($planos as $plano): ?>
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="plano-card <?= $plano['destaque'] ? 'destaque' : '' ?>">
          <div class="plano-header">
            <div class="plano-nome"><?= $plano['nome'] ?></div>
            <div class="plano-descricao"><?= $plano['descricao'] ?></div>
            <div class="plano-preco">R$ <?= number_format($plano['preco'], 2, ',', '.') ?></div>
            <div class="plano-duracao"><?= $plano['duracao'] ?></div>
          </div>
          <div class="plano-body">
            <ul class="beneficios-list">
              <?php foreach ($plano['beneficios'] as $beneficio): ?>
                <li>
                  <i class="fas fa-check-circle"></i>
                  <?= $beneficio ?>
                </li>
              <?php endforeach; ?>
            </ul>
            <button class="btn btn-primary btn-assinar">
              <i class="fas fa-shopping-cart me-2"></i>
              Assinar Agora
            </button>
            <?php if ($plano['destaque']): ?>
              <div class="text-center mt-3">
                <span class="badge badge-plano badge-destaque">
                  <i class="fas fa-star me-1"></i> Mais Escolhido
                </span>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="card mt-5">
    <div class="card-header">
      <i class="fas fa-chart-bar me-2"></i>Comparativo de Planos
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Benefício</th>
              <?php foreach ($planos as $plano): ?>
                <th class="text-center"><?= $plano['nome'] ?></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Acesso Ilimitado</td>
              <?php foreach ($planos as $plano): ?>
                <td class="text-center">
                  <?= in_array('Acesso ilimitado', $plano['beneficios']) || in_array('12 meses de acesso', $plano['beneficios']) || in_array('2 acessos simultâneos', $plano['beneficios']) ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <td>Acompanhamento Nutricional</td>
              <?php foreach ($planos as $plano): ?>
                <td class="text-center">
                  <?= in_array('Acompanhamento nutricional', $plano['beneficios']) || in_array('Plano alimentar personalizado', $plano['beneficios']) ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <td>Treino Personalizado</td>
              <?php foreach ($planos as $plano): ?>
                <td class="text-center">
                  <?= in_array('Treino personalizado', $plano['beneficios']) || in_array('Personal trainer dedicado', $plano['beneficios']) ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <td>Avaliação Física</td>
              <?php foreach ($planos as $plano): ?>
                <td class="text-center">
                  <?= in_array('Avaliação física', $plano['beneficios']) ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' ?>
                </td>
              <?php endforeach; ?>
            </tr>
            <tr>
              <td>Área VIP</td>
              <?php foreach ($planos as $plano): ?>
                <td class="text-center">
                  <?= in_array('Acesso à área VIP', $plano['beneficios']) ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' ?>
                </td>
              <?php endforeach; ?>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<footer class="bg-dark text-light py-4 mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h5 class="fw-bold">STAR GYM</h5>
        <p class="mb-0">Transformando vidas através da musculação</p>
      </div>
      <div class="col-md-6 text-md-end">
        <p class="mb-0">&copy; 2023 Star Gym. Todos os direitos reservados. 
            <br>Cauã Mauricio Ronchi e Pedro Renato Giassi Carpes</p>
      </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const planoCards = document.querySelectorAll('.plano-card');
    
    planoCards.forEach(card => {
      card.addEventListener('mouseenter', function() {
        if (!this.classList.contains('destaque')) {
          this.style.transform = 'translateY(-8px)';
        }
      });
      
      card.addEventListener('mouseleave', function() {
        if (!this.classList.contains('destaque')) {
          this.style.transform = 'translateY(0)';
        } else {
          this.style.transform = 'scale(1.05)';
        }
      });
    });
    
    //filtro nao funciona
    const filtro = document.querySelectorAll('.btn-group .btn');
    filtro.forEach(button => {
      button.addEventListener('click', function() {
        filtro.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
      });
    });
  });
</script>
</body>
</html>