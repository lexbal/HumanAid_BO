import mysql from 'mysql';
import dotenv from 'dotenv';

dotenv.config();

var mysql_pool  = mysql.createPool({
    host: process.env.HOST,
    user: process.env.MYSQL_USER,
    password: process.env.MYSQL_PWD,
    database: process.env.DATABASE
});

export default mysql_pool;
