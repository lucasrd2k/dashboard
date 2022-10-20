      <?php
      include "header.php";

      ?>
      </header>

      <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
          <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Comentários
          </h2>
          <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
              <table class="w-full whitespace-no-wrap">
                <thead>
                  <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Autor</th>
                    <th class="px-4 py-3">Comentário</th>
                    <th class="px-4 py-3">Aula</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Responder</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <?php
                    $sql = "SELECT c.id, c.comentario, cl.nome, v.titulo, cs.titulo as curso, 
                    (SELECT COUNT(id) FROM resposta r WHERE r.comentario = c.id) as status FROM comentario c JOIN cliente cl ON c.cliente = cl.id JOIN video v ON c.video = v.id JOIN curso cs ON v.curso = cs.id;";
                    $result = mysqli_query($conn, $sql);
                    while ($linha = mysqli_fetch_array($result)) {
                      $id = $linha['id'];
                      $titulo = $linha['titulo'];
                      $comentario = $linha['comentario'];
                      $nome = $linha['nome'];
                      $curso = $linha['curso'];
                      $status = $linha['status'];
                    ?>
                  <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">
                      <div class="flex items-center text-sm">
                        <!-- Avatar with inset shadow -->
                        <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                          <img class="object-cover w-full h-full rounded-full" src="https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ" alt="" loading="lazy" />
                          <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                        </div>
                        <div>
                          <p class="font-semibold"><?php echo $nome; ?></p>
                          <p class="text-xs text-gray-600 dark:text-gray-400">
                            <?php echo $curso; ?>
                          </p>
                        </div>
                      </div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      <?php echo $comentario;?>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      <?php echo $titulo;?>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      <?php 
                        if($status > 0){
                          echo "Respondido";
                        }
                        else{
                          echo "Não Respondido";

                        }
                      ?>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      <a href="responder.php?id=<?php echo $id; ?>"><span class="material-symbols-outlined" ">edit</span></a>
                    </td>
                  </tr>
                <?php
                    }

                ?>

                </tbody>
              </table>
            </div>
            <div class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
              <span class="col-span-2"></span>
            </div>
          </div>
        </div>
        </div>
        </div>
        </div>
      </main>
      </div>
      </div>
      </body>

      </html>