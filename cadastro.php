<?php
 session_start();
 require 'conexao.php';
  
if($_SERVER['REQUEST_METHOD']=='POST'){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];
    $senha = md5($_POST['senha']);
    $nivel = 'usuario'; 
  

    $sql = "INSERT INTO usuarios (nome, email, cpf, endereco, senha, nivel)
    VALUES ('$nome', '$email', '$cpf', '$endereco', '$senha', '$nivel')";
    if($conn->query($sql)){
        $_SESSION['sucesso'] = "Matrícula realizada com sucesso!";
        header("Location: index.php#matricula");
        exit;
    } else {
        $_SESSION['erro'] = "Erro ao cadastrar: ". $conn->error;
        header("Location: index.php#matricula");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário - Academia Star Gym</title>
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
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, var(--gray-900) 0%, var(--dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--light);
            overflow-x: hidden;
        }
        
        .register-container {
            display: flex;
            width: 100%;
            max-width: 1100px;
            min-height: 700px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(220, 38, 38, 0.2);
        }
        
        .register-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--gray-800) 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
            border-right: 3px solid var(--secondary);
        }
        
        .register-left::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(220, 38, 38, 0.05)"/></svg>');
            background-size: cover;
        }
        
        .register-right {
            flex: 1.2;
            background: var(--light);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 40px;
            z-index: 1;
            position: relative;
        }
        
        .logo h1 {
            font-size: 2.8rem;
            font-weight: 900;
            color: white;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
    
        .logo p {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--secondary);
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        
        .welcome-text {
            margin-bottom: 30px;
            z-index: 1;
            position: relative;
        }
        
        .welcome-text h2 {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: white;
            font-weight: 700;
        }
        
        .welcome-text p {
            font-size: 1rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .benefits {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 30px;
            z-index: 1;
            position: relative;
        }
        
        .benefit {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.05);
        }
        
        .benefit:hover {
            background: rgba(220, 38, 38, 0.1);
            transform: translateX(5px);
        }
        
        .benefit i {
            font-size: 1.5rem;
            color: var(--secondary);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(220, 38, 38, 0.1);
            border-radius: 50%;
        }
        
        .benefit span {
            color: white;
            font-weight: 500;
        }
        
        .register-form {
            width: 100%;
        }
        
        .form-title {
            text-align: center;
            margin-bottom: 30px;
            color: var(--dark);
        }
        
        .form-title h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--primary);
        }
        
        .form-title p {
            color: var(--gray-600);
            font-size: 0.95rem;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-control {
            height: 50px;
            border-radius: 10px;
            border: 2px solid var(--gray-300);
            padding: 10px 15px 10px 45px;
            font-size: 1rem;
            transition: all 0.3s;
            background: white;
        }
        
        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.15);
        }
        
        .form-select {
            height: 50px;
            border-radius: 10px;
            border: 2px solid var(--gray-300);
            padding: 10px 15px 10px 45px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-select:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.15);
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            font-size: 1.2rem;
        }
        
        .select-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-500);
            font-size: 1.2rem;
            z-index: 5;
        }
        
        .btn-register {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--accent) 100%);
            border: none;
            color: white;
            height: 50px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(220, 38, 38, 0.4);
            background: linear-gradient(135deg, var(--accent) 0%, #7f1d1d 100%);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 25px;
            color: var(--gray-600);
            font-size: 0.9rem;
        }
        
        .form-footer a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .form-footer a:hover {
            text-decoration: underline;
            color: var(--accent);
        }
        
        .alert {
            border-radius: 10px;
            padding: 12px 15px;
            margin-top: 20px;
            border: none;
            font-weight: 500;
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            color: #1d4ed8;
            border-left: 4px solid #3b82f6;
        }

        .alert-danger {
            background: rgba(220, 38, 38, 0.1);
            color: var(--secondary);
            border-left: 4px solid var(--secondary);
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        
        .col-md-6 {
            flex: 0 0 50%;
            padding: 0 10px;
        }
        
        @media (max-width: 992px) {
            .register-container {
                flex-direction: column;
                max-width: 600px;
            }
            
            .register-left, .register-right {
                padding: 30px;
            }
            
            .logo h1 {
                font-size: 2.2rem;
            }
            
            .col-md-6 {
                flex: 0 0 100%;
            }
            
            .register-left {
                border-right: none;
                border-bottom: 3px solid var(--secondary);
            }
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translate(0, 0px); }
            50% { transform: translate(0, -10px); }
            100% { transform: translate(0, 0px); }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .nav-back {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 10;
        }
        
        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-3px);
        }
        
        .stats-counter {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
            z-index: 1;
            position: relative;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--secondary);
            display: block;
        }
        
        .stat-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .password-strength {
            height: 4px;
            background: var(--gray-300);
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s;
            border-radius: 2px;
        }
        
        .strength-weak { background: var(--secondary); width: 33%; }
        .strength-medium { background: var(--warning); width: 66%; }
        .strength-strong { background: var(--success); width: 100%; }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-left">
            <div class="nav-back">
                <a href="index.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            
            <div class="logo">
                <h1>STAR GYM</h1>
                <p>FORÇA & RESULTADO</p>
            </div>
            
            <div class="welcome-text">
                <h2>Junte-se à nossa comunidade</h2>
                <p>Crie sua conta e comece sua jornada de transformação hoje mesmo. Tenha acesso a todos os benefícios da nossa academia.</p>
            </div>
            
            <div class="benefits">
                <div class="benefit">
                    <i class="fas fa-dumbbell"></i>
                    <span>Equipamentos de última geração</span>
                </div>
                <div class="benefit">
                    <i class="fas fa-user-friends"></i>
                    <span>Acompanhamento personalizado</span>
                </div>
                <div class="benefit">
                    <i class="fas fa-apple-alt"></i>
                    <span>Planos nutricionais</span>
                </div>
                <div class="benefit">
                    <i class="fas fa-chart-line"></i>
                    <span>Acompanhamento de evolução</span>
                </div>
            </div>
        </div>

        <div class="register-right">
            <div class="register-form">
                <div class="form-title">
                    <h2>CRIAR CONTA</h2>
                    <p>Preencha os dados abaixo para se cadastrar</p>
                </div>
                
                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="nome" class="form-control" placeholder="Nome Completo" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="fas fa-envelope input-icon"></i>
                                <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="fas fa-id-card input-icon"></i>
                                <input type="text" name="cpf" class="form-control" placeholder="CPF" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                <input type="text" name="endereco" class="form-control" placeholder="Endereço" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" name="senha" class="form-control" placeholder="Senha" required id="senha">
                                <div class="password-strength">
                                    <div class="password-strength-bar" id="password-strength-bar"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <i class="fas fa-lock input-icon"></i>
                                <input type="password" name="confirmar_senha" class="form-control" placeholder="Confirmar Senha" required id="confirmar_senha">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-register pulse">CADASTRAR</button>
                    
                    <?php if(isset($bençapai)): ?>
                        <div class="alert alert-info mt-3">
                            <?=$bençapai;?>
                        </div>
                    <?php endif; ?>
                </form>
                
                <div class="form-footer">
                    <p>Já tem uma conta? <a href="index.php">Faça login aqui</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const title = document.querySelector('.logo h1');
            const text = "STAR GYM";
            title.textContent = '';
            
            let i = 0;
            const typeWriter = () => {
                if (i < text.length) {
                    title.textContent += text.charAt(i);
                    i++;
                    setTimeout(typeWriter, 100);
                } 
            };
            
            setTimeout(typeWriter, 500);
            

            // Validação de senhas
            const senha = document.getElementById('senha');
            const confirmarSenha = document.getElementById('confirmar_senha');
            const strengthBar = document.getElementById('password-strength-bar');
            
            function validarSenhas() {
                if (senha.value !== confirmarSenha.value && confirmarSenha.value !== '') {
                    confirmarSenha.style.borderColor = 'var(--secondary)';
                } else {
                    confirmarSenha.style.borderColor = 'var(--success)';
                }
            }
            
            function checkPasswordStrength() {
                const password = senha.value;
                let strength = 0;
                
                if (password.length >= 8) strength++;
                if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
                if (password.match(/\d/)) strength++;
                if (password.match(/[^a-zA-Z\d]/)) strength++;
                
                strengthBar.className = 'password-strength-bar';
                if (password.length > 0) {
                    if (strength <= 2) {
                        strengthBar.classList.add('strength-weak');
                    } else if (strength === 3) {
                        strengthBar.classList.add('strength-medium');
                    } else {
                        strengthBar.classList.add('strength-strong');
                    }
                }
            }
            
            senha.addEventListener('input', function() {
                validarSenhas();
                checkPasswordStrength();
            });
            
            confirmarSenha.addEventListener('input', validarSenhas);
        });
    </script>
</body>
</html>