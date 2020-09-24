import express from 'express';
import ensureIsAuthenticated from '../helpers/authGuard.js';
import { create, findAllByEvent } from '../controllers/ratingController.js';
let ratingRouter = express.Router();

ratingRouter.post('/', ensureIsAuthenticated, create);
ratingRouter.get('/event/:id', findAllByEvent);

export default ratingRouter;
