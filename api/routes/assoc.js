import express from 'express';
import { findAll, findOne } from '../controllers/assocController.js';
let assocRouter = express.Router();

assocRouter.get('/', findAll);
assocRouter.get('/:id', findOne);

export default assocRouter;
