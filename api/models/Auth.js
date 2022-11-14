const Sequelize = require('sequelize');
const db = require('./db');

const Auth = db.define('autenticacao', {
    hash: {
        type: Sequelize.STRING,
        allowNull: false,
        primaryKey: true
    },
    id: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
            model: 'cliente',
            key: 'id'
        }
    },
    nome: {
        type: Sequelize.STRING,
        allowNull: false,
    },
    nivel: {
        type: Sequelize.INTEGER,
        allowNull: false,
    }

});

//Criar a tabela
Auth.sync();
//Verificar se há alguma diferença na tabela, realiza a alteração
// Auth.sync({ alter: true })

module.exports = Auth;