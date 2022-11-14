const Sequelize = require('sequelize');
const db = require('./db');

const Card = db.define('carta', {
    id: {
        type: Sequelize.INTEGER,
        autoIncrement: true,
        allowNull: false,
        primaryKey: true
    },
    texto: {
        type: Sequelize.STRING,
        allowNull: false,
    },
    categoria: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
            model: 'categoria',
            key: 'id'
        }

    }
});

//Criar a tabela
Card.sync();
//Verificar se há alguma diferença na tabela, realiza a alteração
// Category.sync({ force: true })

module.exports = Card;