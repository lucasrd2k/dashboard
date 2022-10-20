        <?php
        $m = false;

        include "header.php";

        $texto = "";
        $categoria = -1;
        if (isset($_GET['id'])) {
          $id = $_GET['id'];
          $sql = "SELECT * FROM carta WHERE id = $id;";
          $result = mysqli_query($conn, $sql);
          $linha = mysqli_fetch_array($result);
          $texto = $linha['texto'];
          $categoria = $linha['categoria'];

          $sql = "UPDATE carta SET ";
          $edit = false;

          if (isset($_POST['texto'])) {
            $texto = $_POST['texto'];
            $sql .= "texto = '$texto'";
            $edit = true;
          }
          if (isset($_POST['categoria'])) {
            $categoria = $_POST['categoria'];
            if ($edit) {
              $sql .= ",";
            }
            $sql .= "categoria = '$categoria'";
            $edit = true;
          }

          if ($edit) {
            $sql .= " WHERE id = $id;";
            echo $sql;
            if (mysqli_query($conn, $sql)) {
              //echo "<script>window.location.replace('cartas.php');</script>";
            } else {
              $msg = "Erro ao editar carta.";
              $m = true;
            }
          }
        }
        else if (isset($_POST['texto'], $_POST['categoria'])) {

          $texto = $_POST['texto'];
          $categoria = $_POST['categoria'];

          $sql = "INSERT INTO carta (texto, categoria) VALUES ('$texto', $categoria);";
          //echo $sql;
          if (mysqli_query($conn, $sql)) {
            echo "<script>window.location.replace('cartas.php');</script>";
            $msg = "Categoria cadastrada com sucesso.";
            $m = true;
          } else {
            $msg = "Erro ao cadastrar categoria.";
            $m = true;
          }
        }


        ?>
        </header>
        <main class="h-full overflow-y-auto">
          <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <?php echo isset($_GET['id']) ? "Editar" : "Cadastrar"?> Carta
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
                <label class="block mt-2 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                    Selecione a categoria
                  </span>
                  <select name="categoria" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                    <?php
                      $sql = "SELECT * FROM categoria";
                      $result = mysqli_query($conn, $sql);
                      while ($linha = mysqli_fetch_array($result)) {
                        $idc = $linha['id'];
                        $nome = $linha['nome'];
                        $txt = $idc == $categoria ? "selected" : "";
                        echo "<option value=\"$idc\" $txt>$nome</option>";
                      }
                    ?>
                  </select>
                </label>
                <label class="block mt-4 text-sm">
                  <span class="text-gray-700 dark:text-gray-400">
                    Texto da Carta
                  </span>
                  <input name="texto" value="<?php echo $texto; ?>" type="text" class="block w-full mt-1 text-sm border-light-600 dark:text-gray-300 dark:bg-gray-700 focus: focus:outline-none form-input" <?php echo isset($_GET['id']) ? "" : "required"; ?> />
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