import mysql_pool from '../config/db.js';

// constructor
const Address = function (address) {
  this.street     = address.street ? address.street : '';
  this.city       = address.city ? address.city : '';
  this.department = address.department ? address.department : '';
  this.region     = address.region ? address.region : '';
  this.zipcode    = address.zipcode ? address.zipcode : '';
  this.user_id    = address.user_id ? address.user_id : '';
  this.country_id = address.country_id ? address.country_id : '';
};

Address.getAllByUser = (user, result) => {
    mysql_pool.getConnection(function(err, connection) {
      if (err) {
        console.log(' Error getting mysql_pool connection: ' + err);
        throw err;
      }

      connection.query(
        `SELECT _a.street, _a.zipcode, _a.city, _a.region, _a. department, _c.label AS country
            FROM address _a
            INNER JOIN country _c ON _c.id = _a.country_id
            WHERE _a.user_id = ${user}`,
        (err, res) => {
          connection.release();

          if (err) {
            console.log("error: ", err);
            result(null, err);

            return;
          }

          result(null, res);
        }
      );
    });
};

Address.create = (newAddress, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `INSERT INTO address SET ?`,
      newAddress,
      (err, res) => {
        connection.release();

        if (err) {
          console.log("error: ", err);
          result(err, null);

          return;
        }

        result(null, {id: res.insertId, ...newAddress});
      }
    );
  });
};

Address.update = (country, address, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `UPDATE address, country SET country.label = ?, address.street = ?, address.zipcode = ?, address.city = ?, address.region = ?, address.department = ? WHERE address.user_id = ? AND country.id = address.country_id`,
      [country.label, address.street, address.zipcode, address.city, address.region, address.department, address.user_id],
      (err, res) => {
        connection.release();

        if (err) {
          console.log("error: ", err);
          result(err, null);

          return;
        }

        result(null, {address: address, country: country});
      }
    );
  });
};

export default Address;
