const mysql = require('mysql2');

const pool = mysql.createPool({
    host: 'localhost',
    user: 'root',
    database: 'petopia',
    password: 'websql'
});

module.exports = pool.promise();