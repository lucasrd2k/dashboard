const Sequelize = require('sequelize');
const db = require('./db');

const Fav = db.define('favorito', {
    id: {
        type: Sequelize.INTEGER,
        autoIncrement: true,
        allowNull: false,
        primaryKey: true
    },
    cliente: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
            model: 'cliente',
            key: 'id'
        }
    },
    carta: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
            model: 'carta',
            key: 'id'
        }
    }

});

//Criar a tabela
Fav.sync();
//Verificar se há alguma diferença na tabela, realiza a alteração
// Fav.sync({ alter: true })

module.exports = Fav;