import mysql_pool from '../config/db.js';
import moment from 'moment';

// constructor
const Rating = function (rating) {
    this.user_id      = rating.user_id ? rating.user_id : null;
    this.event_id     = rating.event_id ? rating.event_id : null;
    this.rating       = rating.rating ? rating.rating : '';
    this.comment      = rating.comment ? rating.comment : '';
    this.publish_date = moment().format("YYYY-MM-DD HH:mm:ss");
};


Rating.create = (newRating, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `INSERT INTO rating SET ?`,
      newRating,
      (err, res) => {
        connection.release();

        if (err) {
          console.log("error: ", err);
          result(err, null);

          return;
        }

        result(null, {id: res.insertId, ...newRating});
    });
  });
};

Rating.getAllByEvent = (eventId, result) => {
  mysql_pool.getConnection(function(err, connection) {
    if (err) {
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
    }

    connection.query(
      `SELECT _u.username AS username, _u.email AS email, _r.rating AS rating, _r.comment AS comment, _r.publish_date AS publish_date
        FROM rating _r
        INNER JOIN event _e ON _e.id = _r.event_id
        INNER JOIN user _u ON _u.id = _r.user_id
        WHERE _e.id = ${eventId}`,
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

export default Rating;
