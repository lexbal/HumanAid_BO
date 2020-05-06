import Assoc from '../models/assocModel';

// Retrieve all Assocs from the database.
export const findAll = (req, res) => {
    Assoc.getAll((err, data) => {
        if (err) {
            return res.status(500).send({
                message: "Some error occurred while retrieving events."
            });
        }
            
        return res.status(200).send(data);
    });
};

// Find a single Assoc with a id
export const findOne = (req, res) => {
    Assoc.findById(req.params.id, (err, data) => {
        if (err) {
            if (err.kind === "not_found") {
                return res.status(404).send({
                    message: `Not found Assoc with id ${req.params.id}.`
                });
            } 

            return res.status(500).send({
                message: "Error retrieving Assoc with id " + req.params.id
            });
        }
        
        return res.status(200).send(data);
    });
};