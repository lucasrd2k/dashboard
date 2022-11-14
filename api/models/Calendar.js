const Sequelize = require('sequelize');
const db = require('./db');

const Calendar = db.define('calendario', {
    id: {
        type: Sequelize.INTEGER,
        autoIncrement: true,
        allowNull: false,
        primaryKey: true
    },
    texto: {
        type: Sequelize.STRING,
        allowNull: false
    },
    data: {
        type: Sequelize.DATEONLY,
        allowNull: false
    }
});

//Criar a tabela
// Calendar.sync();
//Verificar se há alguma diferença na tabela, realiza a alteração
Calendar.sync({ force: true })

module.exports = Calendar;