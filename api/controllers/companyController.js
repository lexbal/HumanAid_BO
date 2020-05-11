import Company from '../models/companyModel';

// Retrieve all Companies from the database.
export const findAll = (req, res) => {
    Company.getAll((err, data) => {
        if (err) {
            return res.status(500).send({
                message: "Some error occurred while retrieving companies."
            });
        }
            
        return res.status(200).send(data);
    });
};

// Find a single Company with a id
export const findOne = (req, res) => {
    Company.findById(req.params.id, (err, data) => {
        if (err) {
            if (err.kind === "not_found") {
                return res.status(404).send({
                    message: `Not found Company with id ${req.params.id}.`
                });
            } 

            return res.status(500).send({
                message: "Error retrieving Company with id " + req.params.id
            });
        }
        
        return res.status(200).send(data);
    });
};