import Event from '../models/eventModel.js';
import User from '../models/userModel.js';
import EventCategory from '../models/eventCategoryModel.js';
import Rating from '../models/ratingModel.js';
import moment from 'moment';

// Create and Save a new Event
export const create = (req, res) => {
    // Validate request
    if (!req.body) {
        return res.status(400).send({
            message: "Content can not be empty!"
        });
    }

    User.findByUsernameOrEmail(req.body.user, (err, data) => {
      if (err) {
        return res.status(500).send({
          message: "Some error occurred while searching the User."
        });
      }

      // Create a Event
      const event = new Event({
        title:        req.body.title,
        description:  req.body.description,
        owner_id:     data.id,
        start_date:   moment(req.body.start_date).format("YYYY-MM-DD HH:mm:ss"),
        end_date:     moment(req.body.end_date).format("YYYY-MM-DD HH:mm:ss")
      });

      // Save Event in the database
      Event.create(event, (err, data) => {
        if (err) {
          return res.status(500).send({
            message: "Some error occurred while creating the Event."
          });
        }

        return res.status(200).send(data);
      });
    });
};

// Retrieve all Events from the database.
export const findAll = (req, res) => {
    Event.getAll((err, data) => {
        if (err) {
            return res.status(500).send({
                message: "Some error occurred while retrieving events."
            });
        }

        return res.status(200).send(data);
    });
};

// Retrieve all Events from the database.
export const findAllCategory = (req, res) => {
  EventCategory.getAll((err, data) => {
    if (err) {
      return res.status(500).send({
        message: "Some error occurred while retrieving events."
      });
    }

    return res.status(200).send(data);
  });
};

// Find a single Event with a id
export const findOne = (req, res) => {
    Event.findById(req.params.id, (err, data) => {
        if (err) {
            if (err.kind === "not_found") {
                return res.status(404).send({
                    message: `Not found Event with id ${req.params.id}.`
                });
            }

            return res.status(500).send({
                message: "Error retrieving Event with id " + req.params.id
            });
        }

        let response = {
            "event": data
        };

        Rating.getAllByEvent(req.params.id, (err, data) => {
            if (err) {
                return res.status(500).send({
                    message: "Some error occurred while retrieving users."
                });
            }

            response["ratings"] = data;

            return res.status(200).send(response);
        });
    });
};

// Retrieve all Events by Assoc from the database.
export const findAllByAssoc = (req, res) => {
    Event.getAllByAssoc(req.params.id, (err, data) => {
        if (err) {
            return res.status(500).send({
                message: "Some error occurred while retrieving events."
            });
        }

        return res.status(200).send(data);
    });
};

// Update a Event identified by the id in the request
export const update = (req, res) => {
    // Validate Request
    if (!req.body) {
        return res.status(400).send({
            message: "Content can not be empty!"
        });
    }

    Event.updateById(
        req.params.id,
        new Event(req.body),
        (err, data) => {
            if (err) {
                if (err.kind === "not_found") {
                    return res.status(404).send({
                        message: `Not found Event with id ${req.params.id}.`
                    });
                }

                return res.status(500).send({
                    message: "Error updating Event with id " + req.params.id
                });
            }

            return res.status(200).send(data);
        }
    );
};

// Delete a Event with the specified id in the request
export const remove = (req, res) => {
    Event.remove(req.params.id, (err, data) => {
        if (err) {
            if (err.kind === "not_found") {
                return res.status(404).send({
                    message: `Not found Event with id ${req.params.id}.`
                });
            }

            return res.status(500).send({
                message: "Could not delete Event with id " + req.params.id
            });
        }

        return res.status(200).send({
            message: `Event was deleted successfully!`
        });
    });
};

// Delete all Events from the database.
export const removeAll = (req, res) => {
    Event.removeAll((err, data) => {
        if (err) {
            return res.status(500).send({
                message: "Some error occurred while removing all events."
            });
        }

        return res.status(200).send({
            message: `All Events were deleted successfully!`
        });
    });
};
