const Sequelize = require('sequelize');
const db = require('./db');

const Category = db.define('categoria', {
    id: {
        type: Sequelize.INTEGER,
        autoIncrement: true,
        allowNull: false,
        primaryKey: true
    },
    nome: {
        type: Sequelize.STRING,
        allowNull: false,
    },
    arquivo: {
        type: Sequelize.STRING,
        allowNull: false,
    },
    paga: {
        type: Sequelize.INTEGER,
        allowNull: false,
    },
    descricao: {
        type: Sequelize.STRING,
        allowNull: false,
    }
});

//Criar a tabela
Category.sync();
//Verificar se há alguma diferença na tabela, realiza a alteração
// Category.sync({ force: true })

module.exports = Category;