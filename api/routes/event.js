import express from 'express';
import ensureIsAuthenticated from '../helpers/authGuard';
import { create, findAll, findOne, remove, update } from '../controllers/eventController';
let eventRouter = express.Router();

eventRouter.post('/', ensureIsAuthenticated, create);
eventRouter.get('/', findAll);
eventRouter.get('/:id', findOne);
eventRouter.put('/:id', ensureIsAuthenticated, update);
eventRouter.delete('/:id', ensureIsAuthenticated, remove);

export default eventRouter;
