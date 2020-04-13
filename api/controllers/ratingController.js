import Rating from '../models/ratingModel';

// Create and Save a new User
export const create = (req, res) => {
    // Validate request
    if (!req.body) {
        return res.status(400).send({
            message: "Content can not be empty!"
        });
    }

    // Create a Rating
    const rating = new Rating({
        event_id: req.body.event_id,
        user_id:  req.body.user_id,
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
        
        return res.status(200).send(data);
    });
};

// Retrieve all Ratings from the database.
export const findAll = (req, res) => {
    Rating.getAllByEvent(req.params.id, (err, data) => {
        if (err) {
            return res.status(500).send({
                message: "Some error occurred while retrieving users."
            });
        }
            
        return res.status(200).send(data);
    });
};