import mysql_pool from '../db';

// constructor
const Assoc = function (assoc) {
    this.name        = assoc.name ? assoc.name : '';
    this.description = assoc.description;
    this.status      = assoc.status ? assoc.status : '';
    this.location    = assoc.location;
    this.website     = assoc.website;
    this.email       = assoc.email ? assoc.email : '';
    this.roles       = assoc.roles ? assoc.roles : '';
    this.username    = assoc.username ? assoc.username : '';
    this.password    = assoc.password ? assoc.password : '';
    this.siret       = assoc.siret;
};

Assoc.findById = (assocId, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(`SELECT _u.name, _u.description, _user_address.street, _u.manager_first_name, _u.manager_last_name, _u.landline, _u.website, _u.email, _u.photo, _u.facebook, _u.twitter
        FROM user _u
        INNER JOIN address _user_address ON _user_address.user_id = _u.id
        WHERE _u.id = ${assocId} AND _u.roles LIKE '%ROLE_ASSOC%'`, (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(err, null);

        return;
      }

      if (res.length) {
        result(null, res[0]);

        return;
      }

      // not found User with the id
      result({kind: "not_found"}, null);
    });
  });
};

Assoc.getAll = result => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query("SELECT * FROM user WHERE roles LIKE '%ROLE_ASSOC%'", (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(null, err);

        return;
      }

      result(null, res);
    });
  });
};


export default Assoc;
