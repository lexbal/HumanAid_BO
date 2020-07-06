import connection from '../db';

// constructor
const Company = function (company) {
    this.name        = company.name ? company.name : '';
    this.description = company.description;
    this.status      = company.status ? company.status : '';
    this.location    = company.location;
    this.website     = company.website;
    this.email       = company.email ? company.email : '';
    this.roles       = company.roles ? company.roles : '';
    this.username    = company.username ? company.username : '';
    this.password    = company.password ? company.password : '';
    this.siret       = company.siret;
};

Company.findById = (companyId, result) => {
    connection.query(`SELECT * FROM user WHERE id = ${companyId} AND roles LIKE '%ROLE_COMP%'`, (err, res) => {
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

Company.getAll = result => {
    connection.query("SELECT * FROM user WHERE roles LIKE '%ROLE_COMP%'", (err, res) => {
        if (err) {
            console.log("error: ", err);
            result(null, err);

            return;
        }

        result(null, res);
    });
};


export default Company;