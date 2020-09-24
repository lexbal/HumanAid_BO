import mysql_pool from "../config/db.js";

const Country = function (country) {
  this.code  = country.code ? country.code : '';
  this.label = country.label ? country.label : '';
};

Country.create = (newCountry, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `INSERT INTO country SET ?`,
      newCountry,
      (err, res) => {
        connection.release();

        if (err) {
          console.log("error: ", err);
          result(err, null);

          return;
        }

        result(null, {id: res.insertId, ...newCountry});
      }
    );
  });
};

export default Country;
