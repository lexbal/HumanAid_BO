// constructor
import connection from "../db";

const Country = function (country) {
  this.code  = country.code ? country.code : '';
  this.label = country.label ? country.label : '';
};

Country.create = (newCountry, result) => {
  connection.query("INSERT INTO country SET ?", newCountry, (err, res) => {
    if (err) {
      console.log("error: ", err);
      result(err, null);

      return;
    }

    console.log("Created country id: ", res.insertId);
    result(null, { id: res.insertId, ...newCountry });
  });
};

export default Country;
