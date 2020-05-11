import express from 'express';
import ensureIsAuthenticated from '../helpers/authGuard';
import { create, findAll } from '../controllers/ratingController';
let ratingRouter = express.Router();

ratingRouter.post('/', ensureIsAuthenticated, create);
ratingRouter.get('/event/:id', findAll);

export default ratingRouter;
