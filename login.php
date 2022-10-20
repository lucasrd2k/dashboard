<style>
    *,
*::before,
*::after {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

body {
  height: 100vh;
  display: grid;
  place-items: center;
  font-family: sans-serif;
  background-image: linear-gradient(to right top, #d16ba5, #c777b9, #ba83ca, #aa8fd8, #9a9ae1, #8aa7ec, #79b3f4, #69bff8, #52cffe, #41dfff, #46eefa, #5ffbf1);
  color: rgb(225,225,255);
}

.container {
  display: flex;
  flex-direction: column;
  padding: 3rem 5rem;
  border-radius: 2em;
  background-color: rgba(0,0,0,0.75);
  width: 30rem;
}

h1 {
  text-align: center;
  margin: 1rem;
  margin-bottom: 5rem;
  text-transform: uppercase;
  letter-spacing: 2px;
}

label span{
  display: inline-block;
  font-size: 1.25rem;
  letter-spacing: 2px;
  position: relative;
  bottom: 4rem;
  transition: transform 200ms ease-in-out;
}

input {
  position: relative;
  margin-bottom: 2rem;
  padding: 0.5rem 0;
  background-color: transparent;
  outline: none;
  border: unset;
  border-bottom: 1.5px solid white;
  font-size: 1.25rem;
  letter-spacing: 1.5px;
  color: white;
  z-index: 1;
}

button {
  display: inline-block;
  margin: 1rem 0;
  padding: 0.75rem;
  cursor: pointer;
  outline: none;
  border: none;
  border-radius: 0.25em;
  font-size: 1rem;
  letter-spacing: 1.5px;
  font-weight: 500;
  transition: all 100ms ease-in-out;
  background-color: rgb(225,225,255);
}

button:hover {
  background-color: rgb(235,235,235);
}

a {
  color: rgb(235, 235, 235);
}

a:hover {
  color: rgb(215, 215, 215);
}

p {
  text-align: center;
}

input:focus, input:valid {
  border-bottom: 2px solid white;
}

input:focus + label span, input:valid + label span {
  color: white;
  transform: translateY(-2rem);
}
</style>
<form action="" method="POST">

<div class="container">
        <h1>Login</h1>
        <input name="email" id="email" type="text" required>
        <label for="email"><span>Email</span></label>
        <input name="senha" type="password" id="password" required>
        <label for="password"><span>Senha</span></label>
        <button type="submit">Entrar</button>
        <p>Não tem uma conta? Contate o administrador.</p>
        <p>  
          <?php
            include_once "conexao.php";
            
            if (isset($_POST['email'], $_POST['senha'])){
                $email = $_POST['email'];
                $senha = md5($_POST['senha']);
                $sql = "SELECT * FROM cliente WHERE email = \"$email\" and senha = \"$senha\"  and nivel = 2";
                //echo $sql;
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result)>0){
                  $linha = mysqli_fetch_array($result);
                  session_start();
                  $_SESSION['nome'] = $linha['nome'];
                  $_SESSION['id'] = $linha['id'];
                  $_SESSION['admin'] = true;
                  echo "<script>window.location.replace('dashboard.php');</script>";
                }
              }
 
          ?>
        </p>  
      </div>
    </form>

<script>
    const labels = document.querySelectorAll("label");

labels.forEach(label => {
  // console.log(label.innerText);
  label.innerHTML = label.innerText
    .split('')
    .map((letter, index) => {
    return `<span style="transition-delay: ${index*30}ms">${letter}</span>`;})
    .join('');
  console.log(label.innerHTML);
});
</script>