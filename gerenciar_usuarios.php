<?php 
//CONECTA NO BANCO 
require "conexao.php";
session_start();
$is_admin = true; 

// EXCLUI
if (isset($_GET['excluir']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM usuarios WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        $mensagem = "Usuário excluído com sucesso!";
        $tipo_mensagem = "success";
    } else {
        $mensagem = "Erro ao excluir: " . $conn->error;
        $tipo_mensagem = "danger";
    }
}
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'cadastrar') {
        // CADASTRA
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $endereco = $_POST['endereco'];
        $nivel = $_POST['nivel'];
        
        $sql = "INSERT INTO usuarios (nome, email, cpf, endereco, nivel) VALUES ('$nome', '$email', '$cpf', '$endereco', '$nivel')";
        
        if ($conn->query($sql) === TRUE) {
            $mensagem = "Aluno cadastrado com sucesso!";
            $tipo_mensagem = "success";
        } else {
            $mensagem = "Erro: " . $conn->error;
            $tipo_mensagem = "danger";
        }
    }
    elseif ($action == 'editar') {
        // ATUALIZA
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $endereco = $_POST['endereco'];
        $nivel = $_POST['nivel'];
        
        $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', cpf = '$cpf', endereco = '$endereco', nivel = '$nivel' WHERE id = '$id'";
        
        if ($conn->query($sql) === TRUE) {
            $mensagem = "Aluno atualizado com sucesso!";
            $tipo_mensagem = "success";
        } else {
            $mensagem = "Erro: " . $conn->error;
            $tipo_mensagem = "danger";
        }
    }
}

