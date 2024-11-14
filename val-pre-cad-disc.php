<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Pré-Cadastro Discente - SiVAC</title>
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
            flex-direction: column;
            flex: 1;
            margin: 20px;
            
            align-items: center;
        }

        .form-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            display: none; /* Initially hidden */
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

        .form-container select {
            width: 200px; /* Ajuste do tamanho da caixa de seleção */
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #333;
            cursor: pointer;
        }
        
        select{
            width: 200px;
            text-size-adjust: 90px;
            font-size: 17px;
            display: flex;
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="index.php"><img src="img/Runa.png" alt="Logo Runas" class="logo"></a>
        <div class="title">Sistema de Registro Unificado de Normativas de Atividades Suplementares - RUNAS</div>
    </header>

    <div class="container">
       
        <label for="validationSelect">Escolha o método de validação:</label> 
        <div class="negocio">
        <select id="validationSelect">
            <option value="">Selecione um método</option>
            <option value="matricula">Número de Matrícula e CPF</option>
            <option value="email">Email e CPF</option>
        </select>
    </div>
        <div id="formContainer" class="form-container">
            <h1>Validar Pré-Cadastro Discente</h1>
            <form id="validarPreCadastroForm" onsubmit="return validateForm()">
                <div id="matriculaFields">
                    <label for="matricula">Número de Matrícula:</label>
                    <input type="number" id="matricula" name="matricula" placeholder="Número de Matrícula">
                    <span class="error" id="matriculaError"></span>

                    <label for="cpf">Número de CPF:</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Número de CPF" required>
                    <span class="error" id="cpfError"></span>
                </div>

                <div id="emailFields" style="display: none;">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Email">
                    <span class="error" id="emailError"></span>

                    <label for="cpfEmail">Número de CPF:</label>
                    <input type="text" id="cpfEmail" name="cpfEmail" placeholder="Número de CPF" required>
                    <span class="error" id="cpfErrorEmail"></span>
                </div>

                <button type="submit">Validar</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('validationSelect').addEventListener('change', function() {
            const formContainer = document.getElementById('formContainer');
            const selectedValue = this.value;

            if (selectedValue === 'matricula') {
                document.getElementById('matriculaFields').style.display = 'block';
                document.getElementById('emailFields').style.display = 'none';
                formContainer.style.display = 'block';
            } else if (selectedValue === 'email') {
                document.getElementById('matriculaFields').style.display = 'none';
                document.getElementById('emailFields').style.display = 'block';
                formContainer.style.display = 'block';
            } else {
                formContainer.style.display = 'none';
            }
        });

        function validateForm() {
            let valid = true;

            // Clear previous errors
            document.querySelectorAll('.error').forEach(e => e.textContent = '');

            // Check validation method
            const validationMethod = document.getElementById('validationSelect').value;
            if (!validationMethod) {
                alert('Por favor, selecione um método de validação.');
                valid = false;
            } else if (validationMethod === 'matricula') {
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

            } else if (validationMethod === 'email') {
                // Validation for Email and CPF
                const email = document.getElementById('email').value.trim();
                const cpfEmail = document.getElementById('cpfEmail').value.trim();

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
