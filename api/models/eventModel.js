import mysql_pool from '../db';
import moment from 'moment';

// constructor
const Event = function (event) {
    this.title        = event.title ? event.title : '';
    this.description  = event.description ? event.description : '';
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

    connection.query("INSERT INTO event SET ?", newEvent, (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(err, null);

        return;
      }

      console.log("Created event id: ", res.insertId);
      result(null, {id: res.insertId, ...newEvent});
    });
  });
};

Event.findById = (eventId, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
        `SELECT _assoc.name, _assoc.website, _assoc.email, _assoc.landline, _assoc.facebook, _assoc_address.street, _assoc.twitter, _e.title, _e.description, _e.start_date, _e.end_date, _e.publish_date, _e.rating
        FROM event _e
        INNER JOIN user _assoc ON _assoc.id = _e.owner_id
        INNER JOIN address _assoc_address ON _assoc.id = _assoc_address.user_id
        WHERE _e.id = ?`,
      eventId,
      (err, res) => {
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
        INNER JOIN event_category_event _ece ON _e.id = _ece.event_id
        INNER JOIN event_category _ec ON _ec.id = _ece.event_category_id
        GROUP BY _e.id
        ORDER BY _e.start_date DESC`,
      (err, res) => {
        if (err) {
          console.log("error: ", err);
          result(null, err);

          return;
        }

        result(null, res);
      });
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
      "UPDATE event SET ? WHERE id = ?",
      [event, id],
      (err, res) => {
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

        console.log("Updated event id: ", id);
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

    connection.query("DELETE FROM event WHERE id = ?", id, (err, res) => {
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

      console.log("Deleted event id: ", id);
      result(null, res);
    });
  });
};

Event.removeAll = result => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query("DELETE FROM event", (err, res) => {
      if (err) {
        console.log("error: ", err);
        result(null, err);

        return;
      }

      console.log(`Deleted ${res.affectedRows} events`);
      result(null, res);
    });
  });
};

export default Event;
