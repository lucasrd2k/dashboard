        <?php
        $m = false;

        include "header.php";

        $nome = "";
        $descricao = "";
        if (isset($_GET['id'])) {
          $id = $_GET['id'];
          $sql = "SELECT * FROM categoria WHERE id = $id;";
          $result = mysqli_query($conn, $sql);
          $linha = mysqli_fetch_array($result);
          $nome = $linha['nome'];
          $descricao = $linha['descricao'];
          $paga = $linha['paga'];
          $p = $paga ? "Categoria Paga" : "Categoria Gratuíta";


          $sql = "UPDATE categoria SET ";
          $edit = false;
          if (isset($_POST['nome'])) {
            $nome = $_POST['nome'];
            $sql .= "nome = '$nome'";
            $edit = true;
          }
          if (isset($_POST['descricao'])) {
            $descricao = $_POST['descricao'];
            if ($edit) {
              $sql .= ",";
            }
            $sql .= "descricao = '$descricao'";
            $edit = true;
          }
          if (isset($_POST['paga'])) {
            $paga = $_POST['paga'];
            if ($edit) {
              $sql .= ",";
            }
            $sql .= "paga = '$paga'";
            $edit = true;
          }
          if (empty($_FILES["fundo"]["name"]) === false) {
            $arquivo = $_FILES["fundo"];
            //diretorio dos arquivos
            $pasta_dir = "localhost/dashboard/arquivos/img/";
            // Faz o upload da imagem
            $arquivo_nome = $pasta_dir . time() . $arquivo["name"];
            //salva no banco
            move_uploaded_file($arquivo["tmp_name"], $arquivo_nome);

            if ($edit) {
              $sql .= ",";
            }
            $sql .= "arquivo = '$arquivo_nome'";

            $edit = true;
          }

          if ($edit) {
            $sql .= " WHERE id = $id;";
            echo $sql;
            if (mysqli_query($conn, $sql)){
              echo "<script>window.location.replace('categorias.php');</script>";
            }
            else{
              $msg = "Erro ao editar categoria.";
              $m = true;
            }
          }
        }
        else if (isset($_POST['nome'], $_POST['descricao'], $_POST['paga'])) {
          if (empty($_FILES["fundo"]["name"]) === false) {
            $arquivo = $_FILES["fundo"];
            //diretorio dos arquivos
            $pasta_dir = "localhost/dashboard/arquivos/img/";
            // Faz o upload da imagem
            $arquivo_nome = $pasta_dir . time() . $arquivo["name"];
            //salva no banco
            move_uploaded_file($arquivo["tmp_name"], $arquivo_nome);
            
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $paga = $_POST['paga'];
            $p = $paga ? "Categoria Paga" : "Categoria Gratuíta";

            
            
            $sql = "INSERT INTO categoria (nome, arquivo, paga, descricao) VALUES ('$nome', '$arquivo_nome', $paga, '$descricao')";
            
            if (mysqli_query($conn, $sql)){
              $msg = "Categoria cadastrada com sucesso.";
              $m = true;
              echo "<script>window.location.replace('categorias.php');</script>";

            }
            else{
              $msg = "Erro ao cadastrar categoria.";
              $m = true;
            }
              
          }
      }


        ?>
        </header>
        <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <?php echo isset($_GET['id']) ? "Editar" : "Cadastrar"?> Categoria
            </h2>
            <!-- Validation inputs -->
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
              <center>
                <?php
                echo $m ? $msg : "";
                ?>
              </center>
              <form action="" method="POST" enctype="multipart/form-data" style="width: 80%; margin-left:8%; margin-top: 2%">

                <!-- Invalid input -->
                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                    Nome da categoria
                  </span>
                  <input name="nome" value="<?php echo $nome; ?>" type="text" class="block w-full mt-1 text-sm border-light-600 dark:text-gray-300 dark:bg-gray-700 focus: focus:outline-none form-input" <?php echo isset($_GET['id']) ? "" : "required";?>/>
                </label>
                </label>
                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                    Descrição da categoria
                  </span>
                  <input name="descricao" value="<?php echo $descricao; ?>" type="text" class="block w-full mt-1 text-sm border-light-600 dark:text-gray-300 dark:bg-gray-700 focus: focus:outline-none form-input" <?php echo isset($_GET['id']) ? "" : "required";?>/>
                </label>
                <label class="block mt-2 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                    Selecione o tipo
                  </span>
                  <select name="paga" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <?php echo isset($_GET['id']) ? "<option value=\"$paga\">$p</option>" : ""; ?>
                    <option value="0">Categoria Gratuíta</option>
                    <option value="1">Categoria Paga</option>
                  </select>
                </label>
                <label class="block mt-2 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">Selecione o fundo <?php echo isset($_GET['id']) ? "<sub>Só envie em caso de alteração</sub>" : ""; ?></span>
                  <input name="fundo" type="file" class="block w-full mt-1 text-sm border-light-600 dark:text-gray-300 dark:bg-gray-700 focus: focus:outline-none form-input" <?php echo isset($_GET['id']) ? "" : "required";?> />
                </label><br>
                <button class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                  <span><?php echo isset($_GET['id']) ? "Editar" : "Cadastrar"?></span>
                  <svg class="w-4 h-4 ml-2 -mr-1" fill="currentColor" aria-hidden="true" viewBox="0 0 20 20">
                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" fill-rule="evenodd"></path>
                  </svg>
                </button>
              </form>
            </div>
          </div>
          </div>
        </main>
        </div>
        </div>
        </body>

        </html>