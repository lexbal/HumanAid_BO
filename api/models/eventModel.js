import mysql_pool from '../config/db.js';
import moment from 'moment';

// constructor
const Event = function (event) {
    this.owner_id     = event.owner_id ? event.owner_id : null;
    this.title        = event.title ? event.title : '';
    this.description  = event.description ? event.description : '';
    this.categories   = event.categories ? event.categories : [];
    this.start_date   = event.start_date;
    this.end_date     = event.end_date;
    this.publish_date = moment().format("YYYY-MM-DD HH:mm:ss");
    this.rating       = event.rating;
};

Event.create = (newEvent, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `INSERT INTO event SET owner_id = ?, title = ?, description = ?, start_date = ?, end_date = ?, publish_date = ?, rating = ?`,
      [newEvent.owner_id, newEvent.title, newEvent.description, newEvent.start_date, newEvent.end_date, newEvent.publish_date, newEvent.rating],
      (err, res) => {
        connection.release();

        if (err) {
          console.log("error: ", err);
          result(err, null);

          return;
        }

        let event_id = res.insertId;

        if (newEvent.categories.length > 0) {
          let categories = [];

          for (let category of newEvent.categories) {
            categories.push([category, event_id]);
          }

          mysql_pool.getConnection(function(err, connection) {
            if (err) {
              console.log(' Error getting mysql_pool connection: ' + err);
              throw err;
            }

            connection.query(
              `INSERT INTO event_category_event (event_category_id, event_id) VALUES ?`,
              [categories],
              (err, res) => {
                connection.release();

                result(null, {id: event_id, ...newEvent});
              }
            );
          });
        }

        result(null, {id: event_id, ...newEvent});
      }
    );
  });
};

Event.findById = (eventId, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
        `SELECT _assoc.name, _assoc.website, _assoc.email, _assoc.photo, _assoc.landline, _assoc.facebook, _assoc_address.street, _assoc.twitter, GROUP_CONCAT(_ec.label) AS categories, _e.title, _e.description, _e.start_date, _e.end_date, _e.publish_date, _e.rating
        FROM event _e
        INNER JOIN user _assoc ON _assoc.id = _e.owner_id
        LEFT JOIN address _assoc_address ON _assoc.id = _assoc_address.user_id
        LEFT JOIN event_category_event _ece ON _e.id = _ece.event_id
        LEFT JOIN event_category _ec ON _ec.id = _ece.event_category_id
        WHERE _e.id = ?
        GROUP BY _e.id`,
      eventId,
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

        // not found Event with the id
        result({kind: "not_found"}, null);
      }
    );
  });
};

Event.getAll = result => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `SELECT _e.id, _e.title, GROUP_CONCAT(_ec.label) AS categories, _e.description, _e.rating, _e.start_date, _e.end_date, _e.publish_date
      FROM event _e
      LEFT JOIN event_category_event _ece ON _e.id = _ece.event_id
      LEFT JOIN event_category _ec ON _ec.id = _ece.event_category_id
      GROUP BY _e.id
      ORDER BY _e.start_date DESC`,
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

Event.getAllByAssoc = (assocId, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `SELECT _e.id, _e.title, GROUP_CONCAT(_ec.label) AS categories, _e.description, _e.rating, _e.start_date, _e.end_date, _e.publish_date
        FROM event _e
        INNER JOIN event_category_event _ece ON _e.id = _ece.event_id
        INNER JOIN event_category _ec ON _ec.id = _ece.event_category_id
        INNER JOIN user _u ON _u.id = _e.owner_id
        WHERE _u.id = ${assocId}
        GROUP BY _e.id`,
      (err, res) => {
        connection.release();

        if (err) {
          console.log("error: ", err);
          result(err, null);

          return;
        }

        result(null, res);
      }
    );
  });
};

Event.updateById = (id, event, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `UPDATE event SET ? WHERE id = ?`,
      [event, id],
      (err, res) => {
        connection.release();

        if (err) {
          console.log("error: ", err);
          result(null, err);

          return;
        }

        if (res.affectedRows == 0) {
          // not found Event with the id
          result({kind: "not_found"}, null);

          return;
        }

        result(null, {id: id, ...event});
      }
    );
  });
};

Event.remove = (id, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `DELETE FROM event WHERE id = ?`,
      id,
      (err, res) => {
        connection.release();

        if (err) {
          console.log("error: ", err);
          result(null, err);

          return;
        }

        if (res.affectedRows == 0) {
          // not found Event with the id
          result({kind: "not_found"}, null);

          return;
        }

        result(null, res);
      }
    );
  });
};

export default Event;
