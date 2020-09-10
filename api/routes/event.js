import express from 'express';
import ensureIsAuthenticated from '../helpers/authGuard';
import { create, findAll, findOne, findAllCategory, findAllByAssoc, remove, update } from '../controllers/eventController';
let eventRouter = express.Router();

eventRouter.post('/', ensureIsAuthenticated, create);
eventRouter.get('/', findAll);
eventRouter.get('/categories', findAllCategory);
eventRouter.get('/:id', findOne);
eventRouter.get('/assoc/:id', findAllByAssoc);
eventRouter.put('/:id', ensureIsAuthenticated, update);
eventRouter.delete('/:id', ensureIsAuthenticated, remove);

export default eventRouter;
