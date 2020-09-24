import mysql_pool from '../config/db.js';
import moment from "moment";

// constructor
const User = function (user) {
    this.name               = user.name ? user.name : '';
    this.manager_first_name = user.manager_first_name ? user.manager_first_name : '';
    this.manager_last_name  = user.manager_last_name ? user.manager_last_name : '';
    this.description        = user.description;
    this.status             = user.status ? user.status : '';
    this.photo              = user.photo ? user.photo : '';
    this.website            = user.website;
    this.email              = user.email ? user.email : '';
    this.roles              = user.roles ? user.roles : '["ROLE_USER"]';
    this.username           = user.username ? user.username : '';
    this.password           = user.password ? user.password : '';
    this.landline           = user.landline ? user.landline : '';
    this.siret              = user.siret;
    this.facebook           = user.facebook ? user.facebook : '';
    this.twitter            = user.twitter ? user.twitter : '';
    this.created_at         = moment().format("YYYY-MM-DD HH:mm:ss");
    this.updated_at         = moment().format("YYYY-MM-DD HH:mm:ss");
};

User.register = (user, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `SELECT * FROM user WHERE email = ? OR username = ? LIMIT 1`,
      [user.email, user.username],
      (err, res) => {
        connection.release();

        if (err) {
          console.log("error: ", err);
          result(err, null);

          return;
        }

        if (res.length) {
          result("This email/username is already used !", null);

          return;
        }

        mysql_pool.getConnection(function(err, connection) {
          if (err) {
            console.log(' Error getting mysql_pool connection: ' + err);
            throw err;
          }

          connection.query(
            `INSERT INTO user SET ?`,
            user,
            (err, res) => {
              connection.release();

              if (err) {
                console.log("error: ", err);
                result(err, null);

                return;
              }

              result(null, {id: res.insertId, ...user});
            }
          );
        });
      }
    );
  });
};

User.login = (user, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `SELECT * FROM user WHERE username = ? OR email = ? LIMIT 1`,
      [user.username, user.email],
      (err, res) => {
        connection.release();

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
      }
    );
  });
};

User.create = (newUser, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `INSERT INTO user SET ?`,
      newUser,
      (err, res) => {
        connection.release();

        if (err) {
          console.log("error: ", err);
          result(err, null);

          return;
        }

        result(null, {id: res.insertId, ...newUser});
      }
    );
  });
};

User.findById = (userId, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `SELECT * FROM user WHERE id = ${userId}`,
      (err, res) => {
        connection.release();

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
      }
    );
  });
};

User.findByUsernameOrEmail = (user, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `SELECT * FROM user WHERE username = ? OR email = ? LIMIT 1`,
      [user, user],
      (err, res) => {
        connection.release();

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

User.getAll = result => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `SELECT * FROM user`,
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

User.updateById = (id, user, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `UPDATE user SET ? WHERE id = ?`,
      [user, id],
      (err, res) => {
        connection.release();

        if (err) {
          console.log("error: ", err);
          result(null, err);

          return;
        }

        if (res.affectedRows == 0) {
          // not found User with the id
          result({kind: "not_found"}, null);

          return;
        }

        result(null, {id: id, ...user});
      }
    );
  });
};

User.remove = (id, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `DELETE FROM user WHERE id = ?`,
      id,
      (err, res) => {
        connection.release();

        if (err) {
          console.log("error: ", err);
          result(null, err);

          return;
        }

        if (res.affectedRows == 0) {
          // not found User with the id
          result({kind: "not_found"}, null);

          return;
        }

        result(null, res);
      }
    );
  });
};

export default User;
