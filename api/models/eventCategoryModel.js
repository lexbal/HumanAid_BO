import mysql_pool from '../db';

// constructor
const EventCategory = function (category) {
  this.code  = category.title ? category.title : '';
  this.label = category.description ? category.description : '';
};

EventCategory.getAll = result => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query("SELECT * FROM event_category", (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(null, err);

        return;
      }

      result(null, res);
    });
  });
};

EventCategory.getAllByEvent = (id, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `SELECT * FROM event_category _ec INNER JOIN event_category_event _ece ON _ec _ec.id = _ece.event_category_id
      WHERE ece.event_id = ${id}`,
      (err, res) => {
        if (err) {
          console.log("error: ", err);
          result(err, null);

          return;
        }

        result(null, res);
      });
  });
};

export default EventCategory;
