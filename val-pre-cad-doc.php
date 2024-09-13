<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Pré-Cadastro Docente - SiVAC</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f0f4f8;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #333;
        }

        .header {
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
            z-index: 1000;
        }

        .logo {
            width: 60px;
        }

        .title {
            font-size: 24px;
            color: #00796b;
            margin-left: 20px;
        }

        .container {
            display: flex;
            flex: 1;
            flex-direction: column;
            margin: 20px;
        }

        .form-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-container h1 {
            color: #00796b;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #333;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            background-color: #00796b;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #004d40;
        }

        .form-container .optional {
            font-size: 14px;
            color: #666;
        }

        .form-container .error {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 15px;
        }

        .radio-group {
            margin-bottom: 20px;
        }

        .radio-group label {
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="index.php"><img src="img/Runa.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
        <div class="form-container">
            <h1>Validar Pré-Cadastro Docente</h1>
            <form id="validarPreCadastroForm" onsubmit="return validateForm()">
                <div class="radio-group">
                    <label><input type="radio" name="validationMethod" value="matricula" id="matriculaMethod" required> Número de Matrícula e CPF</label>
                    <label><input type="radio" name="validationMethod" value="email" id="emailMethod"> Email e CPF</label>
                </div>

                <div id="matriculaFields" class="validation-fields">
                    <label for="matricula">Número de Matrícula:</label>
                    <input type="number" id="matricula" name="matricula" placeholder="Número de Matrícula">
                    <span class="error" id="matriculaError"></span>

                    <label for="cpf">Número de CPF:</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Número de CPF" required>
                    <span class="error" id="cpfError"></span>
                </div>

                <div id="emailFields" class="validation-fields" style="display: none;">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email">
                    <span class="error" id="emailError"></span>

                    <label for="cpf">Número de CPF:</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Número de CPF" required>
                    <span class="error" id="cpfErrorEmail"></span>
                </div>

                <button type="submit">Validar</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('matriculaMethod').addEventListener('change', function() {
            document.getElementById('matriculaFields').style.display = 'block';
            document.getElementById('emailFields').style.display = 'none';
        });

        document.getElementById('emailMethod').addEventListener('change', function() {
            document.getElementById('matriculaFields').style.display = 'none';
            document.getElementById('emailFields').style.display = 'block';
        });

        function validateForm() {
            let valid = true;

            // Clear previous errors
            document.querySelectorAll('.error').forEach(e => e.textContent = '');

            // Check validation method
            const validationMethod = document.querySelector('input[name="validationMethod"]:checked');
            if (!validationMethod) {
                alert('Por favor, selecione um método de validação.');
                valid = false;
            } else if (validationMethod.value === 'matricula') {
                // Validation for Número de Matrícula and CPF
                const matricula = document.getElementById('matricula').value.trim();
                const cpf = document.getElementById('cpf').value.trim();

                if (matricula === '') {
                    document.getElementById('matriculaError').textContent = 'O número de matrícula é obrigatório.';
                    valid = false;
                }

                if (cpf === '') {
                    document.getElementById('cpfError').textContent = 'O número de CPF é obrigatório.';
                    valid = false;
                } else if (!validateCPF(cpf)) {
                    document.getElementById('cpfError').textContent = 'O CPF fornecido não é válido.';
                    valid = false;
                }

            } else if (validationMethod.value === 'email') {
                // Validation for Email and CPF
                const email = document.getElementById('email').value.trim();
                const cpfEmail = document.getElementById('cpf').value.trim();

                if (email === '') {
                    document.getElementById('emailError').textContent = 'O email é obrigatório.';
                    valid = false;
                } else if (!validateEmail(email)) {
                    document.getElementById('emailError').textContent = 'O email fornecido não é válido.';
                    valid = false;
                }

                if (cpfEmail === '') {
                    document.getElementById('cpfErrorEmail').textContent = 'O número de CPF é obrigatório.';
                    valid = false;
                } else if (!validateCPF(cpfEmail)) {
                    document.getElementById('cpfErrorEmail').textContent = 'O CPF fornecido não é válido.';
                    valid = false;
                }
            }

            return valid;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validateCPF(cpf) {
            // Basic CPF validation (length and number format)
            const re = /^\d{11}$/;
            return re.test(cpf);
        }
    </script>
</body>
</html>
