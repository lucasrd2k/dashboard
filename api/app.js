const express = require('express');
var md5 = require('md5');
const fs = require('fs');
const app = express();
const User = require('./models/User');
const Category = require('./models/Category');
const Card = require('./models/Card');
const Auth = require('./models/Auth');
const Fav = require('./models/Fav');
const Calendar = require('./models/Calendar');
const Book = require('./models/Book');



function encoder(cats) {
    cats.forEach(cat => {
        let File = fs.readFileSync(cat.arquivo, { encoding: "base64" });
        cat.arquivo = File;
    });

    return cats;
}

function encoder2(cats) {
    cats.forEach(cat => {
        let File = fs.readFileSync(cat.capa, { encoding: "base64" });
        cat.capa = File;
    });

    return cats;
}


async function isAuthorized(req, res, next) {

    const auth = req.headers.authorization;

    authorization = await Auth.findByPk(auth);
    console.log(authorization);
    if (authorization != null) {
        console.log("Passou na auth1");
        next();
    } else {
        res.status(401);
        res.send('Não logado');
    }
}

async function isAdmin(req, res, next) {
    if (authorization.nivel == 2) {
        console.log("Passou na auth2 - adm");
        next();
    } else {
        res.status(403);
        res.send('Não autorizado');
    }
}

async function isTheUser(req, res, next) {
    id = req.params.id;
    if (!id) {
        console.log("Pegou id pela body");
        id = req.body.cliente;
    }

    if (id && authorization.id == id) {
        console.log("Passou no IsTheUser");
        next();
    } else {
        res.status(401);
        res.send('Não permitido');
    }
}





app.use(express.json());

app.get("/", async(req, res) => {
    res.send("Página inicial - Celke");
});


// Cadastro

app.post("/favoritar", isAuthorized, isTheUser, async(req, res) => {
    req.body.id = "";
    fav = await Fav.create(req.body)
        .then(() => {
            return res.json({
                erro: false,
                mensagem: "Favorito adicionado com sucesso!"
            });
        }).catch(() => {
            return res.status(400).json({
                erro: true,
                mensagem: "Erro: Favorito não cadastrado!"
            });
        });
    console.log(fav);
});

app.post("/cadastrar", async(req, res) => {
    // console.log(req.body);
    req.body.senha = md5(req.body.senha);
    req.body.nivel = 0;
    await User.create(req.body)
        .then(() => {
            return res.json({
                erro: false,
                mensagem: "Usuário cadastrado com sucesso!"
            });
        }).catch(() => {
            return res.status(400).json({
                erro: true,
                mensagem: "Erro: Usuário não cadastrado com sucesso!"
            });
        });

    //res.send("Página cadastrar");
});
// Cadastro

app.post("/autenticar", async(req, res) => {
    // console.log(req.body);
    const Email = req.body.email;
    const Senha = md5(req.body.senha);
    const result = await User.findAll({
        where: {
            email: Email,
            senha: Senha
        }
    });

    if (result[0] != null) {

        const id = result[0].id;
        const nome = result[0].nome;
        const nivel = result[0].nivel;
        const r = Math.random() * (10000 - 1000) + 1000;

        const hash = md5(r + "" + id + nome + nivel + r);

        dest = await Auth.findAll({
            where: {
                id: id
            }
        });

        if (dest) {
            await Auth.destroy({
                where: {
                    id: id
                }
            });
        }
        await Auth.create({
                hash: hash,
                id: id,
                nome: nome,
                nivel: nivel
            })
            .then(() => {
                return res.json({
                    erro: false,
                    mensagem: "Sessão registrada com sucesso!",
                    hash: hash,
                    id: id
                });
            }).catch(() => {
                return res.status(400).json({
                    erro: true,
                    mensagem: "Erro: Sessão não cadastrada!"
                });
            });

        // const Id = result.id;
    } else {
        res.status(400).json({
            erro: true,
            mensagem: "Erro: Login ou senha incorretos!"
        });
    }

    //res.send("Página cadastrar");
});


// Listagem

app.get("/favoritos/:id/categoria/:idc", isAuthorized, isTheUser, async(req, res, next) => {
    const cliente = req.params.id;
    const categoria = req.params.idc;
    const favs = await Fav.findAll({
        where: {
            cliente: cliente
        }
    });
    ids = [];
    count = 0;
    favs.forEach(fav => {
        ids[count] = fav.carta;
        count++;
    });
    // const produto = await Produto.findByPk(resultadoCreate2.id, {include: Fabricante});

    const cards = await Card.findAll({
        where: {
            id: ids,
            categoria: categoria
        }
    });

    res.json(cards);
});

