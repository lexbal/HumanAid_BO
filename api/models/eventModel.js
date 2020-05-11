import connection from '../db';
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
    connection.query("INSERT INTO event SET ?", newEvent, (err, res) => {
        if (err) {
            console.log("error: ", err);
            result(err, null);

            return;
        }

        console.log("Created event id: ", res.insertId);
        result(null, { id: res.insertId, ...newEvent });
    });
};

Event.findById = (eventId, result) => {
    connection.query(
        `SELECT _assoc.name, _assoc.website, _assoc.email, _e.title, _e.description, _e.start_date, _e.end_date, _e.publish_date, _e.rating
        FROM event _e
        INNER JOIN user _assoc ON _assoc.id = _e.owner_id
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
            result({ kind: "not_found" }, null);
        }
    );
};

Event.getAll = result => {
    connection.query("SELECT * FROM event", (err, res) => {
        if (err) {
            console.log("error: ", err);
            result(null, err);

            return;
        }

        result(null, res);
    });
};

Event.updateById = (id, event, result) => {
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
                result({ kind: "not_found" }, null);

                return;
            }
    
            console.log("Updated event id: ", id);
            result(null, { id: id, ...event });
        }
    );
};

Event.remove = (id, result) => {
    connection.query("DELETE FROM event WHERE id = ?", id, (err, res) => {
        if (err) {
            console.log("error: ", err);
            result(null, err);

            return;
        }
    
        if (res.affectedRows == 0) {
            // not found Event with the id
            result({ kind: "not_found" }, null);

            return;
        }
    
        console.log("Deleted event id: ", id);
        result(null, res);
    });
};

Event.removeAll = result => {
    connection.query("DELETE FROM event", (err, res) => {
        if (err) {
            console.log("error: ", err);
            result(null, err);

            return;
        }
    
        console.log(`Deleted ${res.affectedRows} events`);
        result(null, res);
    });
};

export default Event;