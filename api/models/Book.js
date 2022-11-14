const Sequelize = require('sequelize');
const db = require('./db');

const Book = db.define('material', {
    id: {
        type: Sequelize.INTEGER,
        autoIncrement: true,
        allowNull: false,
        primaryKey: true
    },
    nome: {
        type: Sequelize.STRING,
        allowNull: false
    },
    arquivo: {
        type: Sequelize.STRING,
        allowNull: false
    },
    capa: {
        type: Sequelize.STRING,
        allowNull: false
    }
});

//Criar a tabela
Book.sync();
//Verificar se há alguma diferença na tabela, realiza a alteração
// Book.sync({ force: true })

module.exports = Book;