app.get("/favoritos/:id/categorias", isAuthorized, isTheUser, async(req, res, next) => {
    const cliente = req.params.id;
    const favs = await Fav.findAll({
        where: {
            cliente: cliente
        }
    });
    ids = [];
    count = 0;
    favs.forEach(fav => {
        ids[count] = fav.carta;
        count++;
    });

    const cats = await Card.findAll({
        where: {
            id: ids
        }
    });

    ids = [];
    count = 0;
    cats.forEach(cat => {
        ids[count] = cat.categoria;
        count++;
    });

    // const produto = await Produto.findByPk(resultadoCreate2.id, {include: Fabricante});

    const cards = await encoder(await Category.findAll({
        where: {
            id: ids
        }
    }));

    res.json(cards);
});

app.get('/clientes', isAuthorized, isAdmin, async(req, res, next) => {
    const users = await User.findAll();
    console.log(users);
    res.json(users);
});


app.get('/clientes/:id', isAuthorized, isAdmin, async(req, res, next) => {
    //console.log(req.body);
    const user = req.params.id;
    const users = await User.findAll({
        where: {
            id: user
        }
    });
    // console.log(users);
    res.json(users);
});


app.get('/calendario', isAuthorized, async(req, res, next) => {
    const cals = await Calendar.findAll();
    // console.log(cals);
    res.json(cals);
});

app.get('/materiais', isAuthorized, async(req, res, next) => {
    const cals = await Book.findAll({
        attributes: ['id', 'nome', 'capa']
    });
    const Cals = await encoder2(cals);
    res.json(Cals);
});

app.get('/materiais/:id', isAuthorized, async(req, res, next) => {
    const id = req.params.id;

    const cals = await Book.findAll({
        where: {
            id: id
        },
        attributes: ['id', 'nome', 'arquivo', 'capa']
    });
    var Cals = await encoder(cals);
    Cals = await encoder2(Cals);
    res.json(Cals);
});



app.get('/categorias', isAuthorized, async(req, res, next) => {
    const categorias = await Category.findAll();
    const cats = await encoder(categorias);
    res.json(cats);
});



app.get('/categorias/:id', isAuthorized, async(req, res, next) => {
    //console.log(req.body);
    const categoria = req.params.id;
    const result = await Category.findAll({
        where: {
            id: categoria
        }
    });
    // console.log(result);
    const cat = await encoder(result);
    res.json(cat);
    //res.send("Página cadastrar");
});


app.get('/categorias/:id/cartas', isAuthorized, async(req, res, next) => {
    const categoria = req.params.id;
    const result = await Category.findByPk(categoria);
    if (result) {

        if (result.paga == 0 || authorization.nivel > 0) {
            const cards = await Card.findAll({
                where: {
                    categoria: categoria
                }
            });
            res.json(cards);

        } else {
            res.status(401);
            res.send('Não permitido');
        }
    } else {
        res.status(401);
        res.send('Não encontrada');
    }

});

app.get('/cartas', isAuthorized, async(req, res, next) => {
    const cartas = await Card.findAll();

    // console.log(cartas);
    res.json(cartas);
});

app.get('/cartas/:id', isAuthorized, async(req, res, next) => {
    //console.log(req.body);
    const carta = req.params.id;
    const result = await Card.findAll({
        where: {
            id: carta
        }
    });
    // console.log(result);
    res.json(result);
    //res.send("Página cadastrar");
});


// Edição




// Exclusão

app.delete("/cliente/:id/carta/:idc", isAuthorized, isTheUser, async(req, res, next) => {
    const id = req.params.id;
    const idc = req.params.idc;
    await Fav.destroy({
        where: {
            cliente: id,
            carta: idc
        }
    }).then(() => {
        return res.json({
            erro: false,
            mensagem: "Favorito removido com sucesso!"
        });
    }).catch(() => {
        return res.status(400).json({
            erro: true,
            mensagem: "Erro: Favorito não removido!"
        });
    });
});


// Delete everyone named "Jane"
// await User.destroy({
//     where: {
//       id: "Jane"
//     }
//   });




app.listen(8080, () => {
    console.log("Servidor iniciado na porta 8080: http://localhost:8080");
});