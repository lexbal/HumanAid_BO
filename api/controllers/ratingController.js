import Rating from '../models/ratingModel.js';
import User from '../models/userModel.js';
import Event from '../models/eventModel.js';

// Create and Save a new User
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

    const user = data;

    // Create a Rating
    const rating = new Rating({
      event_id: req.body.event_id,
      user_id:  data.id,
      rating:   req.body.rating,
      comment:  req.body.comment
    });

    // Save Rating in the database
    Rating.create(rating, (err, data) => {
      if (err) {
        return res.status(500).send({
          message: "Some error occurred while creating the Rating."
        });
      }

      Rating.getAllByEvent(req.body.event_id, (err, data) => {
        if (err) {
          return res.status(500).send({
            message: "Some error occurred while creating the Rating."
          });
        }

        let sum = 0;

        for (var i = 0; i < data.length; i++) {
          sum = sum + data[i].rating;
        }

        Event.updateById(
          req.body.event_id,
          {
            rating: (sum > 0 && data.length) ? (sum / data.length) : 0
          },
          (err, data) => {
            if (err) {
              if (err.kind === "not_found") {
                return res.status(404).send({
                  message: `Not found Event with id ${req.body.event_id}.`
                });
              }

              return res.status(500).send({
                message: "Error updating Event with id " + req.body.event_id
              });
            }

            return res.status(200).send({
              rating: rating.rating,
              comment: rating.comment,
              username: user.username,
              email: user.email,
              publish_date: data.publish_date,
            });
          }
        );
      });
    });
  });
};

// Retrieve all Ratings from the database.
export const findAllByEvent = (req, res) => {
    Rating.getAllByEvent(req.params.id, (err, data) => {
        if (err) {
            return res.status(500).send({
                message: "Some error occurred while retrieving users."
            });
        }

        return res.status(200).send(data);
    });
};
