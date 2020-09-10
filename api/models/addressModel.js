import connection from '../db';

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
    connection.query(
        `SELECT _a.street, _a.zipcode, _a.city, _a.region, _a. department, _c.label AS country
        FROM address _a
        INNER JOIN country _c ON _c.id = _a.country_id
        WHERE _a.user_id = ${user}`,
        (err, res) => {
            if (err) {
                console.log("error: ", err);
                result(null, err);

                return;
            }

            result(null, res);
        }
    );
};

Address.create = (newAddress, result) => {
  connection.query("INSERT INTO address SET ?", newAddress, (err, res) => {
    if (err) {
      console.log("error: ", err);
      result(err, null);

      return;
    }

    console.log("Created address id: ", res.insertId);
    result(null, { id: res.insertId, ...newAddress });
  });
};

export default Address;
