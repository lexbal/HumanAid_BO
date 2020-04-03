import mysql from 'mysql';
import dotenv from 'dotenv';
import emoji from 'node-emoji';

dotenv.config();

// Create a connection to the database
const connection = mysql.createConnection({
    host:     process.env.HOST,
    user:     process.env.MYSQL_USER,
    password: process.env.MYSQL_PWD,
    database: process.env.DATABASE
});

// open the MySQL connection
connection.connect(error => {
    if (error) {
        throw error;
    }

    console.log(emoji.get('white_check_mark'), "Successfully connected to the database.");
});

export default connection;