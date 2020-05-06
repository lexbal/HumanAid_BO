import connection from '../db';

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
    connection.query(`SELECT * FROM user WHERE id = ${assocId}`, (err, res) => {
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
        result({ kind: "not_found" }, null);
    });
};

Assoc.findAll = result => {
    connection.query("SELECT * FROM user", (err, res) => {
        if (err) {
            console.log("error: ", err);
            result(null, err);

            return;
        }

        result(null, res);
    });
};


export default Assoc;