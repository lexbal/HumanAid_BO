import express from 'express';
import ensureIsAuthenticated from '../helpers/authGuard';
import { create, findAllByEvent } from '../controllers/ratingController';
let ratingRouter = express.Router();

ratingRouter.post('/', ensureIsAuthenticated, create);
ratingRouter.get('/event/:id', findAllByEvent);

export default ratingRouter;
