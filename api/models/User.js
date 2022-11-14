const Sequelize = require('sequelize');
const db = require('./db');

const User = db.define('cliente', {
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
    email: {
        type: Sequelize.STRING,
        allowNull: false,
        unique: true
    },
    senha: {
        type: Sequelize.STRING,
        allowNull: false
    },
    telefone: {
        type: Sequelize.STRING,
        allowNull: false
    },
    uso: {
        type: Sequelize.INTEGER,
        allowNull: false
    },
    nivel: {
        type: Sequelize.INTEGER,
        allowNull: false
    }
});

//Criar a tabela
User.sync();
//Verificar se há alguma diferença na tabela, realiza a alteração
// User.sync({ alter: true })

module.exports = User;