//MOSTRA OS USUARIOS NA LISTA
$sql_usuarios = "SELECT * FROM usuarios ORDER BY id DESC";
$result_usuarios = $conn->query($sql_usuarios);
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Star Gym - Gerenciamento de Alunos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #000000;
      --secondary: #dc2626;
      --accent: #b91c1c;
      --dark-red: #7f1d1d;
      --success: #16a34a;
      --warning: #d97706;
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
    }
    
    .navbar { 
      background: linear-gradient(135deg, var(--primary) 0%, var(--gray-900) 100%);
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      border-bottom: 3px solid var(--secondary);
    }
    
    .navbar-brand {
      font-weight: 800;
      font-size: 1.6rem;
      color: white;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
  
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      margin-bottom: 24px;
      transition: transform 0.3s, box-shadow 0.3s;
      background-color: var(--card-bg);
      border-left: 4px solid var(--secondary);
    }
    
    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .card-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--gray-800) 100%);
      border-bottom: 2px solid var(--secondary);
      font-weight: 700;
      padding: 18px 20px;
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
      background: linear-gradient(135deg, var(--accent) 0%, var(--dark-red) 100%);
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
    
    .table {
      color: var(--gray-800);
    }
    
    .table th {
      background: linear-gradient(135deg, var(--primary) 0%, var(--gray-800) 100%);
      color: white;
      border: none;
      padding: 16px 15px;
      font-weight: 700;
      font-size: 0.9rem;
      border-bottom: 2px solid var(--secondary);
    }
    
    .table td {
      vertical-align: middle;
      border-color: var(--gray-200);
      padding: 14px 15px;
      background-color: white;
    }
    
    .table tbody tr {
      transition: all 0.2s;
      border-left: 3px solid transparent;
    }
    
    .table tbody tr:hover {
      background-color: rgba(220, 38, 38, 0.05);
      border-left: 3px solid var(--secondary);
      transform: translateX(2px);
    }
    
    footer { 
      background: linear-gradient(135deg, var(--primary) 0%, var(--gray-900) 100%);
      padding: 25px; 
      text-align: center; 
      margin-top: 60px;
      color: white;
      border-top: 3px solid var(--secondary);
    }
    
    .form-control {
      border-radius: 8px;
      padding: 12px 16px;
      border: 2px solid var(--gray-300);
      transition: all 0.3s;
      background-color: white;
    }
    
    .form-control:focus {
      border-color: var(--secondary);
      box-shadow: 0 0 0 0.25rem rgba(220, 38, 38, 0.15);
      background-color: white;
    }
    
    .form-label {
      color: var(--gray-800);
      font-weight: 600;
      margin-bottom: 10px;
      font-size: 0.95rem;
    }
    
    .badge {
      padding: 8px 14px;
      border-radius: 6px;
      font-weight: 600;
      font-size: 0.8rem;
    }
    
    .action-buttons .btn {
      margin-right: 8px;
      border-radius: 6px;
      font-size: 0.85rem;
      padding: 8px 14px;
    }
    
    .page-title {
      color: var(--primary);
      font-weight: 800;
      margin-bottom: 30px;
      font-size: 2rem;
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
    
    .badge-admin {
      background: linear-gradient(135deg, var(--warning) 0%, #b45309 100%);
      color: white;
    }
    
    .badge-usuario {
      background: linear-gradient(135deg, var(--gray-500) 0%, var(--gray-600) 100%);
      color: white;
    }
    
    .badge-id {
      background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
      color: white;
      box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
    }
    
    .alert {
      border-radius: 8px;
      border: none;
      font-weight: 600;
      border-left: 4px solid;
    }
    
    .alert-success {
      background-color: rgba(22, 163, 74, 0.1);
      color: var(--success);
      border-left-color: var(--success);
    }
    
    .alert-danger {
      background-color: rgba(220, 38, 38, 0.1);
      color: var(--secondary);
      border-left-color: var(--secondary);
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
    .modal-content {
      border: none;
      border-radius: 12px;
      box-shadow: 0 15px 40px rgba(0,0,0,0.2);
      border: 2px solid var(--gray-200);
    }

    .modal-header {
      background: linear-gradient(135deg, var(--primary) 0%, var(--gray-800) 100%);
      border-bottom: 3px solid var(--secondary);
      color: white;
      border-radius: 10px 10px 0 0;
      padding: 20px 25px;
    }

    .modal-title {
      font-weight: 700;
      font-size: 1.3rem;
    }

    .modal-body {
      padding: 25px;
      background-color: var(--gray-100);
    }

    .modal-footer {
      border-top: 2px solid var(--gray-300);
      padding: 20px 25px;
      border-radius: 0 0 10px 10px;
      background-color: white;
    }

    .edit-btn {
      cursor: pointer;
    }
    
    .table-responsive {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    
    .empty-state {
      padding: 50px 20px;
      text-align: center;
      color: var(--gray-500);
      background-color: white;
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
    
    .text-primary-custom {
      color: var(--primary);
    }
    
    .text-secondary-custom {
      color: var(--secondary);
    }
    
    .stats-badge {
      background: linear-gradient(135deg, var(--primary) 0%, var(--gray-700) 100%);
      color: white;
      border: 2px solid var(--secondary);
    }
    
    .form-section {
      background: linear-gradient(135deg, #ffffff 0%, var(--gray-100) 100%);
      border-radius: 10px;
      padding: 5px 20px 20px 20px;
      margin-bottom: 10px;
      border: 1px solid var(--gray-200);
    }
    
    .accent-border {
      border-left: 4px solid var(--secondary);
    }
    
    .card-body {
      padding: 25px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <div class="navbar-content">
      <a class="navbar-brand">STAR GYM</a>
      <div class="navbar-right">
        <div class="admin-badge">
          <i class="fas fa-shield-alt me-1"></i> MODO ADMIN
        </div>
        <a href="index.php" class="btn btn-home">
          <i class="fas fa-home me-1"></i> Página Inicial
        </a>
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
    <i class="fas fa-users me-3"></i>
    Gerenciamento de Alunos
  </h1>
  
  <?php if (!$is_admin): ?>
  <!-- FORMULÁRIO DO CADASTRO-->
  <div class="card">
    <div class="card-header">
      <i class="fas fa-user-plus me-2"></i>
      Cadastrar Novo Aluno
    </div>
    <div class="card-body">
      <form method="post" class="row g-3">
        <input type="hidden" name="action" value="cadastrar">
        
        <div class="col-md-6">
          <label class="form-label">Nome Completo</label>
          <input type="text" name="nome" class="form-control" placeholder="Digite o nome completo" required>
        </div>
        
        <div class="col-md-6">
          <label class="form-label">E-mail</label>
          <input type="email" name="email" class="form-control" placeholder="Digite o e-mail" required>
        </div>
        
        <div class="col-md-6">
          <label class="form-label">CPF</label>
          <input type="text" name="cpf" class="form-control" placeholder="000.000.000-00" required>
        </div>
        
        <div class="col-md-6">
          <label class="form-label">Tipo de Usuário</label>
          <select name="nivel" class="form-control" required>
            <option value="usuario">Aluno</option>
            <option value="admin">Instrutor</option>
          </select>
        </div>
        
        <div class="col-12">
          <label class="form-label">Endereço Completo</label>
          <textarea name="endereco" class="form-control" rows="3" placeholder="Digite o endereço completo" required></textarea>
        </div>
        
        <div class="col-12">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-user-plus me-2"></i>
            Cadastrar Aluno
          </button>
        </div>
      </form>
    </div>
  </div>
  <?php else: ?>

  <?php endif; ?>
  
  <!-- LISTA DOS USER-->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div>
        <i class="fas fa-list me-2"></i>Alunos Cadastrados
      </div>
      <span class="badge stats-badge"><?= $result_usuarios->num_rows ?> registros</span>
    </div>
    <div class="card-body p-0">
      <?php if ($result_usuarios->num_rows > 0): ?>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>CPF</th>
                <th>Endereço</th>
                <th>Tipo</th>
                <th class="text-center">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php while($usuario = $result_usuarios->fetch_assoc()): ?>
                <tr>
                  <td><span class="badge badge-id">#<?= $usuario['id'] ?></span></td>
                  <td class="fw-medium"><?= $usuario['nome'] ?></td>
                  <td><?= $usuario['email'] ?></td>
                  <td><?= $usuario['cpf'] ?></td>
                  <td><small class="text-muted"><?= $usuario['endereco'] ?></small></td>
                  <td>
                    <span class="badge <?= $usuario['nivel'] == 'admin' ? 'badge-admin' : 'badge-usuario' ?>">
                      <i class="fas fa-<?= $usuario['nivel'] == 'admin' ? 'shield-alt' : 'user' ?> me-1"></i>
                      <?= $usuario['nivel'] == 'admin' ? 'Instrutor' : 'Aluno' ?>
                    </span>
                  </td>
                  <td class="text-center action-buttons">
                    <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#editModal" 
                            data-id="<?= $usuario['id'] ?>"
                            data-nome="<?= htmlspecialchars($usuario['nome']) ?>"
                            data-email="<?= htmlspecialchars($usuario['email']) ?>"
                            data-cpf="<?= htmlspecialchars($usuario['cpf']) ?>"
                            data-endereco="<?= htmlspecialchars($usuario['endereco']) ?>"
                            data-nivel="<?= $usuario['nivel'] ?>">
                      <i class="fas fa-edit me-1"></i> Editar
                    </button>
                    <a href="gerenciar_usuarios.php?excluir=1&id=<?= $usuario['id'] ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Tem certeza que deseja excluir este aluno?')">
                      <i class="fas fa-trash me-1"></i> Excluir
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="empty-state">
          <i class="fas fa-users"></i>
          <h5>Nenhum aluno cadastrado</h5>
          <p class="text-muted">Não há registros de alunos no sistema.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- MODAL DA EDIT -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">
          <i class="fas fa-edit me-2"></i>Editar Aluno
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post">
        <div class="modal-body">
          <input type="hidden" name="action" value="editar">
          <input type="hidden" name="id" id="edit_id">
          
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nome Completo</label>
              <input type="text" name="nome" id="edit_nome" class="form-control" required>
            </div>
            
            <div class="col-md-6">
              <label class="form-label">E-mail</label>
              <input type="email" name="email" id="edit_email" class="form-control" required>
            </div>
            
            <div class="col-md-6">
              <label class="form-label">CPF</label>
              <input type="text" name="cpf" id="edit_cpf" class="form-control" required>
            </div>
            
            <div class="col-md-6">
              <label class="form-label">Tipo de Usuário</label>
              <select name="nivel" id="edit_nivel" class="form-control" required>
                <option value="usuario">Aluno</option>
                <option value="admin">Instrutor</option>
              </select>
            </div>
            
            <div class="col-12">
              <label class="form-label">Endereço Completo</label>
              <textarea name="endereco" id="edit_endereco" class="form-control" rows="3" required></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-2"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Salvar Alterações
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<footer>
  <p class="fw-bold mb-0" style="font-size: 1.3rem;">STAR GYM</p>
  <small class="text-light">Sistema desenvolvido por Cauã Mauricio Ronchi e Pedro Renato Giassi</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // ESSA PARTE SERVE PRA ABRI O MODAL COM OS DADOS ANTIGOS
  document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');
    const editModal = document.getElementById('editModal');
    
    editButtons.forEach(button => {
      button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const nome = this.getAttribute('data-nome');
        const email = this.getAttribute('data-email');
        const cpf = this.getAttribute('data-cpf');
        const endereco = this.getAttribute('data-endereco');
        const nivel = this.getAttribute('data-nivel');
        
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_nome').value = nome;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_cpf').value = cpf;
        document.getElementById('edit_endereco').value = endereco;
        document.getElementById('edit_nivel').value = nivel;
      });
    });
  });
</script>
</body>
</html>