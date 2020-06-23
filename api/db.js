import mysql from 'mysql';
import dotenv from 'dotenv';
import emoji from 'node-emoji';

dotenv.config();

// Create a connection to the database
let connection;
let db_config = {
    host:     process.env.HOST,
    user:     process.env.MYSQL_USER,
    password: process.env.MYSQL_PWD,
    database: process.env.DATABASE
};

function handleDisconnect() {
  connection = mysql.createConnection(db_config); // Recreate the connection, since
                                                  // the old one cannot be reused.

  connection.connect(function(err) {              // The server is either down
    if(err) {                                     // or restarting (takes a while sometimes).
      console.log('error when connecting to db:', err);
      setTimeout(handleDisconnect, 2000); // We introduce a delay before attempting to reconnect,
    }                                     // to avoid a hot loop, and to allow our node script to
    
    console.log(
        emoji.get('white_check_mark'), 
        "Successfully connected to the database."
    );
  });                                     // process asynchronous requests in the meantime.
                                          // If you're also serving http, display a 503 error.
  connection.on('error', function(err) {
    console.log('db error', err);
    if(err.code === 'PROTOCOL_CONNECTION_LOST') { // Connection to the MySQL server is usually
      handleDisconnect();                         // lost due to either server restart, or a
    } else {                                      // connnection idle timeout (the wait_timeout
      throw err;                                  // server variable configures this)
    }
  });
}

handleDisconnect();

export default connection;